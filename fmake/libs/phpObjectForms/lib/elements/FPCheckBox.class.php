<?php
    /**
     * @author Ilya Boyandin <ilyabo@gmail.com>
     */

    class FPCheckBox extends FPElement {

        var $_isChecked = false;
        var $_tblPadding = 2;
        var $_tblSpacing = 0;
        var $_tblAlign;
        var $_value;
        
        function FPCheckBox($params)
        {
            FPElement::FPElement($params);
            if (isset($params["table_padding"])) $this->_tblPadding = $params["table_padding"];
            if (isset($params["table_spacing"])) $this->_tblSpacing = $params["table_spacing"];
            if (isset($params["table_align"])) $this->_tblAlign = $params["table_align"];
            if (isset($params["checked"])) $this->_isChecked = $params["checked"] ? true : false;
            if (isset($params["value"]))
                $this->_value = $params["value"];
            else
                $this->_value = true;
        }

        function getTitleSource()
        {
            return
                '<span class="'.$this->_owner->getCssClassPrefix().'CheckBoxTitle">'.
                    $this->getTitle().
                '</span>'
            ;
        }

        function echoSource()
        {
            $this->_append(
                '<table '.
                    ' cellpadding="'.$this->_tblPadding.'"'.
                    ' cellspacing="'.$this->_tblSpacing.'"'.
                    (isset($this->_tblAlign) ? ' align="'.$this->_tblAlign.'"' : '').
                    ' border="0"'.
                '>'."\n".
                '<tr>'."\n".
                    '<td'.
                        (isset($this->_tblFieldCellWidth) ?
                            ' width="'.$this->_tblFieldCellWidth.'"' : ''
                        ).
                    '>'."\n".

                        '<input type="checkbox"'.
                            ' name="'.
                                $this->_name.
                                (isset($this->_ID) ? "[".$this->_ID."]" : "").
                            '"'.
                            ($this->_isChecked ? ' checked' : '').
                            (isset($this->_cssStyle) ?
                                ' style="'.$this->_cssStyle.'"' : ''
                            ).
                            ' value="'.$this->_value.'"'.
                        	$this->getEventsSource().
                            '>'.

                    '</td>'."\n".

                    
                    '<td'.
                        (isset($this->_tblFieldCellWidth) ?
                            ' width="'.$this->_tblTitleCellWidth.'"' : ''
                        ).
                    '>'."\n".
                        $this->getTitleSource().
                    '</td>'."\n".

                '</tr>'."\n".
                ($this->_comment ?
                '<tr>'."\n".
                    '<td>&nbsp;</td>'.
                    '<td'.
                        (isset($this->_tblFieldCellWidth) ?
                            ' width="'.$this->_tblFieldCellWidth.'"' : ''
                        ).
                    '>'."\n".
                        $this->getCommentSource()."\n".
                    '</td>'."\n".
                '</tr>'."\n"
                :
                    ''
                ).
                ($this->getErrorMsg() ?
                '<tr>'."\n".
                    '<td>&nbsp;</td>'.
                    '<td'.
                        (isset($this->_tblFieldCellWidth) ?
                            ' width="'.$this->_tblFieldCellWidth.'"' : ''
                        ).
                    '>'."\n".
                        $this->getErrorSource()."\n".
                    '</td>'."\n".
                '</tr>'."\n"
                :
                    ''
                ).
                '</table>'."\n"
            );
        }

        
        function setValue($value) {
            if (is_array($value)) {
                if (isset($this->_ID)) {
                    $this->_isChecked =
                        isset($value[$this->_ID]) && $value[$this->_ID]!==false ?
                            true : false;
                }
                else
                    $this->_isChecked = false;
            } else
                $this->_isChecked =
                    $value!==false ? true : false;
        }


        function getValue() {
            return $this->_isChecked ? $this->_value : false;
        }


        function validate() {
            return true;
        }

    }

?>