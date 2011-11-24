<style>
a {color: white}
#gallery {color:white; background-color:black; height:900px; overflow-y: scroll; overflow-x: hidden; }
#gallery.list {}
#gallery ul {margin:0;}
#gallery > img {border:5px solid white;;} 

#gallery > ul > li { display:inline;height:400px; margin:10px 5px;  border:2px solid gray; position: relative}
 
#gallery a span.number {position: absolute;top: 5px;left: 5px; display: block; background-color: white; background-color:rgba(128,128,128,0.8);padding:5px;}

.fb_like {position: absolute;right:0;}
</style>

<div id="gallery" class="list clearfix" style="width:<?php echo ($images->count()+1)*600 . 'px'; ?>;">
  <h3><?php echo $album->name; ?>(<?php echo $album->id; ?>)</h3>
  <ul>
	<?php foreach ($images as $key=>$image) : ?>
  <li> 
  	<a href="/<?php echo Request::current()->uri(array('action'=>'image','id'=>$image->id));?>/">
      <img src="/images/dynamic/<?php echo $image->filehash;?>/1000x350xheight.jpg" alt="image <?php echo $image->name; ?> preview" />
      <span class="number"><?php echo $image->id ?></span>
     <!--
 <span class="magnify">Full size
      <?php echo $image->name; ?> (<?php echo $image->id; ?>) </span>
  	
</a>
  	<a class="mimibutton" href="/<?php echo Request::current()->uri(array('action'=>'buy','id'=>$image->id));?>/"><span class="buy">Buy me</span></a>
 --> </li>
<?php endforeach; ?>
</ul>
<div style="clear:both;">
<?php echo $pagination->render(); ?>
<?php echo $pagination->details(); ?>
</div>
