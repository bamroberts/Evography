<form method="post" action="<?php echo Request::initial()->url(array('action'=>'add','controller'=>'comments'));?>" class="form-stacked">
   <fieldset>
    <?php echo $form; ?>  
      
    <div class="actions"> 
      <button type="submit" name="action" class="btn">Add comment</button>
    </div>
   </fieldset>
  </form>
