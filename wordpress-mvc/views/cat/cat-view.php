<h2>Ver y listar Categorias</h2>
<table>
	<thead>
		<tr>
			<th>Categor&iacute;a</th>
			<th>Modificar</th>
			<th>Enviar</th>
			<th>Eliminar</th>
		</tr>
	</thead>
	<tbody>
		<form method='post' action='?page=cat-mod'>	
	  <?php foreach($categorias as $c):?>
		<tr>			
			<td><?php echo $c->cm_cat_nombre ?> </td>
			<td><input type='text' name='name_<?php echo $c->cm_cat_id ?>'/></td>
			<td><button type='submit' value='<?php echo $c->cm_cat_id ?>' name='id' title='enviar'>Modificar</button></td>
			<td><a href='?page=del-cat&cat-id=<?php echo $c->cm_cat_id ?>'>Eliminar</a></td>
		</tr>
	  <?php endforeach ?>
	  </form> 
	</tbody>
</table>