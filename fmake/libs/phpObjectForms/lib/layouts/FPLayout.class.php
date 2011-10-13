<?php
    /**
     * @author Ilya Boyandin <ilyabo@gmail.com>
     */

    class FPLayout {

        var $_elements = array();
        var $_elementsNum = 0;

        var $_name;
        var $_title;
        var $_comment;
        var $_owner;
        var $_required;

        var $_dataSource;
        var $_fileDataSource;
        var $_cssClassPrefix;

        var $_wasFormSubmitted;

        var $_wrapper;  // reference to a class responsible for the element displaying

        var $_parentFormObj;
            // used to store a reference to the form that contains this layout,
            // must be accessed only via getParentFormObj (the property is set
            // after the first call of this method)

        /*
            When true the display() method doesn't output generated HTML to
            stdout but returns it as a string. The produced output is
            stored in _outputStr.

            When an element is added to a container its _holdOutput value
            is set to the _holdOutput value of the container.
        */
        var $_holdOutput = false;
        var $_outputStr;

        function FPLayout($params = array())
        {
            if (isset($params["wrapper"])) $this->_wrapper = &$params["wrapper"];
            if (isset($params["name"])) $this->_name = $params["name"];
            if (isset($params["title"])) $this->_title = $params["title"];
            if (isset($params["comment"])) $this->_comment = $params["comment"];
            if (isset($params["required"])) $this->_required = $params["required"];
            if (isset($params["elements"]))
                $this->addElements($params["elements"]);
            if (isset($params["hold_output"]))
                $this->_holdOutput = $params["hold_output"] ? true : false;
        }

        function getName() { return $this->_name; }

        function addElement(&$element)
        {
            if (!is_object($element))  return;
            $this->_elements[$this->_elementsNum++] = &$element;
            $element->setOwner($this);
            $element->setHoldOutput($this->_holdOutput);
        }


        function addElements($elementsArray)
        {
            for ($i=0; $i<count($elementsArray); $i++)
                $this->addElement($elementsArray[$i])
            ;
        }

        function getSubmittedData()
        {
            $this->_dataSource = &$this->_owner->getDataSource();
            $this->_fileDataSource = &$this->_owner->getFileDataSource();

            for ($i=0; $i<$this->_elementsNum; $i++)
            {
                $element = &$this->_elements[$i];
                if (isInstanceOf($element, "FPLayout"))
                {
                    // get submitted data of all inner containers
                    $element->getSubmittedData();

                } elseif (isInstanceOf($element, "FPElement")) {

                    // get submitted data of all contained elements
                    if (isInstanceOf($element, "FPFile"))
                    {
                        $this->_switchToMultipartMode();
                        if ($this->_wasFormSubmitted())
                        {
                            if (isset($this->_fileDataSource[$element->getName()]))
                                $element->setValue($this->_fileDataSource[$element->getName()])
                            ;
                        }
                    } else {
                        if ($this->_wasFormSubmitted())
                        {
                            if (isset($this->_dataSource[$element->getName()]))
                                $element->setValue($this->_dataSource[$element->getName()]);
                            else
                                // if ($this->_wasFormSubmitted())
                                    $element->setValue(false);
                        }
                    }
                }    
            }
        }

        function getElementValues()
        {
            $values = array();

            for ($i=0; $i<$this->_elementsNum; $i++)
            {
                $element = &$this->_elements[$i];
                if (isInstanceOf($element, "FPElement"))
                {
                    $name = $element->getName();
                    $value = $element->getValue();
                    // id is optional (see the comment below)
                    $id = $element->getID();

                    if (isset($name)  &&  isset($value)  &&  $value !== false)
                    {
                        // If an element's id is set, it's value
                        // must be returned as an element of an array
                        // (there are other elements with the same name)
                        if ($id) {
                            if (!isset($values[$name]))
                                $values[$name] = array($id => $value);
                            else
                                $values[$name][$id] = $value;
                        } else {
                            $values[$name] = $value;
                        }
                    }


                } elseif (isInstanceOf($element, "FPLayout")) {

                    $values = array_merge($values, $element->getElementValues());
                }
            }

            return $values;
        }


        function &getInnerElementByName($elmName)
        {
            for ($i=0; $i<$this->_elementsNum; $i++)
            {
                $element = &$this->_elements[$i];

                if ($element->getName() == $elmName)  return $element;
                if (isInstanceOf($element, "FPLayout")) {
                    $elm = &$element->getInnerElementByName($elmName);
                    if ($elm)
                        return $elm;
                    else {
                        print "name:".$element->getName()."<br>";
                        if ($element->getName() == $elmName) {
                            return $element;
                        }
                    }
                }
            }
            return false;
        }


        function getInnerElements()
        {
            $elems = array();
            for ($i=0; $i<$this->_elementsNum; $i++)
            {
                $element = &$this->_elements[$i];
                if (isInstanceOf($element, "FPLayout"))
                    $elems = array_merge($elems, $element->getInnerElements());
                elseif (isInstanceOf($element, "FPElement"))
                    $elems[] = &$element;
            }
            return $elems;
        }


        function deleteInnerElement($elmName)
        {
            for ($i=0; $i<$this->_elementsNum; $i++)
            {
                $element = &$this->_elements[$i];
                if ($element->getName() == $elmName)
                {
                    // remove element, shift the array tail
                    $this->_elementsNum--;
                    for ($k=$i; $k<$this->_elementsNum; $k++)
                        $this->_elements[$k] = &$this->_elements[$k+1];
                    return true;
                }
                if (isInstanceOf($element, "FPLayout")  &&
                    $element->deleteInnerElement($elmName))  return true;
            }
            return false;
        }


        function validate()
        {
            $isValid = true;
            // calls validate method of all contained elements
            for ($i=0; $i<$this->_elementsNum; $i++)
            {
                if (!$this->_elements[$i]->validate())  $isValid = false;
            }
            return $isValid;
        }


        function &getOwner()
        {
            return $this->_owner;
        }

        function setOwner(&$obj)
        {
            // $obj can be an instance of either FPForm or FPLayout
            $this->_owner = &$obj;
//            $this->_cssClassPrefix = $obj->getCssClassPrefix();
        }


        function &getParentFormObj()
        {
            if (!isset($this->_parentFormObj)) {
                $obj = &$this;
                while (is_object($obj->_owner)) $obj = &$obj->_owner;
                if (isInstanceOf($obj, "FPForm"))
                    $this->_parentFormObj = &$obj;
            }
            return $this->_parentFormObj;
        }


        function refineElementsOwner()
        {
            for ($i=0; $i<$this->_elementsNum; $i++)
            {
                $this->_elements[$i]->setOwner($this);
                if (isInstanceOf($this->_elements[$i], "FPLayout"))
                    $this->_elements[$i]->refineElementsOwner();
            }
        }


        // this method tells owner that FPFile object was added
        function _switchToMultipartMode()
        {
            $this->_owner->_switchToMultipartMode();
        }


        // you can call these two methods only after getSubmittedData is called
        function &getDataSource() { return $this->_dataSource; }

        function &getFileDataSource() { return $this->_fileDataSource; }

        function getCssClassPrefix() {
            if (isset($this->_cssClassPrefix))
                return $this->_cssClassPrefix;
            else
                return $this->_cssClassPrefix = $this->_owner->getCssClassPrefix();
        }

        function _wasFormSubmitted()
        {
        	if (isset($this->_wasFormSubmitted)) {
        		return $this->_wasFormSubmitted;
        	} else {
        		if (isInstanceOf($this->_owner, "FPForm")) {
                    return $this->_wasFormSubmitted = $this->_owner->wasSubmitted();
                } else {
					return $this->_wasFormSubmitted = $this->_owner->_wasFormSubmitted();
                }
        	}
        }

        function _clearOutput() {
            $this->_outputStr = "";
        }

        function _append($str) {
            if ($this->_holdOutput) {
                $this->_outputStr .= $str;
            } else {
                echo $str;
            }
        }

        function _getOutput() {
            return $this->_holdOutput ? $this->_outputStr : "";
        }

        function setHoldOutput($bool) {
            $this->_holdOutput = $bool;
            for ($i=0; $i<$this->_elementsNum; $i++)
                $this->_elements[$i]->setHoldOutput($bool);
        }

        function display()
        {
            $this->_clearOutput();
            if (is_object($this->_wrapper))
                $this->_wrapper->display($this);
            else
                $this->echoSource();
            return $this->_getOutput();
        }

        function echoSource() {
            for ($i=0; $i<$this->_elementsNum; $i++)
                $this->_elements[$i]->display();
        }

        function getTitle() { return $this->_title; }
        function getComment() { return $this->_comment; }

        function getTitleSource()
        {
            return
                '<span class="'.$this->_owner->getCssClassPrefix().'Title">'.
                    ($this->_required  ||  $this->_requiredOnChecked ? 
                        '<span class="'.$this->_owner->getCssClassPrefix().'ReqTitle">' : ''
                    ).
                        $this->getTitle().
                    ($this->_required ? 
                        '</span>' : ''
                    ).
                '</span>'.
                ($this->_required ?
                    '<sup class="'.$this->_owner->getCssClassPrefix().'ReqStar">'.
                        '*'.
                    '</sup>'
                    : ''
                )
            ;
        }

        function getCommentSource()
        {
            return
                '<span class="'.$this->getCssClassPrefix().'Comment">'.
                    $this->_comment .
                '</span>'
            ;
        }

        /**
          * Prints tree of contained elements (for debug purposes only)
          */
        function printElementsTree() {
            print
                '<div>'.get_class($this).
                '['.$this->_name.'<div style="margin-left:15px;">';
            for ($i=0; $i<$this->_elementsNum; $i++)
            {
                $element = &$this->_elements[$i];
                if (isInstanceOf($element, "FPLayout"))
                    $element->printElementsTree();
                else
                    print get_class($element)." \"".$element->getName()."\"<br>";
            }
            print "</div>]</div>";
        }

    }

?>