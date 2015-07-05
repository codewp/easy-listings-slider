<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Header view of listings-list
 *
 * @var string $css_url
 */
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="<?php echo admin_url( 'css' ) ?>/list-tables.css">
	<link rel="stylesheet" type="text/css" href="<?php echo admin_url( 'css' ) ?>/common.css">
	<link rel="stylesheet" type="text/css" href="<?php echo admin_url( 'css' ) ?>/forms.css">
	<link rel="stylesheet" type="text/css" href="<?php echo esc_url( $css_url ) ?>els-slider-slides.css">
</head>
<body>
