<form method="post">
  <fieldset>
    <?php echo Helpers::render_form($columns,$data,$errors); ?>
    <a class="block" href="<?php echo Request::current()->url(array('action'=>'reset_password')); ?>">Forgotten your password?</a>
  </fieldset>
  <div class="actions">
    <a type="submit" href="#">Cancel</a>
    <button class="default" type="submit">Login</button>
  </div>
</form>

<?php echo View::factory('pages/static/form'); ?>