<div data-role="page" id="main">
	
	<div data-role="header" data-position="fixed">
	  <?php echo url::back($collection); ?>
	  <h1><?php echo $collection->name; ?></h1>
    <a href="index.html" data-icon="gear" data-iconpos="notext">Opions</a>
	</div>
  <div data-role="content">
   <ul data-role="listview">
   <?php foreach ($sections as $key=>$section): ?>
   <?php if (!$section->published) continue; ?>
	   <li>
	     <a href="<?php echo Route::url($section->id); ?>">
	       <img src="<?php echo URL::image($section->cover,80,80,'crop'); ?>" alt="Cover for <?php echo $section->type; ?>">
	       <h2><?php echo $section->name; ?></h2>
	       <p><strong><?php echo ucwords($section->type); ?></strong> <?php echo $section->desc; ?></p>
	       <span class="ui-li-aside"></span>
	       <span class="ui-li-count">
	         <?php switch($section->type) {
	            case 'gallery': 
	            case 'collection':
	             echo $section->children->count();
	             break; 
	            case 'guestbook':
	             echo $section->comment->count_all();
	             break;
	            default:
	             echo $section->images->count_all();
	            break;
	           }; 
	         ?>
	       </span>
	     </a>
	   </li>
	  <?php endforeach; ?>
    </ul>
	</div>   
	<div data-role="footer" data-position="fixed">	
    <a href="<?php echo Request::current()->url(array('action'=>'add')); ?>" data-icon="plus" data-iconpos="right" data-rel="dialog">Add a comment</a>
  </div> <!-- /footer -->
  
</div>
  
 