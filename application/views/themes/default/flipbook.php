<?php 
 if(Arr::get($_REQUEST['current'],'multi',false)) {
  $image_x ='400';
  $image_y ='250';
  $book_x  ='850';
  $book_y  ='260';
  $pane_y  ='280';
 } else { 
  $image_x ='400';
  $image_y ='600';
  $book_x  ='850';
  $book_y  ='600';
  $pane_y  ='650';
 }
?>


<script type="text/javascript" src="/assets/pageflip/js/swfobject.js"></script>
<script type="text/javascript" src="/assets/pageflip/js/flippingbook.js"></script>
<script>
flippingBook.pages = [
<?php foreach($images as $image): ?>
  <?php echo "\"/images/dynamic/{$image->filehash}/{$image_x}x{$image_y}xfit.{$image->ext}\",";?>
<?php endforeach; ?>
];


// define custom book settings here
flippingBook.settings.bookWidth = <?php echo $book_x; ?>;
flippingBook.settings.bookHeight = <?php echo $book_y; ?>;
flippingBook.settings.preserveProportions= true;
flippingBook.settings.pageBackgroundColor = 0xffffff;
flippingBook.settings.backgroundColor = 0xcccccc;
flippingBook.settings.zoomUIColor = 0x919d6c;
flippingBook.settings.useCustomCursors = false;
flippingBook.settings.dropShadowEnabled = false,
flippingBook.settings.zoomImageWidth = 992;
flippingBook.settings.zoomImageHeight = 1403;
flippingBook.settings.flipSound = "sounds/02.mp3";
flippingBook.settings.flipCornerStyle = "first page only";
flippingBook.settings.zoomHintEnabled = true;


// default settings can be found in the flippingbook.js file
flippingBook.create();
</script>
<style>
h3 {margin-bottom:2px}
#fbContainer{height:<?php echo $pane_y;?>px;} 
</style>

<h3><?php echo $album->name; ?></h3>
<div id="fbContainer">
    	<a class="altlink" href="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash"><div id="altmsg">Download Adobe Flash Player.</div></a>
    </div>
   	<div id="fbFooter">
		<div id="fbContents">
   	</div>
</div>
