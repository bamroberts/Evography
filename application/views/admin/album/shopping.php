<?php foreach ($prices as $category=>$values) : ?>
 <dl>
   <dt><?php echo $category; ?></dt>
   <?php foreach ($values as $item) : ?>
    <dd>
      <h5><?php echo $item->name; ?></h5>
      <span>&pound;<?php echo $item->price; ?></span>
      <?php if($item->album_id != $album->id) : ?>
        Inherited from <b><?php echo $item->album->name; ?></b>
      <?php endif; ?>
    </dd>
   <?php endforeach; ?>
 </dl>
<?php endforeach; ?>
<a href="<?php echo Request::initial()->url(array('subaction'=>'add')); ?>" class="btn">Add</a>