<h3>Export to a Facebook album</h3>
<?php echo Request::factory(Request::current()->URL(array('controller'=>'facebook','action'=>'export')))->execute();?>
<h3>Or download images in a zip file</h3>
<a class="button" href="<?php echo Request::current()->url(array('action'=>'download')); ?>">Download</a>