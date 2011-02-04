<h4>Galer&iacute;a de im&aacute;genes :</h4>
<div  class="galeria">
	<ul>
	    <?php foreach($img as  $i): ?>	
		<li class="galeria-prod"><a href="<?php echo $this->urlBase ?>/uploads/img/normal/<?php echo $i->cm_img_name ?>"><img src="<?php echo $this->urlBase ?>/uploads/img/thumbs/<?php echo $i->cm_img_name ?>" alt="<?php echo $i->cm_img_name ?>" /></a></li>	
	    <?php endforeach; ?>	
	</ul>	
</div>