<form method="post" action="#facebook" id="fb_pick">
    <fieldset>
        
        <div class="group select">
          <label>Pick images</label>
          <button type="submit" class="btn">Import selected images</button>
          <?php  echo Form::hidden('album',$album); ?>
        </div>
        
        <div class="group media-grid" data-control="all-none" >
          <?php  echo Form::render($columns,$data,$errors,'images'); ?>
        </div>
    
      </fieldset>  
</form>
