
<style>
	.ui-state-highlight { height: 0.5em !important; overflow:hidden; line-height: 1.2em; background-color: aqua !important; list-style: none;}
	
	</style>

<h2>Gallery Details</h2>
<h3><?php echo $details->name; ?></h3>
<img class="left" src="/images/dynamic/<?php echo $details->cover()->filehash; ?>/130x130xfit.<?php echo $details->cover->ext; ?>" alt="album cover for <?php echo $details->name; ?>" />
<dl>
    <dt>Sections</dt>
    <dd><?php echo count($sections); ?></dd>
    <dt>Style</dt>
    <dd><?php echo $details->theme; ?></dd>
  </dl>
<a class="button" href="<?php echo Request::current()->url(array('controller'=>$details->type,"action"=>'edit','id'=>$details->id));?>">Gallery options </a>
<a class="button" href="<?php echo Request::current()->url(array('controller'=>$details->type,"action"=>'add','id'=>$details->id));?>">Add section</a>
<a class="button warn js_warn" href="<?php echo Request::current()->url(array('controller'=>$details->type,"action"=>'delete','id'=>$details->id));?>">Delete</a>

<h3>Sections</h3>
<ol class="js_soratable clear sections">
<?php foreach ($sections as $section) : ?>
  <?php echo $section ?>
<?php endforeach; ?>
</ol>
<script>
//$( ".js_soratable" ).fadeOut();
	$(function() {
	
		$( ".js_soratable" )
			.sortable({
				axis: "y",
				handle: "h4",
				placeholder: "ui-state-highlight",
				opacity: 0.6, 
				cursor: 'move', 
				update: function(event,ui) {
				  item=ui.item.attr('id');
				  before=ui.item.next('li').attr('id');
				  if (typeof before == "undefined")	{before='0'} 
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