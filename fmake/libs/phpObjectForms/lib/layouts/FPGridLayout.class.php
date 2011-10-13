<?php
    /**
     * @author Ilya Boyandin <ilyabo@gmail.com>
     */

    class FPGridLayout extends FPLayout {

        var $_tblPadding = 2;
        var $_tblSpacing = 0;
        var $_tblAlign;
        var $_tblWidth;
        var $_columns;

        function FPGridLayout($params = array())
        {
            FPLayout::FPLayout($params);
            if (isset($params["table_padding"])) $this->_tblPadding = $params["table_padding"];
            if (isset($params["table_spacing"])) $this->_tblSpacing = $params["table_spacing"];
            if (isset($params["table_align"])) $this->_tblAlign = $params["table_align"];
            if (isset($params["table_width"])) $this->_tblWidth = $params["table_width"];
            if (isset($params["columns"])) $this->_columns = $params["columns"];
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
                '>'."\n"
            );
            for ($i=0; $i<$this->_elementsNum; $i++)
            {
                if ($i%$this->_columns == 0)
                    $this->_append('<tr>'."\n");
                $this->_append('<td>'."\n");
                $this->_append($this->_elements[$i]->display());
                $this->_append('</td>'."\n");
                if (($i+1)%$this->_columns == 0  ||  $i == $this->_elementsNum - 1)
                    $this->_append('</tr>'."\n");
            }
            $this->_append('</table>'."\n");
        }
    }

?>