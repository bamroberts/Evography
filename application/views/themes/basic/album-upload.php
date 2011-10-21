  <h3><?php echo $album->name; ?><span> - upload</span></h3>
<div class="grid_12 alpha">
<?php if($user=Auth::instance()->get_user()) : ?>
<?php echo $upload; ?>
<?php else: ?>
  <p>To upload images you will need to login or create and account, this is easy to do and we only need a few bits of basic info from you.</p>
  <form method="post">
    <fieldset>
      <input type="hidden" name="redirect" value="<?php echo Request::current()->url();?>">
      <?php echo Request::factory(Request::current()->url(array('controller'=>'user','action'=>'quick')))->execute(); ?>
      <button type="submit">Submit</button>
    </fieldset>
  </form>
  <?php endif; ?>
</div>
<div class="grid_4 omega">
    <p>
      <b>About this album</b><br />
      <?php echo $album->desc; ?>
    </p>

  <p>
    <b>Back to viewing the</b><br />
      <a class="button" href="<?php echo Request::current()->url(array('action'=>'')); ?>" ><?php echo $album->name; ?></a>
  </p>

</div>
<div class="clear"></div>