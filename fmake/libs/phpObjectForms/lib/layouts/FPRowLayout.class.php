<?php
    /**
     * @author Ilya Boyandin <ilyabo@gmail.com>
     */

    class FPRowLayout extends FPLayout {

        var $_tblPadding = 2;
        var $_tblSpacing = 0;
        var $_tblAlign;
        var $_tblWidth;
        var $_comment;
        var $_elemVAlign = 'top';   // vertical alignment of each contained element

        function FPRowLayout($params = array())
        {
            FPLayout::FPLayout($params);
            if (isset($params["table_padding"])) $this->_tblPadding = $params["table_padding"];
            if (isset($params["table_spacing"])) $this->_tblSpacing = $params["table_spacing"];
            if (isset($params["table_align"])) $this->_tblAlign = $params["table_align"];
            if (isset($params["table_width"])) $this->_tblWidth = $params["table_width"];
            if (isset($params["comment"])) $this->_comment = $params["comment"];
            if (isset($params["element_valign"])) $this->_elemVAlign = $params["element_valign"];
        }

        function echoSource()
        {
            $this->_append(
                '<table'.
                    ' cellpadding="'.$this->_tblPadding.'"'.
                    ' cellspacing="'.$this->_tblSpacing.'"'.
                    (isset($this->_tblAlign) ?
                        ' align="'.$this->_tblAlign.'"' : ''
                    ).
                    (isset($this->_tblWidth) ?
                        ' width="'.$this->_tblWidth.'"' : ''
                    ).
                    ' border="0"'.
                '>'."\n".
                '<tr>'."\n"
            );
            for ($i=0; $i<$this->_elementsNum; $i++)
            {
                $this->_append(
                    '<td'.
                        (isset($this->_elemVAlign) ? ' valign="'.$this->_elemVAlign.'"' :'').
                    '>'."\n"
                );
                $this->_append($this->_elements[$i]->display());
                $this->_append('</td>'."\n");
            }
            $this->_append(
                '</tr>'."\n".
                (isset($this->_comment) ?
                '<tr>'.
                    '<td colspan="'.$this->_elementsNum.'">'.
                        $this->getCommentSource().
                    '</td>'.
                '</tr>'
                :''
                ).
                '</table>'."\n"
            );
        }
    }

?>