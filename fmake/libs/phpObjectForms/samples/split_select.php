<html>
<head>
<title>phpObjectForms Sample - FPSplitSelect</title>
<link rel="stylesheet" href="../css/pof/blue.css" type="text/css">
</head>
<body>
<div align="center">
<?php

// Initialize
require "../lib/FormProcessor.class.php";
$fp = new FormProcessor("../lib/");
$fp->importElements(array("FPButton", "extra/FPSplitSelect"));
$fp->importLayouts(array("FPColLayout", "FPRowLayout"));


// Create the form object
$myForm = new FPForm(array(
    "title" => 'FPSplitSelect Sample Form',
    "name" => 'myForm',
    "action" => $_SERVER["PHP_SELF"],
    "display_outer_table" => true,
    "table_align" => 'center',
));

$myForm->setBaseLayout(
    new FPColLayout(array(
        "table_padding" => 5,
        "element_align" => "center",
        "elements" => array(
            new FPSplitSelect(array(
                "name" => "fruits",
                //"title" => "Fruits",
                "size" => 4,
                "options" => array(
                    1 => "Apple",
                    2 => "Banana",
                    3 => "Birne",
                    4 => "Mango",
                    5 => "Orange",
                    6 => "Peach",
                    6 => "Pineapple",
                ),
                "left_title" => "Fruits",
                "right_title" => "Your chose:",
                "right_ids" => array(),
                "css_style" => "width:120px;",
                "table_padding" => 5,
            )),

            new FPRowLayout(array(
            "table_align" => "center",
            "table_padding" => 20,
            "elements" => array(
                new FPButton(
                array(
                    "submit" => true,
                    "name" => 'submit',
                    "title" => '    OK   ',
                )),
            )
            )),

        )
    ))
);

// Obtain submitted data and check the values correctness
if ($myForm->getSubmittedData()  &&  $myForm->isDataValid()) {

        $elements = $myForm->getElementValues();
        echo
        '<div align="left">'.
            'Thank you, your data is valid!'.
            '<pre>'
        ;
                var_dump($elements);
        echo
            '</pre>'.
        '</div>';
} else
    $myForm->display();

?>
</div>
</body>
</html>