<?php
    class Front extends Sistema{
    	public function __construct(){
	    parent::__construct();
	    $this->prod = $this->loadModel('Mod_productos');
    	}
	public function menu(){
	    $this->data['productos']=$this->prod->selProductos();
	    $this->view('front/menu',$this->data);
	}
	public function cm_head(){
	}
	public function fichaTecnica(){
	    $this->data['file']=$this->prod->selFile(get_the_ID());
	    return $this->view('front/cm_head',$this->data,1);
	}
	public function header(){
	    $this->view('front/header',$this->data);
	}
	
	public function cm_foot(){
	    ob_start(); 
		the_meta();
		$meta = ob_get_contents(); 
	    ob_end_clean(); 
	    return $meta.$this->listaImg(get_the_ID());
	}
	private function listaImg($ID){
	    $this->data['img']= $this->prod->selImg2Post($ID);
	    return $this->view('front/galeria',$this->data,true);
	}
    }
?>