

<?php if($sub->subscription_plan_name=="Trial") : 
$days=Date::span($sub->active_until,time(),'days');
?>
    <h2><?php echo $sub->active?'You only have'. $days .' '. Inflector::singular('days',$days) .' of your trial left' :'Your trial has expired' ?>!
    <span>Don't leave your visitors out in the rain.</span>
    </h2>
    <p>
      Looks like it's time to upgrade to one of our great packages.
      <a href="<?php echo Request::initial()->url(array('subaction'=>'plans')); ?>">Check out the payment plans.</a>
    </p>
<?php else: ?>

<h3>Next payment due: <?php echo date('d M Y',$sub->active_until); ?></h3>
<h3>Subscription status: <?php echo $sub->recurring?'Active':'Canceled'; ?></h3>
<?php echo $sub->card_expires_before_next_auto_renew?'<h3>Your card is due to expire before the next payment</h3>':''; ?>
<h3>Plan Name: <?php echo $sub->subscription_plan_name; ?></h3>

<h3>Remember you can change or cancel your plan at anytime.  And if you change plans we can user whats left of your current subscription as credit against the new one.</h3>

<a href="<?php echo Request::initial()->url(array('subaction'=>'plans')); ?>">Change your plan</a>
<a href="<?php echo Request::initial()->url(array('subaction'=>'cancel')); ?>">Cancel your plan</a>

<?php endif; ?>

<?php echo debug::vars($sub); ?>