<?php
    /**
     * @author Ilya Boyandin <ilyabo@gmail.com>
     */

    class FPGroup extends FPColLayout {

        function FPGroup($params = array())
        {
            FPColLayout::FPColLayout($params);
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
                    ' class="'.$this->getCssClassPrefix().'GroupTbl"'.
                '>'."\n".
                '<tr>'.
                    '<td'.
                        ' class="'.$this->getCssClassPrefix().'GroupTitleCell"'.
                    '>'.$this->_title.'</td>'.
                '</tr>'
            );
            for ($i=0; $i<$this->_elementsNum; $i++)
            {
                $this->_append('<tr><td>'."\n");
                $this->_append($this->_elements[$i]->display());
                $this->_append('</td></tr>'."\n");
            }
            $this->_append('</table>'."\n");
        }
    }

?>