-----------------------
What Is phpObjectForms?
-----------------------

phpObjectForms is a fully object-oriented, highly customizable, easily 
extendable, library for creating and processing HTML forms without writing any 
HTML code. The main goals of the library are ease of use and universality. The 
library is distributed under the terms of the GNU Lesser Public License. 


-------------
Main Features
-------------
 - Support for all the standard HTML form input elements
 - Server-side input validation based on regular expressions
 - Optional client-side JavaScript pre-validation (currently only for textfields)
 - Support for template-based forms 


----------------------
Summary of the Library
----------------------
There are three types of object entities in the library: elements, wrappers, and 
layouts. Elements define the form elements logic and necessary "inner" HTML 
code, wrappers define the elements presentation (the same wrapper can be used 
for many elements), and finally layouts are containers which define how the 
elements are placed on the screen. 

Though many elements, wrappers, and layouts are provided with the library, users 
can easily add particular functionality by simply extending library elements, 
wrappers, or layouts classes or creating new ones. 

The output forms presentation is highly tied with CSS, therefore it can be 
easily tuned without writing any code but only by changing the stylesheet. 

The library is able to perform simple text field values validation using regular 
expressions, and more complex validations as well. For example, it can require a 
field value to be entered only if a corresponding checkbox is set, or check that 
"Password" and "Confirm password" field values are the same, or examine the mime 
type or the size of an uploaded file, etc. 

The library users can simply add the needed logic for their particular elements 
extending its object hierarchy. 

Visit the samples page to see how the forms produced by the library look like. 


---------------------------
Participate In The Project!
---------------------------
If you want to contribute to the project, I will appreciate it greatly. Please,
mail your ideas and suggestions to <<ilyabo> AT <gmx.net>>. 
