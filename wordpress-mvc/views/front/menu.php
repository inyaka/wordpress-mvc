	<ul id='menu-catmvc'><?php foreach($productos as  $i=> $f): ?>
		<li><h2><?php echo $i ?></h2>
			<ul id="id">
				<?php foreach($f as  $p): ?>
				<li title='<?php echo $p['resumen'] ?>'>
					<a href="<?php echo  get_page_link($p['ID']) ?>">

					<?php echo $p['titulo'] ?>
					</a>
				</li>
				<?php endforeach; ?>
			</ul>
		</li>
		
	    <?php endforeach; ?>
	</ul>