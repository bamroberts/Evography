<style>
a {color: white}
#gallery {color:white; background-color:black; width:900px}
#gallery.list {}
#gallery ul {margin:0;}
#gallery a img {border:none;} 

#gallery > ul > li {float: left; display:block; margin:10px 5px; padding:3px; border:1px solid white; position: relative; background-color:#222;}
 
#gallery a span {position: absolute;top: 5px;left: 5px; display: none; background-color: white; background-color:rgba(128,128,128,0.8);padding:5px;}

#gallery a:hover span {display: block}

.fb_like {position: absolute;right:0;margin-top:10px;}


</style>

<div id="gallery" class="list clearfix">

<iframe class="fb_like" src="http://www.facebook.com/plugins/like.php?app_id=179663692087801&amp;href=<?php echo URL::site(Request::current()->url(),'http'); ?>&amp;send=false&amp;layout=standard&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font=verdana&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:35px;" allowTransparency="true"></iframe> 
 
  <h3><?php echo $album->name; ?></h3>
  <ul>
	<?php foreach ($images as $key=>$image) : ?>
   <li> 
   	 <a href="/<?php echo Request::current()->uri(array('action'=>'image','id'=>$image->id));?>/">
       <img src="/images/dynamic/<?php echo $image->filehash;?>/70x70xcrop.jpg" alt="image <?php echo $image->name; ?> preview" />
       <span class="magnify">Full size</span>
  	</a>
  </li>
<?php endforeach; ?>
</ul>
<div style="clear:both;">
<?php if($pagination->render()): ?>
  <a class="awesome blue fright" href="<?php echo Request::current()->url(); ?>" >More photos -></a>
<?php endif;?>
<?php echo $pagination->details(); ?>
</div>
