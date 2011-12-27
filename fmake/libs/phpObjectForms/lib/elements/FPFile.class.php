<?php
    /**
     * @author Ilya Boyandin <ilyabo@gmail.com>
     */
    
    class FPFile extends FPElement {

        var $_size;
        var $_maxFileSize;
        var $_allowableContentTypes;
        var $_destinationFile;

        function FPFile($params)
        {
            FPElement::FPElement($params);
            if (isset($this->_size))
                $this->_size = $params["size"];
            else
                $this->_size = 16;
            if (isset($params["allowable_content_types"]))
                $this->_allowableContentTypes = &$params["allowable_content_types"];
            if (isset($params["max_file_size"]))
                $this->_maxFileSize = &$params["max_file_size"];
            if (isset($params["destination_file"]))
                $this->_destinationFile = &$params["destination_file"];
        }


        function echoSource()
        {
            $this->_append(
                '<input type="file"'.
                    ' name="'.$this->_name.'"'.
                    ' size="'.$this->_size.'"'.
                    (isset($this->_cssStyle) ?
                        ' style="'.$this->_cssStyle.'"' : ''
                    ).
                '>'
            );
        }


        function setValue(&$value)
        {
            if (isset($value) && is_array($value) && $value['size'] > 0)
            {
                $this->_value = array();
                $this->_value["contentType"] = $value["type"];
                $this->_value["tempFilename"] = $value["tmp_name"];
                $this->_value["remoteFilename"] = $value["name"];
                $this->_value["filesize"] = $value["size"];
            }
        }

        function validate()
        {
            if (isset($this->_value["tempFilename"]))
            {
                if (!is_uploaded_file($this->_value["tempFilename"]))
                {
                    $this->_errCode = FP_ERR_CODE__FILE_UPLOAD_ATTACK;
                    return false;
                }

                $_maxSize = isset($this->_maxFileSize) ?
                    $this->_maxFileSize : FP_MAX_UPLOAD_FILE_SIZE
                ;
                if ($this->_value["filesize"] > $_maxSize)
                {
                    // unlink($this->_value["tempFilename"]);
                    $this->_errCode = FP_ERR_CODE__FILE_UPLOAD_IS_TOO_BIG;
                    return false;
                }

                if (isset($this->_allowableContentTypes)  &&
                    !in_array($this->_value["contentType"], $this->_allowableContentTypes)) {

                    // unlink($this->_value["tempFilename"]);
                    $this->_errCode = FP_ERR_CODE__FILE_UPLOAD_CTYPE_NOT_ALLOWED;
                    return false;
                }

                if (isset($this->_destinationFile))
                {
                    if (!move_uploaded_file(
                            $this->_value["tempFilename"], $this->_destinationFile
                        )) {
                       $this->_errCode = FP_ERR_CODE__CANT_MOVE_UPLOADED_FILE;
                       return false;
                    }
                }

            } else {
                if ($this->_required)
                {
                    $this->_errCode = FP_ERR_CODE__REQ_FILE_NOT_CHOOSEN;
                    return false;
                }
            }

            $this->_errCode = FP_SUCCESS;
            return true;
        }

    }

?>