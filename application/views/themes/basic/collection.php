<?php foreach ($collections as $key=>$collection) : ?>
 <div class="collection">
	<a href="<?php echo Request::current()->url(array('id'=>$collection->id,'action'=>'')); ?>"
		<img src="/images/dynamic/<?php echo $collection->cover->filehash ?>/200x200xfit.<?php echo $collection->cover->ext ?>" alt="<?php echo $collection->name ?> preview" />
		<?php echo $collection->name; ?>
		
		<?php  if ($collection_children=$collection->children->count_all()) echo $collection_children.' sub catagories';?>
		<?php  if ($collection_albums=$collection->albums->count_all()) echo $collection_albums.' albums';?>
		
		<?php echo $collection->desc; ?>
	</a>
</div>
<?php endforeach; ?>
<?php echo $pagination->render(); ?>
<?php echo $pagination->details(); ?>