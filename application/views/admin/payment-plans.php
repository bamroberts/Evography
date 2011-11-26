<p>
  Please select one of our great plans, remember that if you are changing plan, we will credit you the remainder of your current plan to use against this or future payments.
</p>
<div class="row">
<?php foreach ($plans as $plan) : ?>
<?php if ($plan->plan_type=="free_trial") continue; ?>
    <div class="span5 plan<?php echo($plan->name == $sub->subscription_plan_name)?' active':false; ?>">
       
      <h3><?php echo $plan->name; ?></h3>
      &pound;<?php echo number_format($plan->amount,2); ?> 
      every 
      <?php echo ($is_one=$plan->duration_quantity==1)?'': $plan->duration_quantity; ?>
      <?php echo Inflector::singular($plan->duration_units,$is_one); ?>
      <?php if($plan->name == $sub->subscription_plan_name) :  ?>
        Your current plan
      <?php else :  ?>
        <a class="btn pull-right" href="<?php echo Request::initial()->url(array('subaction'=>'checkout','id'=>$plan->id)); ?>">Buy this</a>
      <?php endif; ?>
      
    </div>
<?php endforeach; ?>
</div>