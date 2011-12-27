<?php
    /**
     * @author Ilya Boyandin <ilyabo@gmail.com>
     */

    class FPSelect extends FPElement {

        var $_size;
        var $_isMultiple = false;
        var $_options = array();
        var $_selected = array();
        var $_originalSelected;  // used in wasChanged() method

        var $_minOptsSelection;
        var $_maxOptsSelection;
        var $_exactOptsSelection;
        
        function FPSelect($params)
        {
            FPElement::FPElement($params);
            if (isset($params["multiple"]))
                $this->_isMultiple = $params["multiple"] ? true : false
            ;

            if (isset($params["size"]))
                $this->_size = $params["size"];
            else
                $this->_size = $this->_isMultiple ? 5 : 1;

            if (isset($params["options"]))
                $this->_options = $params["options"];

            if (isset($params["selected"])  &&  $params["selected"] !== false)
                $this->_selected = $params["selected"];
            $this->_originalSelected = $this->_selected;

            if ($this->_isMultiple)
            {
                if (isset($params["min_options_selection"]))
                    $this->_minOptsSelection = $params["min_options_selection"]
                ;
                if (isset($params["max_options_selection"]))
                    $this->_maxOptsSelection = $params["max_options_selection"]
                ;
                if (isset($params["exact_options_selection"]))
                    $this->_exactOptsSelection = $params["exact_options_selection"]
                ;
                $this->_required =
                    ($this->_minOptsSelection > 0  ||  $this->_exactOptsSelection > 0)
                ;
            } /*else {
                $this->_required = true;
            }*/

        }


        function setValue($selected)
        {
            $this->_selected =
                is_array($selected) ? $selected : 
                    (!$this->_isMultiple ? $this->_selected : array());
        }


        function getValue()
        {
            return $this->_isMultiple ? $this->_selected : $this->_selected[0];
        }


        function wasChanged() {
            return $this->_selected != $this->_originalSelected;
        }


        function validate()
        {
            $cnt = 0;
            for ($i=0; $i<count($this->_selected); $i++)
            {
                if (!isset($this->_options[$this->_selected[$i]]))
                {
                    $this->_errCode = FP_ERR_CODE__INVALID_USER_DATA;
                    return false;
                }
                $cnt++;
            }

            if ($this->_isMultiple)
            {
                if (isset($this->_minOptsSelection)  &&  $cnt < $this->_minOptsSelection)
                {
                    $this->_errCode = FP_ERR_CODE__TOO_FEW_OPTS_SELECTED;
                    return false;
                }

                if (isset($this->_maxOptsSelection)  &&  $cnt > $this->_maxOptsSelection)
                {
                    $this->_errCode = FP_ERR_CODE__TOO_MANY_OPTS_SELECTED;
                    return false;
                }

                if (isset($this->_exactOptsSelection)  &&  $cnt != $this->_exactOptsSelection)
                {
                    $this->_errCode =
                        $cnt < $this->_exactOptsSelection ?
                            FP_ERR_CODE__TOO_FEW_OPTS_SELECTED :
                            FP_ERR_CODE__TOO_MANY_OPTS_SELECTED
                    ;
                    return false;
                }
            } else {
                if ($this->_required  &&  $cnt == 0)
                {
                    $this->_errCode = FP_ERR_CODE__TOO_FEW_OPTS_SELECTED;
                    return false;
                }
                if ($this->_required  &&  $this->_selected[0] == "EMPTY_VALUE")
                {
                    $this->_errCode = FP_ERR_CODE__EMPTY_VALUE;
                    return false;
                }
            }
            $this->_errCode = FP_SUCCESS;
            return true;
        }


        function echoSource()
        {
            $this->_append(
                '<select'.
                    ' name="'.$this->_name.'[]"'.
                    ' size="'.$this->_size.'"'.
                    ($this->_isMultiple ? ' multiple' : '').
                    (isset($this->_cssStyle) ?
                        ' style="'.$this->_cssStyle.'"' : ''
                    ).
                    $this->getEventsSource().
                '>'."\n"
            );
            foreach ($this->_options as $value => $title)
            {
                $this->_append(
                    '<option'.
                        // (!is_integer($value) ? ' value="'.$value.'"' : '').
                        ' value="'.$value.'"'.
                        (in_array($value, $this->_selected) ? ' selected' : '').
                    '>'.
                        $title.
                    '</option>'."\n"
                );
            }

            $this->_append(
                '</select>'."\n"
            );
        }
    }

?>