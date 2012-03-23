<html>
<head>
<title>phpObjectForms Sample - No Sense</title>
<link rel="stylesheet" href="../css/pof/green.css" type="text/css">
</head>
<body>
<div align="center">
<?php

// Initialize
require "../lib/FormProcessor.class.php";
$fp = new FormProcessor("../lib/");
$fp->importElements(array(
    "FPText", "FPTextField", "FPTextArea", "FPPassword", "FPSelect",
    "FPFile", "FPCheckBox", "FPRadio", "FPButton",
    "extra/FPConfirmPassword", "extra/FPSplitSelect",
));
$fp->importLayouts(array("FPColLayout", "FPRowLayout", "FPGridLayout", "FPGroup" ));
$fp->importWrappers(array( "FPLeftTitleWrapper" ));


// Create the form object
$myForm = new FPForm(array(
    "title" => 'phpObjectForms - Sample Form',
    "name" => 'myForm',
    "action" => $_SERVER["PHP_SELF"],
    "display_outer_table" => true,
    "table_align" => 'left',
    "table_width" => '500',
    "enable_js_validation" => true,
	"hold_output" => true
));


include "inc/countries.inc.php";

// Wrappers
$leftWrapper = new FPLeftTitleWrapper(array());

//$WEEKDAYS = ;

// Construct a grid of radio elements
$radioGrid = new FPGridLayout(array(
    "table_padding" => 7,
    "columns" => 3,
));


$i = 0;
foreach (
    array(
        'Sunday', 'Monday', 'Tuesday', 'Wednesday',
        'Thursday', 'Friday', 'Saturday')
    as $weekday
)
    $radioGrid->addElement(
        new FPRadio(
        array(
            "group_name" => 'radio_group',
            "item_value" => $i,
            "title" => $weekday,
            "checked" => ($i++ == 0)
        ))
    );


// Construct a grid of checkbox elements
$checkboxGrid = new FPGridLayout(array(
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
            "name" => 'checkbox'.$i,
            "title" => $month,
            "table_align" => 'left',
            "table_padding" => 0,
            "checked" => (++$i)%2,
            "comment" => 'Check it if you like it!'
        ))
    );


// Password field
// We have to create an explicit reference to this object to use it
// in the FPConfirmPassword object constructor
$passwordField = new FPPassword(
array(
    "name" => 'password',
    "title" => 'Password',
    "required" => true,
    "size" => 20,
    "valid_RE" => FP_VALID_PASSWORD,
    "max_length" => 36,
    "wrapper" => &$leftWrapper,
    "comment" =>
        'Password is case sensitive and must be '.
        'at least 6 characters!',
));


// Define form elements
$myForm->setBaseLayout(

    new FPColLayout(array(

        "table_padding" => 5,
        "element_align" => "center",
        "elements" => array(

            new FPText(
            array(                
                "text" =>
                    '<div align="left">'.
                    'Please, fill in the following fields.'.'<br>'.
                    'Read the comments carefully before submitting '.
                    'your data!'.
                    '</div>'
            )),

            new FPTextField(
            array(
                "name" => 'email',
                "title" => 'E-mail Address',
                "required" => true,
                "size" => 33,
                "valid_RE" => FP_VALID_EMAIL,
                "max_length" => 256,
                "wrapper" => &$leftWrapper,
            )),

            new FPTextField(
            array(
                "name" => 'first_name',
                "title" => 'First Name',
                "comment" =>
                    'First name must be shorter than 36 '.
                    'symbols and start with a letter',
                "required" => true,
                "size" => 25,
                "valid_RE" => FP_VALID_NAME,
                "max_length" => 36,
                "wrapper" => &$leftWrapper,
            )),

            new FPTextField(
            array(
                "name" => 'last_name',
                "title" => 'Last Name',
                "required" => true,
                "size" => 25, 
                "valid_RE" => FP_VALID_NAME,
                "max_length" => 36,
                "wrapper" => &$leftWrapper,
            )),

            &$passwordField,

            new FPConfirmPassword(
            array(
                "name" => '_password_confirm',
                "title" => 'Confirm Password',
                "required" => true,
                "size" => 20,
                "valid_RE" => FP_VALID_PASSWORD,
                "max_length" => 32,
                "wrapper" => &$leftWrapper,
                "confirm_object" => &$passwordField,
            )),

            new FPSelect(
            array(
                "name" => 'country',
                "title" => 'Your Country',
                "multiple" => false,
                "options" => $COUNTRIES,
                "selected" => array("RUS"),
                "css_style" => 'width:200px;',
                "wrapper" => &$leftWrapper,
            )),

            new FPSelect(
            array(
                "name" => 'favourite_countries',
                "title" => 'Your Favourite Countries',
                "multiple" => true,
                "min_options_selection" => 2,
                "max_options_selection" => 4,
                "comment" => 'You must select between 2 and 4 options',
                "options" => $COUNTRIES,
                "selected" => array("GBR"),
                "css_style" => 'width:200px;',
                "wrapper" => &$leftWrapper
            )),

            new FPGroup(
            array(
                "name" => "weekdayGroup",
                "title" => 'Choose Your Favourite Weekday',
                "table_align" => "center",
                "table_padding" => 7,
                "elements" => array(
                    &$radioGrid
                )
            )),

            new FPTextArea(
            array(
                "name" => 'comments',
                "title" => 'Your Comments',
                "max_length" => 2048,
                "wrapper" => &$leftWrapper
            )),

            new FPGroup(
            array(
                "name" => "monthGroup",
                "title" => 'Choose Your Favourite Months',
                "table_align" => "center",
                "table_padding" => 7,
                "elements" => array(
                    &$checkboxGrid,
                )
            )),

            new FPFile(
            array(
                "name" => 'image',
                "title" => 'Your Image',
                "size" => '20',
                /* "destination_file" =>
                    '/var/www/html/tests/pof/upload/upload.gif', */
                "allowable_content_types" => array('image/gif'),
                "max_file_size" => 20480,
                "wrapper" => &$leftWrapper,
                "comment" =>
                    'Only GIF images with size less than 20K '.
                    'are allowed for uploading'
            )),

            new FPCheckBox(
            array(
                "name" => 'subscribe_chkbox',
                "title" => 'Subscribe me for the newsletter',
                "table_align" => 'center',
                "checked" => true
            )),

            new FPRowLayout(array(
            "table_align" => "center",
            "table_padding" => 20,
            "elements" => array(
                new FPButton(
                array(
                    "submit" => true,
                    "name" => 'submit',
                    "title" => '   Submit  ',
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
   echo $myForm->display();

?>
</div>
</body>
</html>