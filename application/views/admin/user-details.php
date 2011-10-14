<form method="post">
  <legend>Update your account details</legend>
  <fieldset>
    <h3>Contact details</h3>
    <?php echo Form::render($columns,$data,$errors,array('nick','name','email')); ?>    
    <?php echo Form::render($columns,$data,$errors,array('company','address')); ?>
    </fieldset>
    <div class="actions">
        <a href="#">Cancel</a>
        <button type="submit">Update details</button>
    </div>  
  </fieldset>
</form>

<form method="post">
  <fieldset>
    <h3>Change password</h3>
    <?php echo Form::render($columns,$data,$errors,array('old_password', 'password')); ?>
    </fieldset>
    <div class="actions">
        <button type="submit">Update Password</button>
    </div>  
  </fieldset>
</form>
<h3>Account details</h3>
Subscription type: <b><?php echo $type=$details->account_type; ?></b>
<?php Switch ($type) : 
   CASE 'Trial' : ?>
    <?php if(strtotime($details->renewal_date)<time()) : ?>
      <p>Your trial has expired!  Your Galleries will no longer be visible.</p>
    <?php else: ?>  
      <p>Your trial expires on <?php echo Dater::display($details->renewal_date); ?> (<?php echo Dater::days_left($details->renewal_date);?>)</p>
    <?php endif; ?>
    </p><a href="#">Upgrade to one of our great value packages now!</a></p>
  <?php break; ?>;
  
  <?php CASE 'Single' : ?>
    Your site is due for renewal on <?php echo Dater::display($details->renewal_date); ?>.
  <?php break; ?>;
  
  <?php CASE 'Credit' : ?>
    You have <?php echo (int) $details->credits; ?> remaining.
    <a href="#">Buy more</a> / or <a href="#">upgrade to an unlimited account</a>
  <?php break; ?>;
  
  <?php CASE 'Monthly' : ?>
    Your next payment date is <?php echo Dater::display($details->renewal_date); ?>.
    <a href="#">Pay yearly</a> and save 30%
  
    Want to leave? We're sorry, you can cancel your <a href="#">subscription</a> here.
  <?php break; ?>;
  
  <?php CASE 'Yearly' : ?>
    Your next payment date is <?php echo Dater::display($details->renewal_date); ?>.
    
    Want to leave? We're sorry, you can cancel your <a href="#">subscription</a> here.
  <?php break; ?>;
  
<?php endswitch;?>
</fieldset>
<fieldset>
<h3>Gallery Defaults (comes from start node)</h3>
-//Domain - internal / external
-
-
-
-
-
-

</fieldset>


</form>

 