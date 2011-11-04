<h4>Upload images</h4>

<nav>
  <ul class="tabs">
    <li class="active">
      <a href="<?php echo Request::current()->url(array('action'=>'index')); ?>">
        From your computer
      </a>
    </li>
    <li>
      <a href="<?php echo Request::current()->url(array('action'=>'facebook')); ?>">
        From Facebook
      </a>
    </li>
  </ul>
</nav>

<div data-control="tabs">
<section id="computer">
  <h4>From your computer</h4>
  <form id="uploader" action="<?php echo Request::initial()->url(); ?>" method="post" enctype="multipart/form-data">
    <div id="photoupload-fallback">
      <p>
        It appears you either have javascript disabled or are missing the latest version of Flash.  Unfortunately because of this you will be limited to uploading files one at a time.
      </p>
      
      <label for="file">
        Upload a Photo:
        <input type="file" name="file" />
      </label>
      <button type="submit" name="save" value="">Upload Images</button>
    </div>
  </form>
</section>
<?php echo $facebook; ?>

<style type="text/css">@import url(/assets/javascript/plupload/jquery.plupload.queue/css/jquery.plupload.queue.css);</style>
<!-- Load plupload and all it's runtimes and finally the jQuery queue widget -->
	<script type="text/javascript" src="/assets/javascript/plupload/plupload.full.js"></script>
	<script type="text/javascript" src="/assets/javascript/plupload/jquery.plupload.queue/jquery.plupload.queue.js"></script>
	 
	<script type="text/javascript">
	// Convert divs to queue widgets when the DOM is ready
	$(function() {
	    $("#uploader").pluploadQueue({
	        // General settings
	        runtimes : 'gears,html5,flash,silverlight',
	        url : $("#uploader").attr('action') + '.json',
	        max_file_size : '20mb',
	        //chunk_size : '1mb',
	 
	        // Resize images on clientside if we can
	        //resize : {width : 320, height : 240, quality : 90},
	 
	        // Specify what files to browse for
	        filters : [
	            {title : "Image files", extensions : "jpg,gif,png"},
	           // {title : "Zip files", extensions : "zip"}
	        ],
	 
	        // Flash settings
	        flash_swf_url : '/assets/javascript/plupload/plupload.flash.swf',
	 
	        // Silverlight settings
	        silverlight_xap_url : '/assets/javascript/plupload/plupload.silverlight.xap',
	        
	        preinit : {
	        Init: function(up, info) {
	                $('#'+up.settings.container).find('.plupload_buttons').append('<label for=resize>Resize images before uploading</label><input type=checkbox name=resize id=resize>');
	            },
	 	            UploadFile: function(up, file) {
	 	              //If resize toggle is set the values
	 	              if ($("#resize").attr('checked')){
	 	                up.settings.resize={width : 1024, height : 1024, quality : 100};
	                }  else  up.settings.resize={};
	            }
	        },
	        
	        init : {
	           UploadProgress: function(up, file) {
	                //once finshed let the user upload more files
	                if (up.total.uploaded == up.files.length) {
	                  container=$('#'+up.settings.container)
                    container.find(".plupload_buttons").css("display", "inline");
                    container.find(".plupload_upload_status").css("display", "inline");
                    container.find(".plupload_start").addClass("plupload_disabled");
                  }
	            },
	             FileUploaded: function(up, file, info) {
	                //once a file has finished, put the pic in th page.
	                record=$.parseJSON(info.response);
	                $("#uploader").prepend('<img src="/images/dynamic/'+record.filehash +'/100x100xfit.' + record.ext + '" />');
	                // Called when a file has finished uploading
	                
	                //console.log(.filehash);
	            },
	        }
	        
	        
	    });
 
      
 
	    // Client side form validation
	    $("#uploader").submit(function(e) {
	        var uploader = $('#uploader').pluploadQueue();
	 
	        // Files in queue upload them first
	        if (uploader.files.length > 0) {
	            // When all files are uploaded submit form
	            uploader.bind('StateChanged', function() {
	                if (uploader.files.length === (uploader.total.uploaded + uploader.total.failed)) {
	                    $('form')[0].submit();
	                }
	            });
	                 
	            uploader.start();
	        } else {
	            alert('You must queue at least one file.');
	        }
	 
	        return false;
	    });
	});
	</script>
</div>