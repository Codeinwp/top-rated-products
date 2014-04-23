<?php
/*
Plugin Name: Top Rated Products
Plugin URI: http://www.readythemes.com/plugins
Description: Display featured products in your sidebar.
Version: 1.0
Author: Ready Themes
Author URI: http://www.readythemes.com
License: GPLv2 or later
*/

add_action( 'admin_menu', 'top_rated_products_menu' );

function top_rated_products_menu() 
{
	add_menu_page( 'Top Rated Products', "Top Rated Products", 0, "top-rated-products", "top_rated_products"); 

//	$page = add_submenu_page( "hidden", "Options", "Options", 0, "top-rated-products", "top_rated_products"); 

	$page = add_submenu_page( "hidden", "Top Rated Products FAQ", "Top Rated Products FAQ", 0, "top-rated-products-faq", "top_rated_products_faq"); 

	$page = add_submenu_page( "hidden", "Top Rated Products Tutorial", "Top Rated Products Tutorial", 0, "top-rated-products-tutorial", "top_rated_products_tutorial"); 

}

add_action( 'wp_enqueue_scripts', 'trp_add_stylesheet' );
function trp_add_stylesheet() 
{
	// Respects SSL, Style.css is relative to the current file
    wp_register_style( 'trp-style', plugins_url('style.css', __FILE__) );
    wp_enqueue_style( 'trp-style' );
}

function trp_default()
{
	$default = array();
	$default['no-follow'] 			= 'yes';
	$default['new-window'] 			= 'yes';
	$default['buy-button-url'] 		= plugins_url('images/buy.jpg', __FILE__) ;
	$default['read-more-button-url']= plugins_url('images/read-more.jpg', __FILE__) ;
	return $default;
}

function trpw_default()
{
	$default = array();
	$default['showposts'] 				= 10;
	$default['show-buy-button'] 		= 'yes';
	$default['show-read-more-button'] 	= 'yes';
	$default['show-star-ratings']		= 'yes';
	return $default;
}

function trp_selected($val1, $val2)
{
	echo $val1==$val2?'selected="selected"':'';
	return ;
}
function trp_checked($val1, $val2)
{
	echo $val1==$val2?'checked="checked"':'';
	return ;
}
require_once(dirname(__FILE__)."/top-rated-products-home.php");
require_once(dirname(__FILE__)."/top-rated-products-faq.php");
require_once(dirname(__FILE__)."/top-rated-products-tutorial.php");
require_once(dirname(__FILE__)."/top-rated-products-widget.php");
require_once(dirname(__FILE__)."/top-rated-products-metabox.php");
?>