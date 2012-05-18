
<div class="media-grid polaroid" style="height:<?php echo Arr::get($_REQUEST['current'],'height',400); ?>px;" <?php echo $data; ?> >
  <?php foreach ($images as $key=>$image) : ?>
    <?php 
        $left=rand(0,50);
        $top=rand(0,50);
        $mode=(true)?'%':'px';
        $x=rand(0,1)?"left:{$left}$mode;":"right:{$left}$mode;";
        //$y=rand(0,1)?"top:{$top}$mode;":"bottom:{$top}$mode;";
        $y="top:".rand(0,Arr::get($_REQUEST['current'],'height',400)-100)."px;";
        $rot = rand(-40,40);
    ?>
    <a href="<?php echo Route::url($image->album_id,array('controller'=>'image','id'=>$image->id)); ?>" style="
      <?php echo $x; ?>
      <?php echo $y; ?>
      -moz-transform:rotate(<?php echo $rot; ?>deg); 
      -webkit-transform:rotate(<?php echo $rot; ?>deg);
      transform:rotate(<?php echo $rot; ?>deg);
      " > 
        <span>
          <img src="/images/dynamic/<?php echo $image->filehash;?>/100x100xcrop.<?php echo $image->ext; ?>">
        </span>
        <p><?php echo $image->name; ?></p>
      </a>
  <?php endforeach; ?>
</div>
<p class="details"><?php echo $details; ?></p>   
      