<div  class="js_soratable">
<ul>
 <?php $level=false;?>
  <?php foreach ($collection as $key=>$data) : ?>
     
    <?php if($level&&$data->level>$level) : //create an additonal level ?>
      <ul>
    <?php endif; ?>
    <?php if($data->level<$level) : //close additonal level  ?>
      </ul>
    <?php endif; ?>
    
    <?php $level=$data->level;?>
  
    <li id="<?php echo $data->id; ?>">
        <?php echo $data->type; ?>
        <a href="<?php echo Request::current()->url(array('controller'=>$data->type,'id'=>$data->id,'action'=>'')); ?>">
          <?php echo $data->name ?><?php if ($data->type=='multiview') echo " - Multipage" ?>
        </a> 
        - (<?php echo $data->published?'Live':'Offline' ?>)
    </li>  
  
  <?php endforeach; ?>
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
          $.get(window.location + "/reorder", order, function(theResponse){
                //$("#contentRight").html(theResponse);
          });
        },
				stop: function(event,ui) {
					jQuery(" .js_soratable > li > div").show('blind');
				},
				start: function() {
				  jQuery(" .js_soratable > li > div").hide('blind');
				}
			});
	});
</script>