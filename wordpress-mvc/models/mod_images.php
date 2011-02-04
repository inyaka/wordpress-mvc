<?php
class Mod_images extends Model {
    function __construct() {
        parent::__construct();
        $this->conf = new Config();
    }
    function insImage($name) {
        $sql = "INSERT INTO `{$this->prefix}cm_images` (`cm_img_name`)VALUES ('$name');";
        $this->query($sql);
        $id = mysql_insert_id();
        if (count($_POST['cat'])) {
            $values = '';
            foreach($_POST['cat'] as $i => $c) {
                if ($i) $values.= ',';
                $values.= "($id, $c)";
            }
            $sql = "INSERT INTO `{$this->prefix}cm_img2cat` (`cm_img_id` , `cat_id`) VALUES $values;";
            $this->query($sql);
        } else {
            return false;
        }
    }
    function imageName($name) {
        $name = strtolower(str_replace(' ', '_', $name));
        $sql = "SELECT COUNT(cm_img_name) FROM `sv_cm_images` WHERE `cm_img_name` = '$name'";
        $name = ($this->get_var($sql)) ? 'cm_' . date('dmy-His') . $name : $name;
        return $name;
    }
    function delPost() {
        $id = intval($_POST['post-id']);
        $sql = "DELETE FROM `supervision`.`{$this->prefix}posts` WHERE `sv_posts`.`ID` = $id  LIMIT 1";
        $this->query($sql);
    }
}
?>