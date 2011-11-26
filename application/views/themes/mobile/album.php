
<div data-role="page" id="album">

	<div data-role="header" data-position="fixed">
	  <?php echo URL::back($album); ?>
    <h1><?php echo $album->name; ?></h1>
    <a href="index.html" data-icon="gear" data-iconpos="notext">Opions</a>

		<div data-role="navbar">
		  <ul>
			 <li><a href="#album" class="ui-btn-active">Album</a></li>
			 <li><a href="<?php echo Request::current()->url(array('controller'=>'comments')); ?>">Comments</a></li>
			 <li><a href="#buy">Buy</a></li>
		  </ul>
	   </div><!-- /navbar -->
	</div><!-- /header -->

	<div data-role="content">	
	 <section>
	  <?php echo $pagination->details(); ?>
    <?php echo $media; ?>	
   </section>
	</div><!-- /content -->

  <div data-role="footer" data-position="fixed">	
    <?php echo $pagination->render(); ?>
  </div> <!-- /footer -->
  
</div><!-- /page -->



<div data-role="page" id="comments">

	<div data-role="header" data-position="fixed">
    <a href="<?php echo Route::url($album->parent_id); ?>" data-icon="grid">Back</a>
    <h1>Comments</h1>
    <a href="index.html" data-icon="gear" data-iconpos="notext">Opions</a>
		<div data-role="navbar">
		  <ul>
			 <li><a href="#album">Album</a></li>
			 <li><a href="#comments" class="ui-btn-active">Comments</a></li>
			 <li><a href="#buy">Buy</a></li>
		  </ul>
	   </div><!-- /navbar -->
	</div><!-- /header -->

	<div data-role="content">	
  	<?php echo $comments; ?>
	</div><!-- /content -->

  <div data-role="footer" data-position="fixed">	
    <a href="<?php echo route::URL($album->id,array('controller'=>'comments','action'=>'add')); ?>" data-icon="plus" data-iconpos="right" data-rel="dialog">Add a comment</a>
  </div> <!-- /footer -->
  
</div><!-- /page -->