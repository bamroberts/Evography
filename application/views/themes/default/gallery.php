  
<style>
  .intro {	
  
  
	background-image: url('/images/dynamic/<?php echo $collection->cover->filehash;?>/900x200xcrop.jpg');
	background-repeat: repeat-x;
	}
	
	h2 {height:100px;background-color: rgba(0,0,0,0.7); }
	h2 span {font-size: 50%;display: block;}
	
	.links {
	  background-color:rgba(0,0,0,0.7);
	  clear:left;
	  float:right;
	}
	
	div.section {border-top:2px solid white;}
</style>
<div class='intro'>
  <h2><?php echo $collection->name; ?><span><?php echo $collection->desc; ?></span></h2>
  <?php echo Request::factory(Request::current()->url(array('controller'=>'menu','action'=>'index')))->execute();?>
</div>

<?php foreach ($sections as $key=>$details): ?>
   <div id="<?php $key ?>" class="section" style="clear:both">  
    <?php $_REQUEST['current'] = Arr::get($details,'data',array()); ?>
    <?php echo Request::factory($details['factory'])->execute(); ?>
   </div>
<?php endforeach; ?>
