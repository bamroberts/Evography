
<style>
	.ui-state-highlight { height: 0.5em !important; overflow:hidden; line-height: 1.2em; background-color: aqua !important; list-style: none;}
	
	</style>

<h2>Gallery Details</h2>
<h3><?php echo $gallery->name; ?></h3>

<img class="left" src="<?php echo url::image($gallery->cover,300,300); ?>" alt="album cover for <?php echo $gallery->name; ?>" class="media" />
<dl>
    <dt>Sections</dt>
    <dd><?php echo count($sections); ?></dd>
    <dt>Style</dt>
    <dd><?php echo $gallery->theme; ?></dd>
  </dl>
<a class="btn" href="<?php echo Request::current()->url(array('controller'=>$gallery->type,"action"=>'add','id'=>$gallery->id));?>">Add section</a>
<a class="btn warn js_warn" href="<?php echo Request::current()->url(array('controller'=>$gallery->type,"action"=>'delete','id'=>$gallery->id));?>">Delete</a>

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
		  .css('overflow','auto')
			.sortable({
				axis: "y",
				handle: "h4",
				placeholder: "ui-state-highlight",
				opacity: 0.6, 
				cursor: 'move',
				helper: 'clone', 
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
					//jQuery(" .js_soratable > li > div").show('blind');
				},
				start: function() {
				  //jQuery(" .js_soratable > li > div").hide('blind')
				}
			})
		.mouseup(function(){jQuery(" .js_soratable > li > div").filter(':hidden').show('blind')})	
		.find('h4')
		.mousedown(function(){jQuery(" .js_soratable > li > div").hide('blind')})
		
	});
</script>