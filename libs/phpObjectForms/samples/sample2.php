<html>
<head>
<title>phpObjectForms Sample - Upgrade Your Account</title>
<link rel="stylesheet" href="../css/pof/blue.css" type="text/css">
</head>
<body>
<div align="center">
<?php

// Initialize
require "../lib/FormProcessor.class.php";
$fp = new FormProcessor("../lib/");
$fp->importElements(array(
    "FPText", "FPTextField", "FPTextArea", "FPPassword", "FPSelect",
    "FPFile", "FPCheckBox", "FPRadio", "FPButton", "extra/FPConfirmPassword"
));
$fp->importLayouts(array( "FPColLayout", "FPRowLayout", "FPGridLayout", "FPGroup" ));
$fp->importWrappers(array( "FPTopTitleWrapper" ));


// Create the form object
$myForm = new FPForm(array(
    "title" => 'Upgrade Your Account',
    "name" => 'myForm',
    "action" => $_SERVER["PHP_SELF"],
    "display_outer_table" => true,
    "table_align" => 'center',
    "table_width" => '500',
));


include "inc/countries.inc.php";

// Wrappers
$topWrapper = new FPTopTitleWrapper(array());

// Define form elements
$myForm->setBaseLayout(new FPColLayout(array(
    "elements" => array(
        new FPText(array(
            "text" =>
                'Many of the items we make and sell are avaliable in large '.
                'quantities for wholesale or corporate accounts.'.
                '<br><br>'.
                'For a wholesale account please fill out the following form. '.
                '<br><br>'
        )),

        new FPGroup(array(
        "title" => 'Your Existing Account',
        "elements" => array(new FPRowLayout(array(
            "elements" => array(
                new FPTextField(array(
                    "name" => "login",
                    "title" => 'Email',
                    "valid_RE" => FP_VALID_EMAIL,
                    "wrapper" => &$topWrapper,
                    "size" => 20,
                    "css_style" => 'width:150px;',
                    "required" => true,
                    "max_length" => 256
                )),
                new FPPassword(array(
                    "name" => "password",
                    "title" => 'Password',
                    "valid_RE" => FP_VALID_PASSWORD,
                    "wrapper" => &$topWrapper,
                    "size" => 20,
                    "css_style" => 'width:150px;',
                    "required" => true,
                    "max_length" => 256
                ))
            ),
            "comment" =>
                'You first need to '.
                '<a href="/signup">'.
                    'get an account'.
                '</a> '.
                'before upgrading <br> to Wholesale Account'
        ))),
        )),

        new FPTextField(array(
            "name" => "companyName",
            "title" => 'Company Name',
            "valid_RE" => FP_VALID_TITLE,
            "wrapper" => &$topWrapper,
            "size" => 25,
            "css_style" => 'width:300px;',
            "required" => true,
            "max_length" => 256
        )),
        new FPGroup(array(
        "title" => 'Company Address',
        "elements" => array(
            new FPTextField(array(
                "name" => "companyStreetAddress",
                "title" => 'Street Address',
                "valid_RE" => FP_VALID_ADDRESS,
                "wrapper" => &$topWrapper,
                "max_length" => 256,
                "size" => 57,
                "css_style" => 'width:437px;',
                "required" => true
            )),
            new FPRowLayout(array(
            "elements" => array(
                new FPTextField(array(
                    "name" => "companyCity",
                    "title" => 'City',
                    "valid_RE" => FP_VALID_NAME,
                    "wrapper" => &$topWrapper,
                    "max_length" => 32,
                    "size" => 20,
                    "required" => true
                )),
                new FPSelect(
                array(
                    "name" => "companyState",
                    "title" => 'State',
                    "multiple" => false,
                    "options" => $US_STATES,
                    "selected" => array( "Other" ),
                    "wrapper" => &$topWrapper,
                    "required" => true
                )),
                new FPTextField(array(
                    "name" => "companyPostalCode",
                    "title" => 'Postal Code',
                    "valid_RE" => FP_VALID_ZIP,
                    "wrapper" => &$topWrapper,
                    "max_length" => 16,
                    "size" => 12,
                    "required" => true
                ))
            ),
            )),
            new FPRowLayout(array(
            "elements" => array(
                new FPSelect(
                array(
                    "name" => "companyCountry",
                    "title" => 'Country',
                    "multiple" => false,
                    "options" => $COUNTRIES,
                    "selected" => array('GBR'),
                    "wrapper" => &$topWrapper,
                    "css_style" => 'width:150px;',
                )),
                new FPTextField(array(
                    "name" => "faxNumber",
                    "title" => 'Fax',
                    "valid_RE" => FP_VALID_TELEPHONE,
                    "wrapper" => &$topWrapper,
                    "size" => 15,
                    "css_style" => 'width:150px;',
                    "required" => false,
                    "max_length" => 256
                ))
            ),
            )),
        )
        )),
        new FPRowLayout(array(
        "table_align" => "center",
        "table_padding" => 15,
        "elements" => array(
            new FPButton(
            array(
                "name" => 'submit',
                "submit" => true,
                "title" => '    Submit    '
            )),
        )
        )),
    )
)));


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