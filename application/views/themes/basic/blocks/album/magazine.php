<div class="media-grid magazine small" <?php echo $data; ?>>
<?php 
$matrix = array(
  'ppp' =>array('twothird','third','third'),
  'lll' => array('end','half','half end'),
  'ppl' => array('quarter','quarter','half end'),
  'llp' => array('end','twothird','third end'),
  'lpl' => array('end','third','twothird end'),
  'pll' => array('half','half','half end'),
  'plp' => array('quarter','half','quarter end'),
  'lpp' => array('end','half','half end'),
);

$leftovers = array(
  'pp' =>array('half','half end'),
  'll' => array('half','half end'),
  'lp' => array('twothird','third end'),
  'pl' => array('third','twothird end'),
  'l' => array('end'),
  'p' => array('end'),
  );

$store=array(); 
$pattern='';
 foreach ($images as $key=>$image) :
    $store[]=$image;
    $pattern.=$image->width > $image->height ? 'l':'p';
    if ($format=Arr::get($matrix,$pattern,false)){
      draw($pattern,$format,$store);
      $pattern='';
      $store=array(); 
    }
  endforeach;
  if ($format=Arr::get($leftovers,$pattern,false)) {
    draw($pattern,$format,$store);
  }   
?>
</div>

<?php function draw($layout,$format,$output){ ?>
    <div class="layout layout-<?php echo $layout; ?>">
      <?php foreach ($output as $pos=>$image) : ?>
        <div class="image image-<?php echo $pos+1; ?>">
           <a href="<?php echo Route::url($image->album_id,array('controller'=>'image','id'=>$image->id)); ?>">
              <img src="/images/dynamic/<?php echo $image->filehash;?>/1000x750xfit.<?php echo $image->ext; ?>" alt="image <?php echo $image->name; ?> preview" />
              <span>
                  <large><?php echo $image->name; ?></large>
                  <small>13</small>
              </span>

           </a>
        </div> 
      <?php endforeach; ?>
    </div>
<?php } ?>
<p class="details"><?php echo $details; ?></p>
