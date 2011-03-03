<?php
ini_set('display_errors',true);
error_reporting(E_ALL^E_STRICT);
require_once __DIR__.'/../../autoload.php';

// Set up a view object we'd like to display
$class = new stdClass();
$class->var1 = '<p>This is var1 inside a standard class</p>';

$savant = new \PEAR2\Templates\Savant\Main();
$savant->addTemplatePath(__DIR__ . '/templates');

// Display a simple string
echo $savant->render('<h1>Welcome to the Savant Demo</h1>');

// Display a string, in a custom template
echo $savant->render('mystring', 'StringView.tpl.php');

// Display an array
echo $savant->render(array('<ul>', '<li>This is an array</li>', '</ul>'));

// Display an object using a default class name to template mapping function
echo $savant->render($class);

// Display the object using a specific template
echo $savant->render($class, 'MyTemplate.tpl.php');

echo $savant->render('<h2>Output Filtering</h2>');
$savant->addFilters('htmlspecialchars');

// Now show an entire template with htmlspecialchars
echo $savant->render($class);

// Ok, now remove the output filters
$savant->setFilters();

highlight_file(__FILE__);

