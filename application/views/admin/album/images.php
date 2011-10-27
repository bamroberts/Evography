<style>
  ul.media-grid {position: relative;}
  ul.media-grid li {position: relative;float:left}
  ul.media-grid a.main {display:block;float:none;}
  
  .control {position: absolute; bottom:0; right:0;}
  
  .b span {position:absolute; left:0px;top:-50px;; z-index:20; display:block; background: #000; font-weight: bold; min-width:10px; width:100%; text-align:center;}
  
  
  .drag span {top:0;}
  
  a.b span, 
  a.main .drag span { 
    display:none; font-weight: normal;
  }
  
  a.b:hover span,
  a.main:hover .drag span {display: inline;}

</style>

<ul class="media-grid js_soratable">
   <?php foreach ($images as $image): ?>
      <li id="image_<?php echo $image->id ?>"> 
        
        <a class="main"  href="<?php echo URL::site(Request::current()->uri(array('controller'=>'images','id'=>$image->id,'action'=>'')));?>"> 
          <img src="/images/dynamic/<?php echo $image->filehash;?>/100x100xcrop.<?php echo $image->ext;?>" />
          <span class='b drag'>+<span>Drag to move</span></span>
        </a>
        
        <div class="control">
        <a class='edit b' href="<?php echo Request::current()->url(array('controller'=>'image','id'=>$image->id,'action'=>''));?>">
          E
          <span>
            Edit details
          </span>
        </a>
    
        <a class='cover b' href="<?php echo Request::current()->url(array('action'=>'set_cover'));?>?cover=<?php echo $image->id ;?>">
          C
          <span>
            Use as cover
          </span>
        </a>
    
        <a class='delete b' href="<?php echo 
              Request::current()->url(array('controller'=>'image','id'=>$image->id,'action'=>'delete'))
             .URL::query(array('return_path'=>Request::current()->uri()));
              ?>">
   		    X
   		    <span> 
   		      Delete item
   		    </span>
   		  </a>
   		  </div>
    </li>
  <?php endforeach; ?>
</ul>
  
<script>
//$( ".js_soratable" ).fadeOut();
	$(function() {
	
		$( ".js_soratable" )
			.sortable({
				placeholder: "ui-state-highlight",
				opacity: 0.6, 
				cursor: 'move', 
				update: function(event,ui) {
				  item=ui.item.attr('id');
				  before=ui.item.next('li').attr('id');
				  if (typeof before == "undefined")	{
				    first_child_under=ui.item.parent('li').attr('id');
				  }
				  if (typeof before == "undefined")	{
				    before='0'
				  } 
          var order = '&mode=move&item='+item.replace('section_','')+'&before='+before.replace('section_','');
          //$.get(window.location + "/reorder", order, function(theResponse){
                //$("#contentRight").html(theResponse);
          }
        
			});
	});
</script>
  <?php //echo Route::url('images',array('id'=>$image->id)); ?>
  <?php //echo Route::url('images',array('id'=>$image->id,'action'=>'delete')); ?>
  
  <?php //echo Request::current()->url(array('action'=>'set_cover')); ?>
  
  <?php //echo Route::url('image',array('id'=>$image->id)); ?>
  