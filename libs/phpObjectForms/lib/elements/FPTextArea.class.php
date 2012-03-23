<?php
    /**
     * @author Ilya Boyandin <ilyabo@gmail.com>
     */

    class FPTextArea extends FPElement {

        var $_rows = 5;
        var $_cols = 30;
        
        function FPTextArea($params)
        {
            FPElement::FPElement($params);
            if (isset($params["rows"])) $this->_rows = $params["rows"];
            if (isset($params["cols"])) $this->_cols = $params["cols"];
        }


        function echoSource()
        {
            $this->_append(
                '<textarea '.
                    ' name="'.$this->_name.'"'.
                    ' rows="'.$this->_rows.'"'.
                    ' cols="'.$this->_cols.'"'.
                    (isset($this->_cssStyle) ?
                        ' style="'.$this->_cssStyle.'"' : ''
                    ).
                '>'. 
                    htmlspecialchars($this->_value).
                '</textarea>'
            );
        }

        
        function setValue($value)
        {
            $this->_value =
                //htmlspecialchars(
                    //stripslashes(
                        $value
                    //)
                //)
            ;
        }
    }


?>