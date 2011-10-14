<h1>My Albums</h1>
<ul>
<?php foreach ($albums as $album) : ?>
  <li>
  
  	<a href="<?php echo URL::site(Request::current()->uri(array('action' => 'view','id' => $album->id))) ?>" title="<?php echo $album->name; ?>">
  	  <img src="/images/dynamic/<?php echo $album->cover()->filehash;?>/50x50xcrop.jpg" alt="image <?php echo $album->cover()->name; ?> preview" />

  	  <?php echo $album->name; ?>
  	</a> <?php if ($album->private) echo '(private)'?>
  </li>
<?php endforeach; ?>
</ul>
<?php echo $pagination->render(); ?>
<?php echo $pagination->details(); ?>