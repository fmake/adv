<?php
    /**
     * @author Ilya Boyandin <ilyabo@gmail.com>
     */

    class FPPassword extends FPElement {

        var $_size;
        var $_resendValueAfterSubmit;
        
        function FPPassword($params)
        {
            FPElement::FPElement($params);
            if (isset($this->_size))
                $this->_size = $params["size"];
            else
                $this->_size = 16;
            if (isset($params["resend_value"]))
                $this->_resendValueAfterSubmit = $params["resend_value"] ? true : false;
        }


        function echoSource()
        {
            $this->_append(
                '<input type="password"'.
                    ' name="'.$this->_name.'"'.
                    ($this->_resendValueAfterSubmit ?
                        ' value="'.
                        htmlspecialchars($this->_value).
                        '"' : ' value=""'
                    ).
                    ' size="'.$this->_size.'"'.
                    (isset($this->_cssStyle) ?
                        ' style="'.$this->_cssStyle.'"' : ''
                    ).
                    $this->getEventsSource().
                    ($this->_disabled ? " disabled" : "").
                '>'
            );
        }


        function setValue($value)
        {
            $this->_value = 
                // htmlspecialchars(
                    // stripslashes(
                        $value
                    // )
                // )
            ;
        }
    }


?>