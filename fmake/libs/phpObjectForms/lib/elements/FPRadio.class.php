<?php
    /**
     * @author Ilya Boyandin <ilyabo@gmail.com>
     */

    class FPRadio extends FPElement {

        var $_isChecked = false;
        var $_tblPadding = 2;
        var $_tblSpacing = 0;
        var $_tblAlign;
        var $_tblFieldCellWidth = 1;
        var $_tblTitleCellWidth;
        var $_nowrapTitle = false;
        var $_groupName;
        var $_itemValue;
        var $_groupValue;
        var $_firstItemInGroup = false;
        
        function FPRadio($params)
        {
            FPElement::FPElement($params);

            // required params
            $this->_name = $this->_groupName = $params["group_name"];
            $this->_itemValue= $params["item_value"];

            // optional params
            if (isset($params["table_padding"])) $this->_tblPadding = $params["table_padding"];
            if (isset($params["table_spacing"])) $this->_tblSpacing = $params["table_spacing"];
            if (isset($params["table_title_cell_width"]))
                $this->_tblTitleCellWidth = $params["table_title_cell_width"]
            ;
            if (isset($params["table_field_cell_width"]))
                $this->_tblFieldCellWidth = $params["table_field_cell_width"]
            ;
            if (isset($params["nowrap_title"]))
                $this->_nowrapTitle = $params["nowrap_title"];

            if (isset($params["table_align"])) $this->_tblAlign = $params["table_align"];
            
            if (isset($params["checked"]))
                $this->_isChecked = $params["checked"] ? true : false;

            if (isset($params["first_item_in_group"]))
                $this->_firstItemInGroup = $params["first_item_in_group"] ? true : false;
        }


        function getTitleSource()
        {
            return
                '<span class="'.$this->_owner->getCssClassPrefix().'RadioTitle">'.
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
                ($this->_firstItemInGroup  &&  $this->getErrorMsg() ?
                '<tr>'."\n".
                    '<td>&nbsp;</td>'.
                    '<td'.
                        /*(isset($this->_tblFieldCellWidth) ?
                            ' width="'.$this->_tblFieldCellWidth.'"' : ''
                        ).*/
                    '>'."\n".
                        $this->getErrorSource()."\n".
                    '</td>'."\n".
                '</tr>'."\n"
                :
                    ''
                ).
                '<tr>'."\n".
                    '<td'.
                        (isset($this->_tblFieldCellWidth) ?
                            ' width="'.$this->_tblFieldCellWidth.'"' : ''
                        ).
                    '>'."\n".

                        '<input type="radio"'.
                            ' name="'.$this->_groupName.'"'.
                            ' value="'.$this->_itemValue.'"'.
                            ($this->_isChecked ? ' checked' : '').
                            (isset($this->_cssStyle) ?
                                ' style="'.$this->_cssStyle.'"' : ''
                            ).
                            $this->getEventsSource().
                        '>'.

                    '</td>'."\n".

                    '<td width="'.$this->_tblTitleCellWidth.'"'.
                        (isset($this->_nowrapTitle) ?
                            ' nowrap' : ''
                        ).
                    '>'."\n".
                        $this->getTitleSource().
                    '</td>'."\n".

                '</tr>'."\n".
                (isset($this->_comment) ?
                '<tr>'."\n".
                    '<td>&nbsp;</td>'.
                    '<td'.
                        /*(isset($this->_tblFieldCellWidth) ?
                            ' width="'.$this->_tblFieldCellWidth.'"' : ''
                        ).*/
                    '>'."\n".
                        $this->getCommentSource()."\n".
                    '</td>'."\n".
                '</tr>'."\n"
                :
                    ''
                ).
                '</table>'."\n"
            );
        }

        
        function setValue($value)
        { 
            $this->_isChecked = ($value == $this->_itemValue) ? true : false; 
            if ($value !== false)
                $this->_groupValue = $value;
        }

        function getValue()
        {
            return $this->_isChecked ? $this->_itemValue : false;
        }


        function getItemValue() { return $this->_itemValue; }
        
        function getGroupName() { return $this->_groupName; }

        function validate() {
                   
            if ($this->_required  &&  !isset($this->_groupValue)) {
                $this->_errCode = FP_ERR_CODE__RADIO_NOT_SELECTED;
                return false;
            } else {
                $this->_errCode = FP_SUCCESS;
                return true;
            }
        }

    
    }



?>