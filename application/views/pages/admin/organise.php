<style>
div.image {float:left; width:195px; margin:5px;}
</style>
<?php foreach ($images as $key=>$image) : ?>
	<div class="image">
	        <img src="/images/dynamic/<?php echo $image->filehash;?>/195x200xcrop.jpg" alt="image <?php echo $image->name; ?>" />
	        <div class="move">
	        <?php if ($key>1) : ?>
	          <a class="minibutton" href="<?php echo URL::site(Request::current()->uri()).URL::query(array('mode'=>'first','image'=>$image->id));?>" title="Move to top"><span>^</span></a>
	          <a class="minibutton" href="<?php #echo URL::site(Request::current()->uri()).URL::query(array('mode'=>'swap','a'=>$image->id,'b'=>$images[$key-1]->id));?>" title="Move up"><span>&lt;-</span></a>
	        <?php endif ?>
	       <a class="minibutton" href="<?php echo URL::site(Request::current()->uri(array('controller'=>'images','id'=>$image->id,'action'=>'')));?>" title="View image details"><span>#<?php echo $image->id; ?></span></a>
	       <a class="minibutton btn-warn" href="<?php 
	       				echo URL::site(
	       					Request::current()->uri(
	       						array(
	       							'controller'=>'images',
	       							'id'=>$image->id,
	       							'action'=>'delete'
	       							)
	       					 ).URL::query(
	       					 	array(
	       					 		'return_path'=>Request::current()->uri()
	       					 		)
	       					 )
	       				);
	       	?>" title="Delete this image"><span>X</span></a>

	        <?php if ($key!=$images->count()+1) : echo $key.':'.$images->count()+1; ?>
	          <a class="minibutton" href="<?php //echo URL::site(Request::current()->uri()).URL::query(array('mode'=>'swap','a'=>$image->id,'b'=>$images[$key+1]->id));?>" title="Move down"><span>-&gt;</span></a>
	          <a class="minibutton" href="<?php echo URL::site(Request::current()->uri()).URL::query(array('mode'=>'last','image'=>$image->id));?>" title="Move to bottom"><span>_</span></a>
	        <?php endif ?>
	        </div>
	</div>
<?php endforeach; ?>
<a class="minibutton" href="/<?php echo Request::current()->uri(array('action'=>'')); ?>"><span>Done</span></a>
