<?php echo Request::factory(Request::current()->url(array('controller'=>'menu','action'=>'index','format'=>'.part')))->execute(); ?>