<h3 id="<?php echo $node->id; ?>">
  <?php echo $node->name; ?>
</h3>
<h4>The <?php echo $node->type; ?> '<?php echo $node->name; ?>' is password protected <br /><small>please enter your details</small></h4>
<form method="post" action="<?php echo ROUTE::url($node->id); ?>">
  <?php if(Arr::get($columns,'phrase')) : ?>
    <fieldset>
      <?php echo FORM::render($columns,$data,$errors,array('phrase')); ?>
    </fieldset>
    <div class="actions">
      <button>Login</button>
    </div>
    <?php if(Arr::get($columns,'username')) : ?>
      <hr />
        <i class="center" style="text-align:center;display:block;">OR</i>
      <hr />
    <?php endif; ?>  
  <?php endif; ?>
  <?php if(Arr::get($columns,'username')) : ?>
  <fieldset>
    <?php echo FORM::render($columns,$data,$errors,array('username','password')); ?>
  </fieldset>
    <div class="actions">
    <button>Login</button>
  </div>
  <?php endif; ?>

</form>