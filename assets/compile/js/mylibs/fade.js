var Fade = function ( content, options ) {
    //this.settings = $.extend({}, $.fn.fade.defaults, options)
    this.$element = $(content)
    var speed=$(content).data('fade-speed') || 300;
    $(this.$element).find('img').hide().fadeIn(speed);
    
    $(this.$element).find('img').load(function () {
          $(this).fadeIn(speed);
      });
       
    return this
  }
  
  
$.fn.fadeImages = function( options ) {
  // alert("fade");
    $(this).data('fade', new Fade( this, options ))
    return this;
  } 