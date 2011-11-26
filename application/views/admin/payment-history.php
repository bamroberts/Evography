<table>
 <tr>
  <th>Date</th>
  <th>Amount</th>
  <th>Options</th>
 </tr>
<?php foreach ($sub->invoices as $key=>$invoice) : ?>
 <tr>
   <td><?php echo date('d M Y h:i:s',$invoice->created_at); ?></td>
   <td><?php echo $invoice->price; ?></td>
   <td><a href="<?php echo Request::initial()->url(array('subaction'=>'invoice','id'=>$key)); ?>">View</a> / <a href="">Download</a></td>
 </tr>
<?php endforeach; ?>
</table>

