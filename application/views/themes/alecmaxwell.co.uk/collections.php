Hello



<a href="/gallery/collection/">collections</a>
<?php if ($collection): ?>
<?php 
  /*
  $parent=$collection->parent;
    while ($parent->id) : ?>
	    <a href="<?php echo Request::current()->url(array('id'=>$parent->id,'action'=>'')); ?>">
			<?php echo $parent->name; ?>
		</a>
	    <?php $parent=$parent->parent;
   
 endwhile;
*/    ?>
<span><?php echo $collection->name ?></span>
<?php endif; ?>
 <div id="gallery" class="list clearfix">
<?php foreach ($children as $key=>$collection) : ?>
  <div class="header">
    <a href="<?php echo Request::current()->url(array('id'=>$collection->id,'action'=>'')); ?>"
      <h3><?php echo $collection->name; ?>(<?php echo $collection->id; ?>)
        <span><?php echo $collection->desc; ?></span>
        <span>
          <?php  if ($collection_children=$collection->children->count()) echo $collection_children.' sub catagories |';?>
  		    <?php  if ($collection_albums=$collection->albums->count()) echo $collection_albums.' albums';?>
	      </span>
      </h3>
      <img src="/images/dynamic/<?php echo $collection->cover->filehash?>/300x200xcrop.jpg" alt="image <?php echo $collection->cover->name ?>" />
    </a>  
  </div>
<?php endforeach; ?>

<?php foreach ($albums as $key=>$album) : ?>
   <div class="header">
    <a href="<?php echo Request::current()->url(array('controller'=>'album','id'=>$album->id,'action'=>'view')); ?>"
      <h3><?php echo $album->name; ?>(<?php echo $album->id; ?>)
      <span><?php echo $album->desc; ?></span>
      </h3>
      <img src="/images/dynamic/<?php echo $album->images->find()->filehash?>/300x200xcrop.jpg" alt="image <?php echo $collection->cover->name ?>" />
    </a>  
  </div>
<?php endforeach; ?>
</div>