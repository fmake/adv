<?php
    /**
     * @author Ilya Boyandin <ilyabo@gmail.com>
     */

    class FPElement {
    
        var $_name;         // element name
        var $_title;
        var $_shortTitle;
        var $_ID;           // optional
                            // If an element's id is set, it's value
                            // must be returned (from the getElementValues()
                            // function) as an element of an array
                            // (there are other elements with the same name)

        var $_comment;      // text comment appearing under the element
        var $_value;
        var $_originalValue;   // needed for wasChanged() method
        var $_required;         // bool: is an element value required for submitting
        var $_valid_RE;         // regular expression for valid values
        var $_maxValueLength;   // max length of the value (optional parameter)

        var $_errCode;
        var $_customErrMsg;     // custom error message text (displayed when
                                // errCode = FP_ERR_CODE__CUSTOM_ERROR)

        var $_owner;    // reference to the parent container-class
        var $_wrapper;  // reference to a class responsible for the element displaying
        
        var $_cssStyle;  // used for <input ... style="$_cssStyle" ...>

        var $_requiredOnChecked;
            // element can become required only when a particular checkbox or radio
            // item is checked

        var $_events;
            // "onXxxx" events js code to be inserted in the element's HTML code

        var $_tabIndex;

        var $_parentFormObj;
            // used to store a reference to the form that contains this element,
            // must be accessed only via getParentFormObj (the property is set
            // after the first call of this method)

        var $_disabled;

        function FPElement($params)
        {
            if (isset($params["name"]))
                $this->_name = $params["name"];

            if (isset($params["title"]))
                $this->_title = $params["title"];

            if (isset($params["short_title"]))
                $this->_shortTitle = $params["short_title"];
            else
                $this->_shortTitle = &$this->_title;

            if (isset($params["id"]))
                $this->_ID = $params["id"];

            if (isset($params["required"]))
                $this->_required = $params["required"] ? true : false;
            if (isset($params["valid_RE"]))
                $this->_valid_RE = $params["valid_RE"];
            if (isset($params["comment"]))
                $this->_comment = $params["comment"];
            if (isset($params["value"]))
                $this->_originalValue = $this->_value = $params["value"];
            if (isset($params["max_length"]))
                $this->_maxValueLength = $params["max_length"];
            if (isset($params["required_on_checked"]))
                $this->_requiredOnChecked = &$params["required_on_checked"];

            if (isset($params["css_style"])) $this->_cssStyle = $params["css_style"];
            if (isset($params["wrapper"])) $this->_wrapper = &$params["wrapper"];
            if (isset($params["events"])) $this->_events = $params["events"];
            if (isset($params["tab_index"])) $this->_tabIndex = $params["tab_index"];

            if (isset($params["disabled"])) $this->_disabled = $params["disabled"];
        }


        function &getOwner()
        {
            return $this->_owner;
        }

        function setOwner(&$containerObj)
        {
            $this->_owner = &$containerObj;
        }

        function &getParentFormObj()
        {
            if (!isset($this->_parentFormObj)) {
                $obj = &$this;
                while (isset($obj->_owner) && is_object($obj->_owner)) $obj = &$obj->_owner;
                if (isInstanceOf($obj, "FPForm"))
                    $this->_parentFormObj = &$obj;
            }
            return $this->_parentFormObj;
        }

        function validate()
        {
            // can be overriden
            if (isset($this->_value)  &&  $this->_value != '')
            {
                if (isset($this->_valid_RE))
                {
                    if (!preg_match($this->_valid_RE, $this->_value))
                    {
                        $this->_errCode = FP_ERR_CODE__FIELD_IS_INVALID;
                        return false;
                    }
                }

                if (isset($this->_maxValueLength)  &&  
                        strlen($this->_value) > $this->_maxValueLength)
                {
                    $this->_errCode = FP_ERR_CODE__VALUE_IS_TOO_LONG;
                    return false;
                }
            } else {
                if ($this->_required)
                    $_required = true;
                elseif (is_object($this->_requiredOnChecked))
                    $_required = $this->_requiredOnChecked->getValue();
                else
                    $_required = false;

                if ($_required)
                {
                    $this->_errCode = FP_ERR_CODE__REQ_FIELD_IS_EMPTY;
                    return false;
                }
            }
            $this->_errCode = FP_SUCCESS;
            return true;
        }


        function isValid()
        {
            if (!isset($this->_errCode)) $this->validate();
            return ($this->_errCode == FP_SUCCESS);
        }


        function getName() { return $this->_name; }

        function getID() { return $this->_ID; }

        function getTitle() { return $this->_title; }

        function getComment() { return $this->_comment; }

        function getValue() { return $this->_value; }

        function getValidRE() { return $this->_valid_RE; }

        function isRequired() { return $this->_required ? true : false; }

        function isValueSet() { return isset($this->_value); }

        function setValue($value)
        {
            // can be overriden
            $this->_value = $value; 
        }

        function wasChanged() { return $this->_value != $this->_originalValue; }

        function getErrorMsg()
        {
            if (isset($this->_errCode) && $this->_errCode != FP_SUCCESS)
            {
                $errMsg = ($this->_errCode != FP_ERR_CODE__CUSTOM_ERROR ?
                    $GLOBALS["FP_ERR_MSG"][$this->_errCode] : $this->_customErrMsg
                );

                return str_replace('[element_title]', $this->_shortTitle, $errMsg);

            } else
                return '';
        }


        function invalidate($errCode, $customErrMsg = '')
        {
            if (!isset($this->_errCode) || $this->_errCode == FP_SUCCESS)
            {
                $this->_errCode = $errCode;
                if ($errCode == FP_ERR_CODE__CUSTOM_ERROR)
                    $this->_customErrMsg = $customErrMsg
                ;
            }
        }


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
                ($this->_required /* ||  $this->_requiredOnChecked */ ?
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
                '<span class="'.$this->_owner->getCssClassPrefix().'Comment">'.
                    $this->_comment .
                '</span>'
            ;
        }


        function getEventsSource() {
            if (is_array($this->_events)) {
                $code = '';
                foreach ($this->_events as $name => $jsCode)
                    $code .= " $name=\"$jsCode\"";
                return $code;
            } else
                return '';
        }


        function getErrorSource()
        {
            return
                '<span class="'.$this->_owner->getCssClassPrefix().'Error">'.
                    $this->getErrorMsg().
                '</span>'
            ;
        }


        function echoSource()
        {
            // must be overriden
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

    }

?>