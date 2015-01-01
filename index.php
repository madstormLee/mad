<?
include "mad/tools.php";

error_reporting(E_ALL);
MadHeaders::utf8();

$router = MadRouter::getInstance();

$component = new MadComponent( $router->component );
$component->setAction( $router->action );
$view = $component->getContents();

// layout
$component = new MadComponent('layout');
$component->setConfig('ant');
$component->setAction('view');
// $component->setParams( $params );

$layout = $component->getContents();

$layout->main = $view;

print $layout;
