<style>
#gallery {color:white; background-color:black;}
#gallery.list {}
#gallery ul {}
#gallery > ul > li {position:relative; display:block;width:900px;height:250px; margin:25px auto;  border:2px solid white;}
#gallery ul ul {position:absolute; right:5px; top:10px; width:300px;}
#gallery ul ul li {list-style:none; float:left; margin:2px 4px; border:1px solid white; height:50px; width:50px}
#gallery ul a {color:white;display:block; width:870px; height:220px; padding:15px;  text-shadow:0 0 6px black;}
#gallery ul a:hover {background-color:rgba(0,0,0,0.3);}
#gallery ul a * {display:none;}
#gallery ul a:hover * {display:block;}
#gallery .title {font-size:160%;}
#gallery .date {font-size:140%;}
#gallery .desc {font-size:120%;}
#gallery .count {}
#gallery .count span {display:inline;font-size:120%;}

</style>

<div id="gallery" class="list">
  <h3>All albums</h3>
  <ul>
    <?php foreach ($results as $r) : ?>
    <li style="background-image:url(/images/dynamic/<?php echo $r['album_cover'];?>/900x250xcrop.jpg);">
      <a href="/album/<?php echo $r['name'];?>/">
	      <span class="title"><?php echo $r['name'];?></span>
	      <span class="date"><?php echo $r['date'];?></span>
	      <span class="desc"><?php echo $r['desc'];?></span>
	      <span class="count">There 
	      <?php if ($r['album_count']==1) : ?>
	        is <span><?php echo $r['album_count'];?></span> image
	      <?php else : ?>
	        are <span><?php echo $r['album_count'];?></span> images 
	      <?php endif; ?>
	      in this collection</span>
	    </a>
	      <ul class="preview">
	        <?php $preview=explode(',',$r['album_preview']); ?>
	        <?php foreach ($preview as $key=>$hash):?>
	        <li>
	         <img src="/images/dynamic/<?php echo $hash;?>/50x50xcrop.jpg" alt="image <?php echo $key; ?> preview" />
	        </li>
	        <?php endforeach;?>
	      </ul>
      
    </li>
    <?php endforeach; ?>
  </ul>
  <?php echo $page_links; ?>
</div>
