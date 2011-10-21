<?php if (Request::initial()->controller()!='gallery') echo $pagination->render(); ?>
  <?php echo $media; ?>
<?php if (Request::initial()->controller()!='gallery') echo $pagination->render(); ?>
<?php $_REQUEST['comment_count']=$pagination->details();?>  