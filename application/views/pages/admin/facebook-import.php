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
<section id="facebook">
  <h4>From Facebook</h4>
  <div class="row">
    
    <div class="span4">
       <img src="<?php echo $user->picture; ?>" class="media" />
       <p>
        <?php echo $user->name; ?>
       </p>
    </div> 
    
    <form method="post" action="#facebook" id="fb_album" class="span8">
      <fieldset name="Pick Album">
        <?php echo Form::render($columns,$data,$errors,'album'); ?>
        <button type="submit" class="btn">Select album</button>
      </fieldset>  
    </form>
    
  </div>  

  <?php if ($album=Arr::get($data,'album',false)) : ?>
  <form method="post" action="#facebook" id="fb_pick">
    <fieldset>
        
        <div class="group select">
          <label>Pick images</label>
          <button type="submit" class="btn">Import selected images</button>
          <?php  echo Form::hidden('album',$album); ?>
        </div>
        
        <div class="group media-grid" data-control="all-none" >
          <?php  echo Form::render($columns,$data,$errors,'images'); ?>
        </div>
    
      </fieldset>  
    </form>
  <?php endif; ?>
   
</section>

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