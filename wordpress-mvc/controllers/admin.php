<?php
class Admin extends Sistema{
	var $data;
	var $topPage = 'catmvc';
	var $access_level= 6;
	
	public function __construct(){
		parent::__construct();
		$this->data['title'] = 'Catalogo de Pantallas';
		$this->data['menu_title'] = 'Productos';
		$this->cat = $this->loadModel('Mod_categorias');
		$this->prod = $this->loadModel('Mod_productos');
		
	}
	function add_menu(){		
		if($_GET['page']!= 'jsu-opt' && isset($_GET['page'])) add_action('wp_head',$this->head());
		add_menu_page($this->data['title'],$this->data['menu_title'],$this->access_level,$this->topPage,array ( $this , 'principal'),$this->urlBase.'/theme/img/pantalla.png');
		add_submenu_page($this->topPage,'Categorias','Categorias',$this->access_level,'categorias',array ( $this , 'categorias'));
		add_submenu_page($this->topPage,'Crear producto','Crear producto',$this->access_level,'catmvc-prod',array ( $this , 'productos'));
		add_submenu_page($this->topPage,'Imagenes','Subir Imagenes',$this->access_level,'imagenes',array ( $this , 'imagenes'));
		add_submenu_page($this->topPage,'','',$this->access_level,'cat-add',array ( $this , 'catadd'));
		add_submenu_page($this->topPage,'','',$this->access_level,'cat-mod',array ( $this , 'catmod'));		
		add_submenu_page($this->topPage,'','',$this->access_level,'images',array ( $this , 'imagenes'));
	 	add_management_page('', '', 0, 'del-cat', array ( $this , 'delCat'));
	 	add_management_page('', '', 0, 'catmvc-prod-edit', array ( $this , 'editProd'));
	 	add_management_page('', '', 0, 'catmvc-prod-save-edit', array ( $this , 'saveEditProd'));
	 	add_management_page('', '', 0, 'catmvc-prod-del', array ( $this , 'delProd'));
	 	add_management_page('', '', 0, 'catmvc-prod-img-del', array ( $this , 'delProdImg'));
	 	add_management_page('', '', 0, 'catmvc-prod-img-add', array ( $this , 'addProdImg'));
	 	add_management_page('', '', 0, 'prod-save', array ( $this , 'prodSave'));
	 	add_management_page('', '', 0, 'prod-save-img', array ( $this , 'prodSaveImg'));
	 	add_management_page('', '', 0, 'jsu-head', array ( $this , 'jsuHead'));
	}
	function principal(){
		$this->data['prod']=$this->prod->selProductos();
		$this->view('prod/prod-view-admin',$this->data);
	}
	function delCat(){
		if($_POST['confirma'] == ''){
			$this->view('cat/cat-conf');    			
		}else{
			$this->cat->elimina();
			$this->categorias();
		}
	}
	function delProd(){
		$this->prod->delProd();
		echo '<p class="alerta">A borrado el archivo</p>';
		$this->data['prod']=$this->prod->selProductos();
		$this->view('prod/prod-view-admin',$this->data);
	}
	function editProd(){
		wp_enqueue_script('jquery');
		$id= intval($_GET['post-id']);
		$this->data['items']= $this->prod->selProdItems($id);
		$this->data['prod']= $this->prod->selProd($id);
		$this->data['imgs']= $this->prod->selImg2cat4Post($id);
		$this->data['desc']= '';
		$this->data['categorias']= $this->cat->listaCat();
		$this->action= 'prod-save';
		$this->view('prod/prod-edit',$this->data);
	}
	function categorias(){
		$mod = parent::loadModel('Mod_categorias');
		$this->view('cat/cat-add');
		$this->verCategorias($mod);
	}
	function productos(){
		$this->data['desc']= '';
		$this->data['categorias']= $this->cat->listaCat();
		$this->action= 'prod-save';
		$this->view('prod/prod-add',$this->data);
	}
	function prodSave(){
		if($this->validaProducto()){		
			$id = $this->prod->insProd();
			$this->action= 'prod-save-img';
			$this->data['ID'] =$id;		
			$this->data['cat'] =intval($_POST['cat']);
			$this->data['imagenes'] = $this->prod->selImg2cat($this->data['cat']);
			$this->view('prod/prod-add-img',$this->data);
		}else{
			$this->productos();
		}
		
	}
	function validaProducto(){
		$error=false;
		if($_POST['titulo']==''){
			$error['titulo']= "Titulo obligatorio";
		}elseif($this->prod->selTitle($_POST['titulo'])){
			$error['titulo']= "Este titulo ya existe";
		}else{
			$this->data['titulo']=$_POST['titulo'];
		}
		foreach($_POST['key'] as $i=> $k){
			if($_POST['value'][$i]==''){
				$error[$k]= "$k obligatorio";
			}else{
				$this->data[$k]=$_POST['value'][$i];
			}
		}
		if($_POST['desc']==''){
			$error['desc']= "Describa el producto";
		}else{
			$this->data['desc']=$_POST['dec'];
		}
		if($_POST['cat']==''){
			$error['cat']= "Categorize el producto";
		}else{
			$this->data['cat']=$_POST['cat'];
		}
		$this->data['error']=$error;
		return ($error)? false : true;
	}
	function prodSaveImg(){		
		$this->prod->insProdImg();
		$this->view('prod/prod-add-fin',$this->data);
	}
	function delProdImg(){		
		$this->prod->delProdImg();
		exit;
	} 
	function addProdImg(){		
		$this->prod->addProdImg();
		mysql_insert_id();
		exit;
	}
	function saveEditProd(){		
		$this->prod->saveEditProd();
		echo '<h2>Los cambios fueron guardados</h2>';
		$this->principal();
	}
	function catadd(){
		$mod = parent::loadModel('Mod_categorias');
		$mod->crear();
		$this->verCategorias($mod);
	}
	function catmod(){
		$mod = parent::loadModel('Mod_categorias');
		$mod->modifica();
		$this->verCategorias($mod);
	}
	function verCategorias($mod){
		$this->data['categorias']= $mod->listaCat();
		$this->view('cat/cat-add',$this->data);
		$this->view('cat/cat-view',$this->data);	
	}
	function imagenes(){
		if(count($_FILES['imagen'])) $this->uploadImg();
		$this->data['categorias']= '';
		$this->data['categorias']= $this->cat->listaCat();
		$this->view('sis/uploaderForm',$this->data);
	}	
	function uploadImg(){
		if($_FILES['imagen']['type']=='image/jpeg' && !$_FILES['imagen']['error']){			
			$mi = $this->loadModel('Mod_images');
			$name = $mi->imageName($_FILES['imagen']['name']);
			$destino= PATH_CM.'/uploads/img/'.$name;
			$thumbs=	PATH_CM.'/uploads/img/thumbs/'.$name;
			$normal=	PATH_CM.'/uploads/img/normal/'.$name;
			if(move_uploaded_file($_FILES['imagen']['tmp_name'], $destino)){
				$mi->insImage($name);
				chmod($destino, 0777);
				$thumb = $this->loadLibray('Thumb');
				$thumb->loadImage($destino);
				$thumb->resize(400, 'height'); 
				$thumb->save($normal);	 
				$thumb->resize(60, 'height'); 
				$thumb->resize(90, 'width'); 
				$thumb->save($thumbs);
			}else{
				echo '<h2>error al mover archivo</h2><p>revise los permisos de la carpeta '.$destino.'</p>';
			} 
		}
	}
}
?>