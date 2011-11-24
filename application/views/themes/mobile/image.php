
<div data-role="page" id="image">

	<div data-role="header" data-position="fixed">
	  <a href="<?php echo Route::url($image->album_id); ?>" data-icon="grid">Back</a>
    <h1>Image <?php echo $image->name; ?></h1>
    <a href="index.html" data-icon="gear" data-iconpos="notext">Opions</a>

		<div data-role="navbar">
		  <ul>
			 <li><a href="#image" class="ui-btn-active">Image</a></li>
			 <li><a href="#comments">Comments</a></li>
			 <li><a href="#buy">Buy</a></li>
		  </ul>
	   </div><!-- /navbar -->
	</div><!-- /header -->

	<div data-role="content">	
    <img src="/images/dynamic/<?php echo $image->filehash;?>/1024x1024xfit.jpg" alt="Image <?php echo $image->name; ?>" class="media" style="max-height:100%; width:100%;"/>	
	</div><!-- /content -->


  <div data-role="footer" data-position="fixed">	
   <a href="<?php echo !$previous? '#' : Request::current()->url(array('id'=>$previous->id,'action'=>false));?>" data-role="button" data-icon="arrow-l" <?php if (!$previous) echo 'class="hide"' ?>style="float:left;">previous</a>
   <a href="<?php echo !$next? '#' : Request::current()->url(array('id'=>$next->id,'action'=>false));?>" data-role="button" data-icon="arrow-r" data-iconpos="right" <?php if (!$next) echo 'class="hide"' ?> style="float:right;">next</a>
   <h5><?php echo $image->order+1; ?> of <?php echo $image->album->images->count_all(); ?></h5>
  </div> <!-- /footer -->
</div><!-- /page -->

<div data-role="page" id="comments">
	<div data-role="header">
	  <h1>Comments</h1>
		<div data-role="navbar">
		  <ul>
			 <li><a href="#image">Image</a></li>
			 <li><a href="#comments" class="ui-btn-active">Comments</a></li>
			 <li><a href="#buy">Buy</a></li>
		  </ul>
	   </div>	
  </div><!-- /header -->

	<div data-role="content">	
		 <?php echo $comments; ?>;
	</div><!-- /content -->

</div><!-- /page -->

  
<div data-role="page" id="buy">
	<div data-role="header">
	 <h1>Buy</h1>
		<div data-role="navbar">
		  <ul>
			 <li><a href="#image">Image</a></li>
			 <li><a href="#comments">Comments</a></li>
			 <li><a href="#buy" class="ui-btn-active">Buy</a></li>
		  </ul>
	   </div>	
  </div><!-- /header -->

	<div data-role="content">	
		 <a class="" href="<?php echo Request::current()->url(array('controller'=>'buy','action'=>'image','id'=>$image->id));?>/">
		   <span class="btn primary">Buy this image</span> for £3.99.
	   </a>
	</div><!-- /content -->

</div><!-- /page -->
  