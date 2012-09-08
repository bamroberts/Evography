var Slider = function ( content, options ) {
    var _this=this;
    
    this.debug("Initialising plugin")
    
    this.gallery=[];//gallery objects
    this.panes={} //for storing working panes
    this.current=-1
    
    this.cache=[] //for cashing items
    
    this.control={}; //object for storing control elements
    this.info={}; //info layer
    
    this.transitionFinished=true;
    
    this.loaders = [];
    
    this.buttons={
      'next':{
         'text'    :'Next'
        ,'action'  :'next'
        ,'title'   :'Next item (n or ->)'
        ,'shortcut':[78,39]
        ,'group'   :'center'
        ,'classes' :''
      },
      'previous':{
         'text'    :'Previous'
        ,'action'  :'previous'
        ,'title'   :'Previous item (<- or p)'
        ,'group'   :'center'
        ,'shortcut':[80,37]
      },
      'play':{
         'text'    :'Play'
        ,'action'  :'toggle'
        ,'title'   :'Play / pause slideshow'
        ,'shortcut':[32]
       // ,'status'  :function(){this.settings.play}
      },
      'link':{
         'text'    :'Link'
        ,'action'  :'link'
        ,'title'   :'Show more information'
        //,'shortcut':[32]
        //,'status'  :function(){this.settings.play}
      },
      'repeat':{
         'text'    :'Repeat'
        ,'action'  :'repeat'
        ,'title'   :'Repeat slideshow'
        //,'shortcut':[32]
        //,'status'  :function(){this.settings.play}
      },
    }
    
    //merge settings with defaults 
    
    this.debug("Import settings")
    this.settings    = $.extend({}, $.fn.slider.defaults,    options);
    
    this.debug("Import transitions")
    this.transitions = $.extend({}, $.fn.slider.transitions, this.settings.transitions);
    
    //master object
    this.$element = $(content);
      
    //Target is either defined in options , defaults or falling back to self
    this.$target = $(this.settings.target || content);
    
    //main container
    this.debug("Create plugin container")
        this.$slider=$('<div class="slider">');
        this.$slider.hide();
        this.$target.append(this.$slider);
    
    //bind resize function for windo resizing.
    var resizeTimer = null;
    $(window).bind('resize', function() {
      if (resizeTimer) clearTimeout(resizeTimer);
      resizeTimer = setTimeout(function(){_this.resize()}, 100);
    });
    
    //$(window).bind('onorientationchange', function(){
    //  _this.resize()
    //})
    
    if (this.settings.prefetch){
      this.getData()
    }
    
    console.log(this.settings);
    if (this.settings.autoLoad) {
        this.show();
        this.next();
    }    
  }
  Slider.prototype = {
     //create elements
     init: function () {
        var _this=this;
        this.debug("Build plugin DOM")
        if (!this.gallery.length) return; //nothing to build
        
        
        //slide holder window
        this.$frame=$('<div class="slider-frame">');
        
        //default pane
        this.panes.$current=$('<div class="slider-empty">');
        //controls
        this.$control=$('<div class="slider-control">'); 
        
        //if controls are always on add .active class.
        if (this.settings.controlsAlwaysOn) {
          this.$control.addClass('active');
        }
       
       //append frame and control layers.
       this.$slider.append(this.$frame, this.$control);
       
       
       this.$timer=$('<b>&nbsp;</b>')
         timer  = $('<div class="slider-timer">')
          .append('<span>'+ this.settings.speed + 's</span>')
          .append(this.$timer)
       
       
       
       this.$title   = $('<div class="slider-title">');
       this.$info   = $('<div class="slider-title">');
       this.$details = $('<div class="slider-title">');
       
       var info={};
       
       info.timer=timer;
       info.title=this.$title;
       info.info=this.$info;
       info.details=this.$details;
       
       if (this.settings.info) {
       console.log('info')
        if(jQuery.isArray(this.settings.info)) {
          console.log('limited')
          $.each(this.settings.info, function(i,name){
            //if (jQuery.inArray(info,name)) {
             console.log(name)
              _this.$control.append($(info).attr(name))
            //}
          })
        } else {
          console.log('all')
          $.each(info, function(name,item){
              console.log(name)
              _this.$control.append(this)
              
          })
        }
        //this.info=info;
        
        
        
        //if info is array 
       // this.$control.append(timer,this.$info,this.$title,this.$details);
       }
       //this.$control.append(info)
        
        
        
       this.buildControl();
       
       
       // Add swipe listners
        //this.$frame.bind("touchstart", $.proxy(this.touch, this));
        
        this.isIOS = ((/iphone|ipad/gi).test(navigator.appVersion));

       
        this.debug("Bind mouse controls");
        if(this.isIOS) {
        	if (this.settings.swipe===true || this.settings.swipe=='touch') {
	          this.$control.bind("touchstart", $.proxy(this.onMouseDown, this));
	        }
	        this.$control.bind("touchmove", $.proxy(this.onMouseMove, this));
	        this.$control.bind("touchend", $.proxy(this.onMouseUp, this));
        } else {
	        if (this.settings.swipe === true || this.settings.swipe == 'mouse') {
	          this.$control.bind("mousedown", $.proxy(this.onMouseDown, this));
	        } 
	        this.$control.bind("mousemove", $.proxy(this.onMouseMove, this));
	        this.$control.bind("mouseup", $.proxy(this.onMouseUp, this));
        }
        
   /*
     document.body.addEventListener('touchmove', function (e){
	        if($('.slider .open').length > 1 && document.elementFromPoint(e.targetTouches[0].pageX, e.targetTouches[0].pageY) !== this.$element){
		        e.preventDefault();
		    }
		 }, false);
*/
		 
        
        
        
       
       this.$overlay=$('<div class="slider-overlay">&nbsp;</div>').css('opacity',this.settings.overlay);
       if (this.settings.overlay){
          $('body').append(this.$overlay)
       }
       
       
       this.preload();
       
       this.next();
       
     },
     
     buildControl:function () {
       var _this=this;
       
       this.debug("Build plugin controls")
       if ( this.settings.conrolsAlwaysOn) {this.$control.addClass('')}
       
       
       var top    = $('<div class="slider-control-top">')
       var center = $('<div class="slider-control-center">')
       var bottom = $('<div class="slider-control-bottom">')
       
       
       if (this.settings.controls === true){
          var control=[]
          $.each(this.buttons, function(name,btn){
            control.push(name)
          })
          this.settings.controls=control;
       }
       
     
      $.each(this.settings.controls, function(i,name){
          btn=$(_this.buttons).attr(name);
          var button=$('<a class="slider-ui pull-right">')
                  .addClass(name)
                  .attr('title',btn.title)
                  .attr('href','#'+name)
                  .text(btn.text);
          action=$(_this).attr(btn.action);
          _this.$slider.delegate('.'+name, 'click', $.proxy(action, _this))
          $(_this.control).attr(name,button)
          //if (this.settings.keyboard && btn.shortcut){
          //  this.keys[btn.shortcut]=action
          //}
          
          console.log(button)
          bottom.append(button)
       })

       
       var next = $('<a class="slider-ui pull-right next" href="#next" title="Next item (n or ->)">Next</a>')
        this.$slider.delegate('.next', 'click', $.proxy(this.next, this))
       var previous = $('<a class="slider-ui pull-left previous" href="#next" title="Previous item (p or <-)">Prev</a>')
        this.$slider.delegate('.previous', 'click', $.proxy(this.previous, this))
       
       center.append(next,previous);
       
       
      
       
    //   play = $('<a class="slider-ui pull-right play" href="#play" title="Play / Pause button">Play</a>')
               
       var shuffle = $('<a class="slider-ui pull-right shuffle" href="#shuffle" title="Shuffle">Shuffle</a>')
       if (this.settings.shuffle) {shuffle.addClass('on')}
        
       var repeat = $('<a class="slider-ui pull-right repeat" href="#repeat" title="Repeat">Repeat</a>')
       if (this.settings.repeat) {repeat.addClass('on')}
       
       var close = $('<a class="slider-ui pull-right close" href="#close" title="Close">x</a>');
       var thumb = $('<a class="slider-ui pull-right thumb" href="#close" title="Thumbnails">Gallery</a>');
  
     //  this.$slider.delegate('.play, .pause', 'click', $.proxy(this.toggle, this))
       this.$slider.delegate('.shuffle', 'click', $.proxy(this.shuffle, this))
       this.$slider.delegate('.repeat', 'click', $.proxy(this.repeat, this))
       this.$slider.delegate('.close', 'click', $.proxy(this.hide, this))
       this.$slider.delegate('.thumb', 'click', $.proxy(this.thumbnails, this))
       
       var keyControl={
          80:this.previouse //p
         ,37:this.previouse //left arrow
         ,78:this.next //n
         ,39:this.next //right arrow
         ,32:this.toggle //space
         ,88:this.hide //x
         ,27:this.hide //escape
         ,83:this.shuffle //s
         ,82:this.repeat //r
         ,71:this.thumbnails //g
         ,84:this.thumbnails //t       
        };
       
       //this.control={}
    //   this.control.play=play;
       this.control.repeat=repeat;
       this.control.shuffle=shuffle;
       this.control.thumb=thumb;
       this.control.close=close;
       this.control.next=next;
       this.control.previous=previous;
       if (this.settings.play) {this.toggle();}

       
       bottom.append( repeat, shuffle, thumb, close);
       
       if (!this.settings.controls) return;
       
       this.$control.append(top,center,bottom);
       //this.$slider.click(this.onMouseMove())
       this.$slider.delegate('*', 'mousemove', $.proxy(this.movement, this))
       this.$slider.mouseenter($.proxy(this.movement, this))
       this.$slider.mouseleave($.proxy(this.noMovement, this))
     },
     
     getData:function(){
      var _this=this;
      //this.dataFetched=true
     //fetch data from url    
      if (this.settings.data) {
          
          this.debug("Fetch gallery list from AJAX")
          this.$slider.addClass('slider-loading');
          $.ajax({
    		    url      : this.settings.data,
    		    dataType : this.settings.dataType,
    		    async    : this.settings.async,
    		    success  : function(data){
    		      // 
    		      
    			     _this.gallery=_this.settings.onDataLoad(data);
    			     _this.$slider.removeClass('slider-loading')
    			     
    			     _this.init()
    			     _this.dataFetched=true
    				},
          })
        //or selector  
        } else {
          
          this.debug("Fetch gallery list from page elements")
          this.gallery=_this.settings.onDataLoad( this.$element.find(this.settings.selector) )
          this.init();
          this.dataFetched=true
        }  
     },
     
     start:function () {
     
       this.debug("Play slideshow");
       var _this=this;
       this.playing=true;
       this.$slider.removeClass('stopped').addClass('playing');
       this.$timer.animate({
          width: '100%',
          }, this.settings.speed*1000, function() {
             if (_this.playing) {_this.fromPlay=true;_this.$timer.css('width',0);_this.next();}
          });
     },
     stop:function () {
     
       this.debug("Stop slideshow");
       this.playing=false;
       this.$slider.removeClass('playing').addClass('stopped');
       this.$timer.stop();
       this.$timer.css('width',0);
     },
     next:function (e) {
     
      this.debug("Next item");
      e && e.preventDefault() && e.stopImmediatePropagation();
       var _this = this;
       if (e){
         this.control.next.addClass('on'); 
         setTimeout(function(){_this.control.next.removeClass('on')},300);
       }
       
       //---------
       
       /*
       
       if (!this.current || this.current <0 ) {this.current=0};
       this.current++;
       
       //if we are at the end of the collection either repeat or stop
       if (this.current>this.gallery.length) {
        if (this.settings.repeat || this.settings.shuffle ) {this.current=1}
        else {
          this.settings.onEnd();
          return this.stop();
        }
       }
       
       this.goto();
       return;
       */
       
       if (!this.panes.$next) {
          this.settings.onEnd.call(this);
          return this.stop();
        }
       if (this.settings.shuffle) return this.gotoPane(this.panes.$random)
       this.gotoPane(this.panes.$next)

     
     },
     previous:function (e) {
     this.debug("Previous item");
     e && e.preventDefault()
       var _this = this;
       this.control.previous.addClass('on'); 
       setTimeout(function(){_this.control.previous.removeClass('on')},300); 
       
    /*
 this.current--;
     if (this.current<=0) {
      if (this.settings.repeat) {this.current=this.gallery.length}
        else {return;}
     }
     this.goto();
      
     return;
*/
       if (!this.panes.$previous) return;    
       if (this.settings.shuffle) return this.gotoPane(this.panes.$random)
       this.gotoPane(this.panes.$previous)
     },
     
     getRandom:function(){
     this.debug("get random item");
       var newItem;
       if (this.gallery.length>1){
          do {
            newItem = Math.floor(Math.random()*this.gallery.length+1);
            console.log(newItem);
          } 
          while (newItem==this.active);
          
          this.current=newItem;
        } else {this.current=1;}
        
        return;
     },
     randomPane:function(){
       
        this.debug("get random item (pane)");
          var newItem
          //if we havent used our previous random frame return;
          if (this.panes.$random && this.panes.$random.data('pane') != this.panes.$current.data('pane') ) return;
          
          //get a random number
          newItem = Math.floor(Math.random()*this.gallery.length+1);
          
          //if new random frame is also current frame have another dip
          if (newItem==this.current) return this.randomPane();
          
          return this.pane(newItem)
     },
     pane:function(node){
     
     this.debug("Create image pane or fetch from cache");
        if (!this.gallery[node]) return false;
        if (this.cache[node]) {
        
        console.log('returning cached copy of node '+node)
        return this.cache[node].clone().data('pane',node);
        
        }
        
        var _this = this;
        var pane=$('<div class="slider-image">').addClass('pane_'+node)
        var node = node;	
        
        //TODO:logic for other data types, selector, ajax, video, image, html
        //var target=
        
        
        
        
       var content =$('<img>')//.attr('src',this.gallery[node].src)
       
       // if (content.complete == 'true'){
       //   pane.append(content);
          //_this.resize(pane);
      
          pane.addClass('slider-preload')
          pane.append('<span>Loading...</span>')
          
          //imgLoaded = function
          
          
          
          var preload=function(){
          	console.log('unbind');
          	  content.unbind( 'load error', preload );
              content.fadeOut(0)
              pane.removeClass('slider-preload').empty().append(content);
              _this.resize(pane);
              //content.fadeIn(600);
              
              //pane.show();
              if (_this.settings.cache){
                _this.cache[node]=pane
              }
            };
            
          content.bind( 'load error',  preload ).each( function() {
		    // cached images don't fire load sometimes, so we reset src.
		    if (this.complete || this.complete === undefined){
				// webkit hack from http://groups.google.com/group/jquery-dev/browse_thread/thread/eee6ab7b2da50e1f
				// data uri bypasses webkit log warning (thx doug jones)
				console.log(this)
				this.src = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==';
				this.src = _this.gallery[node].src;
			}
		  });
          //content.load(preload)
          //content.attr('src',this.gallery[node].src)
        
          this.resize(pane);
          //pane.fadeIn(300)
        ;//add preload
        
        
        //
        pane.data('pane',node);
        
        
        console.log('returning first instance of node '+node)
        
        return pane;
     },
     
     goto:function (node) {
     this.debug("Go to image number " + node);     
       if (this.current==-1) {
        this.current=node-1;
        this.show();
       }    
       return this.gotoPane(this.pane(node))  
     },
     
     gotoPane:function($pane){
     this.debug("Go to Pane");
     var _this=this;
         //this is needed to make sure we dont stop playing if its a play request
      if (this.playing && !this.fromPlay){
        this.$timer.stop(true);
        this.$timer.css('width',0);
      } else {
        this.fromPlay=false;
      }
     
        this.panes.$last=this.panes.$current        
        this.current=$pane.data('pane') || 0
        this.currentData=this.gallery[this.current];
        
        this.panes.$current=$pane;
        
     //this.transitionComplete(true)
        
        this.$frame.append($pane)
        
        
        
        //sizing.
          this.resize($pane); 
         // $pane.show();
          
          this.$title.removeClass('active');
          this.$info.removeClass('active');
          
          function waitForImage(){
          
            		if(_this.panes.$current.hasClass('slider-preload') ) {
            		  console.log('waiting');
            		  return;
            		}
            		console.log('finished waiting');
            		jQuery.each(_this.loaders, function(){
	            		clearInterval(this);
            		})
            		_this.transition();
            		       		
            		//_this.resize(); 
            		//_this.transitionComplete()
            		return; 		  		
            	};
          
          if(_this.panes.$current.hasClass('slider-preload') ) {
          		loader = setInterval(function(){waitForImage()},100);
            	this.loaders.push(loader);
          } else {
          		this.transition()
          }  
          
        //  this.transition();
          
          _this.preload()
        
          
        
     
     },
     
     updateInfo:function(force){
     
     this.debug("Update image info (title, no, etc)"); 
      
     
      var _this=this;
      var text=this.currentData
      if (this.$title){
        this.$title
            .css('position','relative')
            .animate(
                {'top':this.$title.height()*2}
              , 600 
              , function(){
                  _this.$title.text(text);
                  _this.$title.animate({'top':0},600)
                }
            );
       }
       
       if (this.$info){
        this.$info
            .css('position','relative')
            .animate(
                {'top':this.$info.height()*2}
              , 600 
              , function(){
                  _this.$info.text((_this.current+1) +'/'+ _this.gallery.length);
                  _this.$info.animate({'top':0},600)
                }
            );
       }

     },
     

     
     preload:function(){
     
     this.debug("Preload previous, next, random");
       //if (!this.settings.preload) return;
       
       //this.panes.$current=this.$pane;
       var next, previous;
       
       next=this.current + 1
       if (next>=this.gallery.length) {
        if (this.settings.repeat){
          next=0;
        } else {
          this.control.next.addClass('slider-ui-disable');
        }
       } else {
          this.control.next.removeClass('slider-ui-disable');
       }  
       
       
       console.log('fetching next slide')
       this.panes.$next=this.pane(next);
       
       previous=this.current - 1
       if (previous<0) {
        if (this.settings.repeat){
          previous=this.gallery.length-1
        } else { 
          this.control.previous.addClass('slider-ui-disable');
        }  
       } else {
          this.control.previous.removeClass('slider-ui-disable');
       }  
       console.log('fetching previous slide')
       this.panes.$previous=this.pane(previous);
       
       if (!this.panes.$random || this.current==this.panes.$random.data('pane')) {
            console.log('fetching random slide')
            this.panes.$random = this.randomPane();
       }
       
       
       //clear queue
       //load next
          //load previous
            //if (this.settings.cache)
            //foreach load
            //sync
     },
     
     resize:function(pane){
     
     this.debug("Resize image and pane");
     
        if (!pane) {var pane=this.panes.$current; console.log('k')}
        if (!pane) return;
        
        //img=pane.find('img').first();
        //console.log(img.attr('src')||'img not found!!!')
         var item,fw,fh,w,h,wScale,hScale,scale,mw,mh,wd,hd;
        item=pane.children().first();
        
  //      console.log('tag:'+img.tagName)
        
        fw=this.$slider.width();
        fh=this.$slider.height();
        
        if (item.attr('src')) {
          item.css('width','auto');
          item.css('height','auto');
          item.css('margin-left','0');
          item.css('margin-top','0');
        }
     //console.log('checking:pane'+pane.data('pane'));
          w=item.width();
          h=item.height();
          if (w==0){
            var copy=item.clone();
            copy.show().css('opacity',0)
            this.$frame.append(copy)
            w=copy.width();
            h=copy.height();
            copy.remove(); 
          }
          
         if (w==0) {
          item=false;
          w=fw;
          h=fh;
        }
        
               
        scale=1        
        if (w>fw) {
            wScale=fw/w
            //nw=w*scale
           // pane.css('height',h*scale)
            //set width = fw
          } else {wScale=1}
        if (h>fh) {
            hScale=fh/h
            //set width = fw
        } else {hScale=1}
                //scale
        if (this.settings.scaleUp){
          if (w<fw) {wScale=fw/w;}
          if (h<fh) {hScale=fh/h;}
          
          //are we allowed to scale up? and by how much
          if (this.settings.scaleUp!==true){
            wScale=Math.min(wScale,this.settings.scaleUp);
            hScale=Math.min(hScale,this.settings.scaleUp)
          }
        }
        
        //take the max or min edge depending on 
        if (this.settings.scale=='fit') {
         scale=Math.min(hScale, wScale);
         
        } else if (this.settings.scale=='fill')  {
         scale=Math.max(hScale, wScale);
        }
        //scale down
        
        
        
               
        w=Math.floor(w*scale);
        h=Math.floor(h*scale);
        
        
        
        
        
        //take into any padding, borders, etc applied to the frame with css
        wd=(pane.outerWidth()-pane.innerWidth())
        hd=(pane.outerHeight()-pane.innerHeight())
        
        //get frame dimentions
        //nw=Math.min(fw,w)
        //nh=Math.min(fh,h)
        
        mw=0-Math.floor(w/2);
        mh=0-Math.floor(h/2);
        
        var cssObj = {
          'top':'50%'
        , 'left':'50%'
        , 'margin-left':mw
        , 'margin-top':mh
  //      , 'width':nw-wd
  //      , 'height':nh-wd
        , 'overflow':'hidden'
      //  , 'width':w
      //  , 'height':h
        };
        pane.css(cssObj);
        if (item){
          w=w*(w/(w+wd))
          h=h*(h/(h+hd))
          item.css('width',w);
          item.css('height',h);
 //         if frame width is small than item width
          if (fw<w){
            item.css('margin-left',0-((w-fw)/2)-wd);  
          }
          
          if (fh<h){
            item.css('margin-top',0-((h-fh)/2)-hd);  
          }
         
        }
     },
     show:function (node) {
     
     this.debug("Show plugin");
       this.visible=true;
       this.$slider.show();
       this.$slider.addClass('open').removeClass('closed');
       this.$target.addClass('slider-target');
       
       if(this.isIOS){
       		$('body').bind('touchmove.slider', function (e){e.preventDefault();});
       }
       
       if (!this.dataFetched){
         this.getData()
       }
       keyboardControl.call(this)
       
       return this;
       // console.log(this.gallery.length);
     },
     hide:function (e) {
     
     this.debug("Hide plugin");
       e && e.preventDefault()
       if (e && this.$thumbnails && this.$thumbnails.hasClass('active')) {
          //thumbnails are open, close them instead
          return this.thumbnails()
       }
       if (this.settings.persist) {
          //only close if allowed
          return;
       }
       this.stop();
       this.visible=false;
       keyboardControl.call(this)
       
       this.$slider.removeClass('open').addClass('closed');
       this.$target.removeClass('slider-target');
       if(this.isIOS){
       		$('body').unbind('touchmove.slider')
       }
       this.$slider.hide();
       this.$overlay.fadeOut(600);
       
       //this.stop();
       //this.timer.stop();
     },
     toggle:function(e){
     
       e && e.preventDefault()
       var el=this.control.play
       if (this.playing){
        
        this.debug("Stop",true);
        el.text('Play')
        el.removeClass('on').addClass('pause');
        this.stop();
       }else {
        this.debug("Play",true);
        el.text('Pause')
        el.removeClass('pause').addClass('on');
        this.start();
       }
     },
     shuffle:function(e){
      e && e.preventDefault()
      var btn=this.control.shuffle
      if (this.settings.shuffle){
        this.debug("Shuffle Off",true);
        this.settings.shuffle=false;
        btn.removeClass('on')
        this.control.repeat.removeClass('slider-ui-disable')
        if (!this.settings.repeat) {this.control.repeat.removeClass('on')}
        
      } else {
        
        this.debug("Shuffle On",true);
        this.settings.shuffle=true;
        btn.addClass('on')
        this.control.repeat.addClass('slider-ui-disable on')
      }
     },
     repeat:function(e){
      e && e.preventDefault()
      var btn;
      if (!(btn=this.control.repeat||false)) return;
      if (btn.hasClass('slider-ui-disable')) return;
      if (this.settings.repeat){
        
        this.debug("Repeat Off",true);
        this.settings.repeat=false;
        btn.removeClass('on')
      } else {
        
        this.debug("Repeat On",true);
        this.settings.repeat=true;
        btn.addClass('on')
      }
      this.preload();
     },
     
     link:function(){
       //get page with ajax
       //display it ? iframe?
       //x to close
       
       //toggle this       
     },
     swipe:function(){
      var next,previous;
      this.swiped=true;
      
      this.debug("Swipe start");
      //these won't exist if we are at the end;
       next=this.panes.$next
       if (next){
          this.$frame.append(next)
          this.resize(next);
          next.css('left','-200%').show();
       } else {
         // this.panes.$next=next=$('<div class="slider-empty">')
       }
       
       previous=this.panes.$previous
       if (previous){
          this.$frame.append(previous)
          this.resize(previous);
          previous.css('left','-200%').show();
       } else {
          //this.panes.$previous=previous=$('<div class="slider-empty">')
       }
       
       
        
     },
     swipeMove:function(e){
       var pos=this.swipePercent;
       //console.log(pos)
       if(this.swiped || pos > this.settings.swipeThreshold || pos < 0 - this.settings.swipeThreshold){
          if (!this.swiped) this.swipe()
          if (this.controlVisible) {this.toggleControls('hide');}
          if (this.playing) {this.stop();this.resume=true}
       
       
       //pos it a %
       this.panes.$current.css('left',50 - pos +'%');
       if (this.panes.$next){
        this.panes.$next.css('left',150 - pos +'%');
       }
       if (this.panes.$previous){
        this.panes.$previous.css('left',-50 - pos +'%');
       }
        //where is position
       } 
     },
     swipeEnd:function(){
      
      this.debug("Swipe end");
      var _this=this;
      var speed,complete,direction,other,$other,ok,swipePercent,fail, swiped;
        speed=3*(100-this.swipePercent)
        console.log(speed)
        complete={'left':'50%'}
        direction=(this.swipePercent>=0)
        other=direction?'$next':'$previous';
        $other=$(this.panes).attr(other);
        
        
        
//if there is no target page i.e. first of last image, always revert.       
        if( (direction && this.panes.$next) || (!direction && this.panes.$previous) ) {
          ok=true;
        } else {
          ok=false;
        }

        if (this.swipePercent < 0) {-1 * this.swipePercent} 
        swipePercent=(direction)?this.swipePercent:this.swipePercent * (-1);
        console.log(swipePercent)
        
        if ($other && swipePercent>this.settings.swipeSnap){
        
        
        
         //sucseeded
         //this.panes.$current.addClass('active')
         //$other.removeClass('active')
         //finish transition
         //this.current=$other.data('pane') 
         this.skipTransition=true;    
         $other.animate(complete,speed,function(){_this.gotoPane($other)})
         fail=(direction) ? '-50%' : '150%';
         this.panes.$current.animate({'left':fail},speed)
         
         // this.current=$other.data('pane')//direction ? this.current + 1  : this.current - 1 ;
         //this.panes.$current=this.panes.$next;
         //this.preload();
         
        } else {
        //failed
        if (this.resume) {
            this.resume=false;
            this.start();
        }
         this.panes.$current.animate(complete,speed);
         if ($other){
          fail=(direction) ? '150%' : '-50%';
          $other.animate({'left':fail},speed,function(){return;})
         }
        }
        this.swiped=false;     
     },
     
     transition:function(){
      this.debug("Transition start");
       var _this=this;
       var transition,newItem,oldItem;
       
       this.panes.$current.css('opacity',1)
       
        console.log('starting transition last is state:'+_this.panes.$last.css('display'))
      // this.skipTransition=true;
       this.transitionFinished=false;
       if (this.skipTransition) {this.skipTransition=false; return this.transitionComplete() }
       
       if (jQuery.isArray(this.settings.transition)){
        this.transitionSelection=this.settings.transition
        this.settings.transition='random'       
       }
       var transition=$(this.transitions).attr(this.settings.transition);
       if (jQuery.isFunction(transition)){
         transition=transition.call(this);
         if (transition===true) {return};
       }
              
       newItem=this.panes.$current;
       oldItem=this.panes.$last || this.$frame.find('.active')
     
       //if ($('html').hasClass('csstrasistions')) {
       //oldItem.set('opacity=0')
       //newItem.set('opacity=1')
      // panes=this.$frame.find('.slider-image');//.addClass('animate fade-out');
      //newItem.addClass('active').show()
       //newItem.addClass('active').hide().fadeIn(500);
       
       //this.panes.$current.show()
       //return
        newItem.hide();
        
        newItem.animate(
        transition.start,
        0,
        function(){
          newItem.show();
          newItem.animate(
            transition.end,
            _this.settings.transitionSpeed*1000,
            function() {    
              _this.transitionComplete();
            }
          )
        }
      )   
     //  newItem.addClass('active');
      oldItem.animate(transition.old, this.settings.transitionSpeed*1000);
     },
     
     transitionComplete:function(a){
     
      this.debug("Transition end");
     /*
if (!a) return;
        this.transitionFinished=true
      
*/  
        var panes,w,h;
        this.panes.$current.addClass('active');
        this.panes.$last.removeClass('active');
        
        panes=this.$frame.find('.slider-image');
        panes.not('.active').detach();

        this.$title.text(this.gallery[this.current].alt)        
        this.$title.addClass('active');

        
        this.$info.text(this.current+1 + '/' +this.gallery.length) 
        this.$info.addClass('active');
        //this.updateInfo()
        
        if (this.settings.controlInside){
          w=Math.min(this.panes.$current.width(),this.$slider.width())
          h=Math.min(this.panes.$current.height(),this.$slider.height())
          this.$control.css({'top':'50%','left':'50%','width':w,'height':h,'margin-left':0-(w/2),'margin-top':0-(h/2)});
        }
        
                
        if (this.playing || this.resume) {
            this.resume=false;
            this.start();
        }
        
        //this.transitionFinished=false;
        //return;
        
        
                
     
     },
     
     movement:function(e){
     
      
     if (this.settings.controlsAlwaysOn) return;
     if (this.mouseDown) {return};
     
     //mouse move fires on mouse click - this skips that effect
     if (e.pageX - this.swipeStart == 0 && e.pageY - this.swipeStartY == 0) return;
    
     var that = this;
       if (this.controlVisible){
        clearTimeout(this.controlTimeout);
       }else {
         this.toggleControls('show')   
       }
     },
     
     noMovement:function(e){
     if (this.settings.controlsAlwaysOn) return;
     //console.log('here');
     var _this = this;
       if (this.controlVisible){
        clearTimeout(this.controlTimeout);
        this.controlTimeout=setTimeout(function(){_this.toggleControls('hide');},1000);
       }
     },
     
     touch:function(e){
       if(e && e.target.nodeName != 'A') { 
        this.toggleControls()
       }
     },
          
     onMouseDown:function(e){
       var x,y;
       
       if(e && e.target.nodeName == 'A') { 
        return;
       }
       this.mouseDown=true;
       if (e.targetTouches) {
         x=e.targetTouches[0].pageX;      
         y=e.targetTouches[0].pageY;
       } else {
         x=e.pageX;
         y=e.pageY;
       }
       this.swipeStart=x;
       this.swipeStartY=y;
      
     },   
     onMouseMove:function(e){
       var x,y;
       if (!this.mouseDown) return;
       
       
       if (e.targetTouches) {
         e.preventDefault();
         x=e.targetTouches[0].pageX;
       } else {
         x=e.pageX;
       }
      
       this.swipePercent=((this.swipeStart - x)/this.$slider.width()*100)
       this.swipeMove();
     },
     onMouseUp  :function(e){
      
      //console.log('fired')
      if (!this.swiped) {
        this.touch(e)
        //console.log('touch')
      } else {
        this.swipeEnd();
      }
      this.mouseDown=false
     },
     
     toggleControls:function(force){
     
      if (this.settings.controlsAlwaysOn || force=='show' || !this.controlVisible){
        
         this.debug("Show controls");
         this.$control.addClass('active')
         this.controlVisible=true
      } else if(force=='hide' || this.controlVisible){
        this.debug("Hide controls");
        this.$control
            .removeClass('active')
        this.controlVisible=false
      }
      
     }, 
    //callbacks

    thumbnails:function(){
      if (this.settings.thumbnails=false) return;
      
      if (!this.$thumbnails) this.buildThumbnails();
      
      var el=this.control.thumb
      if (this.$thumbnails.hasClass('active')) {
        this.debug("Hide thumbnails");
        if (this.playing){this.start();}
        el.removeClass('on')
        this.$thumbnails.removeClass('active').fadeOut(300)
      } else {
        this.debug("Show thumbnails");
        if (this.playing){this.stop();this.playing=true;} 
        el.addClass('on')
        this.$thumbnails.addClass('active').fadeIn(300)
      }
    },
    
    buildThumbnails:function(){
      var _this=this;
      this.debug("Build thumbnails");
      this.$thumbnails=$('<div class="slider-thumbnails"><h1>Pick a slide <a href="#close" class="slider-ui close active pull-right">Cancel</a></h1>')
      
      $.each(this.gallery,function(i,img){
        var item=$('<a>').attr('href',img.link).data('slide',i).addClass('slider-thumbnail slider-loading');
        var image=$('<img>').fadeOut();
        
        image.load(function(){
          image.fadeIn(300)
          item.removeClass('slider-loading')
        })
        image.attr('src',img.thumb)
                item.append(image).click(function(e){
            e && e.preventDefault()
            var slide=$(this).data('slide')
            if (_this.playing){
              _this.playing=false;
              _this.resume=true;
            }
            _this.thumbnails();
            _this.goto(slide)
            
        })
        _this.$thumbnails.append(item);
      })
      this.$thumbnails.fadeOut(0);
      this.$slider.append(this.$thumbnails);
    },
    
    classPrefix:function(className){
      return this.settings.classPrefix + className;
    },
    
    animation:function(cssObj){
      if (this.settings.disableAnimation) return {};
      return cssObj;
    },
    
    find:function(field, value, onFail){
    
       var _this=this;
       
       if (this.panes && this.panes.$current){
          this.panes.$current.remove()
       }
       
       if (! _this.dataFetched ) {
            this.getData();
          }
       
       
       
      
       var wait=function(){
          
          if (! _this.dataFetched ) {
            return;
          }
          clearInterval(load);
          
          var found=false
            		
          console.log('looking for "'+value +'" in '+ field)  		
          $(_this.gallery).each(function(i,details){
            console.log($(details).attr(field))
            if ($(details).attr(field)==value) {
              //this.current=i-1
                 _this.goto(i)
                 _this.show()
                found=true;
                //alert('found it')
            }
          });
          if (!found){
           // alert('did not find image ' + value) 		  		
          }
        };
        var load = setInterval(wait,100);//check data;
      },
      debug:function(text){
        console.log(text)
      }, 
    }
      
  /* Slider PLUGIN DEFINITION
  * ============================ */

  $.fn.slider = function ( options ) {
      return this.each(function () {
        $(this).data('slider', new Slider(this, options))
      })
    return this
  }

  $.fn.slider.defaults = {
   //content 
    target: 'body'
  , type:'auto'
  , data:false
  , dataType:'json' //json, jsonp
  , dataSync:'async'
  , dataPrefetch:false //process the selector or ajax gallery data before the slidewho is launched
  , selector: 'img'
  , cache: true //cache items or fetch every time.
  , preload: true //preload next, previous and random image.
  , classPrefix:'slider-'
  , info:true // ['count','title','details','timer'] 
    
  //Display
  , overlay: true //add overlay to body
  , scale:'fit' //fit-shortest edge, fill-widest edge, //@TODO overlap-20% extera for ken burns
  , kenBurns:true //if image overlaps in any direction use ken burns effect to transition image.
  , scaleUp:1.2 //true, false, highest upscale 1.5
  , transition:'random' // 
  , transitionSpeed:1
  , engine: 'css'// browser, canvas, js, auto 
  
  //buttons
  , controls:true//['play','next','previous']
  , controlsAlwaysOn:false
  , controlsInside:false 
  , keyboard: true  
  
   //initial control states
  
  , autoLoad:true
  , startSlide:1 
  , repeat:true
  , shuffle:false
  , play:false
  , show: false
  , speed:3 //in seconds - user nagative number for random time between 0 - x

  //Swipe gesture
  , swipe:true //true, false,touch -touch devices only ,mouse - mouse devices only  
  , swipeThreshold:5 //percentage mouse movement to initiate drag
  , swipeSnap: 25 // percentage before page will roll over on release
  
  //Callbacks
  , onDataLoad:function(data){return data;}
  , onEnd:function(){}
  , onShow:function(){}
  , onChange:function(){}
  , onResize:function(){}
  , onStart:function(){}
  , onStop:function(){}                
}
  
  $.fn.slider.transitions = {
     'fade':{
        'start': {'opacity':0} ,
        'end'  : {'opacity':1} ,
        'old'  : {'opacity':0} ,
     },
     'slide':{
        'start': {'left':'150%'} ,
        'end'  : {'left':'50%'} ,
        'old'  : {'left':'-50%'} ,
     },
     
     'top-bottom':{
        'start': {'top':'150%'} ,
        'end'  : {'top':'50%'} ,
        'old'  : {'top':'-50%','height':'100%','opacity':'0'} ,
     },
     'bottom-top':{
        'start': {'top':'-50%'} ,
        'end'  : {'top':'50%'} ,
        'old'  : {'top':'150%','height':'100%','opacity':'0'} ,
     },
     'tr-bl':{
        'start': {'left':'150%','top':'150%'} ,
        'end'  : {'left':'50%','top':'50%'} ,
        'old'  : {'opacity':'0'} ,
     },
     'scale':{
        'start': {'opacity':'0','scale':'0'} ,
        'end'  : {'opacity':'1','scale':'1'} ,
        'old'  : {'opacity':'0',} ,
     },
     'random':function(){
        if (!this.transitionSelection) {
          var trans=this.transitions;
          var array=[];
          $.each(trans,function(i, tran){
            if (i != 'random'){
              array.push(i)
            }
          })
          this.transitionSelection=array;
        }
        var item,chosen;
        item=this.transitionSelection[Math.floor(Math.random() * this.transitionSelection.length)];
        console.log(item)
        chosen=$(this.transitions).attr(item)
        if (jQuery.isFunction(chosen)){
          return chosen.call(this);
        } 
        return chosen 
     }, 
    };

  
    function keyboardControl() {
    var that = this
    var fired=false
    if ( this.visible && this.settings.keyboard ) {
      $(document).bind('keypress.slider', function ( e ) {
         if (e.which==32) {  
            e && e.preventDefault() //space
            fired=true;
            that.toggle(e);
          }
      });
      
        $(document).bind('keyup.slider', function ( e ) {
         switch (e.which) {
            
            case 80: //p
            case 37: //left arrow
              fired=true;
              that.previous(e); 
              break; //left
              
            case 78: //n
            case 39: //right arrow
              fired=true;
              that.next(e); 
              break; //right
            
            case 88: //x  
            case 27: //escape
              fired=true;
              that.hide(e); 
              break; //esacpe
            
            case 83: //s
              fired=true;
              that.shuffle(e); 
              break; 
           
            case 82: //r
              fired=true;
              that.repeat(e); 
              break; 
            
            case 71://g
            case 84://t
              fired=true;
              that.thumbnails(e); 
              break; //thumbnails or gallery
        }
      if (fired) {
        //that.movement();
        //that.noMovement();
      }        
      });
    } else if ( !this.visible ) {
      $(document).unbind('keyup.slider');
      $(document).unbind('keypress.slider')
    }
  }
  
  newTrans={
  curtains:function(){
    var _this=this;
    var $current=this.panes.$current.hide();
    //var item;
    var finish=function(){_this.panes.$current.show();_this.transitionComplete();}
    
    var speedIncr,cols,rows
    speedIncr=1000
    cols=2
    rows=1
    var height=Math.ceil($current.height()/rows)
    var width =Math.ceil($current.width()/cols)
    var fxwindow=$current.clone().empty().css('width',$current.width()).css('height',$current.height()).show()
    this.panes.$last.fadeOut(cols*rows*speedIncr/2)
    this.$frame.append(fxwindow);
    for(r=1;r<=rows;r++){
      for(c=1;c<=cols;c++){
        
        var item, speed, func;
        item=$current.clone()
        start=(c==1)? 0-width:width*2;
        end=(c==1)? 0:width;
        
        item.removeClass('slider-image')
            .css({'display':'block','overflow':'hidden','position':'absolute','margin':0,'top':0})
            .css({'width':width,'height':height,'left':start})
            .find('img')
            .css({'margin-left':0-(width*(c-1)),'margin-top':0-(height*(r-1))})
        func=(c==cols && r==rows) ? finish : null;
        fxwindow.append(item)
        speed=speedIncr*(r+c) 
        item.animate({'left':end},speedIncr,func);
      }    
    }
    return true
  },
   fly:function(){
    var _this=this;
    var $current=this.panes.$current.hide();
    //var item;
    var finish=function(){_this.panes.$current.show();_this.transitionComplete();}
    var speedIncr,cols,rows, left,top;
    cols=6
    rows=4
    
    speedIncr=this.settings.transitionSpeed*1000/(cols*rows) 
    
  
  if (this.$slider.width() > $current.width()){
      var width=Math.ceil($current.width()/rows)
      left=0
    } else {
      var width=Math.ceil(this.$slider.width()/rows)
      left=Math.ceil(($current.width()-this.$slider.width())/2)
    }
    
    if (this.$slider.height() > $current.height()){
      var height=Math.ceil($current.height()/rows)
      top=0
    } else {
      var height=Math.ceil(this.$slider.height()/rows)
      top=Math.ceil(($current.height()-this.$slider.height())/2)
    }

    
   // top=0
   // left=0
   // var height=Math.ceil($current.height()/rows)
   // var width =Math.ceil($current.width()/cols)
    
    var fxwindow=$current.clone().empty().css('width',$current.width()).css('height',$current.height()).show()
    this.panes.$last.fadeOut(cols*rows*speedIncr*2)
    this.$frame.append(fxwindow);
    for(r=1;r<=rows;r++){
        var item, speed, func;
      for(c=1;c<=cols;c++){
        item=$current.clone()
        item.removeClass('slider-image')
            .css({'display':'block','overflow':'hidden','position':'absolute','margin':0,'top':0,'opacity':0})
            .css({'width':width,'height':height,'left':left+(width*(c-1)), 'top':top+(height*(r-1))})
            .find('img')
            .css({'margin-left':0-(left+(width*(c-1))),'margin-top':0-(top+(height*(r-1)))})
        //func=(c==cols && r==rows) ? finish : null;
        fxwindow.append(item)
        speed=speedIncr*(r+c) *4
        if (r%2 != 0){
          func=(c==cols && r==rows) ? finish : null;
          item.delay(speedIncr*c+((r-1) * cols * speedIncr )).animate({'opacity':1},speed,func);
        } else {    
          func=(c==1 && r==rows) ? finish : null;
          item.delay(speedIncr*(cols-c)+((r-1) * cols * speedIncr  )).animate({'opacity':1},speed,func);
        }
      }    
    }
    return true
  },
  grid:function(){
    var _this=this;
    var $current=this.panes.$current.hide().css('opacity',1);
    //var item;
    var finish=function(){_this.panes.$current.show();_this.transitionComplete();}
    var speedIncr,cols,rows
    speedIncr=50
    cols=9
    rows=9
    var height=Math.ceil($current.height()/rows)
    var width =Math.ceil($current.width()/cols)
    var fxwindow=$current.clone().empty().addClass('slider-fx').css('width',$current.width()).css('height',$current.height()).show()
    lastSpeed=cols*rows*speedIncr/2
    console.log(lastSpeed)
    this.panes.$last.fadeOut(lastSpeed)
    this.$frame.append(fxwindow);
    for(r=1;r<=rows;r++){
      for(c=1;c<=cols;c++){
      
        var item, speed, func;
        item=$current.clone()
        item.removeClass('slider-image')
            .css({'display':'block','overflow':'hidden','opacity':0,'position':'absolute','margin':0})
            .css({'width':width,'height':height,'left':width*(c-1),'top':height*(r-1)})
            .find('img')
            .css({'margin-left':0-(width*(c-1)),'margin-top':0-(height*(r-1))})
        func=(c==cols && r==rows) ? finish : null;
        fxwindow.append(item)
        speed=speedIncr*(r+c) 
        item.delay(speed).animate({'opacity':1},300,func);
      }    
    }
    return true
    
  },
  
  stripes:function(){
    var _this=this;
    var $current=this.panes.$current.hide();
    //var item;
    var finish=function(){_this.panes.$current.show();_this.transitionComplete();}
    var speedIncr,cols,rows
    speedIncr=100
    cols=9
    rows=1
    var height=Math.ceil($current.height()/rows)
    var width =Math.ceil($current.width()/cols)
    var fxwindow=$current.clone().empty().css('width',$current.width()).css('height',$current.height()).show()
    this.panes.$last.fadeOut(cols*rows*speedIncr/2)
    this.$frame.append(fxwindow);
    for(r=1;r<=rows;r++){
      for(c=1;c<=cols;c++){
        var item, speed, func;
        item=$current.clone()
        item.removeClass('slider-image')
            .css({'display':'block','overflow':'hidden','opacity':-1,'position':'absolute','margin':0})
            .css({'width':width,'height':height,'left':width*(c-1),'top':0-height})
            .find('img')
            .css({'margin-left':0-(width*(c-1)),'margin-top':0-(height*(r-1))})
        func=(c==cols && r==rows) ? finish : null;
        fxwindow.append(item)
        speed=speedIncr*(r+c) 
        item.delay(speed).animate({'opacity':1,'top':0},300,func);
      }    
    }
    return true;
  },
};
$.extend($.fn.slider.transitions,newTrans);
  
  var myOptions={
    //data:'http://alec-maxwell.evography.dev/bryony-and-luke-stala/main-album.json'
   target: 'body'
  //, scaleUp:true
  , speed: 6
  , controls:['play']
  //, keyboard:false
  , onDataLoad:function(data){
      var items=[];
      $.each(data.images, function(i, image){
        var item={};
        item.id=image.id;
        item.alt=image.name;
        item.link=image.link;
        item.src = image.sizes.full 
        item.thumb = image.sizes.thumb 
        items.push(item);   
      })
      return items;
    }
  , onEnd:function(){
      var _this=this;
      end=$('<div>You have reach the end!</div>').addClass('slider-image').css('color','white').css('z-index','2000')
      again=$('<a href="#">Play again?</a>').click(function(){_this.goto(0)})
      
      end.append(again);
      this.gotoPane(end);
    } 
 // , transition:'slide'
  , info:['timer','info']
  , play:false
  , swipe:true
  //, transitionSpeed:0
 // , transition:'fade'
  , scale: 'fit'
  , autoLoad:false
  }

  
    

    
