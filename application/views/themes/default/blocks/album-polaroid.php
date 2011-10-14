<style>
	.gallery{
	    /* The pics container */
	    height:580px;
	    position:relative;
	}
	 
	.pic, .pic a{
	    /* Each picture and the hyperlink inside it */
	    width:100px;
	    height:100px;
	    overflow:hidden;
	}
	 
	.pic{
	    /* Styles specific to the pic class */
	    position:absolute;
	    background-color: #eee;
	    padding:5px 5px 18px 5px;
	    
	 
	    /* CSS3 Box Shadow */
	    -moz-box-shadow:2px 2px 3px #333333;
	    -webkit-box-shadow:2px 2px 3px #333333;
	    box-shadow:2px 2px 3px #333333;
	}
	 
	.pic a{
	    /* Specific styles for the hyperlinks */
	    background-color:#333;
	    display:block;
	    /* Setting display to block enables advanced styling for links */
	}
	
	.pic a span {text-indent:-999px;}
	
	.pic a:hover{
	    background-color:rgba(255,255,255,0.25);
	}
</style>
<div class="gallery">
  <?php foreach ($images as $key=>$image) : ?>
    <?php 
        $left=rand(0,50);
        $top=rand(0,50);
        $mode=(true)?'%':'px';
        $x=rand(0,1)?"left:{$left}$mode;":"right:{$left}$mode;";
        $y=rand(0,1)?"top:{$top}$mode;":"bottom:{$top}$mode;";
        $rot = rand(-40,40);
    ?>
    <div id="pic-<?php echo $key; ?>" class="pic image" style="
      <?php echo $x; ?>
      <?php echo $y; ?>
      
      -moz-transform:rotate(<?php echo $rot; ?>deg); 
      -webkit-transform:rotate(<?php echo $rot; ?>deg);
      transform:rotate(<?php echo $rot; ?>deg);
      ">
      <a class="fancybox" rel="fncbx" href="<?php echo Route::url($image->album_id,array('controller'=>'image','id'=>$image->id)); ?>"> 
        <img src="/images/dynamic/<?php echo $image->filehash;?>/100x100xcrop.<?php echo $image->ext; ?>">
        <span><?php echo $image->name; ?></span>
      </a>
    </div>
  <?php endforeach; ?>
</div>
<div style="clear:both;">
<?php echo $pagination->render(); ?>
<p class="pagination details"><?php echo $pagination->details(); ?></p>
</div>     
      