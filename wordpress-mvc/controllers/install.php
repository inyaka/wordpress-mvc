<?php
class Install extends Sistema{
    public function __construct(){
    	parent::__construct();
    }   
    static function activate(){
    	$mi = parent::loadModel('Mod_install');
		$mi->modActivate();
    }    
    static function deactivate(){
    	$mi = parent::loadModel('Mod_install');
		$mi->modDeactivate();
    }
}
?>