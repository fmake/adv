<?php
    /**
     * @author Ilya Boyandin <ilyabo@gmail.com>
     */

    class FPHidden extends FPElement {

        function echoSource()
        {
            $this->_append(
                '<input type="hidden"'.
                    ' name="'.$this->_name.'"'.
                    ' value="'.$this->_value.'"'.
                '>'
            );
        }
    }

?>