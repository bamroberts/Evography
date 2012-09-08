var Paginate = function ( content, options ) {
    //this.settings = $.extend({}, $.fn.fade.defaults, options)
    //this is a section
    var $element = $(content)
    var $target=$($element.find('.media'));
    var $url=(window.location.pathname);
    
    //set current page as url
    $element.find('.pagination a.current').attr('href',$url);
    $element.delegate('.pagination a', 'click', function(e){
      e.preventDefault();
      var $currentlink=$(this).attr('href');
      if ($currentlink==$url) {return;}
      $url=$currentlink;
      $target.animate({opacity:'0'}, 300)
      //window.location.replace($currentlink);
      $.ajax({
        url: $(this).attr('href') + ".part",
        context: document.body,
        success: function(data){
          $target.html(data);
          $target.animate({opacity:'1'}, 300);
          $element.find('.pagination a').removeClass('current')
          $element.find('.pagination a[href="'+ $currentlink +'"]').addClass('current');
          //alert('Load was performed.');  
        }
      });
    });
    //alert($target.parent().parent().find('.media-grid').html);
    //this.$current_url=window.loaction;
         
      //alert('Loading page' + $(this).attr('href')  );
    
    
    
    return this
  }  

$.fn.pagination = function( options ) {
    //alert($(this).html);
    //$(this).data('fade', new Paginate( this, options ))
    $(this).data('paginate', new Paginate( this, options ))
    return this;
  }