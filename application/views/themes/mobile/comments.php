<div data-role="page" id="comments">
	<div data-role="header" data-position="fixed">
	  <a href="<?php echo Request::current(array('action'=>false)); ?>" data-icon="cancel" data-rel="back">Cancel</a>
	  <h1>Comments</h1>
	</div>
  <div data-role="content">
   <?php echo $media; ?>
   <?php echo $page_details; ?>
   <?php echo $page_control; ?>
	</div>   
	<div data-role="footer" data-position="fixed">	
    <a href="<?php echo Request::current()->url(array('action'=>'add')); ?>" data-icon="plus" data-iconpos="right" data-rel="dialog">Add a comment</a>
  </div> <!-- /footer -->

</div>