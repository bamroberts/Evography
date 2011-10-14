<style>
a {color: white}
#gallery {color:white; background-color:black; width:900px}
#gallery.list {}
#gallery ul {margin-left:42px;}
#gallery > img {margin-left:35px;} 

#gallery > ul > li {float: left; display:block;width:190px; margin:10px 5px;  border:2px solid white; position: relative}
 
#gallery a span.number {position: absolute;top: 5px;left: 5px; display: block; background-color: white; background-color:rgba(128,128,128,0.8);padding:5px;}


#gallery li a.minibutton {position: absolute;top: 5px;right: 5px;}


p.pagination span.text {display:none;}
p.pagination {text-align: center; margin:0;}
p.details {float:right;}

#gallery .header {position: relative;}
#gallery .header img {border-bottom:3px solid white;border-top:3px solid white;}
#gallery .header h3 {position: absolute; top:3px; left:0px; background-color: white; background-color: rgba(255,255,255,0.5);padding:0 20px 20px;
-moz-border-radius-bottomright: 15px 15px;
border-bottom-right-radius: 15px 15px;}
#gallery .header h3 span {font-size:12px; display:block;}
#gallery .header a {position: absolute;bottom:35px; right:5px;}
#gallery .header a.hover {position: absolute;bottom:5px; right:5px;}


.fb_like {position: absolute;right:0;}
</style>

<div id="gallery" class="list clearfix">
  
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
<iframe class="fb_like" src="http://www.facebook.com/plugins/like.php?app_id=179663692087801&amp;href=<?php echo URL::site(Request::current()->url(),'http'); ?>&amp;send=false&amp;layout=standard&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font=verdana&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:35px;" allowTransparency="true"></iframe>  
<p class="pagination"><?php echo $pagination->details(); ?></p>
<?php echo $pagination->render(); ?>

  <ul>
	<?php foreach ($images as $key=>$image) : ?>
  <li> 
  	<a href="/<?php echo Request::current()->uri(array('action'=>'image','id'=>$image->id));?>/">
      <img src="/images/dynamic/<?php echo $image->filehash;?>/190x142xcrop.jpg" alt="image <?php echo $image->name; ?> preview" />
      <span class="number">#<?php echo $image->add_user_id; ?>-<?php echo $image->album_id; ?>-<?php echo $image->id ?></span>
      <span class="magnify">Full size</span>
      <?php echo $image->name; ?> (<?php echo $image->id; ?>)
  	</a>
  	    <?php if ($album->cart) : ?>
  	<a class="awesome small" href="/<?php echo Request::current()->uri(array('controller'=>'buy','action'=>'image','id'=>$image->id));?>/"><span class="buy">Buy me</span></a>
  	    <?php endif; ?>
  </li>
<?php endforeach; ?>
</ul>
<div style="clear:both;">
<?php echo $pagination->render(); ?>
<p class="pagination details"><?php echo $pagination->details(); ?></p>
</div>
