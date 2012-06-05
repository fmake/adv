<?php
    /**
     * @author Ilya Boyandin <ilyabo@gmail.com>
     */

    class FPSubmitButton extends FPButton {

        function FPSubmitButton($params)
        {
            FPButton::FPButton($params);
            $this->_submit = true;
        }

    }

?>