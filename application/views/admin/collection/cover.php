<h3>Select a cover</h3>
<form method="post" enctype="multipart/form-data">

<h4>Upload a file</h4>
<div class="group">
  <label for="file">Upload a file</label>
  <div class="input"> 
    <input type="file" name="file" id="file" />
  </div>
</div>

<h4>Inherit from a parent album</h4>
<div class="group">
  <label for="inheret">Upload a file</label>
  <div class="input"> 
    <select name="inheret" id="ineret">
      <option>Pick one</option>
     <?php foreach ($inherit as $item) : ?>
     <?php if(!$item->cover_image_id) continue; ?>
       <option value="<?php echo $item->id; ?>">
         <?php echo $item->name; ?>
       </option>
     <?php endforeach; ?>
      </select>  
  </div>
</div>

<h4>Pick from a child album</h4>
<div class="group">
  <label for="album">Pick an album</label>
  <div class="input"> 
    <select name="album" id="album">
      <option>Pick one</option>
     <?php foreach ($albums as $item) : ?>
       <?php if(!$item->cover_image_id && !$item->images->count_all()) continue; ?>
       <?php if($item->id==$album_selected) : ?>
         
       <?php endif; ?>
       <option value="<?php echo $item->id; ?>" <?php if ($item->id==$album_selected) {$album_selected=$item; echo 'selected';}  ?> >
         <?php echo $item->name; ?>
       </option>
     <?php endforeach; ?>
      </select>  
  </div>
</div>

<div class="group">
  <label for="image">Pick an image</label>
  <div class="input"> 
    <select name="image" id="image">
      <option>Pick one</option>
      <?php if($album_selected && $album_selected->cover_image_id) : ?>
        <option value="<?php echo $album_selected->cover_image_id; ?>">ALBUM COVER</option>
      <?php endif; ?>
     <?php foreach ($images as $item) : ?>
       <option value="<?php echo $item->id; ?>">
         <?php echo $item->name; ?>
       </option>
     <?php endforeach; ?>
      </select>  
  </div>
</div>

<div class="actions"><button type="submit">Update cover settings</button></div>

</form>
