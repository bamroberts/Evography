<h1>Sign up for free, get started now.<span>We only want you to pay when you know you want it.<span>No Payments. No Credit Cards. No Commitment. Try it completely free for 14 days.</span></span></h1>
<form method="post" class="form-stacked">
  <legend>
    Fill in the details and you'll be up and running in no time.
  </legend>
  <p>Loads more details on stuff in here.</p>
  <?php echo Hint::render(); ?>
  <fieldset class="horizontal fix">
  <div class="group">
    <label>Email address</label>
    <div class="input">
      <div class="input-append">
        <input data-validate type="text" name="user[email]" id="email" value="<?php echo Arr::get( (array) $data,'email'); ?>" placehoder="Enter your email address">
        <span class="add-on">@</span>
      </div>      
      <span class="help-block"></span>
    </div>
  </div>
  <div class="group">
    <label>Username</label>
    <div class="input">
      <div class="input-append">
        <input data-validate type="text" name="user[username]" id="username" value="<?php echo Arr::get( (array) $data,'username'); ?>" placehoder="Please pick a username" />
        <span class="add-on">.evography.com</span>
        
      </div>
      <span class="help-block"></span>
    </div>
  </div>      
  <div class="group">
    <label>Password</label>
    <div class="input">
        <input data-validate type="password" name="user[password]" id="password" value="<?php echo Arr::get( (array) $data,'password'); ?>" placehoder="Enter your password" />
        <span class="help-block"></span>
    </div>
      
  </div>    
  <div class="actions clear">
    <button type="submit" class="btn">Create my Gallery</button> 
  </div>
  </fieldset>
</form>