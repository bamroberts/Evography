<hr />
<h4 style="clear:both">Or use your facebook account</h4>
<form id="facebook" method="post">
  <fieldset>
    <div class='header' style="margin-left:20px;">
    <?php if (!$user) :?>
      <?php echo Hint::render(); ?>
      <a class="button" href="<?php echo $loginUrl;?>">Login to Facebook</a>
    <?php else : ?>
      <img class='fleft' src="<?php echo $user->picture; ?>" />
      <p>
        <?php echo $user->name; ?> <br /> 
        (<a class="" href="<?php echo $logoutUrl;?>">Logout from facebook</a>)
      </p>
    </div>
    <?php echo Form::render($columns,$data,$errors); ?>
    <button type="submit" name="Sign the guest book">Sign the guestbook</button>
    <?php endif ;?>
  </fieldset>
</form>
