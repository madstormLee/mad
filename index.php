<?
include "tools.php";

error_reporting(E_ALL);
MadHeaders::utf8();

$router = MadRouter::getInstance();

// sitemap section
$sitemapFile = 'sitemap.json';
if ( is_file( $sitemapFile ) ) {
	$sitemap = MadSitemap::create($sitemapFile);
	$sitemap->setCurrent();
	$current = $sitemap->getCurrent();
} else {
	$current = $router;
}

// component
$params = new MadParams('_GET');
if ( isset( $current->params ) ) {
	$params->addData( (array) $current->params );
}

$component = new MadComponent( $current->component );
$component->setAction( $current->action );
$component->setParams( $params );
$view = $component->getContents();

// layout
$component = new MadComponent('layout');
$component->setConfig('ant');
$component->setAction('view');
$layout = $component->getContents();

$layout->main = $view;

print $layout;
