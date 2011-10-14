<h3><?php echo $album->name; ?></h3>
<div class="grid_12 alpha">
  <div class="gallery grid">
    <ul>   
      <?php foreach ($images as $key=>$image) : ?>
        <li class="image">
         <a href="/<?php echo Request::current()->uri(array('action'=>'image','id'=>$image->id));?>.jpg" rel="lightbox[set1]" title="<?php echo $image->name; ?>">
           <img src="/images/dynamic/<?php echo $image->filehash;?>/100x100xcrop.jpg" alt="image <?php echo $image->name; ?> preview"/>
           <span>Enlarge</span>
         </a>
       </li>
      <?php endforeach; ?>
     </ul>  
  </div>
</div>
<div id="rightpane" class="grid_4 omega">              
    <p>
      <b>About this album</b><br />
      <?php echo $album->desc; ?>
      <?php echo $pagination->details(); ?>
    </p>
    <p>
      <b>Like this album</b><br />
      <iframe src="http://www.facebook.com/plugins/like.php?app_id=179663692087801&amp;href=<?php echo URL::site(Request::current()->url(),'http'); ?>&amp;send=false&amp;layout=standard&amp;width=200&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font=verdana&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:200px; height:35px;" allowTransparency="true"></iframe>     
    </p>
    <?php if(Request::initial()->controller()=='collection') : ?>
    <p>
      <b>View more from the</b>
      <a class="button" href="<?php echo Request::current()->url(); ?>" ><?php echo $album->name; ?></a>
    </p>
    <?php endif; ?>
    </div>		   
<div class="clear"> </div>

