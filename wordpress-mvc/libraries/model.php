<?php
abstract class Model extends Sistema{    
    public $prefix;
    function __construct(){
	global $wpdb;
	$this->prefix = $wpdb->prefix;
    }
    function query($sql, $echo=0, $filtrar=1){
	if($echo) echo "<pre>$sql</pre><hr/>";
	global $wpdb;
	if($filtrar) $sql= $wpdb->prepare($sql);
	$query = $wpdb->query($sql);
    }
    function results($sql, $filtrar=1){
	global $wpdb;
	if($filtrar) $sql= $wpdb->prepare($sql);
	return $wpdb->get_results($sql);
    }
    function get_var($sql, $filtrar=1){
		global $wpdb;
		if($filtrar) $sql= $wpdb->prepare($sql);
		return $wpdb->get_var($sql);
    }
    
    function clear($var,$lower=true){
	$especiales =array("'",'"','-','/','.','\\','(',')','&','?','=','¡','!');
	$var=trim($var);
	$var= str_replace($especiales,'', $var);
	if($lower) $var= strtolower($var);	
	$especiales1= array('á','é','í','ó','ú','û','ü','ñ',' ','ç','à','è','ì','ò','ù');
	$especiales2= array('a','e','i','o','u','u','u','n','-','s','a','e','i','o','u');	
	$var= str_replace($especiales1,$especiales2, $var);
	return $var;
    }
}
?>