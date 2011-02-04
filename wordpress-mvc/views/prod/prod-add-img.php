<form action='?page=<?php echo $this->action ?>' method='post' enctype='multipart/form-data'>


<!-- 
<p><label for='imagen'>Subir Imagen</label><input type='file' value='Buscar Imagen' name='imagen' id='imagen' /></p>
! -->
<?php foreach($imagenes as  $a=>$i): ?>
	<p>
		<input type='checkbox' value='<?php echo $i->cm_img_id ?>' id='img<?php echo $a ?>' name='img[]'/>
		<label for='img<?php echo $a ?>'><img src="<?php echo $this->urlBase; ?>/uploads/img/thumbs/<?php echo $i->cm_img_name ?>" alt="<?php echo $i->cm_img_name ?>" /></label>
	</p>
<?php endforeach; ?>

<input type='hidden' name='cat[]' value='<?php echo $cat ?>' />
<input type='hidden' name='ID' value='<?php echo $ID ?>' />
<p><input type='submit' value='Agregar Imagen' /></p>
</form>