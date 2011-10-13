<?php
    /**
     * @author Ilya Boyandin <ilyabo@gmail.com>
     */

    class FPButton extends FPElement {

        var $_caption;
        var $_submit;
        var $_onClick;
        
        function FPButton($params)
        {
            FPElement::FPElement($params);
            if (isset($params["size"]))
                $this->_size = $params["size"];
            $this->_caption = isset($params["caption"]) ? $params["caption"] : $this->_title;
            if (isset($params["on_click"]))
                $this->_onClick = $params["on_click"];
            if (isset($params["submit"]))
                $this->_submit = $params["submit"] ? true : false;
        }

        function echoSource()
        {
            // JavaScript validation support
            $form = &$this->getParentFormObj();
            $jsEnabled = (is_object($form) && $form->isJSValidationEnabled());
            if ($jsEnabled) {
                $formName = $form->getName();
                $formElements = $form->getInnerElements();
                $funcName = "_fp_validate".ucfirst($formName);

                $this->_append(
                '<script language="JavaScript" type="text/javascript">'."\n".
                '<!--'."\n".
                'function '.$funcName.'Element(re, elt, title, isRequired) {'."\n".
                    'if (isRequired && elt.value == "") {'."\n".
                        'alert("'.
                                str_replace(
                                "[element_title]", '" + title + "',
                                addslashes(
                                    $GLOBALS["FP_ERR_MSG"]
                                            [FP_ERR_CODE__JS_REQ_FIELD_IS_EMPTY]
                                )).
                        '");'."\n".
                        "elt.focus();\n".
                        'return false;'."\n".
                    '}'."\n".
                    'if (elt.value != "" && !re.test(elt.value)) {'."\n".
                        'alert("'.
                                str_replace(
                                "[element_title]", '" + title + "',
                                addslashes(
                                    $GLOBALS["FP_ERR_MSG"]
                                            [FP_ERR_CODE__JS_FIELD_IS_INVALID]
                                )).
                        '");'."\n".
                        "elt.focus();\n".
                        'return false;'."\n".
                    '} else return true;'."\n".
                '}'."\n".

                'function '.$funcName.'() {'."\n".
                    'var els = document.forms["'.$formName.'"].elements;'."\n".
                    'return '
                );
                foreach ($formElements as $element)
                    if ((isInstanceOf($element, "FPTextField") || isInstanceOf($element, "FPPassword"))
                            && $element->getName())
                        $this->_append(
                            $funcName."Element(".
                                $element->getValidRE().','.
                                'els["'.$element->getName().'"]'.','.
                                '"'.$element->getTitle().'",'.
                                ($element->isRequired() ? 'true' : 'false').
                            ")\n&& "
                        );
                $this->_append(
                    "true;"."\n"
                );
                $this->_append(
                '}'."\n".'//-->'."\n".
                '</script>'
                );

                $onClick = "if (!$funcName()) return false;".
                    ($this->_onClick ? "else {".$this->_onClick."}" : "");
            } else
                $onClick = $this->_onClick;

            $this->_append(
                '<input type="'.($this->_submit ? "submit" : "button").'"'.
                    ' name="'.$this->_name.'"'.
                    ' value="'.$this->_caption.'"'.
                    (isset($this->_cssStyle) ?
                        ' style="'.$this->_cssStyle.'"' : ''
                    ).
                    (isset($this->_tabIndex) ?
                        ' tabindex="'.$this->_tabIndex.'"' : ''
                    ).
                    $this->getEventsSource().
                    ($this->_disabled ? " disabled" : "").
                    ($onClick ? ' onclick="'.$onClick.'"' : "").
                    ' class="'.$this->_owner->getCssClassPrefix().
                        ($this->_submit ? "Submit" : "").'Button"'.
                '>'."\n"
            );
        }

        function validate() {
            $this->_errCode = FP_SUCCESS;
            return true;
        }

    }

?>