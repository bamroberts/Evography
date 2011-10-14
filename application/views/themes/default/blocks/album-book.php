 <style>
        .photo {text-align:center; border:1px solid #ccc; padding:5px; margin:4px 0.5%; background-color:white; -moz-box-sizing:border-box; -webkit-box-sizing:border-box; box-sizing: border-box; vertical-align: middle; position:relative; }
   
     .quarter {width:24%;float:left;}
     .third {width:32%;float:left;}
     .half {width:49%;float:left;}
     
     
     .threequarter {width:72%; float:left;}
     .twothird {width:64%;float:left;}
     .end {overflow:hidden;}
     h2{clear:both;}
      
     
    img {width:auto; width:100%;  opacity:0.95; border:2px solid #333;-moz-box-sizing:border-box; -webkit-box-sizing:border-box; box-sizing: border-box; vertical-align: middle;}
    img:hover {opacity:1}
    
    
    .landscape img {width:100%;}
    .portrait img {width:100%;}
    
    

   div.photos {max-width:960px; margin:0 auto; background-color:white; padding:0 20px; overflow:hidden;  }
   
   section {overflow:hidden;}
   
   /* Portrait */
  @media screen and (max-width: 320px) {
	    article {width:100% !important; }
	}
	/* Landscape */
	@media screen and (min-width: 321px) and (max-width: 480px) {
	    article { width:100% !important; }
	} 

        
  </style>

<p class="pagination"><?php echo $pagination->details(); ?></p>
<?php echo $pagination->render(); ?>
<div class="photos">
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
<?php echo $pagination->render(); ?>
<p class="pagination details"><?php echo $pagination->details(); ?></p>

<?php function draw($layout,$format,$output){ ?>
    <section class="<?php echo $layout; ?>">
      <?php foreach ($output as $pos=>$image) : ?>
        <article class="photo image_<?php echo $pos; ?> <?php echo $format[$pos]; ?>">
           <a href="<?php echo Route::url($image->album_id,array('controller'=>'image','id'=>$image->id)); ?>">
              <img src="/images/dynamic/<?php echo $image->filehash;?>/1000x1000xwidth.<?php echo $image->ext; ?>" alt="image <?php echo $image->name; ?> preview" />
           </a>
        </article> 
      <?php endforeach; ?>
    </section>
<?php } ?>

