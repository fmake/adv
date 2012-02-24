<?php
require "lib/FormProcessor.class.php";
$fp = new FormProcessor("lib/");
$fp->importElements(array(
    "FPText", "FPTextField", "FPTextArea", "FPPassword", "FPSelect",
    "FPFile", "FPCheckBox", "FPRadio", "FPButton",
    "extra/FPConfirmPassword", "extra/FPSplitSelect","FPHidden"
));
$fp->importLayouts(array("FPColLayout", "FPRowLayout", "FPGridLayout", "FPGroup" ));
$fp->importWrappers(array( "FPLeftTitleWrapper" ));

class phpObjectForms extends FPForm{
}