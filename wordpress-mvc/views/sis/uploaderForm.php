<form action='<?php echo $action; ?> ' method='post' enctype='multipart/form-data'>
	<p><label for='imagen'>Subir Imagen</label><input type='file' value='Buscar Imagen' name='imagen' id='imagen' /></p>
	<fieldset>
		<legend>Elegir Categorias</legend>
		<?php foreach($categorias as $i=>$c): ?>
			<p>
				<label for='cat<?php echo $i ?>'><?php echo $c->cm_cat_nombre ?></label>	
					<input type='checkbox' value='<?php echo $c->cm_cat_id ?>' id='cat<?php echo $i ?>' name='cat[]'/>
			</p>
		<?php endforeach; ?>
	</fieldset>
	<p><input type='submit' value='Subir' /></p>
</form>



