DataTables-Generator-for-DOORs
==============================

This provides semi-hacky way of getting IBMs Rational DOORs data into a pretty DataTables HTML file

About
------------------------------
Firstly, this was created for my specific work purposes and is probably not useful in any other situation.
Secondly, there was particular limitations when designing how this would work, therefore it may use some bizare methods, libraries or software.

Dependancies and used libraries
------------------------------
*	PHP 4.3 or greater
*	Uses the Javascript libraries jQuery and DataTables

## How To Use It (For my chumbuddy Jack)

### Step 1
Assuming you have your DOORs data all ready to go, export it as a text file with the following criteria:
*	No wiki or spec and other redunant data
*	Only one Validity Variant Version column
*	Make it a book
*	Include empty attributes
*	Save it as data.txt

### Step 2
*	Move the data.txt file you just exported into the 'input' directory
*	Run the txt2json.php file (Using "php txt2json.php" in the CLI)

Assuming the file paths are setup and working correctly, and the input data is in the right format, you should get a lovely table output as index.htm!