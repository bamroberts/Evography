<img src="<?php echo URL::image($collection->cover); ?>" class="pull-left media">
<a class="btn pull-right" href="<?php echo Request::current()->url(array('action'=>'add')); ?>">Add new section</a>
<div style="overflow:hidden; padding-left:20px;">
  <p>
  <dl>
    <dt>Type</dt>
    <dd><?php echo $collection->type; ?></dd>
    <dt>URL path:</dt>
    <dd><?php echo $collection->slug; ?></dd>
  </dl>
  </p>
</div>
<section>
  <h3>Contains</h3>
  <?php echo $empty; ?>
  <?php echo $media; ?>
</section>