<div class="well intro">
    <?php echo Request::factory(Request::current()->url(array('controller'=>'menu','action'=>'index','format'=>'part')))->execute();?>
</div>
<?php echo $media; ?>