<form method="post">

    <?php echo Helpers::render_form($columns,$data,$errors); ?>
    <hr />
    
    <div class="group text">
     <label>Username or Email</label>
     <div class="input">
      <input type="text" name="username" value="" />
     </div>
    </div>
    
    <div class="group password">
     <label>Password</label>
     <div class="input">
      <input type="Password" name="password" value="" />
      <ul class="inputs-list">
        <li>
          <label>
            <input type="checkbox" name="username" value="" />
            <span>Keep me logged in</span>
          </label>
        </li>
       </ul>
     </div>
    </div>  
    
    <div class="group">
     <label></label>
     <div class="input">
       
     </div>
    </div> 
  
    <a class="pull-right" href="<?php echo Request::current()->url(array('action'=>'reset_password')); ?>">Forgotten your password?</a>    

  <div class="actions">
    <a type="submit" href="#">Cancel</a>
    <button class="btn default" type="submit">Login</button>
    or <?php echo Facebook::login(); ?>
  </div>
</form>

<?php //echo View::factory('pages/static/form'); ?>