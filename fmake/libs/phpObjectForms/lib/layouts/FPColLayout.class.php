<?php
    /**
     * @author Ilya Boyandin <ilyabo@gmail.com>
     */

    class FPColLayout extends FPLayout {

        var $_tblPadding = 2;
        var $_tblSpacing = 0;
        var $_tblAlign;
        var $_tblWidth;
        var $_tblHeight;
        var $_elemAlign;

        function FPColLayout($params = array())
        {
            FPLayout::FPLayout($params);
            if (isset($params["table_padding"])) $this->_tblPadding = $params["table_padding"];
            if (isset($params["table_spacing"])) $this->_tblSpacing = $params["table_spacing"];
            if (isset($params["table_align"])) $this->_tblAlign = $params["table_align"];
            if (isset($params["table_width"])) $this->_tblWidth = $params["table_width"];
            if (isset($params["table_height"])) $this->_tblHeight = $params["table_height"];
            if (isset($params["element_align"])) $this->_elemAlign = $params["element_align"];
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
                    (isset($this->_tblHeight) ?
                        ' height="'.$this->_tblHeight.'"' : ''
                    ).
                    ' border="0"'.
                '>'."\n".
                (isset($this->_title) ?
                '<tr>'.
                    '<td colspan="'.$this->_elementsNum.'">'.
                        /*'<span class="'.$this->_owner->getCssClassPrefix().'LayoutTitle">'.
                            $this->_title.
                        '</span>'.*/
                        $this->getTitleSource().
                    '</td>'.
                '</tr>'
                    : ''
                )
            );
            for ($i=0; $i<$this->_elementsNum; $i++)
            {
                $this->_append(
                    '<tr><td'.
                        ($this->_elemAlign ? ' align="'.$this->_elemAlign.'"' : '').
                    '>'."\n"
                );
                $this->_append($this->_elements[$i]->display());
                $this->_append('</td></tr>'."\n");
            }
            $this->_append(
                (isset($this->_comment) ?
                '<tr>'.
                    '<td colspan="'.$this->_elementsNum.'">'.
                        $this->getCommentSource().
                    '</td>'.
                '</tr>'
                    : ''
                ).
             '</table>'."\n");
        }
    }

?>