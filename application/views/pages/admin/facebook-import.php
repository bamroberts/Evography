<style>
 .image_select li {list-style: none; position:relative; float:left; padding:2px; height:140px; width:130px; margin-left:0; margin-right: 30px;}
 .image_select li img {padding:5px;border:1px solid #000; background:#fff;}
 .image_select li input {position: absolute; top:5px; left:5px; width:auto; z-index: 20;}
 fieldset div {display: inline-block;}
 fieldset {float:none;}
 .image_select label {display: none;}
 .image_select li label {display: block;}
 
 #fb_album div.select {display:inline-block}
 .head {margin-left:20px;}
 .head img {border:1px solid #414141; padding:2px; background: white; margin-right: 10px;}
 button, {margin-left:20px;}
</style>
<h4>Import files from facebook:</h4>
<?php if (!$user) :?>
<a class="button" style="margin-left:20px; margin-bottom:20px;" href="<?php echo $loginUrl;?>">Login to Facebook</a>
<?php else : ?>
<div class='head'>
 <img class='fleft' src="<?php echo $user->picture; ?>" />
 <p>
  <?php echo $user->name; ?> <br /> (<a class="" href="<?php echo $logoutUrl;?>">Logout from facebook</a>)
 </p>
</div>
  <a name="facebook"></a>
  <form method="post" action="#facebook" id="fb_album">
    <fieldset name="Pick Album">
      <?php echo Helpers::render_form($columns,$data,$errors,'album'); ?>
      <button type="submit">Select album</button>
    </fieldset>  
  </form>

  <?php if ($album=Arr::get($data,'album',false)) : ?>
  <form method="post" action="#facebook" id="fb_pick">
    <fieldset>
      
 <label for="images">Pick images</label><button type="submit">Import selected images</button>
        <?php  echo Form::hidden('album',$album); ?>
        <?php  echo Helpers::render_form($columns,$data,$errors,'images'); ?>
      
      </fieldset>  
    </form>
  <?php endif; ?>
<?php endif; ?>

<script>
  function all_none(ul){
  if (!$(ul)) return;
    var ul=$(ul);
    
    var p = new Element('span',{text:' - Check '});
    
    var all = new Element('a', {
    href: '#',
    html: 'all',
    events: {
        click: function(e){
            e.stop();
            ul.getElements('li input').each(function(el) { el.checked = true; });
        },
        
    }
    });
    
    var none = new Element('a', {
    href: '#',
    html: 'none',
    events: {
        click: function(e){
            e.stop();
            ul.getElements('li input').each(function(el) { el.checked = false; });
        },
        
    }
    });
    
    all.inject(p);
    p.appendText(' / ');
    none.inject(p);
    
    p.inject(ul.getParent(), 'before');
  }
  all_none('images');
</script>