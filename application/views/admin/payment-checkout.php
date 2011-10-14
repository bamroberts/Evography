<style>

  .input_text_card_number,
  .input_select_data_month {
      float:left;
      margin-right:20px;
   }
   .input_select_data_month select,
   .input_select_data_year select {
      width:236px;
   }
   .input_select_data_year {margin:0 0 0 238px;}
   .input_text_verification_value {margin-left:300px;}
   
   .input_text_card_number input {width:300px; }
   .input_text_verification_value input {width:148px;}
</style>

<?php echo debug::vars($invoice); ?>
<h1>Subscription checkout</h1>
<h2>PLAN: <?php echo $plan->name; ?></h2><a href="<?php echo Request::current()->url(array('action'=>'plans','id'=>'')); ?>">Change plan</a>

<?php foreach ($invoice->line_items as $line): ?>
 <?php echo $line->description; ?> <?php echo $line->price; ?>
 <?php endforeach; ?>
 Sub total <?php echo $invoice->price; ?>
 Total to pay: <?php echo $invoice->amount < 1?'&pound;0.00':$invoice->price; ?>
<?php echo $invoice->amount < 0?'Credit remaining &pound;'. ($invoice->amount * -1):false; ?>

<?php if($invoice->amount <0 ) : ?>
  <p>To change to this plan you will be charged nothing and still have $invoice->price credit to use towards future payments.</p>
  <div class="control">
    <a class="button" href="<?php echo Request::current()->url(array('action'=>'','id'=>'')); ?>">Cancel</a>
    <button class="default" type="submit" name="action" value="pay">Change to this plan</button>
  </div>

<?php else: ?>
<form method="post">
  <fieldset>
    <?php echo Form::render($columns,$data,$errors); ?>
  </fieldset>
  <div class="control">
    <a class="button" href="<?php echo Request::current()->url(array('action'=>'','id'=>'')); ?>">Cancel</a>
    <button class="default" type="submit" name="action" value="pay">Make Payment</button>
  </div>
</form>
<?php endif; ?>