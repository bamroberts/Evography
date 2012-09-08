/* =========================================================
 * bootstrap-modal.js v1.3.0
 * http://twitter.github.com/bootstrap/javascript.html#modal
 * =========================================================
 * Copyright 2011 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================= */


!function( $ ){

 /* CSS TRANSITION SUPPORT (https://gist.github.com/373874)
  * ======================================================= */

  


 /* Lightbox PUBLIC CLASS DEFINITION
  * ============================= */
  var Lightbox = function ( content, options ) {
    //merge settings with defaults 
    this.settings = $.extend({}, $.fn.lightbox.defaults, options)
    
    //master object
    this.$element = $(content)
      .delegate('.close', 'click', $.proxy(this.hide, this))
      .delegate('a img', 'click', $.proxy(this.show, this))
    
    
    //all elements that have an image in an href
    this.$set = $element.find('a img');
    this.current=false;
    
    if (this.settings.preload){
    
    }

    return this
  }
  
  Lightbox.prototype = {
     next: function (event) {},
     previous: function (event) {},
     show: function (event) {
        var that = this
        this.isShown = true
        
        console.log(event);
        console.log(this);
        
        return this
      }

    , hide: function (e) {
        e && e.preventDefault()

        if ( !this.isShown ) {
          return this
        }

        var that = this
        this.isShown = false

        return this
      }

  }


 /* Lightbox PLUGIN DEFINITION
  * ======================= */

  $.fn.lightbox = function ( options ) {
    var lightbox = this.data('lightbox')

    if (!lightbox) {

     // if (typeof options == 'string') {
     //   options = {
     //     show: /show|toggle/.test(options)
     //   }
     // }

      return this.each(function () {
        $(this).data('lightbox', new Lightbox(this, options))
      })
    }

    if ( options === true ) {
      return lightbox
    }

    return this
  }

  $.fn.lightbox.Lightbox = Lightbox

  $.fn.lightbox.defaults = {
    backdrop: true
  , keyboard: true
  , fullscreen: true
  , show: false
  }
  
  }

