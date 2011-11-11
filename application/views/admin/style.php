<h3>Pick a style</h3>
<form method="post"> 
  
  <fieldset>
  <?php foreach ($styles as $style) : $key=$style->id; ?>
    
    <div class="group header">
       <label for="style_<?php echo $key; ?>"><?php echo $style->name; ?></label>
       <input type="radio" name="style" value="<?php echo $key; ?>" id="style_<?php echo $key; ?>" <?php echo $album->style_id==$style->id?'checked':''; ?>/> 
    </div> 
      <?php echo $form->{"style_{$style->id}"}->render('fieldset'); ?>
    <p>
      <?php echo $style->desc; ?>
    </p>    
    
  <?php endforeach; ?>
  </fieldset>
  
  <div class="actions">
    <button type="submit">Update Setting</button>
  </div> 
  
</form>
