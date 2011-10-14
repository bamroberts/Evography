<style>
a {color: white}
#gallery {color:white; background-color:black; width:900px}
#gallery.list {}
#gallery ul {margin:0;}
 #gallery > img {margin-left:35px;} 

#gallery > ul > li {float: left; display:block;width:190px; margin:10px 5px;  border:2px solid white; position: relative}
 
#gallery a span.number {position: absolute;top: 5px;left: 5px; display: block; background-color: white; background-color:rgba(128,128,128,0.8);padding:5px;}

</style>

<div id="gallery" class="list clearfix">
  <h3><?php echo $album->name; ?>(<?php echo $album->id; ?>)</h3>
  <img src="/images/dynamic/<?php echo $images[0]->filehash;?>/820x300xcrop.jpg" alt="image <?php echo $images[0]->name; ?>" />
  <ul>
	<?php foreach ($images as $key=>$image) : ?>
  <li> 
  	<a href="/<?php echo Request::current()->uri(array('action'=>'image','id'=>$image->id));?>">
      <img src="/images/dynamic/<?php echo $image->filehash;?>/190x400xfit.jpg" alt="image <?php echo $image->name; ?> preview" />
      <span class="number"><?php echo $image->id ?></span>
      <span class="magnify">Full size</span>
      <?php echo $image->name; ?> (<?php echo $image->id; ?>)
  	</a>
  	<a class="minibutton" href="/<?php echo Request::current()->uri(array('action'=>'buy','id'=>$image->id));?>/"><span class="buy">Buy me</span></a>
  </li>
<?php endforeach; ?>
</ul>
<div style="clear:both;">
<?php echo $pagination->render(); ?>
<?php echo $pagination->details(); ?>
</div>
