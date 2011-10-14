<style>
  .header h3 {position: absolute; top:3px; left:0px; background-color: white; background-color: rgba(255,255,255,0.1);padding:0 20px 20px;
-moz-border-radius-bottomright: 15px 15px;
border-bottom-right-radius: 15px 15px;}
 .header h3 span {font-size:12px; display:block;}

.comment:nth-child(4n)  {background-color:rgba(255,0,0,0.1);}
.comment:nth-child(4n+1){background-color:rgba(128,255,128,0.1);}
.comment:nth-child(4n+2){background-color:rgba(128,128,255,0.1);}

.comment {
      background-color: rgba(255, 255, 255, 0.7);
    background-image: url("/assets/pageflip/img/bookBackground.png");
    border: 2px solid white;
    border-radius: 15px 15px 15px 15px;
    display: block;
    margin: 65px;
    padding: 20px;
    position:relative;
    }
  .comment .head {float:left; background-color: #666;}
  .comment .head a, .comment .head span {display: block;}
  .comment .body img { float:left;   border:1px solid white; position:absolute; top:-20px;left:-20px;}
  .comment:nth-child(2n) .body img {left:inherit;right:-20px;}
  
  .comment .body p {font-size:18pt; margin:0;float:right;text-align:right;}
  .comment:nth-child(2n) .body p { float:left;;text-align:left;}
  .comment .body p span { font-size:14pt;display: block}

  blockquote {
    background-image: url("/images/quote_begin.gif");
    background-position: left top;
    background-repeat: no-repeat;
    font-size: 26pt;
    font-weight: bold;
    line-height: 1.4em;
    margin:0 50px 20px 50px;
    padding: 13px 0 0 40px;
  }
  
  .comment blockquote span {
    background-image: url("/images/quote_end.gif");
    background-position: right bottom;
    background-repeat: no-repeat;
    padding-bottom: 15px;
    padding-right: 40px;
}

</style>

<h3><?php echo $album->name; ?></h3>
<div class="header">
  <h3>
    <?php echo $album->name; ?>
    <span>
      <?php echo $album->desc; ?>
    </span>
  </h3>
</div>
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

<div id="comments">
  <?php foreach ($album->comment->find_all() as $comment): ?>
    <div id="comment_<?php echo $comment->id ?>" class="comment clearfix">
      <div class="head">   
        
      </div>
      <div class="body">
         <blockquote>
              <span><?php echo $comment->message ?></span>            
          </blockquote>
        <?php if($comment->user->facebook->id) : ?>
          <a href="<?php echo $comment->user->facebook->link; ?>" target="_blank">
            <img src="<?php echo str_replace('_q','_s',$comment->user->facebook->picture); ?>" alt="Image of <?php echo $comment->user->username; ?>" />
          </a>
        <?php else: ?>
            <?php $default=''; ?>
            <?php $grav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $comment->user->email ) ) ) . "?d=" . urlencode( $default ) ."&size=100x100";?>
            <img src="<?php echo $grav_url; ?>" alt="Image of <?php echo $comment->user->username; ?>" />
            <!-- or openImg or Dummy -->
        <?php endif; ?>
          <p class="signoff "><?php echo $comment->user->username ?>
<span><?php echo $comment->add_date ?></span></p> 
      </div>   
    </div>
  <?php endforeach ?>
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
