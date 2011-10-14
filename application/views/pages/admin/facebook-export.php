<style>
 li {list-style: none; position:relative; float:left; padding:2px; height:140px; width:130px}
 li img {padding:5px;border:1px solid #000; background:#fff;}
 li input {position: absolute; top:5px; left:5px; width:auto; z-index: 20;}
</style>

<?php if (!$user) :?>
    <a class="button" href="<?php echo $loginUrl;?>">Login to Facebook</a>
<?php else : ?> 
   <form class='fleft' method='post'>
      <fieldset>  
        <?php  echo Helpers::render_form($columns,$data,$errors,'all'); ?>
        <input type="submit" value='Export all images' />
      </fieldset>  
    </form>
  
   <form method='post'>
      <fieldset>
      <input class='' type="submit" value='Export selected images' />  
        <?php  echo Helpers::render_form($columns,$data,$errors,'images'); ?>
      
      </fieldset>  
    </form>
<?php endif; ?>

<script>
  function all_none(ul){
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
    
    p.inject(ul, 'before');
  }
  all_none('images');
</script>