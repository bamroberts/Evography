<ul>
 <?php $level=false;?>
  <?php foreach ($collection as $key=>$data) : ?>
     
    <?php if($level&&$data->level>$level) : //create an additonal level ?>
      <ul>
    <?php endif; ?>
    <?php if($data->level<$level) : //close additonal level  ?>
      </ul>
    <?php endif; ?>
    
    <?php $level=$data->level;?>
  
    <li>
        <?php echo $data->type; ?>
        <a href="<?php echo Request::current()->url(array('controller'=>$data->type,'id'=>$data->id,'action'=>'')); ?>">
          <?php echo $data->name ?><?php if ($data->type=='multiview') echo " - Multipage" ?>
        </a> 
        - (<?php echo $data->published?'Live':'Offline' ?>)
    </li>  
  
  <?php endforeach; ?>
</ul>