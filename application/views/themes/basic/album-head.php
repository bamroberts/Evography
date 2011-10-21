<div class="header">
  <h3><?php echo $album->name; ?><span><?php echo $album->desc; ?></span></h3>
  <?php if(!Arr::get($_REQUEST['current'],'multi',false) && $images->count()) : ?>
  <img src="/images/dynamic/<?php echo $images[0]->filehash;?>/900x300xcrop.jpg" alt="image <?php echo $images[0]->name; ?>" />
    <?php if ($album->cart) : ?>
        <a class="awesome small" href="/<?php echo Request::current()->uri(array('controller'=>'buy','action'=>'image','id'=>$images[0]->id));?>/">
          <span>Buy this image</span>
        </a>
    	 <a class="awesome  blue" href="/<?php echo Request::current()->uri(array('controller'=>'buy','action'=>'album','id'=>$album->id));?>/">
    	   <span class="buy">Buy the whole album (<?php echo $pagination->total_items; ?> images)</span>
    	 </a>
    <?php endif; ?>
  <?php endif; ?>
  </div>
 
<p class="pagination"><?php //echo $pagination->details(); ?></p>
<?php //echo $pagination->render(); ?>

