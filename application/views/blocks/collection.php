<ul>
  <?php foreach ($collection as $key=>$data) : ?>
    <li>
        <a href="<?php echo Request::current()->url(array('controller'=>$data->type,'id'=>$data->id,'action'=>'')); ?>"><?php echo $data->name ?><?php if ($data->type=='multiview') echo " - Multipage" ?></a> - (<?php echo $data->published?'Live':'Offline' ?>)
        <?php 
        $children=$data->children->find_all();  
        if ($children->count()) {
            echo View::Factory('blocks/collection')->bind('collection',$children);
          }   
        ?>
    </li>
  <?php endforeach; ?>
</ul>