<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Grid Test</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="author" content="">
	<!-- Mobile viewport optimized: j.mp/bplateviewport -->
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />

  	<!-- Place favicon.ico and apple-touch-icon.png in the root directory: mathiasbynens.be/notes/touch-icons -->
	<script type="text/javascript" src="https://www.google.com/jsapi?key=ABQIAAAA-2tTbIRKJojggSRM--n-hxSvpd12rs751Bi4QsVjQ2FFNzfAXhQ0TlJ9sZ-4vT9cZebJUS67Zc18rw">
	</script>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/jquery-ui.min.js" type="text/javascript"></script>

	  <script>window.jQuery || document.write('<script src="/assets/javascript/libs/jquery-1.5.1.min.js"><\/script>')</script>

  	<link rel="stylesheet" href="/bootstrap/css/bootstrap.css">
    <script src="/bootstrap/js/bootstrap.js"></script> 
    <style type="text/css">
    	.media-grid .active {
    		
    		border-color:rgba(50,50,255,1);
    	}

    	.media-grid .active img,
    	.media-grid li:hover img {
    		opacity:0.7;
    	}

    	.media-grid li {
    		position: relative;
    	}
      
    	.media-grid li .image-tools {
    		display:none;
    		position: absolute;
    		top:50%;
    		left:50%;
    		margin:0;
    		width:50px;
    		z-index:1000;
    		margin-top:-24px;
    		margin-left:-24px;
    	}

    	.media-grid li:hover .image-tools
    	
    	 {
    		display:block;
    	}	
    	.image-tools ul {margin:0;}
    	.image-tools li {
    		list-style:none;
    		float:left;
    	}
    	.image-tools li a {
    		text-align:center;
    		background-color: rgb(100,100,150);
    		width:20px;
    		height:20px;
    		display: block;
    		color:white;
    		text-decoration:none;
    		font-weight:bold;
    		margin:1px;
    		border:1px solid rgba(0,0,0,0);
    	}
    	.image-tools li a:hover {
    		background-color: rgb(150,100,150);
    	}

    	.a-fade {
    		position: absolute;
    		display: none;
    		background-color:rgb(50,50,255);
        background-color: rgba(255,255,200,0.5);
    		opacity: 0.5;
    		-moz-opacity: 0.5;
    		filter:alpha(opacity=5);
    		width:85%;
    		height:80%;
    		top:10%;
    		left:7.5%;
        font-size:20px;
        text-align:center; 
    	}
    	li:hover .a-fade {
    		display:block;
    		opacity: 0.5;
    		-moz-opacity: 0.5;
    		filter:alpha(opacity=5);
    	}
    	li.active:hover .a-fade,
    	.active .a-fade,
    	.a-fade.active {
    		display:block;
    		opacity: 0.7;
    		-moz-opacity: 0.7;
    		filter:alpha(opacity=7);
    	}

      .media.active a.thumbnail {
        border-color:red;
      }

      .group {background-color:white; position: relative;}
      .group a {
        
        z-index:100;
        position: relative;
      }

      .group-count {display: none;}

      .group .group-count, 
      .grid-selector .group-count {
        display: inline;
        position:absolute;
        background-color:red;
        color:white;
        font-weight:bold;
        top:5px;
        left:5px;
        padding:3px 5px;
        border:2px solid white;
        border-radius:50px;
        z-index:101;
        opacity:0.8;
      }
             
      .group:after,
      .group:before {
        content: '';
        display: block;
        position:absolute;
        top:-2px;
        left:-2px;
        border:1px solid #999;
        width:100%;
        height:100%;
        z-index:5;
        background-color:white;
        border-radius:5px;
        -moz-border-radius:5px;
        -webkit-border-radius:5px;

      }
      .group:hover:after,
      .group:hover:before {
      border-color:#08C;
      }
      .group:before { 
        top:-4px;
        left:-4px;
      }


      .animate {
        transition: all 2s;
        -moz-transition: all 2s;
        -webkit-transition: all 2s;
        -o-transition: all 2s;

        }

      .grid-selector {
        border:1px solid yellow;
        background-color: rgba(255,255,200,0.5);
        height:100px;
      }

      .js-multiselect {
        -moz-user-select:none;
        -webkit-user-select:none;
        -ms-user-select:none;
        user-select:none;
      }
    </style>  

   

	</head>
	<body>
		<div class="container content">
			<div class="page-header">
				<h1>
					Grid Test
				</h1>
			</div>
			<div class="frame content">
				<div class="row js-multiselect">

					<div class="span8 block media-grid">
						<h3 class="delta">Images</h3>
							<ul class="thumbnails">
                <?php 
                    $host = 'http://new-zealand.evography.com/';
                    $string = file_get_contents($host."akoroa.json");
                    $json=json_decode($string,true);
                    foreach($json['images'] as $key=>$image) :
                    //print_r($image);die();
                ?>			    
								    <li class="span2 media">
								    	<a href="#" class="thumbnail">
                        <span class="group-count"></span>
								    		<span class="a-fade"><?php echo $key; ?></span>
								    		<img src="<?php echo $host.$image['sizes']['square']; ?>" alt="">
								    	</a>
								    	<div class="image-tools">
								    		<ul>
								    			<li>
								    				<a href="#" rel="tooltip" class="js-tip" title="Edit this image">E</a>
								    			</li>
								    			<li>
								    				<a href="#" rel="tooltip" class="js-tip" title="Delete this image">X</a>
								    			</li>
								    			<li>
								    				<a href="#" rel="tooltip" class="js-tip" title="Set this image as the album cover">C</a>
								    			</li>
								    			<li>
								    				<a href="#" rel="more-info" title="More options"><i class="icon-chevron-down icon-white"></i></a>
								    			</li>
								    		</ul>	
								    	</div>
                      
								    </li>
								<?php endforeach; ?>
							</ul><!-- end thumbnails -->
					</div><!-- end span -->	

					<div class="span3 block pick-list">
						<h3 class="delta">Quick pics</h3>
					</div><!-- end span -->	

				</div><!-- end row -->	
        
			</div><!-- end frame -->

		</div><!-- end container -->	
		<script>
    		$('.js-tip').tooltip();

	var MultiSelect = function ( content, options ) {
	    var _this = this
	    //merge settings with defaults 
	    this.settings = $.extend({}, $.fn.multiselect.defaults, options)
	    
	    //master object
	    this.$element = $(content)
        .on('mousemove', $.proxy(this.mouseMove, this))
        .on('mousedown', $.proxy(this.mouseDown, this))
        .on('mouseup', $.proxy(this.mouseUp, this))
        .delegate('.media', 'click', $.proxy(this.click, this))
        .delegate('.media a', 'mousedown', $.proxy(this.mouseDown, this))

	    this.picklist = this.$element.find('.pick-list'); 

	    this.set = this.$element.find('.media').each(function(index){
	    	//console.log(index);
	    	$(this).data('id',index);
	    });

	    this.selected  = [];
	    this.pickObjects  = {};
	    this.$pickObjectHolder = $('<ul class="row" />');
	    this.picklist.append(this.$pickObjectHolder);
	    this.$pickCount = $('<p />');
	    this.picklist.append(this.$pickCount);

      this.groupButton = $('<a class="btn" href="#">Group</a>');
      this.picklist.append(this.groupButton);
      this.groupButton.click(function(e) {
        e.preventDefault();
        _this.group();

      })
	    
	    console.log('init');

	    this.init();    
	    return this
  	}	

  	MultiSelect.prototype = {
  		init:function() {
        var _this = this;

        this.updateCount();

        this.mouseTarget = this.blank;

        this.$element.find('ul').first().sortable({
         distance: _this.settings.dragThreshold,
         placeholder: "span2 media",
         start: function(e,ui){

           ui.item.data('forceGroup',  _this.group(ui.item) );
         },
         stop: function(e,ui){
          if(ui.item.data('forceGroup')) {
            _this.ungroup(ui.item);
          }
         },
        }).disableSelection();
       // this.$element.sortable('disable');

  			return;
  		},

      dragSelect:function(e) {
        xdiff = this.mouse.x - e.pageX 
        xneg = xdiff < 0 ? -1 : 1;
        ydiff = this.mouse.y - e.pageY 
        yneg = ydiff < 0 ? -1 : 1;
        if ((xdiff * xneg) < this.settings.selectThreshold && (ydiff * yneg) < this.settings.selectThreshold) return;
        if(!this.SelectOverlay){
          this.SelectOverlay = $('<div />').addClass('grid-selector').css('position','absolute');
        //  this.SelectOverlay.css({top:this.mouse.y, left:this.mouse.x}); 
          this.$element.append(this.SelectOverlay);
          count = $('<span />').addClass('group-count');
          this.SelectOverlay.append(count);
        }

        if(xneg!=1) {
          this.SelectOverlay.css({left:this.mouse.x, width:xdiff * -1 })
        } else {
          this.SelectOverlay.css({left:e.pageX, width:xdiff})
        }

        if(yneg!=1){
          this.SelectOverlay.css({top:this.mouse.y, height:ydiff * -1 })
        } else {
          this.SelectOverlay.css({top:e.pageY, height:ydiff})
        }
        

        //this.SelectOverlay.css({height:ydiff * -1 , width:xdiff * -1 });
        itemcount = this.findIntersectors(this.SelectOverlay,this.set).length
        itemcount = (e.shiftKey) ? itemcount * -1 : itemcount;
        count.html(itemcount);
        
        
      },
      dragItem: function(e) {
        // xdiff = this.mouse.x - e.pageX 
        // xneg = xdiff < 0 ? -1 : 1;
        // ydiff = this.mouse.y - e.pageY 
        // yneg = ydiff < 0 ? -1 : 1;
        // if ((xdiff * xneg) < this.settings.dragThreshold && (ydiff * yneg) < this.settings.dragThreshold) return;
       
        // if (!this.grouped) {
        //   this.group(this.mouse.target);
        //   this.grouped = true
        // }
        //this.mouse.target.css({position:'absolute', top:e.pageY, left:e.pageX});
  
        //group items
        //start ui drag drop sort
        console.log('Dragging')
      },
      
      blank: function() {
        return;
      },

      mouseMove: function(e) {
        this.mouseTarget(e);
        return;
      },

      mouseDown: function(e) {
        e.preventDefault();
        console.log(e.target.nodeName)
        //store co-ords
        this.mouse = {};
        this.mouse.target = $(e.target).parents('.media');
        this.mouse.x = e.pageX;
        this.mouse.y = e.pageY;
        //this.mouse = e.position
        if($(e.target).is('img')) {
          //this.mouseTarget = this.dragItem;
          //this.$element.sortable('disable');
        } else {
          this.mouseTarget = this.dragSelect;
        }

      },
      mouseUp: function(e) {
        var _this = this;
        if(this.mouseTarget == this.dragItem) {
          // this.mouseTarget = this.blank;
          // if (this.grouped){
          //   this.mouse.target.css({position:'relative',top:0,left:0});
          //   this.grouped = false
          //   this.ungroup(this.mouse.target)
          // }
          // this.$content.sortable('')
          //expand group
        }
        if(this.mouseTarget == this.dragSelect) {
          this.mouseTarget = this.blank;
          if (this.SelectOverlay) {
            selected = this.findIntersectors(this.SelectOverlay,this.set)
            $(selected).each(function() {
              $this = $(this);
              if(!_this.selected[index = $this.data('id')]) {
                $this.addClass('active');
                _this.selected[index] = $this;
                _this.createPickItem($this);
              }
            });
            this.SelectOverlay.detach();
            this.SelectOverlay = false;
          }
          
        }
        
      },

      group:function(target) {
        _this = this;
        picks = $(this.$element).find('li.active');
        console.log(picks.length);
        if(picks.length < 2) return false;
        //if not target set as first item.
        
        if(!target) {
          target = picks.first();
        }
        var $target = $(target);
        $target.css('z-index', 300);
        //clone selected elements

        TargetPosition = $target.position();
        var TargetStyle = {
            'top' : TargetPosition.top,
            'left' : TargetPosition.left
          };
        console.log(TargetStyle)  

        var items = $target.data('items') || [];  

        picks.not($target).each(function(key) {
          console.log('item ' + key);
          var item = $(this);

          //If the item is already a group add in their items
          if (children = item.data('items')) {
            console.log(item.data('items'));
            $(children).each(function(){
              items.push(this);
            });
            //items += item.data('items');
            //might have to move these to new location
          }

          console.log(items.length);

          var position = item.position();
          var copy = item.clone(true);
          var style = {
            'position' : 'absolute',
            'top' : position.top,
            'left' : position.left,
            'z-index': 200
          };

          console.log(style) ; 
          copy.css(style);
          item.css('opacity',0);
          copy.insertAfter($target);
          //copy.addClass('animate');
          //item.addClass('animate');
          
          

          copy.removeClass('active');
          items.push(copy);
          
          copy.animate(style,0, function(){
              copy.animate(TargetStyle,300)

          })
         // console.log(item.width());

          copy.data('originalWidth',item.width());
          item.animate({
             width: '0px'
           }, 300, function() {
               index = $(this).data('id')
               _this.selected[index] = null;
               $(this).detach();
          });


        });
        
        $target.data('items', items);
        $target.addClass('group');

        $target.find('.group-count').html(items.length + 1); 

        this.selected = [];
        this.selected[$target.data('id')] = $target;

        this.redrawPick();

        return true;
      },

      ungroup:function(holder) {
        console.log('here');
        var that = this;
        var holder = $(holder);
        items = holder.data('items');

        $(items).each(function() {
          var item = this;

          item.insertAfter(holder);

          start = {
            position:'relative',
            width:'1px',
            top:'0',
            left:'0',
          };
          
          item.css(start);
          item.animate({width:this.data('originalWidth')},300);
          item.addClass('active');
          that.selected[item.data('id')] = item;
          //that.createPickItem(item);
          
        });
        
        holder.data('items',false);
        holder.removeClass('group');
        holder.find('.group-count').html(0); 
        this.redrawPick();

        this.set = this.$element.find('.media').each(function(index){
        //console.log(index);
          $(this).data('id',index);
        });
      },

  		click:function(e) {
  			_this = this;
  			$item = $(e.currentTarget);
  			e.preventDefault()

        if(!e.metaKey) {
          this.set.removeClass('active');
          $item.addClass('active');
          this.selected = [];
          this.selected[$item.data('id')] = $item;
          this.redrawPick();
          return;
        }

  			var index;
  			if(this.selected[index = $item.data('id')]) {
  				//In array
  				//index = jQuery.inArray($item, this.set)
  				$item.removeClass('active');
  				this.selected[index] = null;
  				this.pickObjects[index].fadeOut(300, function(){
  				 	_this.pickObjects[index].detach()
  				 	_this.updateCount();
  				});
  				
  				console.log(this.selected.length);
  			} else {
  				$item.addClass('active');
  				this.selected[index] = $item;
  				this.createPickItem($item);
  				//this.updateCount()
  			}
  			//this.updatePick();
  		},

  		redrawPick:function() {
  			var _this = this;
        this.$pickObjectHolder.find('li').fadeOut(300);
  			this.$pickObjectHolder.empty();
  			$(this.selected).each(function() {
  				 $item = $(this);
  				 if (!$item.html()) return;
  				_this.createPickItem($item);
  			});
  		},

  		createPickItem:function($item) {
        var _this = this;
  			if (!$item.html()) return;
  				id = $item.data('id');
  				$img = $item.find('img');

  				$li = $('<li class="span1 thumbnail" />');
  				$li.append($img.clone())
          
          if($items = $item.data('items')) {
            count = $items.length + 1;
            type = ' image';
            type += count !=1 ? 's' : '';
            $li.append('<b>' + count + type + '</b>')
            button = $('<a class="btn btn-mini" href="#">Ungroup</a>');
            button.click(function(e){
              e.preventDefault();
              _this.ungroup($item);
            });
            $li.append(button);
          }
  				$li.hide();
  				this.pickObjects[id] = $li

  				this.$pickObjectHolder.append($li);
  				$li.fadeIn(300);

  				this.updateCount();
  		},

  		updateCount:function() {
  			count = this.$pickObjectHolder.find('li').length;
  			plural = (count == 1) ? '' : 's';
  			this.$pickCount.html(count + ' item' + plural + ' selected.'); 
        if(count > 1) {
          this.groupButton.fadeIn(100);
        } else {
          this.groupButton.fadeOut(100);
        }
  		},

      findIntersectors:function(targetSelector, intersectorsSelector) {
        var intersectors = [];

        var $target = $(targetSelector);
        var tAxis = $target.offset();
        var t_x = [tAxis.left, tAxis.left + $target.outerWidth()];
        var t_y = [tAxis.top, tAxis.top + $target.outerHeight()];

        $(intersectorsSelector).each(function() {
              var $this = $(this);
              var thisPos = $this.offset();
              var i_x = [thisPos.left, thisPos.left + $this.outerWidth()]
              var i_y = [thisPos.top, thisPos.top + $this.outerHeight()];

              if ( t_x[0] < i_x[1] && t_x[1] > i_x[0] &&
                   t_y[0] < i_y[1] && t_y[1] > i_y[0]) {
                  intersectors.push($this);
              }

        });
        return intersectors;
      },

  	}
  

  
   $.fn.multiselect = function ( options ) {
      return this.each(function () {
        $(this).data('multiselect', new MultiSelect(this, options))
      })
    return this
  }

  $.fn.multiselect.defaults = {
    
    selectThreshold : 5,
    dragThreshold : 15,
  
  }

  $('.js-multiselect').multiselect();


    	</script>
	</body>
</html>

