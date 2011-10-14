<style>

.comment {
    background-color:#fff;
    background-color: rgba(255, 255, 255, 0.7);
    background-image: url("/assets/pageflip/img/bookBackground.png");
    border: 2px solid white;
    display: block;
    margin: 15px 15px 15px 50px;
    position:relative;
    width:587px;
    }
    .comment:nth-child(4n+2) .body {background-color:rgba(255,0,0,0.3);}
    .comment:nth-child(4n+3) .body {background-color:rgba(0,255,0,0.3);}
    .comment:nth-child(4n+4) .body {background-color:rgba(0,0,255,0.3);}
  
.head{
    background-color: #333;
    background-color: rgba(0, 0, 0, 0.5);
    border: 1px solid #666666;
    color: white;
    padding: 5px 10px;
}  


.body {background-color:rgba(0,0,0,0.5);color:white;border-top:1px solid black;border-bottom: 1px solid black;}
.head p {font-size: 14pt !important; margin-bottom:0 !important;}
.head p span {font-size:8pt;display: block;}

  blockquote {
    background-image: url("/images/quote_begin.gif");
    background-position: left top;
    background-repeat: no-repeat;
    font-size: 16pt;
    font-weight: bold;
    line-height: 1.4em;
    padding: 14px 0;
  }
  
  blockquote p {font-size:16pt !important;
    line-height: 1.4em !important; 
    }
  
  .comment blockquote span {
    background-image: url("/images/quote_end.gif");
    background-position: right bottom;
    background-repeat: no-repeat;

}

.comment .avatar {float:left; margin:20px; margin-bottom: 0;}
.comment blockquote {margin-left:140px}
 
.comment:nth-child(2n) .avatar {float:right;}
.comment:nth-child(2n) blockquote {margin-left:20px; margin-right:120px; text-align: right;} 
.comment:nth-child(2n+1) .head,
.comment:nth-child(2n+1) .top
 {text-align: right;}

.top {background-image: url('/assets/images/ui/nav_bg_shadow.png'); padding:10px 0;}
.top .head{
  position:relative;
  top:6px;
}

#comments img {padding:2px; background-color:white; border:1px solid white;}

</style>

<h3><?php echo $album->name; ?></h3>
<div class="grid_12 alpha">
  <div id="comments">
    <?php if(Request::current()->action()=='post') : ?>
      <?php echo Request::factory(Request::current()->url(array('controller'=>'comments','action'=>'draw')))->execute();?>
      <?php echo Request::factory("admin/facebook/{$album->id}/comment")->execute();?>
      <?php Request::factory(Request::current()->url(array('controller'=>'comments','action'=>'album')))->execute();?>
    <?php else: ?>
      <?php echo Request::factory(Request::current()->url(array('controller'=>'comments','action'=>'album')))->execute();?>
    <?php endif; ?>
  </div>
</div>
<div id="rightpane" class="grid_4 omega">              
    <p>
      <b>About this album</b><br />
      <?php echo $album->desc; ?>
    </p> 
    <p>
      <?php echo $_REQUEST['comment_count']; ?>
    </p>
    <?php if(Request::initial()->controller()=='collection') : ?>
    <p>
      <b>View more from the</b>
      <a class="button" href="<?php echo Request::current()->url(); ?>" ><?php echo $album->name; ?></a>
    </p>
    <?php endif; ?>
    <?php if(Request::initial()->action()!='post') : ?>
    <p>
      <b>Add your message</b><br />
      <a class="button" href="<?php echo Request::current()->url(array('action'=>'post')); ?>" >Sign the guest book</a>
    </p>
    <?php else:?>
    <p>
      <b>Back to viewing the</b><br />
      <a class="button" href="<?php echo Request::current()->url(array('action'=>'')); ?>" ><?php echo $album->name; ?></a>
    </p>
    <?php endif;?>
</div>         
<div class="clear"> </div>


