<html>
<head>
<title>phpObjectForms Sample - Template-based Form</title>
</head>
<body>
<div align="center">
<?php

// Initialize
require "../lib/FormProcessor.class.php";
$fp = new FormProcessor("../lib/");
$fp->importElements(array(
    "FPTextField", "FPSelect", "FPCheckBox", "FPButton",
));

$fp->importWrappers(array( "FPErrorMarkWrapper" ));
$fp->importLayouts(array( "FPTemplate", "FPGridLayout" ));

$myForm = new FPForm(array(
    "name" => 'myForm',
    "action" => $_SERVER["PHP_SELF"],
));

$wrapper = new FPErrorMarkWrapper();
$checkboxGrid = new FPGridLayout(array(
    "name" => "month_grid",
    "table_padding" => 5,
    "columns" => 2,
));

$i = 0;
foreach (
    array(
        'January','February','March','April','May','June',
        'July','August','September','October','November','December' )
    as $month
)
    $checkboxGrid->addElement(
        new FPCheckBox(
        array(
            "title" => $month, 
            "name" => 'checkbox'.$i,
            "table_align" => 'left',
            "table_padding" => 0,
            "checked" => (++$i)%4>1,
        ))
    );

$template = new FPTemplate(array(
    "template" => <<<EOT
    <table border="1" cellpadding="10">
    <tr>
        <th colspan="3">Template-Based Form</th>
    </tr>
    <tr>
        <th>Email</th>
        <td>{%email%}</td>
        <td rowspan="4">{%month_grid%}</td>
    </tr>
    <tr>
        <th>Name</th>
        <td>{%name%}</td>
    </tr>
    <tr>
        <th>Month</th>
        <td>{%month%}</td>
    </tr>
    <tr>
        <td colspan="2" align="center">{%submit%}</td>
    </tr>
    </table>
EOT
));

$template->addElements(array(
        new FPTextField(array(
            "name" => "email",
            "valid_RE" => FP_VALID_EMAIL,
            "wrapper" => &$wrapper,
            "size" => 20,
            "css_style" => 'width:200px;',
            "required" => true,
            "max_length" => 256
        )),
        new FPTextField(array(
            "name" => "name",
            "valid_RE" => FP_VALID_NAME,
            "wrapper" => &$wrapper,
            "size" => 25,
            "css_style" => 'width:300px;',
            "required" => true,
            "max_length" => 256
        )),
        new FPSelect(
        array(
            "name" => 'month',
            "multiple" => false,
            "options" => array(
                'January','February','March','April','May','June',
                'July','August','September','October','November','December'
             ),
            "selected" => null,
            "css_style" => 'width:200px;',
            "wrapper" => &$wrapper,
        )),

        &$checkboxGrid,

        new FPButton(
        array(
            "name" => 'submit',
            "submit" => true,
            "title" => '   Submit  '
        )),
    )
);

$myForm->setBaseLayout($template);


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