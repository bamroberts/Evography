<section class="album-summary">
  <h3>Album Details</h3>
  <div>
    <h4><?php echo $album->name; ?> has <?php echo $album->images->count_all(); ?> images</h4>
    <img id="cover" src="/images/dynamic/<?php echo ($cover=$album->cover)?$cover->filehash:'0';?>/400x300xcrop.jpg" title="Album cover" class="media pull-left" /> 
    <div id="details">
      
      <p>
        created on <b><?php echo Date::formatted_time($album->add_date,'D jS F Y');?></b> 
        by <b><?php echo $album->added_by->username; ?></b>
      </p>
      Links:<ul>
        <li><a class="minibutton" href="/<?php echo Request::current()->uri(array('action'=>'edit')); ?>"><span>Edit details</span></a></li>
        <li><a class="minibutton" href="/<?php echo Request::current()->uri(array('action'=>'organise')); ?>"><span>Organise pictures</span></a></li>
        <li><a class="minibutton" href="/<?php echo Request::current()->uri(array('action'=>'upload')); ?>"><span>Upload new images</span></a></li>
        <li><a class="minibutton btn-warn" href="/<?php echo Request::current()->uri(array('action'=>'delete')); ?>"><span>Delete this Album</span></a></li>
      </ul>
    </div>
  </div>
</section>