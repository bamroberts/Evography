var Polaroid = function ( content, options ) {
    var _this = this
    //merge settings with defaults 
    this.settings = $.extend({}, $.fn.polaroid.defaults, options)
    
    //master object
    this.$element = $(content)
      .delegate('a', 'mouseover', $.proxy(this.drag, this))
      ;
    
    this.button = $('<a href="#" class="btn">Shuffle</a>').click(function(e){e.preventDefault(); _this.shuffle()});
    this.$element.parent().append(this.button);
    
    this.$set = this.$element.find('a');
    
    this.queue = [];
    this.copy  = [];
    
    this.settings.target = this.settings.target ? $(this.settings.target) : this.$element.closest('section');
    
    this.build();    
    return this
  }
  
  Polaroid.prototype = {
     build: function() {
     	  //make sure the page is resized and shuffled on load and device rotation
     	  //bind resize function for windo resizing.
     	  var _this = this;
     	  var resizeTimer = null;
     	  $(window).bind('resize', function() {
	     	  if (resizeTimer) clearTimeout(resizeTimer);
	     	  	resizeTimer = setTimeout(function(){_this.shuffle()}, 100);
	      });
	      this.start();	  
	      //$(window)
	      //	.bind('orientationchange.polaroid', $.proxy(this.shuffle, this))
     },
     start: function () {
       var _this = this
       
       this.$set.each(function(i, el){
         $el = $(el)
               .hide();
         img  = $(el).find('img');
         path = img.attr('src');
         img.attr('src',false)
            .load(_this.load(el))
            .attr('src',path);
       });
      this.shuffle();
      this.timer = setTimeout(function(){_this.next()}, 100);  
     },
     pause: function() {
       //set timeout check viability -> this.next();
     },
     stop:  function () {
      // if (!this.copy.length) {
       
      // this.copy = this.$set
       //this.shuffle(); 
       
       //}
       //copy is empty else dup list
       //else
      // this.queue.push(this.copy.shift())
       //this.next();
      // return;
     },
     next:  function () {
       var _this = this;
       if (!this.queue.length) return this.stop();
       
       var docViewTop = $(window).scrollTop();
       var docViewBottom = docViewTop + $(window).height();

       var elemTop = this.$element.offset().top;
       var elemBottom = elemTop + this.$element.height();
       
       //if top of element is between top and bottom or bottom of element is between top an bottom
       
      // (elemTop >= docViewTop && elemTop <=docViewBottom) || (elemBottom >= elemBottom && elemTop <=docViewBottom)

      if ((elemTop >= docViewTop && elemTop <=docViewBottom) || (elemBottom >= elemBottom && elemTop <=docViewBottom)) {
          this.transition( this.queue.shift() ) 
        }
       
       //if page is not in view then pause timeout -> this.pause()
       
       
       this.timer = setTimeout(function(){_this.next()},  1000 + Math.floor(Math.random()*1000));
     },
     load:  function (item) {
      //add to queue
      this.queue.push(item)
     },
     transition:  function (item) {
     //spin in
     //drop in
     //fade in
	     $item = $(item);
	     //if $item.tranist 
	     
	     $item.css({scale: '10',rotate:'-=45deg', opacity:'0'})
	          .css('z-index', this.highestIndex() )
	          .show()
	     if (!$.support.transition){
		      $item.animate({scale: '1',rotate:'+=45deg', opacity:'1'}, {duration: 1000, easing:'swing'});
	     } else {
	          $item.transition({scale: '1', rotate:'+=45deg', opacity:'1'},500);
	     }
         
     
     },
     drag:  function (e) {
       $item = $(e.currentTarget);
       $item.css('z-index', this.highestIndex() )
       if ($item.data('drag') || $item.is(':animated')) return;
       //do my own
       //----------
       //register events in build
       //on click remove other click.binds, bring to front and add magnify icon
       //if mouse move + threshold start drag
       //bind click to this object
       
       
       $item.draggable({ 
          containment: this.$element, 
          scroll: false, 
          stack: this.$set, 
          //start: function(e, ui) { e.stopPropagation() },
          stop: function(e, ui) {  e.stopPropagation() }
          });
       $item.data('drag',true);
     },
     
     /*
onMouseDown: function(e) {
     	e.target
     },
*/
     
     shuffle:function () {
        var _this = this;
        this.$set.each( function(index,element){
          $el= $(element);
          if ($el.is(':animated') && $el.not(':visible')) return;
          rnd = Math.random
          up = Math.ceil
          topbit = up(rnd() * (_this.$element.height() - $el.height()) ) + 'px'
          left =   up(rnd() * (_this.$element.width() - $el.width()) ) + 'px'
          rotation = (up(rnd()*91)-45) + 'deg'; 
          console.log('top ' + topbit + ' left ' +left);
          
          if (!$.support.transition){
	          $(element).animate({'top': topbit, 'left': left, 'rotate':rotation }, 1000);
	     } else {
	     	  
	          $(element).css({'top':0,'left':0}).transition({'y': topbit, 'x': left, 'rotate':rotation }, 1000);
	     }
          
          
        })
       },
       
       highestIndex: function(){
          var index_highest=0
          this.$set.each(function(i,el) {
            // always use a radix when using parseInt
            var index_current = parseInt($(el).css("z-index"), 10) || i;
            //console.log(parseInt($(el).css("z-index"), 10) || i)
              //if (!index_current) {index_current=index_highest +1 }
            if($(el).is(':visible') && index_current > index_highest) {
                index_highest = index_current;
            }
        });
        console.log(index_highest)
        return index_highest
       
       },
  }
  

  
   $.fn.polaroid = function ( options ) {
      return this.each(function () {
        $(this).data('polaroid', new Polaroid(this, options))
      })
    return this
  }

  $.fn.polaroid.defaults = {
    backdrop: true
  , keyboard: true
  , fullscreen: true
  , show: false
  , destroy:false
  , target: false
  
  }