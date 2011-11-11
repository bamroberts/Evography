<li class="section" id="section_<?php echo $details->id; ?>">
  <h4 class="<?php echo $details->type; ?>"><?php echo ($details->type); ?> - <?php echo $details->name; ?></h4>
  <div>
  <img class="pull-right" src="/assets/images/ui/<?php echo $details->type; ?>.png" alt="Illustration for <?php echo $details->type; ?> section" />
  <img class="pull-left" src="<?php echo Url::image($details->cover)?>"  alt="album cover for <?php echo $details->name; ?>" />
  <dl>
      <dt>Album is </dt>
      <dd><?php echo ($details->published)?'Live':'Offline'; ?></dd>
  
    <?php if($count=$details->images->count_all()) : ?>
      <dt>Images</dt>
      <dd><?php echo $count ?></dd>
    <?php endif; ?>
    
    <?php if($count=$details->comment->count_all()) : ?>
      <dt>Comments</dt>
      <dd><?php echo $count ?></dd>
    <?php endif; ?>
    
    <?php if($details->private) : ?>
      <dt>Password Protected</dt>
      <dd>On</dd>
    <?php endif; ?>
    
    <?php if($details->cart) : ?>
      <dt>Shopping cart</dt>
      <dd>On</dd>
    <?php endif; ?>
    
    <?php if($details->open) : ?>
      <dt>User contributed album</dt>
      <dd>On</dd>
    <?php endif; ?>
    
    <?php if($details->export) : ?>
      <dt>This album can be exported</dt>
      <dd>On</dd>
    <?php endif; ?>
    
    <?php if($details->comments) : ?>
      <dt>Comments</dt>
      <dd>On</dd>
    <?php endif; ?>
    
    <?php if($details->facebook) : ?>
      <dt>Facebook connections</dt>
      <dd>On</dd>
    <?php endif; ?>
    
    <dt>Style</dt>
    <dd><?php echo ($d=$details->theme)?$d:'Default'; ?></dd>
  </dl>
  <a class="button" href="<?php echo Request::current()->url(array('controller'=>$details->type,"action"=>'edit','id'=>$details->id));?>">Configure</a>
  <a class="button" href="<?php echo Request::current()->url(array('controller'=>$details->type,"action"=>'','id'=>$details->id));?>">Open</a>
  <a class="button warn js_warn" href="<?php echo Request::current()->url(array('controller'=>$details->type,"action"=>'delete','id'=>$details->id));?>">Delete</a>
  </div>
</li>