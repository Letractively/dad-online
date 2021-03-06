<?php
/*
DAD Online. Web browser MMORPG.
Copyright(C) 2012 Aceapps Aplicaciones. 
This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version. This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details. You should have received a copy of the GNU General Public License along with this program. If not, see <http://www.gnu.org/licenses
*/

	if ($depth == "aat/") {
		$bottom = "";
	} else {
		$bottom = "../";
	}

	if (!isset($leftstyle) || !isset($leftul)) {
		$leftstyle = "";
		$leftul = "";
	}

	if (!isset($title)) $title = '<li><a href="'.$bottom.'index.php">Home</a></li>
		<li><a href="'.$bottom.'about.php">About</a></li>
		<li><a href="'.$bottom.'products.php">Products</a></li>
		<li><a href="'.$bottom.'services.php">Services</a></li>
		<li><a href="'.$bottom.'support.php">Support</a></li>
		<li><a href="'.$bottom.'contact.php">Contact Us</a></li>';

	echo '<!DOCTYPE html>
		<html lang="en">
		<head>
		<meta charset="utf-8" />
		<title>DAD Online - Engine</title>
		<link rel="stylesheet" type="text/css" href="'.$depth.'styles.css" media="screen" />
		<script type="text/javascript"
		src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
		<script type="text/javascript" src="'.$depth.'js/functions.js"></script>
		</head>
		<body>
		'.$leftstyle.''.$leftul;

/*
<style>
ul#navigationR .home a{
    background-image: url('.$depth.'images/content/camera.png);
}
ul#navigationR .about a      {
    background-image: url('.$depth.'images/content/mail.png);
}
ul#navigationR .shortcodes a      {
    background-image: url('.$depth.'images/content/rss.png);
}
</style>

		<ul id="navigationR">
		<li class="home"><a href="#" title="Home"></a></li>
		<li class="about"><a href="#" title="About"></a></li>
		<li class="shortcodes"><a href="#" title="Shortcodes"></a></li>
		</ul>
*/

	echo '<div id="wrapper"><!-- #wrapper -->

		<header><!-- header -->
		<h1><a href="#">DAD Online - Engine</a></h1>
		</header><!-- end of header -->

		<nav><!-- top nav -->
		<div class="menu">
		<ul>
		'.$title.'
		</ul>
		</div>
		</nav><!-- end of top nav -->

		<section id="main"><!-- #main content area -->

		<article id="drawhere">';
?>
