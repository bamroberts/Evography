<div class="guestbook">
  <?php $internal=Arr::get(Arr::get($_REQUEST,'current'),'multi',false);?>
  <?php if ($internal) : ?>
  <a class="awesome blue fright" href="<?php echo Request::current()->url();?>#comment" />
      Sign the guest book ->
  </a>
  <?php else: ?>
  <a class="awesome blue" href="#comment" />
      Sign the guest book 
  </a>
  <?php endif; ?>
  
  <div class="row comments">
    <?php if (Request::initial()->controller()!='gallery') echo $pagination->render(); ?>
        <?php echo $media; ?>
    <?php if (Request::initial()->controller()!='gallery') echo $pagination->render(); ?>
  <?php $_REQUEST['comment_count']=$pagination->details();?>
  </div>
  
  <?php if(!$internal) : ?>
  
  
  <?php $data=array();?>
  <a name="comment"></a>
  <form id="internal" method="post">
      <?php echo Form::hidden('from','internal');?>
      <?php if(Auth::instance()->get_user()) : ?>
        //LOGGEDIN
      <?php else :?>
        //require email and stuff too  
      <?php endif; ?>
      <?php echo Helpers::render_form(array('message'=>array()),$data,'message'); ?>
  </form>
  <form id="facebook" method="post">
      <?php echo Form::hidden('from','facebook');?>
      <?php //if($fb->user) : ?>
          <img src="<?php //echo $fb->user->picture; ?>" alt="Image of <?php //echo $fb->user->picture; ?>" />
          <?php //echo $fb->user->picture;;?>
          <?php //echo $fb->logout ;?>
      <?php //else :?>
          <?php //echo $fb->login ;?>
      <?php //endif; ?>
      <?php echo Helpers::render_form(array('message'=>array()),$data,'message'); ?>
  </form>
  
  <?php endif; ?>

</div>

