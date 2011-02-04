<?php
abstract class Sistema{
	var $rutaBase;
	public $urlBase;
	public $action;
	function __construct(){
		$basename= split('/', plugin_basename(__FILE__));
		$this->urlBase = WP_PLUGIN_URL.'/'.$basename[0];
	}
	function view($archivo,$datos=0,$return=false,$rutaView='/views'){
		$rutaView= PATH_CM.$rutaView;
		if($datos) extract($datos);
		if($return){ 
		   ob_start(); 
		     require_once("$rutaView/$archivo.php"); 
		     $salida = ob_get_contents(); 
		     ob_end_clean(); 
		     return $salida; 
		}else{ 
		   require_once("$rutaView/$archivo.php");
		} 
	}
	function loadModel($class, $rutaModel='/models'){
		require_once(PATH_CM.$rutaModel.'/'.strtolower($class).'.php');
		eval('$retorno = new '.$class.'();');
		return $retorno;
	}
	function loadLibray($class, $rutaLibrary='/libraries'){
		require_once(PATH_CM.$rutaLibrary.'/'.strtolower($class).'.php');
		eval('$retorno = new '.$class.'();');
		return $retorno;
	}
	function post($var=0){
		$_POST = array_map( 'stripslashes_deep', $_POST);
	}
	
	function uploaderForm(){
		$this->view('sis/uploaderForm');
	}
	function jsSwfUpload(){
		$datos =array(
			'upload_url' =>$this->urlBase 
		);
		$this->view('sis/jsu-opt',$datos);
		exit();
	}
	function head(){
		$this->view('sis/head');
	}
	function uploadIMG(){
	}
	
}
?>