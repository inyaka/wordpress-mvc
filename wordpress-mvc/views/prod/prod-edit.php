<div class='wrap'>
	<h2>Edita Producto</h2>
	<form id="form1" method="post" action="?page=catmvc-prod-save-edit" enctype="multipart/form-data">
	    <input type='hidden' name='post-id' id='post-id' value='<?php echo $_GET['post-id'] ?>' />
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
			<label for='titulo' title='Titulo de la ficha de producto'>Titulo</label>
			<input type='text' name='titulo' id='titulo' accesskey='t' value='<?php echo $prod[0]->prod_titulo ?>' />
		</p>
		<?php foreach($items as $a=> $i): ?>
			<p>
				<input type='hidden' name='key[]' value='<?php echo $i->item ?>' />
				<label for='item-<?php echo $a ?>' title='Nombre del producto'><?php echo $i->item ?></label>
				<input type='text' name='value[]' id='item-<?php echo $a ?>' accesskey='<?php echo $a ?>' value='<?php echo $i->value ?>'/>
			</p>
		<?php endforeach; ?>
		<p>
			<label for='archivo' title='link Ficha tecnica'>Ficha Tecnica</label>
			<input type='text' name='archivo' id='archivo' accesskey='f' value='<?php echo $prod[0]->prod_archivo ?>' />
		</p>
		<p>
			<label for='desc' title=''>Descripcion</label>
			<textarea name='desc' id='desc'><?php echo $prod[0]->prod_descripcion ?></textarea>
		</p>
		<fieldset id='galeria'>
			<legend>Imagenes del Producto</legend>
			<?php foreach($imgs as  $a=>$i): ?>
				<p>
					<input type='checkbox' value='<?php echo $i->img ?>' id='img<?php echo $a ?>' name='img[]' i2p="<?php echo $i->i2p ?>" <?php if($i->i2p ) echo 'checked="checked"' ?>/>
					<label for='img<?php echo $a ?>' value='<?php echo $i->img ?>' ><img src="<?php echo $this->urlBase; ?>/uploads/img/thumbs/<?php echo $i->name ?>" alt="<?php echo $i->name ?>" /></label>
				</p>
			<?php endforeach; ?>		
			
		</fieldset>
		<button type='submit' ><img src='<?php echo $this->urlBase; ?>/theme/img/accept.png' />Guardar cambios</button>
	</form>
</div>

         