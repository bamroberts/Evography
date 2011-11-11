<div  class="js_soratable">
<ul>
<li>
 <?php $level=false;?>
  <?php foreach ($collection as $key=>$data) : ?>
     
    <?php if($level&&$data->level>$level) : //create an additonal level ?>
      <ul class="clear">
    <?php endif; ?>
    <?php if($data->level<$level) : //close additonal level  ?>
      </ul>
    <?php endif; ?>
    
    <?php $level=$data->level;?>
    </li>
    <li id="<?php echo $data->id; ?>" class="target fix">
     
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
  </li> 
</ul>
<a class="button" href="<?php echo Request::current()->url(array('action'=>'add')); ?>">Add new section</a>
</div> 

<script>
//$( ".js_soratable" ).fadeOut();
	$(function() {
	
		$( ".js_soratable ul" )
			.sortable({
				connectWith: ".js_soratable ul",
				placeholder: "ui-state-highlight",
				handle: "h4",
				opacity: 0.6, 
				cursor: 'move', 
				helper: 'clone',
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
</script>