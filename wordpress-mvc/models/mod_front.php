<?php
 class Mod_front extends Model{
    function __construct(){
    	parent::__construct();
    }
	function insPost(){
		$sql = "
			SELECT MAX( ID ) +1
			FROM `{$this->prefix}posts`
			LIMIT 1
		
		";
	}
 }
?>