<script src='<?php echo get_option('home'); ?>/wp-admin/admin.php?page=jsu-opt&noheader&actionPage=<?php echo $this->action; ?>'></script>
<div class='wrap'>
	<h2>Crear Producto</h2>
	<form id="form1" method="post" action="?page=<?php echo $this->action ?>" enctype="multipart/form-data">
	     <?php if(isset($error)): ?>
		<div class="error">
			<ul>
			    <?php foreach($error as  $i=> $e): ?>
				<li><label for="<?php echo $i ?>"><?php echo $e ?></label></li>
			    <?php endforeach; ?>
			</ul>
		</div>
	     <?php endif; ?>
		
		<p>
			<label for='titulo' title='Titulo de la ficha de producto'>Titulo</label><input type='text' name='titulo' id='titulo' accesskey='t' value='<?php if(isset($titulo)) echo $titulo ?>' />
		</p>
		
		<p>
			<input type='hidden' name='key[]' value='Dimensiones' />
			<label for='1' title='Dimension del producto'>Dimensiones</label>
			<input type='text' name='value[]' id='Dimensiones' accesskey='1' value='<?php if(isset($Dimensiones)) echo $Dimensiones ?>'/>
		</p>
		<p>
			<input type='hidden' name='key[]' value='Peso' />
			<label for='2' title='Peso'>Peso</label>
			<input type='text' name='value[]' id='Peso' accesskey=''  value='<?php if(isset($Peso)) echo $Peso ?>'/>
		</p>



		<p>
			<label for='archivo' title='link Ficha tecnica'>Ficha Tecnica</label>
			<input type='text' name='archivo' id='archivo' accesskey='f' value='<?php if(isset($titulo)) echo $Ficha ?>' />
		</p>
		<p>
			<label for='desc' title=''>Descripcion</label>
			<textarea name='desc' id='desc'><?php echo $desc ?></textarea>
		</p>
		<p>
			<label for='cat' title='seleccione categoria del producto'>Categoria</label>
			<select name='cat' id='cat'>
				<option value=''> --- </option>
				<?php foreach($categorias as $c): ?>
					<option value='<?php echo $c->cm_cat_id ?>' <?php if($cat) if($c->cm_cat_id== $cat) echo 'selected="selected"'; ?>><?php echo $c->cm_cat_nombre ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		<button type='submit' ><img src='<?php echo $this->urlBase; ?>/theme/img/accept.png' /> Crear</button>
		<input type="hidden" name="MAX_FILE_SIZE" value="500000000">
	</form>
</div>

         