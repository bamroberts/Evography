<?php 
 if(Request::current()->param('format')=='.part') {
  $image_x ='400';
  $image_y ='250';
 // $book_x  ='850';
 // $book_y  ='260';
  $pane_y  ='280';
 } else { 
  $image_x ='400';
  $image_y ='600';
 // $book_x  ='850';
 // $book_y  ='600';
  $pane_y  ='100%';
 }
?>


<script>
//$settings.node_<?php echo request::current()->param('node'); ?>.photobook.pages = [
  <?php $d=array(); foreach($images as $key=>$image): ?>
     <?php $d[]="/images/dynamic/{$image->filehash}/{$image_x}x{$image_y}xfit.{$image->ext}"; ?>
    <?php  //$d.= "'/images/dynamic/{$image->filehash}/{$image_x}x{$image_y}xfit.{$image->ext}',";?>
  <?php endforeach; ?>
  
//  ];
</script>
<style>
#fbContainer{height:<?php echo $pane_y;?>px;} 
</style>
<div id="fbContainer" data-photobook='<?php echo json_encode($d); ?>' <?php echo $data; ?>>
    	<a class="altlink" href="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash"><div id="altmsg">Download Adobe Flash Player.</div></a>
    </div>
  <div id="fbFooter">
		<div id="fbContents">
   	</div>
    <p class="details"><?php echo $details; ?></p>   	
</div>

