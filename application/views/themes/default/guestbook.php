<section class="guestbook">  
    <?php if (Request::initial()->controller()!='gallery') echo $pagination->render(); ?>
    <?php echo $media; ?>
</section>
<?php echo $pagination->details(); ?>
