<h2>Details for invoice dated <?php echo date('d M Y',$invoice->created_at); ?></h2>
<div class="invoice">
<?php foreach ($invoice->line_items as $key=>$item) : ?>
  <div class="items">
   <span><?php echo $item->price; ?></span>
   <?php echo $item->description; ?>
  </div>
<?php endforeach; ?>
<div class="total"><span><?php echo $invoice->price; ?></span>Invoice Total </div>
</div>
<span>Procssed at <?php echo date('d M Y h:i:s',$invoice->created_at); ?></span>