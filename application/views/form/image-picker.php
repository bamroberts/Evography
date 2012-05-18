<ul>
<?php foreach ($options as $key=>$image) : ?>
  <li>
    <label for="<?php echo "{$name}_{$key}"?>" >
      <img src="<?php echo $image; ?>" />    
    </label>
    <?php echo Form::hidden($name."[$key]", 0,array('style'=>'display:none;')); ?>
    <?php echo Form::checkbox($name."[$key]", 1, Arr::get(Arr::get(Request::initial()->post(),$name),$key)==1?true:false,array('id'=>"{$name}_{$key}")); ?>
  </li>
<?php endforeach; ?>
</ul>