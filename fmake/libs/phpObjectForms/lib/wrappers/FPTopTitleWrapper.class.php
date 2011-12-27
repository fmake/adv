<?php
    /**
     * @author Ilya Boyandin <ilyabo@gmail.com>
     */

    class FPTopTitleWrapper extends FPWrapper {
        
        var $_tblPadding = 2;
        var $_tblSpacing = 0;
        var $_tblAlign;
        var $_tblWidth;
        var $_titleCellAlign;
        var $_contentCellAlign;

        function FPTopTitleWrapper($params = array())
        {
            FPWrapper::FPWrapper($params);

            if (isset($params["table_padding"])) $this->_tblPadding = $params["table_padding"];
            if (isset($params["table_spacing"])) $this->_tblSpacing = $params["table_spacing"];
            if (isset($params["title_cell_align"]))
                $this->_titleCellAlign = $params["title_cell_align"];
            if (isset($params["content_cell_align"]))
                $this->_contentCellAlign = $params["content_cell_align"];

            if (isset($params["table_align"]))
                $this->_tblAlign = $params["table_align"]
            ;
            if (isset($params["table_width"]))
                $this->_tblWidth = $params["table_width"]
            ;
        }

        function display(&$element)
        {
            $element->_append(
                '<table '.
                    ' cellpadding="'.$this->_tblPadding.'"'.
                    ' cellspacing="'.$this->_tblSpacing.'"'.
                    (isset($this->_tblAlign) ? ' align="'.$this->_tblAlign.'"' : '').
                    (isset($this->_tblWidth) ? ' width="'.$this->_tblWidth.'"' : '').
                    ' border="0"'.
                '>'."\n".
                '<tr>'."\n".
                    '<td'.
                        (isset($this->_titleCellAlign) ?
                            ' align="'.$this->_titleCellAlign.'"' : ''
                        ).
                    '>'."\n".
                        $element->getTitleSource().
                    '</td>'."\n".
                '</tr>'."\n".
                '<tr>'."\n".
                    '<td'.
                        (isset($this->_contentCellAlign) ?
                            ' align="'.$this->_contentCellAlign.'"' : ''
                        ).
                    '>'."\n");

            $element->echoSource(true);

            $element->_append(
                    '</td>'."\n".
                '</tr>'."\n".
                (isInstanceOf($element, "FPElement") ?
                    ($element->getErrorMsg() ?
                    '<tr>'."\n".
                        '<td>'."\n".
                            $element->getErrorSource()."\n".
                        '</td>'."\n".
                    '</tr>'."\n"
                    :
                        ''
                    )
                  : ''
                ).
                ($element->getComment() ?
                '<tr>'."\n".
                    '<td'.
                        (isset($this->_tblFieldCellWidth) ?
                            ' width="'.$this->_tblFieldCellWidth.'"' : ''
                        ).
                    '>'."\n".
                        $element->getCommentSource()."\n".
                    '</td>'."\n".
                '</tr>'."\n"
                :
                    ''
                ).
                '</table>'."\n"
            );
        }

    }

?>