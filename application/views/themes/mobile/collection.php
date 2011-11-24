<div data-role="page" id="collection">
	<div data-role="header" data-position="fixed">
	 	  <?php echo URL::back($collection); ?>
	 	  <h1><?php echo $collection->name; ?></h1>
      <a href="index.html" data-icon="gear" data-iconpos="notext">Opions</a>
	</div>
  <div data-role="content">
   <?php echo $media; ?>
	</div>   
	

</div>