<style>
  #album {}
  #album #cover {float:left;}
  #album #details {float:left;padding-left:10px} 
  #album #details ul {margin:0;} 
  #album #details li {padding:2px;list-style:none;} 
  #album #collection {clear:both;}
  #album #collection  {padding:0px; margin:10px 0; border-top:2px solid #ccc;}
  #album #collection li {list-style:none; float:left; margin:0px 5px 0 0; text-align: right; border:1px solid transparent;}
  #album #collection li { padding:0 ; margin:0; display: inline; position:relative;}
  #album #collection li:nth-child(20n+21) {clear:both; position: relative:left:-120px;}
  #album #control {clear:both; position:absolute;top:700px;right:20px;width:100px;}
  
  .b {position:absolute; left:0;top:0; z-index:20; display:block; background: #000; font-weight: bold;}
  .cover {top:20px;}
  .edit {top:40px;}
  .delete {top:60px;}
  
   {display:none; font-weight: normal;}
   {display:inline;}
  
  a.b span, 
  a.main .drag span { 
    display:none; font-weight: normal;
  }
  
  a.b:hover span,
  a.main:hover .drag span {display: inline;}

</style>

<script>
window.addEvent('domready', function(){


drag2();
delete_control();
cover_control();
edit_control();

});


function drag1(){
  $$('#collection li').addEvent('mousedown', function(event){
    event.stop();
    // `this` refers to the element with the .item class
    var original = this;

    var clone = original.clone().setStyles(original.getCoordinates()).setStyles({
      opacity: 0.7,
      position: 'absolute'
    });
    
    var box = original.clone().setStyles({
      opacity: 0.1,
    })
    
        
    var drag = new Drag.Move(clone, {
    
      xCo:0,
      
      placeholder:false,

      droppables: $$('#collection li','#control li'),
      
      onDrop: function(draggable, droppable){
        if (droppable){
          id = droppable.get('id');
          if (id=='cover') {
              original.setStyle('display', 'inline');
              placeholder.destroy();
              //alert('Setting the cover');
          } else if  (id=='bin') {
              original.destroy();
              placeholder.destroy();
              //alert('Deleting the item');
          } else {
          //updated=original.clone().inject(droppable,'top');
          original.replaces(placeholder);
          original.setStyle('display', 'inline');
          droppable.setStyle('background', 'none');
            //alert('item moved')
            order=[];
          Array.each($$('#collection li a'),function(element, index){
              order.push(element.get('id').replace('image_',''));
          });
          //alert(order.join(','));
          }
          draggable.destroy();
        } else {
          draggable.destroy();
          placeholder.destroy();
          original.setStyle('display', 'inline');
        }
      },
      
    onDrag:function(event){
    } , 
      
    onStart: function(draggable){
      
      clone.inject(document.body);      
      original.setStyle('display', 'none');
    },
      
    onEnter: function(draggable, droppable){
      id = droppable.get('id');
      if (id=='cover'||id=='bin') {
       droppable.setStyle('background', '#6B7B95');
        }
      else {
        if (this.placeholder){
          this.placeholder.destroy();
        }
        this.placeholder=box.clone().inject(droppable,'before');
      }
    },

    onLeave: function(draggable, droppable){
    if (id=='cover'||id=='bin') {
      droppable.setStyle('background', 'none');
    }else {
     
    }
    }, 
    onCancel: function(dragging){
        //follow link;
        alert('going to: '+original.get('href'));

      }
    });
    drag.start(event);
  });
};
function drag2(){
$$('#collection li').each(function(e){e.getChildren('.b').hide();});
$$('#collection li').addEvent('mouseenter', function(){this.getChildren('.b').show()});
$$('#collection li').addEvent('mouseleave', function(){this.getChildren('.b').hide()});

var sorted = false;
var stop=function(event){event.stop();}
var scroller=new Scroller(document.body)


      /* create sortables */
    	var sb = new Sortables('collection', {
    		/* set options */
    		clone:true,
    		revert: true,
    		opacity: 0.1,
    		//handle:'a.main span',
    		stopPropagation:true,
    		preventDefault:true,
    		dragOptions:{
    		  stopPropagation:true,
    		  preventDefault:true,
    		  onStart:function(el,event){},
    		  onEnter:function(){//if using multiple lists, count to page number and either move up or down items
    		  },
    		  onComplete:function(el,event){},
    		},
    		/* initialization stuff here */
    		initialize: function() {
        },
    		/* once an item is selected */
    		onStart: function(el,clone) {
    			//el.setStyle('border','1px dashed #fff');
    			el.addEvent('click', stop);
    			//add mouse move fun
    			scroller.start();

    		},
    		onCancel:function(el) { 
    		  el.removeEvent('click', stop)
    		  scroller.stop();
        },
    		onSort: function(el, clone){
          sorted = true;
        },
    		/* when a drag is complete */
    		onComplete: function(el) {
    			//el.setStyle('border','none');
    		  scroller.stop();
    			if(sorted) {
              sorted = false; // clear it out again
                //build a string of the order
          			var sort_order = '';
          			
          			order=[];
          			sort_order = sb.serialize(function(element, index){
          			    if (element.id){
                      order.push(element.id.replace('image_',''));
                    }
                });
                sort_order=order.join(',');
                
          			//do an ajax request
          			uri=new URI().toString().split('/');
          			uri.push('organise');
          			
          			console.log('URL:' + uri.join('/'));
          			console.log('DATA:mode=sort&order=' + sort_order)
          			
          			var req = new Request.JSON({
          					url:uri.join('/'),
          					method:'post',
          					autoCancel:true,
          					data:'mode=sort&order=' + sort_order,
          					onRequest: function() {},
          					onSuccess: function(data) {
          					 	//alert(data.status);
                       //update divs if needed
          					}
          				}).send();

          			}
    		 
        //el.removeEvent('click', stop);
    		}
    	});
}

function delete_control(){
  $$('#collection li a.delete').addEvent('click', function(event){
        var item=this.getParent('li')
        event.stop();
        //do an ajax request
  			var req = new Request.JSON({
  					url:this.get('href'),
  					method:'get',
  					autoCancel:true,
  					data:'',
  					onRequest: function() {},
  					onSuccess: function(data) {
  					  alert(data.status);
  					  item.destroy();
               //update divs if needed
  					}
  				}).send();
  })
}
function cover_control(){
  $$('#collection li a.cover').addEvent('click', function(event){
        event.stop();
        //do an ajax request
  			var req = new Request.JSON({
  					url:this.get('href'),
  					method:'get',
  					autoCancel:true,
  					data:'',
  					onRequest: function() {},
  					onSuccess: function(data) {
  					  src=$('cover').get('src').split('/')
  					  src[3]=data.filehash;
  					  $('cover').set('src',src.join('/'))					  
  					}
  				}).send();
  })
  }
  
  function edit_control(){
    $$('#collection li a.main').addEvent('click', function(event){
        event.stop();
        var myURI = new URI(this.get('href'));
        myURI.go();
    });
  }

</script>

<h3>Album Details</h3>
<?php $parent=$album->parent;?>
<?php if($parent->id) : ?>
Back to collection <a href="<?php echo Request::current()->url(array('controller'=>$parent->type,'id'=>$parent->id)); ?>"> <?php echo $parent->name; ?></a>
<?php else: ?>
Back to  <a href="<?php echo Request::current()->url(array('controller'=>'collections','id'=>'')); ?>">collections</a>
<?php endif; ?>

<div id="album">
  <img id="cover" src="/images/dynamic/<?php echo ($cover=$album->cover)?$cover->filehash:'0';?>/400x300xcrop.jpg" title="Album cover" /> 
  <div id="details">
    <h2><?php echo $album->name; ?> (<?php echo $album->images->count_all(); ?> images)</h2>
    <p>created on <b><?php echo Date::formatted_time($album->add_date,'D jS F Y');?></b> by <b><?php echo $album->added_by->username; ?></b></p>
    Links:<ul>
      <li><a class="minibutton" href="/<?php echo Request::current()->uri(array('action'=>'edit')); ?>"><span>Edit details</span></a></li>
      <li><a class="minibutton" href="/<?php echo Request::current()->uri(array('action'=>'organise')); ?>"><span>Organise pictures</span></a></li>
      <li><a class="minibutton" href="/<?php echo Request::current()->uri(array('action'=>'upload')); ?>"><span>Upload new images</span></a></li>
      <li><a class="minibutton btn-warn" href="/<?php echo Request::current()->uri(array('action'=>'delete')); ?>"><span>Delete this Album</span></a></li>
    </ul>
  </div>
  </div>

<a style="clear:both" class="minibutton" href="/<?php echo Request::current()->uri(array('id'=>'')); ?>"><span>Back to Albums</span></a>
