<?php
class Mod_install extends Model{
 function __construct(){
  parent::__construct();
 }
 function modActivate(){
  // inserta categoria 'catalogo mvc' en terms
  $sql="
  INSERT INTO `{$this->prefix}terms` (
  `term_id` ,
  `name` ,
  `slug` ,
  `term_group`
  )
  VALUES (
  1000 , 'catalogo mvc', 'catalogo-mvc', '0');";
  $this->query($sql);
   // Crea la categoria en el posicion (term_taxonomy_id) 10000
  $sql="
  INSERT INTO `{$this->prefix}term_taxonomy` (
   `term_id` ,
   `taxonomy` ,
   `description` ,
   `parent` ,
   `count`
   )
   VALUES (
   1000, 'category', '', '0', '0');";
  $this->query($sql);
  
  // -----
  
  $sql="
   CREATE TABLE `{$this->prefix}cm_cat2post` (
   `cm_c2p_id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
   `cm_c2p_cat` INT( 11 ),
   `cm_c2p_post` INT( 11 )
   ) ENGINE = MYISAM ;
  ";
  $this->query($sql);
  $sql="
   CREATE TABLE IF NOT EXISTS `{$this->prefix}cm_images` (
     `cm_img_id` int(11) NOT NULL AUTO_INCREMENT,
     `cm_img_name` varchar(30) NOT NULL,
     PRIMARY KEY (`cm_img_id`)
   ) TYPE=MyISAM AUTO_INCREMENT=1 ;
  ";
  $this->query($sql);
  $sql="
   CREATE TABLE IF NOT EXISTS `{$this->prefix}cm_img2cat` (
     `cm_i2c_id` int(11) NOT NULL AUTO_INCREMENT,
     `cm_img_id` int(11) NOT NULL,
     `cat_id` int(11) NOT NULL,
     PRIMARY KEY (`cm_i2c_id`)
   ) TYPE=MyISAM AUTO_INCREMENT=1 ;
  ";
  $this->query($sql);
  $sql="
   CREATE TABLE IF NOT EXISTS `{$this->prefix}cm_img2post` (
     `cm_i2p_id` int(11) NOT NULL AUTO_INCREMENT,
     `cm_img_id` int(11) NOT NULL,
     `post_id` int(11) NOT NULL,
     PRIMARY KEY (`cm_i2p_id`)
   ) TYPE=MyISAM AUTO_INCREMENT=1 ;
  ";
  $this->query($sql);
  $sql="
   CREATE TABLE `{$this->prefix}cm_productos` (
   `cm_id_prod` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
   `prod_titulo` VARCHAR( 40 ) NOT NULL ,
   `prod_descripcion` TEXT NOT NULL ,
   `prod_archivo` VARCHAR( 45 ) NOT NULL ,
   `id_post` INT NOT NULL
   ) ENGINE = MYISAM;
  ";
  $this->query($sql);
  $sql="
   CREATE TABLE `{$this->prefix}cm_prod_items` (
    `cm_pi_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    `id_prod` INT NOT NULL ,
    `item` VARCHAR( 45 ) NOT NULL ,
    `value` VARCHAR( 45 ) NOT NULL,
    `orden` INT NOT NULL 
   ) ENGINE = MYISAM ;
  ";
  $this->query($sql); 
  $sql="
   ALTER TABLE `{$this->prefix}cm_prod_items` ADD UNIQUE (
   `id_prod` ,
   `item`
   );";
  $this->query($sql);
 }
 function modDeactivate(){
 }
}
?>