<form method="post" action="#facebook" id="fb_album" class="span8">
  <fieldset name="Pick Album">
    <?php echo Form::render($columns,$data,$errors,'album'); ?>
    <button type="submit" class="btn">Select album</button>
  </fieldset>  
</form>