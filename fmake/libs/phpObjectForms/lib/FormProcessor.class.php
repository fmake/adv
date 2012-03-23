<?php
    /**
     * @author Ilya Boyandin <ilyabo@gmail.com>
     */

    class FormProcessor {

        var $_classPath;
        
        function FormProcessor($classPath)
        {
            $this->_classPath = $classPath;
            require_once $this->_classPath.'globals.inc.php';
            require_once $this->_classPath.'fpdefines.inc.php';
            require_once $this->_classPath.'fpdefines_extra.inc.php';
            require_once $this->_classPath.'FPForm.class.php';
            require_once $this->_classPath.'elements/FPElement.class.php';
            require_once $this->_classPath.'layouts/FPLayout.class.php';
            require_once $this->_classPath.'wrappers/FPWrapper.class.php';
        }

        function importElements($paths)
        {
            $this->_import($paths, "elements");
        }

        function importLayouts($paths)
        {
            $this->_import($paths, "layouts");
        }

        function importWrappers($paths)
        {
            $this->_import($paths, "wrappers");
        }

        function _import($paths, $stdLoc)
        {
            for($i=0; $i<count($paths);$i++) {
                if (file_exists($paths[$i].".class.php"))
                    require_once $paths[$i].".class.php";
                else
                    require_once $this->_classPath.$stdLoc."/".$paths[$i].'.class.php';
            }
        }

    }

?>
