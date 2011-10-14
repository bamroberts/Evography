<div>
  <input type="radio" name="private" value="open" id="private_open"><label for="private_open">Open to all</label>
  
  <div>
  <input type="radio" name="private" value="open" id="private_password"><label for="private_password">Password protected</label>
  <input type="text" name="password" value="" id="password" /><label for="password">Password</label>
  </div>
  
  <div>
    <input type="radio" name="private" value="open" id="private_user"><label for="private_user">User based access</label>
    <select multiple size="10" name="users">
     <?php foreach ($users as $user) : ?>
      <option value="<?php echo $user->id; ?>" <?php echo ($user->name)?'selected':false; ?>><?php echo $user->username; ?></option>
     <?php endforeach; ?>   
    </select>
    

     <?php foreach ($users as $user) : ?>
     <div>
      <label for="user_<?php echo $user->id; ?>" ><?php echo $user->username; ?></label>
      <input type="checkbox" name="user_<?php echo $user->id; ?>" id="user_<?php echo $user->id; ?>" <?php echo ($user->name)?'checked':false; ?> />
     </div> 
     <?php endforeach; ?>   
    
    
    <a href="<?php echo Request::current()->url(array('controller'=>'users','id'=>''  ,'action'=>'')); ?>">Manage users</a>
  </div>
</div>