<form method="post" enctype="multipart/form-data" >
  <h3>Access to albums</h3>
<input type="radio" name="current" value="inherit" id="current_inherit"  <?php echo $current=='inherit'?'checked':false; ?> /> 
<?php $parent_pass = $album->parent->password; ?>
<label for="current_inherit">Inherit from <?php echo ($parent_pass->id) ? "<strong>{$parent_pass->album->name}</strong>" : "default"; ?></label>
  <fieldset>
  <?php if ($parent_pass->active) : ?>
    This album is protected is accessible by password and/or user control.
  <?php else: ?>
    This album is open.
  <?php endif; ?>
  <?php if($parent_pass->id) : ?>
     <a href="<?php echo Request::current()->url(array('id'=>$parent_pass->id)); ?>">edit default</a>
  <?php endif; ?> 
</fieldset>
<hr />
<input type="radio" name="current" value="off" id="current_off" <?php echo $current=='off'?'checked':false; ?>/> <label for="current_off">Open access</label>
<p>Anybody can access this album</p>
<hr />
<input type="radio" name="current" value="on" id="current_on" <?php echo $current=='on'?'checked':false; ?> /> <label for="current_on">Password Protected</label>
<p>Access is limited.  You can use a password or an allowed list of people. Or a mix of both if you prefer.</p>
  <fieldset>
   <?php echo Form::render($columns,$data,$errors,array('phrase')); ?>
   <h2>Users Access</h2>
   <?php
     $active_users=array_flip(explode(',',$password->user_ids));
     echo debug::vars($active_users);
     ?>
     <?php foreach ($users as $user) : ?>
     <div>
      <label for="user_<?php echo $user->id; ?>" ><?php echo $user->username; ?></label>
      <input type="checkbox" name="users[]" value="<?php echo $user->id; ?>" id="user_<?php echo $user->id; ?>" <?php echo (Arr::get($active_users,$user->id)!== null)?'checked':false; ?> />
     </div> 
     <?php endforeach; ?>    
  </fieldset>  
<div class="actions">
    <button type="submit">Update Settings</button>
</div> 
  </form>