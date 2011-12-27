<?php
    /**
     * @author Ilya Boyandin <ilyabo@gmail.com>
     */

    function isInstanceOf(&$obj, $className)
    {
        return (strtolower(get_class($obj)) == strtolower($className))  ||  is_subclass_of($obj, $className);
    }
    
?>
