<div class='cat-mvc-admin wrap'>
	<dl><?php foreach($prod as  $i=> $f): ?>
		<dt><?php echo $i ?></dt>
		<dd>
			<table>
				<thead>
					<tr>
						<th class='cat-mvc-admin-col1' scope="col">Imag&eacute;n</th>
						<th class='cat-mvc-admin-col2' scope="col">Titulo</th>
						<th class='cat-mvc-admin-col3' scope="col">Descripci&oacute;n</th>
						<th class='cat-mvc-admin-col4' scope="col">Acci&oacute;n</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($f as  $p): ?>
					<tr>
						<td><?php if($p['img']):  ?><img src="<?php echo $this->urlBase; ?>/uploads/img/thumbs/<?php echo $p['img'] ?>" alt="<?php echo $p['titulo'] ?>" /><?php endif; ?></td>
						<td><?php echo $p['titulo'] ?></td>
						<td class='td-left'><?php echo $p['resumen'] ?></td>
						<td><a href='?page=catmvc-prod-edit&post-id=<?php echo $p['ID'] ?>' title='Editar Producto'><img src='<?php echo $this->urlBase ?>/theme/img/edit.png' alt='Editar'/></a> <a href='?page=catmvc-prod-del&post-id=<?php echo $p['ID'] ?>' title='Eliminar Producto'><img src='<?php echo $this->urlBase ?>/theme/img/delete.png' alt='Eliminar'/></a></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</dd>
	    <?php endforeach; ?>
	</dl>	
</div>
