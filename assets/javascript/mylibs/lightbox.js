/* Lightbox PUBLIC CLASS DEFINITION
  * ============================= */
  var Lightbox = function ( content, options ) {
  
    //merge settings with defaults 
    this.settings = $.extend({}, $.fn.lightbox.defaults, options)
    
    //master object
    this.$element = $(content)
      .delegate('a img', 'click', $.proxy(this.click, this))
      ;
    
    this.settings.target = this.settings.target ? $(this.settings.target) : this.$element.closest('section');
    
        
    //all elements that have an image in an href
    this.$set = this.$element.find('a img');
    
    this.page=0;
    this.current=false;
    
    //this.$element.append('<div class="window">Hello</div>')
    
    this.$window=$('<div class="lightbox-window">'); 
    this.$window.delegate('.lightbox-window img', 'click', $.proxy(this.hide, this))
      .delegate('.next', 'click', $.proxy(this.next, this))
      .delegate('.previous', 'click', $.proxy(this.previous, this))
      .delegate('.fullscreen', 'click', $.proxy(this.fullscreen, this))
          
    
    this.bind(this.settings.target);    
    //this.$target.append(this.$window);
    
    if (this.settings.preload){
    
    }

    return this
  }
  
  Lightbox.prototype = {
     next: function (item) {
       //next = $(this.current).parent().next().find('img').first() || this.$element.find('img').first();
       //this.show($(next))
       index = this.page;
       if (++index>this.$set.length-1) index=0;
       
       this.show( $(this.$set[index]) )
     },
     previous: function (event) {
       //previous = this.current.previous('img') || this.$element.find('img').last();
       
       
       index = this.page;
       if (--index<0) index=this.$set.length-1;
       
       this.show( $(this.$set[index]) )
     },
     click:function (e) {
        e && e.preventDefault();
        this.show(e.currentTarget)
     },
     show: function (item) {
        var that = this
  
        this.$element.pass('polaroid','pause');
        
       // if ($polaroid=this.$element.data('polaroid')){
       //     $polaroid.pause();
      //  }
        
        //console.log(this.$set.length)
        
        this.current = item ;
        this.page = this.$set.index(this.current);
        var href = $(item).parent('a').attr('href').replace(/\/$/, '');
         
         this.$window.empty();
         this.$window.append('<img src="'+href+'.jpg" />');
        
         this.$window.append('<a class="next btn">next</a>');
         this.$window.append('<a class="previous btn">previous</a>');
         this.$window.append('<a class="close btn">close</a>');
           
         this.$window.append('<a class="fullscreen btn">fullscreen</a>');
         this.$window.append('<span class="count">'+this.page + '/' + this.$set.length + '</span>');

       
        img=this.$window.find('img').first()
        
        width=img.width();
        height=img.height();
        if (height>width) img.addClass('portrait');
       
        this.$target.addClass('lightbox-target');
       
        console.log(href);
        
        this.isShown = true
        
        escape.call(this)
        
        return this
      }

    , hide: function (e) {
        e && e.preventDefault()

        if ( !this.isShown ) {
          return this
        }

        var that = this
        this.isShown = false
        escape.call(this)
        
        this.$target.removeClass('lightbox-target');
        
        
        if (this.fullscreen) {
          this.fullscreen=false;
          this.bind(this.settings.target);
        }
        
        this.$window.empty();
                
        return this
      }
      
    , fullscreen: function(e) {
       // this.$target.removeClass('lightbox-target');
        
        this.fullscreen=true;
        this.bind('body');
      }
    
    , bind:   function(item) {
      if (this.$target) {
            this.$target.removeClass('lightbox-target')
      }     
      this.$target = $(item);
      
      this.$window.appendTo(this.$target)
      
      if (this.isShown) {
        this.$target.addClass('lightbox-target');
      }
    }
      
  }

/* Lightbox PLUGIN DEFINITION
  * ======================= */

  $.fn.lightbox = function ( options ) {
      return this.each(function () {
        $(this).data('lightbox', new Lightbox(this, options))
      })
    return this
  }

  $.fn.lightbox.defaults = {
    backdrop: true
  , keyboard: true
  , fullscreen: true
  , show: false
  , destroy:false
  , target: false
  
  }
  
  

  function keycontrol() {
    var that = this
    if ( this.isShown && this.settings.keyboard ) {
      $(document).bind('keypress.lightbox', function ( e ) {
         if (e.which==32) {  
            e && e.preventDefault() //space
            that.next();
          }
      });
      
        $(document).bind('keyup.lightbox', function ( e ) {
         switch (e.which) {
            case 37: that.previous(); break; //left - next
            case 39: that.next(); break; //right
            case 27: that.hide(); break; //esacpe
        }      
      });
    } else if ( !this.isShown ) {
      $(document).unbind('keyup.lightbox');
      $(document).unbind('keypress.lightbox')
    }
  }
