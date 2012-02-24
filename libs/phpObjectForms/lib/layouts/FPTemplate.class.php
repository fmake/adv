<?php
    /**
     * @author Ilya Boyandin <ilyabo@gmail.com>
     */

    class FPTemplate extends FPLayout {

        var $_template;

        function FPTemplate($params = array())
        {
            FPLayout::FPLayout($params);
            $this->_template = $params["template"];
        }

        function echoSource()
        {
            for ($i=0; $i<$this->_elementsNum; $i++) {
                $e = &$this->_elements[$i];
                $e->setHoldOutput(true);
                $what[] = "{%".$e->getName()."%}";
                $byWhat[] = $e->display();
            }

            $this->_append(str_replace($what, $byWhat, $this->_template));
        }

    }


?>