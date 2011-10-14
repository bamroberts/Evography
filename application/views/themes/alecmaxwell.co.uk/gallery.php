<style>
.gallery ul {
  width:700px;
  margin-left:40px;
  margin-top:15px;
}
</style>  
<?php echo Request::factory(Request::initial()->url(array('controller'=>'menu','action'=>'index','format'=>'.part')))->execute();?>
<?php foreach ($sections as $key=>$details): ?>
   <div id="<?php $key ?>" class="section" style="clear:both">  
    <?php $_REQUEST['current'] = Arr::get($details,'data',array()); ?>
    <?php echo Request::factory($details['factory'])->execute(); ?>
   </div>
<?php endforeach; ?>
