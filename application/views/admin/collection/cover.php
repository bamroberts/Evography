<h3>Select a cover</h3>


<h4>Current cover</h4>            
<img alt="Current cover" src="<?php echo url::image($current->cover, 300,300); ?>" class="media" />


<form method="post" enctype="multipart/form-data">
<h4>Upload a file</h4>
<div class="group">
  <label for="file">Upload a file</label>
  <div class="input"> 
    <input type="file" name="file" id="file" />
  </div>
</div>
<div class="actions"><button type="submit" class="btn">Update cover settings</button></div>
</form>

<form method="post">
<h4>Inherit from a parent album</h4>
<div class="group">
  <label for="inherit">Pick an existing album cover</label>
  <div class="input"> 
   
         <?php foreach ($inherit as $item) : ?>
         <?php if($item->id==$current->id OR !$item->cover_image_id) continue; ?>
           <label>
            <input type="radio" name="inherit" value="<?php echo $item->cover_image_id; ?>" />
            <?php echo $item->name; ?>
            <img alt="Album <?php echo $item->name; ?> cover" src="<?php echo url::image($item->cover); ?>" class="media" />
           </label>
         <?php endforeach; ?>
      </select>  
  </div>
</div>
<div class="actions"><button type="submit" class="btn">Update cover settings</button></div>
</form>

<?php if($albums->count()) : ?>



<form method="post">
<h4>Pick from a child album</h4>
<div class="group">
  <label for="album">Pick an album</label>
  <div class="input"> 
    <select name="album" id="album">
      <option>Pick one</option>
     <?php foreach ($albums as $item) : ?>
       <?php if(!$item->images->count_all()) continue; ?>
       <option value="<?php echo $item->id; ?>" <?php if ($item->id==$album_selected) {$album_selected=$item; echo 'selected';}  ?> >
         <?php echo $item->name; ?>
       </option>
     <?php endforeach; ?>
      </select>  
  </div>
</div>

<?php if(count($images)) : ?>
<div class="group">
  <label for="image">Pick an image</label>
  <div class="input"> 
      <?php foreach ($images as $item) : ?>
       <label>
          <input type="radio" name="image" value="<?php echo $item->id; ?>" />
          <?php echo $item->name; ?>
          <img alt="Image <?php echo $item->name; ?>" src="<?php echo url::image($item); ?>" class="media" />
       </label>
     <?php endforeach; ?>
      </select>  
  </div>
</div>
<?php endif; ?>

<div class="actions"><button type="submit" class="btn">Update cover settings</button></div>
</form>
<?php endif; ?>