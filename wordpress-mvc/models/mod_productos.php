<?php
class Mod_productos extends Model{
    function __construct(){
	parent::__construct();
	$this->conf= new Config();
    }
    function insProd(){
	global $current_user;get_currentuserinfo();
	$titulo = htmlentities($_POST['titulo'],ENT_QUOTES,'UTF-8');
	$archivo = $_POST['archivo'];
	$post_name= $this->clear($_POST['titulo']);
	strtolower(str_replace(' ', '-', $name));
	$desc = htmlentities($_POST['desc'],ENT_QUOTES,'UTF-8');
	$id= $this->selProdID();
	$guid = get_option('home').'/?page_id='.$id;
	$sql="
	INSERT INTO `{$this->prefix}posts` (
	    `ID`,
	    `post_author`,
	    `post_date`,
	    `post_date_gmt`,
	    `post_content`,
	    `post_title`,
	    `post_excerpt`,
	    `post_status`,
	    `comment_status`,
	    `ping_status`,
	    `post_name`,
	    `post_modified`,
	    `post_modified_gmt`,
	    `post_parent`,
	    `guid`,
	    `menu_order`,
	    `post_type`
	) VALUES (
	    $id,
	    $current_user->ID,
	    NOW(),
	    NOW(),
	    '[cm_head] $desc [cm_foot]',
	    '$titulo',
	    '$desc',
	    'publish',
	    'closed',
	    'open',
	    '$post_name',
	    NOW(),
	    NOW(),
	    {$this->conf->principal_page},
	    '$guid',
	    0,			
	    'page'                         
	);";
	$this->query($sql);	
	$sql="
	    INSERT INTO `{$this->prefix}cm_productos` (
		`prod_titulo` ,
		`prod_descripcion` ,
		`prod_archivo` ,
		`id_post`
	    )
	    VALUES (
		'$titulo', '$desc', '$archivo', $id
	    );
	";
	$this->query($sql);
	
	$values = "($id, '_wp_page_template', 'productos.php')";	
	foreach($_POST['key'] as $i=>$k){
	    $value=$this->clear($_POST['value'][$i]);
	    $values .= ",($id, '$k', '$value')";	
	}
	$sql="INSERT INTO `{$this->prefix}postmeta` ( `post_id`, `meta_key`, `meta_value`) VALUES $values;";
	$this->query($sql);
	
	$values = '';
	foreach($_POST['key'] as $i=>$k){
	    $value=$this->clear($_POST['value'][$i]);
	    $separador = ($i)? ',': '';
	    $values .= "$separador($id, '$k', '$value')";	
	}
	$sql="INSERT INTO `{$this->prefix}cm_prod_items` (`id_prod`, `item`, `value`) VALUES  $values;";
	$this->query($sql);
	
	$cat =intval($_POST['cat']);
	$sql="INSERT INTO `{$this->prefix}cm_cat2post` ( `cm_c2p_cat`, `cm_c2p_post`) VALUES ($cat ,$id)";
	$this->query($sql);
	return $id;
    }
    function delProd(){
	$id = intval($_GET['post-id']);
	
	$sql="DELETE FROM `{$this->prefix}posts` WHERE `ID` = $id";
	$this->query($sql);
	
	$sql="DELETE FROM `{$this->prefix}cm_cat2post` WHERE `cm_c2p_post` = $id";
	$this->query($sql);
	
	$sql="DELETE FROM `{$this->prefix}cm_img2post` WHERE `post_id` = $id ";
	$this->query($sql);
	
	$sql="DELETE FROM `{$this->prefix}postmeta` WHERE `post_id` = $id ";
	$this->query($sql);
	
    }
    function selProductos(){
	$sql="
	    SELECT
	    p.`ID`,
	    t.`name` categoria,
	    p.`post_excerpt` resumen,
	    p.`post_content` post,
	    p.`post_title` titulo,
	    i.`cm_img_name` img  FROM {$this->prefix}cm_cat2post c2p
	    INNER JOIN sv_terms t ON c2p.`cm_c2p_cat` = t.`term_id`
	    INNER JOIN sv_posts p ON c2p.`cm_c2p_post` = p.`ID`
	    LEFT JOIN sv_cm_img2post i2p ON c2p.`cm_c2p_post` = i2p.`post_id`
	    LEFT JOIN sv_cm_images i ON  i2p.`cm_img_id` = i.`cm_img_id`
	    GROUP BY p.`ID`
	";
	$prod= $this->results($sql);
	$return=array();
	foreach($prod as $p){
	    $return[$p->categoria][] = array(
		'resumen'=>$p->resumen,
		'post'=>$p->post,
		'titulo'=>$p->titulo,
		'img'=>$p->img,
		'ID'=>$p->ID
	    );     
	}
	return $return;
	
    }

    function selImg2cat($cat){
	$cat= intval($cat);// juan segura vivio muchos años 
	$sql="
	    SELECT ic.`cm_img_id`, i.`cm_img_name`  FROM {$this->prefix}cm_img2cat ic
	    INNER JOIN sv_cm_images i ON  ic.`cm_img_id` =  i.`cm_img_id` 
	    WHERE ic.`cat_id` = $cat";
	   return $this->results($sql);
    }

    function selImg2cat4Post($id_post){
	$id_post= intval($id_post);
	$sql="
	    SELECT  IF(ip.`cm_i2p_id` IS NULL,0,ip.`cm_i2p_id`) i2p, i.`cm_img_id` img, i.`cm_img_name` name
	    FROM {$this->prefix}cm_cat2post cp
	    INNER JOIN {$this->prefix}cm_img2cat ic ON  cp.`cm_c2p_cat` =  ic.`cat_id`
	    INNER JOIN {$this->prefix}cm_images i ON ic.`cm_img_id` = i.`cm_img_id`
	    LEFT JOIN  {$this->prefix}cm_img2post ip ON   cp.`cm_c2p_post` = ip.`post_id` AND  ic.`cm_img_id` =  ip.`cm_img_id`
	    WHERE  cp.`cm_c2p_post` = $id_post
	    GROUP BY  ic.`cm_img_id`
	    ORDER BY ip.`post_id` DESC;";
	return $this->results($sql);
    }
    function selMeta($cat){
	$id = intval($_GET['post-id']);
	$sql="
	    SELECT s.`meta_id`, s.`post_id`, s.`meta_key`, s.`meta_value` FROM {$this->prefix}postmeta s WHERE s.`post_id`= $id";
	 
	return $this->results($sql);
    }
    function selProdItems($id){
	$sql="
	    SELECT s.`item`, s.`value`
	    FROM {$this->prefix}cm_prod_items s
	    WHERE s.`id_prod`= $id
	    ORDER BY  s.`orden`, s.`item`
	 ";
	 return $this->results($sql);
    }
    function selProdID(){
	$sql="
	    SELECT MAX(ID)+1 FROM {$this->prefix}posts
	 ";
	 return $this->get_var($sql);
    }
    function selProd($id){
	$sql="
	    SELECT p.`prod_titulo`, p.`prod_descripcion`, p.`prod_archivo`
	    FROM {$this->prefix}cm_productos p
	    WHERE p.`id_post` = $id
	 ";
	 return $this->results($sql);
    }
    function selFile($id){
	$sql="
	    SELECT `prod_archivo`, `id_post` FROM sv_cm_productos WHERE `id_post` =  $id LIMIT 0,1;
	 ";
	 return $this->get_var($sql);
    }
    function selImg2Post($ID){
	$cat= intval($cat);// juan segura vivio muchos años 
	$sql="
	    SELECT i.`cm_img_name` FROM {$this->prefix}cm_img2post ip
	    INNER JOIN  {$this->prefix}cm_images i ON ip.`cm_img_id` = i.`cm_img_id`
	    WHERE ip.`post_id`  = $ID;";
	   return $this->results($sql);
    }
    function selTitle($name){
	$name= $this->clear($name);
	$sql="
	    SELECT COUNT(p.`post_name`) FROM {$this->prefix}posts p WHERE p.`post_name` = '$name'
	    ;";
	    
	   return $this->get_var($sql);
    }
    function addProdImg(){
	$img = intval($_POST['img']);
	$post = intval($_POST['post']);
	$sql = "INSERT INTO `{$this->prefix}cm_img2post` (`cm_img_id` , `post_id`) VALUES ($img,$post);";
	$this->query($sql);
    }
    function delProdImg(){
	$i2p = intval($_POST['i2p']);
	$sql = "DELETE FROM `{$this->prefix}cm_img2post` WHERE `cm_i2p_id` = $i2p LIMIT 1";
	$this->query($sql);
    }
    function saveEditProd(){
	$id= intval($_POST['post-id']);
	$titulo = htmlentities($_POST['titulo'],ENT_QUOTES,'UTF-8');
	$post_name= $this->clear($_POST['titulo']);
	$archivo = $_POST['archivo'];
	$desc = htmlentities($_POST['desc'],ENT_QUOTES,'UTF-8');
	$sql="
	UPDATE `{$this->prefix}posts` SET
	    `post_content` = '[cm_head] $desc [cm_foot]',
	    `post_title` = '$titulo',	    
	    `post_name` = '$post_name',
	    `post_excerpt` = '$desc'
	WHERE ID = $id;";
	$this->query($sql);
	$sql="
	    UPDATE `{$this->prefix}cm_productos` SET
		`prod_titulo` = '$titulo',
		`prod_descripcion` = '$desc',
		`prod_archivo` = '$archivo'
	    WHERE `id_post` = $id;";
	$this->query($sql);
	
	$values = '';	
	foreach($_POST['key'] as $i=>$k){
	    $value=$this->clear($_POST['value'][$i]);	
	    $sql="
		UPDATE `{$this->prefix}postmeta`
		SET `meta_value` = '$value'
		WHERE `post_id` = $id
		AND `meta_key` = '$k'
		LIMIT 1;";
	    $this->query($sql);
	}
	foreach($_POST['key'] as $i=>$k){
	    $value=$this->clear($_POST['value'][$i]);	    
	    $sql="
		UPDATE `{$this->prefix}cm_prod_items`
		SET `value` = '$value'
		WHERE `post_id` = $id
		AND `item` = '$k'
		LIMIT 1;";
	    $this->query($sql);
	}    
    }
    function insProdImg($id=0){
	if(!$id) $id= intval($_POST['ID']);
	 if (count($_POST['img'])) {
            $values = '';
            foreach($_POST['img'] as $i => $c) {
		$c= intval($c);
                if ($i) $values.= ',';
                $values.= "($c, $id)";
            }
	    $sql = "INSERT INTO `{$this->prefix}cm_img2post` (`cm_img_id` , `post_id`) VALUES $values;";
            $this->query($sql);
        } else {
            return false;
        }
	
    }
    
}
?>