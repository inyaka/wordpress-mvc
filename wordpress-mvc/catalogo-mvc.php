<?php
   /*
      Plugin Name: Catalogo MVC
      Plugin URI: none
      Description: Es un catalogo de productos bajo categorias, programado bajo el paradigma MVC 
      Version: 11.09
      Author: Pablo Merino
      Author URI: inyaka@gmail.com
   */
	define('PATH_CM', dirname(__FILE__));
	include_once('config/config.php');
	include_once('libraries/sistema.php');
	include_once('libraries/model.php');
	include_once('controllers/install.php');
	include_once('controllers/admin.php');
	include_once('controllers/front.php');	
	$admin= new Admin();
	$front= new Front();
	register_activation_hook(__FILE__, 'Install::activate'); 
	register_deactivation_hook(__FILE__,'Install::deactivate'); 
	add_action('admin_menu', array($admin, 'add_menu'));
	add_action('wp_head',array($front, 'header'));
	function menu_catmvc(){
	    $front= new Front();
	    $front->menu();
	}  
	function fichaTecnica(){
	    $front= new Front();
	    return $front->fichaTecnica();
	}                                                 
	add_shortcode('cm_head',array($front,'cm_head'));
	add_shortcode('cm_foot',array($front,'cm_foot'));

	/* wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui'); */
?>