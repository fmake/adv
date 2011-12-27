<?php
    /**
     * @author Ilya Boyandin <ilyabo@gmail.com>
     * $Id: FPErrorMarkWrapper.class.php,v 1.1 2003/07/04 13:26:44 ilya Exp $
     */

    class FPErrorMarkWrapper extends FPWrapper {
        
        var $_tblPadding = 0;
        var $_tblSpacing = 0;

        function FPLeftTitleWrapper($params = array())
        {
            FPWrapper::FPWrapper($params);
            if (isset($params["table_padding"])) $this->_tblPadding = $params["table_padding"];
            if (isset($params["table_spacing"])) $this->_tblSpacing = $params["table_spacing"];
        }

        function display(&$element)
        {
            if (isInstanceOf($element, "FPElement")  &&
                $errMsg = $element->getErrorMsg())
            {
                $elto =& $element->getOwner();
                $cssPrefix = $elto->getCssClassPrefix();

                $element->_append(
                    '<table '.
                        ' cellpadding="'.$this->_tblPadding.'"'.
                        ' cellspacing="'.$this->_tblSpacing.'"'.
                        ' border="0"'.
                        ' title="'.addslashes($errMsg).'"'.
                    '>'."\n".
                        '<td>'."\n"
                );
                $element->echoSource();
                $element->_append(
                        '</td>'."\n".
                        '<td>'."\n".
                            '<span class="'.$cssPrefix.'Error">'.
                                "*".
                            '</span>'.
                        '</td>'."\n".
                    '</table>');
            } else
                $element->echoSource();
        }

    }

?>