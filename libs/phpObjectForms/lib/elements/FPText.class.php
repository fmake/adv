<?php
    /**
     * @author Ilya Boyandin <ilyabo@gmail.com>
     */

    class FPText extends FPElement {

        var $_text = '';
        var $_outputCallback;
        var $_outputEval;
        var $_overrideCssClass;
        var $_codeOnly;

        function FPText($params)
        {
            FPElement::FPElement($params);
            if (isset($params["text"])) $this->_text = $params["text"];
            if (isset($params["output_callback"])) $this->_outputCallback = $params["output_callback"];
            if (isset($params["output_eval"])) $this->_outputEval = $params["output_eval"];
            if (isset($params["override_css_class"])) $this->_overrideCssClass = $params["override_css_class"];
            if (isset($params["code_only"])) $this->_codeOnly = $params["code_only"];
            $this->_value = true;
        }

        function validate() { return true; }

        function setValue($value) { }


        function echoSource()
        {
            if (!$this->_codeOnly)
            $this->_append(
                '<span class="'.
                    (isset($this->_overrideTextCssClass) ?
                        $this->_overrideCssClass
                     :
                        $this->_owner->getCssClassPrefix().'Text'
                    ).
                '">'
            );

            $this->_append($this->_text);
            
            if (isset($this->_outputCallback)) {
                $callbackName = $this->_outputCallback;
                $this->_append($callbackName());
            }

            if (isset($this->_outputEval))
                $this->_append(eval($this->_outputEval));

            if (!$this->_codeOnly)
            $this->_append('</span>');
        }

    }

?>