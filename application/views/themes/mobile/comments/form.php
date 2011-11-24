<div data-role="page">
	<div data-role="header" data-position="fixed">
	  <a href="<?php echo Request::current(array('action'=>false)); ?>" data-icon="cancel" data-rel="back">Cancel</a>
	  <h1>Add your comment</h1>
	</div>
  <div data-role="content">
   <?php echo View::factory('/themes/default/comments/form')->bind('form',$form); ?>	
  </div>   
</div>