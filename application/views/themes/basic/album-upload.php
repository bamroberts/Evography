<h3>Upload</h3>
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