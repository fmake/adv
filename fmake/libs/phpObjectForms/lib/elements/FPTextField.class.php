<?php
    /**
     * @author Ilya Boyandin <ilyabo@gmail.com>
     */

    class FPTextField extends FPElement {

        var $_size;
        var $_readOnly;
        
        function FPTextField($params)
        {
            FPElement::FPElement($params);
            if (isset($this->_size))
                $this->_size = $params["size"];
            else
                $this->_size = 16;
            if (isset($params['readonly'])) $this->_readOnly = $params["readonly"];
        }


        function echoSource()
        {
            $this->_append(
                '<input type="text"'.
                    ' name="'.$this->_name.'"'.
                    ' value="'.
                        htmlspecialchars($this->_value).
                    '"'.
                    ' size="'.$this->_size.'"'.
                    (isset($this->_cssStyle) ?
                        ' style="'.$this->_cssStyle.'"' : ''
                    ).
                    (isset($this->_maxValueLength) ?
                        ' maxlength="'.$this->_maxValueLength.'"' : ''
                    ).(isset($this->_ID) ?
                        ' id="'.$this->_ID.'"' : ''
                    ).                   
                    $this->getEventsSource().
                    ($this->_readOnly ? " readonly" : "").
                    ($this->_disabled ? " disabled" : "").
                '>'
            );
        }


        function setValue($value)
        {
            // $value == false when the element value is not sent to the server
            // (this can happen when an element is added to the form only after
            // it is submitted) in this case the value set in the class constructor
            // is used
            if ($value !== false)
                $this->_value = trim($value);
        }
    }

?>