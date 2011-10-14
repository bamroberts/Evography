<style>

.collection .header {position: relative; float:left;}
.collection .header img {border-bottom:3px solid white;border-top:3px solid white;}
.collection .header a h3 {position: absolute; top:3px; left:0px; padding:0 20px 0px;width:260px;background-color: white; background-color: rgba(255,255,255,0.8);}
.collection .header a:hover h3 {height:200px;background-color: rgba(255,255,255,0.5);}
.collection .header a h3 span {font-size:12px; display:none;}
.collection .header a:hover h3 span {font-size:12px; display:block;border-top: 1px solid #333;}
</style>
<h3><?php echo $collection->name ?></h3>

  <?php foreach ($collection->children as $key=>$child) : ?>
  <div class="collection">
    <div class="header">
    <a href="<?php echo Route::url($child->id); ?>" class="<?php echo ($child->password->active)?'private':false; ?>">
      <h3><?php echo $child->name; ?>(<?php echo $child->id; ?>)
        <span><?php echo $child->desc; ?></span>
      </h3>
      <img src="/images/dynamic/<?php echo $child->cover->filehash?>/300x200xcrop.jpg" alt="image <?php echo $child->cover->name ?>" />
    </a>  
  </div>
  </div>
  <?php endforeach; ?>

