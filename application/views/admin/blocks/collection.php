<div>
<ol <?php if($collection->count()>1) echo 'data-sort=""'; ?> class="fix">
 <?php $base=$level=0;?>
  <?php foreach ($collection as $key=>$data) : ?>
     
       <?php if(!$base) $base=$data->level;?>
     
       <?php if($level && $level==$data->level) : //if level is the same as before close li?>
         </li>
       <?php endif; ?>
     
     <?php if($level&&$data->level<$level) : //if level is one or more less?>
       <?php for ($i=0;$i<(0+$level-$data->level);$i++): ?>
         </li>
           </ol>
       <?php endfor; ?>
      </li>
     <?php endif; ?>
     
     <?php if($level&&$data->level>$level) : //if we are a level deeper?>
       <ol>
     <?php endif; ?>
      
   <!--
 <?php if($level&&$data->level>$level) : //create an additonal level ?>
      <ul class="">
    <?php endif; ?>
    <?php if($data->level<$level) : //close additonal level  ?>
      </ul>
    <?php endif; ?>
-->
    
    <?php $level=$data->level;?>
    <li id="<?php echo $data->id; ?>" class="target fix clear<?php if ($data->type!='collection' AND $data->type!='gallery') echo ' no-nest'; ?>">
        <h4>
          <a href="<?php echo Request::current()->url(array('controller'=>$data->type,'id'=>$data->id,'action'=>'')); ?>">
            <?php echo $data->name ?><?php if ($data->type=='multiview') echo " - Multipage" ?>
          </a>
        </h4> 
        <div>
        
        <img class="media pull-left" src="<?php echo url::image($data->cover); ?>" alt="Cover for <?php echo $data->name; ?>" />
        <?php echo $data->type; ?>
        - (<?php echo $data->published?'Live':'Offline' ?>)
        </div>
    
     
  <?php endforeach; ?>
  
  <?php for ($i=0;$i<(0+$level-$base);$i++): ?>
         </li>
           </ol>
  <?php endfor; ?>
  
  </li> 
</ol>


<a class="btn" href="<?php echo Request::current()->url(array('action'=>'add')); ?>">Add new section</a>
</div> 


<script src="/assets/vendor/jquery.ui.nestedSortable.js" ></script>
<script>




//$( ".js_soratable" ).fadeOut();
	$(function() {
	  $('[data-sort]').css('overflow','auto')
	   .nestedSortable({
			disableNesting: 'no-nest',
			//forcePlaceholderSize: true,
			handle: 'h4',
			helper:	'clone',
			items: 'li',
			opacity: .6,
			placeholder: 'placeholder',
			revert: 250,
			tabSize: 25,
			tolerance: 'pointer',
			toleranceElement: '> h4',
		  cursor: 'move', 
		  start:function(event, ui){$(this).addClass('ui-drag-start')},
		  stop:function(event, ui){$(this).removeClass('ui-drag-start')},
		  update: function(event,ui) {
				  item=ui.item.attr('id');
				  relation='&before=';
				  target=ui.item.prev('li.target').attr('id');
				  if (typeof target == "undefined")	{
				    relation="&under="; 
				    target=ui.item.parents('li.target').first().attr('id');
				  }
				  if (typeof target == "undefined")	{
				    target="0";
				  } 
          var order = '&mode=move&item='+item.replace('section_','')+relation+target.replace('section_','');
          $.get(window.location + "/reorder", order, function(theResponse){
                //$("#contentRight").html(theResponse);
          });
        },
		})
		.mouseup(function(){jQuery("[data-sort] li > div").filter(':hidden').show('blind')})	
		.find('h4')
		.mousedown(function(){jQuery("[data-sort] li > div").filter(':visible').hide('blind')})
		
		
		$('[data-sort]').each( function() {
		  var $that = $(this);
		  $switch=$('<a href="#">Show / hide details</a>').click(function( ){$that.find('li > div').toggle('blind')})
		  $that.prepend($switch);
		}
		)
  });
  
  

	/*
	$("[data-sort] ul")
			.sortable({
				connectWith: ".js_soratable ul",
				placeholder: "ui-state-highlight",
				handle: "h4",
				opacity: 0.6, 
				helper: 'clone',
				dropOnEmpty: true,
				update: function(event,ui) {
				  item=ui.item.attr('id');
				  relation='&before=';
				  target=ui.item.prev('li.target').attr('id');
				  if (typeof target == "undefined")	{
				    relation="&under="; 
				    target=ui.item.parents('li.target').first().attr('id');
				  }
				  if (typeof target == "undefined")	{
				    target="0";
				  } 
          var order = '&mode=move&item='+item.replace('section_','')+relation+target.replace('section_','');
          $.get(window.location + "/reorder", order, function(theResponse){
                //$("#contentRight").html(theResponse);
          });
        },
				//stop: function(event,ui) {
			//		jQuery(".js_soratable  li  div").show('blind');
		//		},
			//	start: function() {
		//		  jQuery(".js_soratable  li  div").hide('blind');
				 // this.refreshPositions();
			//	}
			});
	});
*/
</script>
<style>
.placeholder {background-color:yellow; height:20px;}
.ui-drag-start .no-nest h4 a {color:#333;}
</style>