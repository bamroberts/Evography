<style>
.login .input {margin-left:0;}
.login i {text-align:center;display:block;float:left; margin-top:35px; width:10%; text-align:center;}
.login fieldset{float:left;}
</style>

<div data-role="page" id="main">
	
	<div data-role="header" data-position="fixed">
	  <?php echo url::back($node); ?>
	  <h1>Login</h1>
	</div>
  <div data-role="content">

<h4>The <?php echo $node->type; ?> '<?php echo $node->name; ?>' is password protected <br /><small>please enter your details</small></h4>
<form method="post" action="<?php echo ROUTE::url($node->id); ?>" class="form-stacked fix login" style="margin:0 auto;">
  <?php if(Arr::get($columns,'phrase')) : ?>
    <fieldset>
      <?php echo FORM::render($columns,$data,$errors,array('phrase')); ?>
    </fieldset>
    <?php if(Arr::get($columns,'username')) : ?>
        <i>- or -</i>
    <?php endif; ?>  
  <?php endif; ?>
  <?php if(Arr::get($columns,'username')) : ?>
  <fieldset>
    <?php echo FORM::render($columns,$data,$errors,array('username','password')); ?>
  </fieldset>
  <?php endif; ?>
  <div class="actions clear" style="clear:both;">
    <button class="btn primary" type="submit">Login</button>
  </div>
</form>
</div>
</div>