<h2>Image details</h2>
<h3><?php echo $image->name; ?></h3>
<img src="/<?php echo "images/dynamic/{$image->filehash}/200x200xfit.{$image->ext}"; ?>" />
<img src="/<?php echo "images/dynamic/{$image->filehash}/840x{$image->height}xfit.{$image->ext}"; ?>" />
Max size: <?php echo $image->width; ?>w X <?php echo $image->height; ?>h

from the album <a class="minibutton" href="<?php echo URL::site(Request::current()->uri(array('controller'=>'album','id'=>$image->albums->find()->id,'action'=>'')));?>" title="View image details"><span><?php echo $image->albums->find()->name; ?></span></a>

<br />
<a href="<?php Request::current()->action('rotate');echo Request::current()->url(); ?>?direction=-1">Rotate left</a>
<br />
<a href="<?php Request::current()->action('rotate');echo Request::current()->url(); ?>">Rotate right</a>

<a class="minibutton btn-warn" href="<?php echo URL::site(Request::current()->uri(array('action'=>'delete')));?>" title="Delete"><span>Delete this image</span></a>
