<?php

header('Content-type: application/xml; charset="utf-8"',true);

function charEscape($str){
	str_replace("&", "&amp;", $str);
	str_replace("'", "&apos;", $str);
	str_replace('"', '&quot;', $str);
	str_replace(">", "&gt;", $str);
	str_replace("<", "&lt;", $str);
	return $str;
}

$domain = "http://lapsic.it/";
$newLine ="\n";
$indent =" ";
$timestamp 	 = time();
$date_format = date("Ymd",$timestamp);

$xml_sitemap = '<?xml version=\"1.0\" encoding=\"utf-8\"?>'.$newLine;
$xml_sitemap = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">';
	
//******************** PAGINE STATICHE ***********************************
$ar_statiche = array(
	array('loc' => 'index.php', 'priority' => '0.9', 'changefreq' => 'daily'),
	array('loc' => 'about.php', 'priority' => '0.9', 'changefreq' => 'monthly'),
	array('loc' => 'profile.php', 'priority' => '0.9', 'changefreq' => 'daily'),
	array('loc' => 'photo.php', 'priority' => '0.9', 'changefreq' => 'daily'),
	array('loc' => 'profile_edit.php', 'priority' => '0.9', 'changefreq' => 'monthly'),
	array('loc' => 'expo.php', 'priority' => '0.9', 'changefreq' => 'daily'),
	array('loc' => 'edit_photo.php', 'priority' => '0.9', 'changefreq' => 'monthly'),
	array('loc' => 'terapie.php', 'priority' => '0.9', 'changefreq' => 'monthly')
	
);

foreach($ar_statiche as $page) {
	$changefreq = isset($page["changefreq"]) ? $page["changefreq"] : 'monthly';
	$xml_sitemap .= $indent.'<url>'.$newLine;
	$xml_sitemap .= $indent.$indent.'<loc>'.$domain.$page["loc"].'</loc>'.$newLine;
	//$xml_sitemap .= $indent.$indent.'<lastmod>2011-01-01</lastmod>'.$newLine;
	$xml_sitemap .= $indent.$indent.'<changefreq>'.$changefreq.'</changefreq>'.$newLine;
	$xml_sitemap .= $indent.$indent.'<priority>'.$page["priority"].'</priority>'.$newLine;
	$xml_sitemap .= $indent.'</url>'.$newLine;
}


$xml_sitemap .= '</urlset>';

echo $xml_sitemap;
?>
