ChavMinifier
============

Web project minifier

### Requirements

* PHP 5.3

### How to use

You have to put your projects to minify in the **original** folder. After that, launch **execute.php** and wait. This may take some time.

To configure the minifier, use **configuration.xml**. With this file, you can activate debug mode to show details after running **execute.php**, add directories list to exclude and activate obfuscation mode.

### Limitations

The minifier don't support the use of a same variable in many files. For example, if you declare **$someVariable** in a file, and you use it in another, it won't work.

### Developers

Presently, the minifier can parse some types of files :

* PHP files
* CSS files (stylesheet)
* TPL files (template)
* JS files (javascript)

To add a new parser, create and include it in **execute.php**. The parser must implements the **Parser** interface. After that, add the parser in the parse function in **app/parser/functions.php**.

### Feedback

Don't hesitate to fork this project, improve it and make a pull request.

### License

This work is licensed under the Creative Commons Attribution-ShareAlike 3.0 Unported License. To view a copy of this license, visit http://creativecommons.org/licenses/by-sa/3.0/ or send a letter to Creative Commons, 444 Castro Street, Suite 900, Mountain View, California, 94041, USA.
