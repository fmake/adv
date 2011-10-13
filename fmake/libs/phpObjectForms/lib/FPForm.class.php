<?php
    /**
     * @author Ilya Boyandin <ilyabo@gmail.com>
     */

    class FPForm {

        var $_name;
        var $_title;
        var $_baseLayout;

        var $_requestMethod;
        var $_encType;
        var $_action;

        var $_isValid;
        var $_wasSubmitted;
        var $_preserveVarsOnSubmit;

        var $_dataSource;
        var $_fileDataSource;

        var $_tblPadding = 5;
        var $_tblSpacing = 0;
        var $_tblAlign;
        var $_tblWidth;
        var $_displayOuterTable;
        var $_outerTblPadding = 2;
        var $_outerTblSpacing = 2;
        var $_outerTblWidth;
        var $_outerTblHeight;

        var $_formPrefixText;

        var $_cssClassPrefix = 'stdFP';

        var $_globalErrorMessage;

        /*
            params['refine_owners'] must be turned on when using simplified
            (using nested constructors) elements initialization


            When you use nested-constructors initialization you should not access
            $this->_owner class member before the $form->refineElementsOwner() method
            is called, especially, don't try to access it in the elements constructors.

            The problem is caused by the PHP4 "feature": when you create an object
            using constructor and try to create a reference to it or to pass the
            reference in a function, in fact, you create a reference to a copy of
            the object, therefore if you manipulate with $this reference in the
            object's constructor (especially, if you try to store it in another
            object) then the references will point to different objects.

            There is a way to avoid the problem. You can write something like:
            "$bar =& new Foo()" to assign a reference to the object itself and
            define a function like "function B(&$a)" to pass a real reference
            but this can't help in our case, as elements are combined into an array:
            "elements => array(new FPElement(..), new FPElement(..), ..)"

            See the "References inside the constructor" section in the PHP4
            manual
        */
        var $_needsToRefineOwners = true;

        /*
            When true the display() method doesn't output generated HTML to
            stdout but returns it as a string. The produced output is
            stored in _outputStr.

            When an element is added to a container its _holdOutput value
            is set to the _holdOutput value of the container.
        */
        var $_holdOutput = false;
        var $_outputStr;

        var $_jsCode;
            // javascript code inserted before the form HTML code
        var $_omitGlobalErrorMsg = false;

        // Enabling this helps to pre-validate user input before sending it by HTTP
        var $_enableJSValidation = false;

        function FPForm($params)
        {
            // required params
            $this->_name = $params["name"];
            $this->_action = $params["action"];

            // optional params
            if (isset($params["title"]))
                $this->_title = $params["title"];
            if (isset($params["refine_owners"]))
                $this->_needsToRefineOwners = $params["refine_owners"] ? true : false;
            if (isset($params["preserve_http_vars"]))
                $this->_preserveVarsOnSubmit = $params["preserve_http_vars"];
            if (isset($params["request_method"]))
                $this->_requestMethod = $params["request_method"];
            else
                $this->_requestMethod = 'POST';
            if (isset($params["hold_output"]))
                $this->_holdOutput = $params["hold_output"] ? true : false;

            if (isset($params["encoding_type"]))
                $this->_encType = $params["encoding_type"];
            if (!isset($this->_encType))  $this->_encType = FP_ENCTYPE__DEFAULT;

            if (isset($params["table_padding"])) $this->_tblPadding = $params["table_padding"];
            if (isset($params["table_spacing"])) $this->_tblSpacing = $params["table_spacing"];
            if (isset($params["table_align"])) $this->_tblAlign = $params["table_align"];
            if (isset($params["table_width"])) $this->_tblWidth = $params["table_width"];
            if (isset($params["display_outer_table"]))
                $this->_displayOuterTable = $params["display_outer_table"] ? true : false;
            if (isset($params["outer_table_padding"]))
                $this->_outerTblPadding = $params["outer_table_padding"];
            if (isset($params["outer_table_spacing"]))
                $this->_outerTblSpacing = $params["outer_table_spacing"];
            if (isset($params["outer_table_width"]))
                $this->_outerTblWidth = $params["outer_table_width"];
            if (isset($params["outer_table_height"]))
                $this->_outerTblHeight = $params["outer_table_height"];

            if (isset($params["prefix_text"]))
                $this->_formPrefixText = $params["prefix_text"];

            if (isset($params["css_class_prefix"]))
                $this->_cssClassPrefix = $params["css_class_prefix"];
            if (isset($params["omit_global_err_msg"]))
                $this->_omitGlobalErrorMsg = $params["omit_global_err_msg"];

            if (isset($params["enable_js_validation"]))
                $this->_enableJSValidation = $params["enable_js_validation"] ? true : false;

            if (version_compare(phpversion(), "4.1.0") < 0) {
                switch ($GLOBALS['HTTP_SERVER_VARS']['REQUEST_METHOD']) {
                    case 'POST':
                        $this->_dataSource = &$GLOBALS['HTTP_POST_VARS'];
                        $this->_fileDataSource = &$GLOBALS['HTTP_POST_FILES'];
                    break;
                    case 'GET':
                        $this->_dataSource = &$GLOBALS['HTTP_GET_VARS'];
                    break;
                }
            } else {
                switch ($_SERVER['REQUEST_METHOD']) {
                    case 'POST':
                        $this->_dataSource = &$_POST;
                        $this->_fileDataSource = &$_FILES;
                    break;
                    case 'GET':
                        $this->_dataSource = &$_GET;
                    break;
                }                
            }
        }

        function setPreservedVar($name, $value) {
            $this->_preserveVarsOnSubmit[$name] = $value;
        }

        function appendJSCode($code) {
            if (isset($this->_jsCode))
                $this->_jsCode .= "\n".$code;
            else
                $this->_jsCode = $code;
        }

        function getName() { return $this->_name; }

        function setBaseLayout(&$container)
        {
            $this->_baseLayout = &$container;
            $container->setOwner($this);
            $container->setHoldOutput($this->_holdOutput);
            if ($this->_needsToRefineOwners)
                $container->refineElementsOwner();
        }


        function getSubmittedData()
        {
            if (isset($this->_wasSubmitted))
                return $this->_wasSubmitted;
            else {
                if (!isset($this->_baseLayout))
                    return false;
                else {
                    $elid = $this->_name."SubmitIndicator";
                    $this->_wasSubmitted =
                        isset($this->_dataSource[$elid]) && $this->_dataSource[$elid] ? true : false
                    ;
                    $this->_baseLayout->getSubmittedData();
                    return $this->_wasSubmitted;
                }
            }
        }

        function wasSubmitted() { return $this->_wasSubmitted ? true : false; }

//        function _wasFormSubmitted() { return $this->wasSubmitted(); }

        function setIsValid($val) { $this->_isValid = $val; }

        function setGlobalErrorMessage($msg) {
            $this->_globalErrorMessage = $msg;
            $this->_omitGlobalErrorMsg = false;
        }

        function isDataValid()
        {
            if (isset($this->_isValid))
                return $this->_isValid;
            else
                return 
                    (isset($this->_baseLayout) ?
                        $this->_isValid = $this->_baseLayout->validate()
                    :
                        false
                    )
                ;
        }

        function isJSValidationEnabled() {
            return $this->_enableJSValidation;
        }

        function setHoldOutput($bool) {
            $this->_holdOutput = $bool;
            if (isset($this->_baseLayout)) {
                $this->_baseLayout->setHoldOutput($bool);
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

        function _displayFormHeader()
        {
            $this->_append(
                '<form'.
                    ' name="'.$this->_name.'" method="'.$this->_requestMethod.'"'.
                    ' action="'.$this->_action.'"'.
                    ($this->_encType == FP_ENCTYPE__MULTIPART ? 
                        ' enctype="multipart/form-data"' : ''
                    ).
                    ' style="margin:0px;"'.
                '>'."\n"
            );
            $this->_append(
                '<input type="hidden" name="'.$this->_name.'SubmitIndicator" value="true">'.
                "\n"
            );
            if (is_array($this->_preserveVarsOnSubmit))
            foreach ($this->_preserveVarsOnSubmit as $name => $val)
            $this->_append(
                '<input type="hidden" name="'.$name.'" value="'.$val.'">'."\n"
            );
        }


        function _displayFormFooter()
        {
            $this->_append('</form>'."\n");
        }


        function display()
        {
            $this->_clearOutput();
            // can be overriden
            if (isset($this->_jsCode))
                $this->_append(
                    '<script language="JavaScript">'."\n".
                        $this->_jsCode."\n".
                    '</script>');

            if ($this->_displayOuterTable) {
                $this->_append(
                '<table'.
                    ' cellpadding="'.$this->_outerTblPadding.'"'.
                    ' cellspacing="'.$this->_outerTblSpacing.'"'.
                    ' align="'.$this->_tblAlign.'"'.
                    (isset($this->_outerTblWidth) ? 
                        ' width="'.$this->_outerTblWidth.'"' : ''
                    ).
                    (isset($this->_outerTblHeight) ? 
                        ' height="'.$this->_outerTblHeight.'"' : ''
                    ).
                    ' class="'.$this->_cssClassPrefix.'OuterTable"'.
                    ' border="0"'.
                '>'."\n"
                );
                if (isset($this->_title))
                $this->_append(
                '<tr>'.
                    '<td class="'.$this->_cssClassPrefix.'OuterTableHeaderCell">'.
                        $this->_title.'</td>'.
                '</tr>'
                );
                $this->_append(
                '<tr>'.
                    '<td class="'.$this->_cssClassPrefix.'OuterTableContentCell">'
                );
            }
            $this->_displayFormHeader();
            $this->_append(
                '<table'.
                    ' cellpadding="'.$this->_tblPadding.'"'.
                    ' cellspacing="'.$this->_tblSpacing.'"'.
                    ' align="'.$this->_tblAlign.'"'.
                    (isset($this->_tblWidth) ? 
                        ' width="'.$this->_tblWidth.'"' : ''
                    ).
                    ' class="'.$this->_cssClassPrefix.'Table"'.
                    ' border="0"'.
                '>'."\n"
            );
            $this->_append(
                ($this->_isValid === false  &&  !$this->_omitGlobalErrorMsg ?
                    '<tr><td>'.
                        '<span class="'.$this->_cssClassPrefix.'Error">'.
                            (isset($this->_globalErrorMessage) ?
                                $this->_globalErrorMessage : FP_DEFAULT_GLOBAL_FORM_ERR_MSG
                            ).
                        '</span>'.
                    '</td></tr>'
                : ''
                )
            );
            $this->_append(
                ($this->_formPrefixText ?
                    '<tr><td>'.
                        '<span class="'.$this->_cssClassPrefix.'Text">'.
                            $this->_formPrefixText.
                        '</span>'.
                    '</td></tr>'
                : ''
                )
            );
            $this->_append(
                '<tr><td>'."\n"
            );
            
            if (isset($this->_baseLayout))
                $this->_append($this->_baseLayout->display());

            $this->_append(
                '</td></tr>'."\n"
            );
            $this->_append(
                '</table>'."\n"
            );
            $this->_displayFormFooter();
            if ($this->_displayOuterTable) {
                $this->_append(
                    '</td></tr>'.
                    '</table>'
                );
            }
            return $this->_getOutput();
        }


        function getElementValues()
        {
            return 
                $this->_baseLayout->getElementValues()
            ;
        }


        function &getInnerElementByName($elmName)
        {
            // Returns a reference to inner element or false
            // if the form doesn't contain an element with
            // such name.
            //
            // If there are two elements with the same name
            // only a reference to the first one will be returned.
            if ($this->_baseLayout->getName() == $elmName)
                return $this->_baseLayout;
            else
                return $this->_baseLayout->getInnerElementByName($elmName)
            ;
        }


        function getInnerElements()
        {
            // Returns a plain array of all the inner elements
            // contained in the form
            if (isset($this->_baseLayout))
                return $this->_baseLayout->getInnerElements();
            else
                return array();
        }


        function deleteInnerElement($elmName)
        {
            return
                $this->_baseLayout->deleteInnerElement($elmName);
            ;
        }


        function &getDataSource() { return $this->_dataSource; }

        function &getFileDataSource() { return $this->_fileDataSource; }

        function getCssClassPrefix() { return $this->_cssClassPrefix; }

        function &getBaseLayout() { return $this->_baseLayout; }


        // this is called by inner containers
        // when FPFile element is added
        function _switchToMultipartMode()
        {
            $this->_encType = FP_ENCTYPE__MULTIPART;
            if ($this->_requestMethod != "POST")
            {
                $this->fatal(FP_FATAL_ERR__TOO_LATE_MULTIPART_SWITCH);
            }
        }


        // fatal error output and exiting
        function fatal($errCode)
        {
            echo
                '<div class="'.$this->_cssClassPrefix.'FatalError">'.
                    str_replace(
                        '[message]',
                        $GLOBALS["FP_FATAL_ERR_MSG"][$errCode],
                        $GLOBALS["FP_FATAL_ERR_MSG_OUTPUT_TEMPL"]
                    ).
                '</div>'
            ;
            exit;
        }


        /**
          * Prints tree of contained elements (for debug purposes only)
          */
        function printElementsTree() {
            print "<div><b>".$this->_name.":</b><br><br>";
            $this->_baseLayout->printElementsTree();
            print "</div>";
        }

    }

?>