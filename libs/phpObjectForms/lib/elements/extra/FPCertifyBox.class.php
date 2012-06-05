<?php
    /**
     * @author Ilya Boyandin <ilyabo@gmail.com>
     */

    class FPCertifyBox extends FPCheckBox {

        function validate()
        {
            if (!$this->_isChecked)
            {
                $this->_errCode = FP_ERR_CODE__CUSTOM_ERROR;
                $this->_customErrMsg = "You have to check this box to continue";
                return false;
            }
            $this->_errCode = FP_SUCCESS;
            return true;
        }

        function getValue() {
            return $this->_value ? true : false;
        }
    }

?>