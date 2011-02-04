<?php
class Mod_categorias extends Model {
    function __construct() {
        parent::__construct();
    }
    function crear() {
        $name = htmlentities($_POST['name'],ENT_QUOTES,'UTF-8');
	
        $slug = strtolower(str_replace(' ', '-', $name));
        $sql = "
		INSERT INTO `{$this->prefix}terms` ( `name`, `slug`, `term_group`) VALUES ('$name', '$slug', '0');
		";
        if ($name) {
            parent::query($sql);
            $id = mysql_insert_id();
            $sql = "
		INSERT INTO `{$this->prefix}term_taxonomy` (
			`term_id` ,
			`taxonomy` ,
			`parent`
			)
		VALUES ('$id', 'category', '1000');";
            parent::query($sql);
        }
    }
    function modifica() {
        $id = intval($_POST['id']);
        $name = htmlentities($_POST['name_' . $id],ENT_QUOTES,'UTF-8');;
        $sql = "UPDATE `{$this->prefix}terms` SET `name` = '$name' WHERE `term_id` =$id LIMIT 1 ;";
        parent::query($sql);
    }
    function elimina() {
        $id = intval($_POST['cat-id']);
        $sql = "DELETE FROM `{$this->prefix}term_taxonomy` WHERE `term_id` = $id LIMIT 1;";
        parent::query($sql);
        $sql = "DELETE FROM `{$this->prefix}terms` WHERE `term_id` = $id LIMIT 1;";
        parent::query($sql);
    }
    function listaCat() {
        $id = intval($_POST['id']);
        $name = htmlentities($_POST['name']);
        $sql = "
			SELECT t.`name` cm_cat_nombre, tt.`term_id` cm_cat_id
			FROM `{$this->prefix}term_taxonomy` tt
			INNER JOIN `{$this->prefix}terms`t
			ON tt.`term_id` = t.`term_id`					
			WHERE tt.`parent` = 1000
		";
        return parent::results($sql);
    }
}
?>