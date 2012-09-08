// @PLUGIN Captures touch events on mobile devices to reduce delay.
jQuery.event.special.tap = {
    setup: function (a, b) {
        var c = this,
            d = jQuery(c);
        if (window.Touch) {
            d.bind("touchstart", jQuery.event.special.tap.onTouchStart);
            d.bind("touchmove", jQuery.event.special.tap.onTouchMove);
            d.bind("touchend", jQuery.event.special.tap.onTouchEnd)
        } else {
            d.bind("click", jQuery.event.special.tap.click)
        }
    },
    click: function (a) {
        a.type = "tap";
        jQuery.event.handle.apply(this, arguments)
    },
    teardown: function (a) {
        if (window.Touch) {
            $elem.unbind("touchstart", jQuery.event.special.tap.onTouchStart);
            $elem.unbind("touchmove", jQuery.event.special.tap.onTouchMove);
            $elem.unbind("touchend", jQuery.event.special.tap.onTouchEnd)
        } else {
            $elem.unbind("click", jQuery.event.special.tap.click)
        }
    },
    onTouchStart: function (a) {
        this.moved = false
    },
    onTouchMove: function (a) {
        this.moved = true
    },
    onTouchEnd: function (a) {
        if (!this.moved) {
            a.type = "tap";
            jQuery.event.handle.apply(this, arguments)
        }
    }
};
// @PLUGIN Notifications
(function ($) {
    $.notification = function (settings) {
       	var con, notification, hide, image, right, left, inner;
        
        settings = $.extend({
        	title: undefined,
        	content: undefined,
            timeout: 0,
            img: undefined,
            border: true,
            fill: false,
            showTime: false,
            click: undefined,
            icon: undefined,
            color: undefined,
            error: false
        }, settings);
        
        con = $("#notifications");
        if (!con.length) {
            con = $("<div>", { id: "notifications" }).appendTo($("#overlays"))
        };
        
		notification = $("<div>");
        notification.addClass("notification animated fadeInLeftMiddle fast");
        
        if(settings.error == true) {
        	notification.addClass("error");
        }
        
        if( $("#notifications .notification").length > 0 ) {
        	notification.addClass("more");
        } else {
        	con.addClass("animated flipInX").delay(1000).queue(function(){ 
        	    con.removeClass("animated flipInX");
        			con.clearQueue();
        	});
        }
        
        hide = $("<div>", {
			click: function () {
				 
				
				if($(this).parent().is(':last-child')) {
				    $(this).parent().remove();
				    $('#notifications .notification:last-child').removeClass("more");
				} else {
					$(this).parent().remove();
				}
			}
		});
		
		hide.addClass("hide");

		left = $("<div class='left'>");
		right = $("<div class='right'>");
		
		if(settings.title != undefined) {
			var htmlTitle = "<h2>" + settings.title + "</h2>";
		} else {
			var htmlTitle = "";
		}
		
		if(settings.content != undefined) {
			var htmlContent = settings.content;
		} else {
			var htmlContent = "";
		}
		
		inner = $("<div>", { html: htmlTitle + htmlContent });
		inner.addClass("inner");
		
		inner.appendTo(right);
		
		if (settings.img != undefined) {
			image = $("<div>", {
				style: "background-image: url('"+settings.img+"')"
			});
		
			image.addClass("img");
			image.appendTo(left);
			
			if(settings.border==false) {
				image.addClass("border")
			}
			
			if(settings.fill==true) {
				image.addClass("fill");
			}
			
		} else {
			if (settings.icon != undefined) {
				var iconType = settings.icon;
			} else {
				if(settings.error!=true) {
					var iconType = '"';
				} else {
					var iconType = '!';
				}
			}	
			icon = $('<div class="icon">').html(iconType);
			
			if (settings.color != undefined) {
				icon.css("color", settings.color);
			}
			
			icon.appendTo(left);
		}

        left.appendTo(notification);
        right.appendTo(notification);
        
        hide.appendTo(notification);
        
        function timeSince(time){
        	var time_formats = [
        	  [2, "One second", "1 second from now"], // 60*2
        	  [60, "seconds", 1], // 60
        	  [120, "One minute", "1 minute from now"], // 60*2
        	  [3600, "minutes", 60], // 60*60, 60
        	  [7200, "One hour", "1 hour from now"], // 60*60*2
        	  [86400, "hours", 3600], // 60*60*24, 60*60
        	  [172800, "One day", "tomorrow"], // 60*60*24*2
        	  [604800, "days", 86400], // 60*60*24*7, 60*60*24
        	  [1209600, "One week", "next week"], // 60*60*24*7*4*2
        	  [2419200, "weeks", 604800], // 60*60*24*7*4, 60*60*24*7
        	  [4838400, "One month", "next month"], // 60*60*24*7*4*2
        	  [29030400, "months", 2419200], // 60*60*24*7*4*12, 60*60*24*7*4
        	  [58060800, "One year", "next year"], // 60*60*24*7*4*12*2
        	  [2903040000, "years", 29030400], // 60*60*24*7*4*12*100, 60*60*24*7*4*12
        	  [5806080000, "One century", "next century"], // 60*60*24*7*4*12*100*2
        	  [58060800000, "centuries", 2903040000] // 60*60*24*7*4*12*100*20, 60*60*24*7*4*12*100
        	];
        	
        	var seconds = (new Date - time) / 1000;
        	var token = "ago", list_choice = 1;
        	if (seconds < 0) {
        		seconds = Math.abs(seconds);
        		token = "from now";
        		list_choice = 1;
        	}
        	var i = 0, format;
        	
        	while (format = time_formats[i++]) if (seconds < format[0]) {
        		if (typeof format[2] == "string")
        			return format[list_choice];
        	    else
        			return Math.floor(seconds / format[2]) + " " + format[1];
        	}
        	return time;
        };
        
        if(settings.showTime != false) {
        	var timestamp = Number(new Date());
        	
        	timeHTML = $("<div>", { html: "<strong>" + timeSince(timestamp) + "</strong> ago" });
        	timeHTML.addClass("time").attr("title", timestamp);
        	timeHTML.appendTo(right);
        	
        	setInterval(
	        	function() {
	        		$(".time").each(function () {
	        			var timing = $(this).attr("title");
	        			$(this).html("<strong>" + timeSince(timing) + "</strong> ago");
	        		});
	        	}, 4000)
        	
        }

        notification.hover(
        	function () {
            	hide.show();
        	}, 
        	function () {
        		hide.hide();
        	}
        );
        
        notification.prependTo(con);
		notification.show();

        if (settings.timeout) {
            setTimeout(function () {
            	var prev = notification.prev();
            	if(prev.hasClass("more")) {
            		if(prev.is(":first-child") || notification.is(":last-child")) {
            			prev.removeClass("more");
            		}
            	}
	        	notification.remove();
            }, settings.timeout)
        }
        
        if (settings.click != undefined) {
        	notification.addClass("click");
            notification.bind("click", function (event) {
            	var target = $(event.target);
                if(!target.is(".hide") ) {
                    settings.click.call(this)
                }
            })
        }
        return this
    }
})(jQuery);
$.initializeLogin = function() {
	// Update
	if ($.browser.msie  && parseInt($.browser.version, 10) === 8) {
		// IE8 doesn't like HTML!
	} else {
		window.addEventListener("load", function (a) {
		    window.applicationCache.addEventListener("updateready", function (a) {
		        if (window.applicationCache.status == window.applicationCache.UPDATEREADY) {
		            window.applicationCache.swapCache();
		            
		            $.notification( 
		            	{
		            		title: 'An update has been installed!',
		            		content: 'Click here to reload.',
		            		icon: "u",
		            		click: function() {
		            			window.location.reload();
		            		}
		            	}
		            );
		            
		        }
		    }, false);
	    
		    window.applicationCache.addEventListener("downloading", function (a) {
		        if (window.applicationCache.status == window.applicationCache.DOWNLOADING) {
		    		$.notification( 
		    			{
		    				title: 'Latest version is being cached',
		    				content: 'Only takes a few seconds.',
		    				icon: "H"
		    			}
		    		);
		    	}
		    }, false);

		}, false);
	}
	// Adding overlay to the body
	$("body").addClass("welcome").append('<div id="overlays"></div>');
	
	// Welcome notification
	$.notification( 
		{
			title: "Welcome to the Dashboard",
			content: "Please pick a user!",
			img: "static/demo/cloud.png",
			border: false
		}
	);
	
	// Adding animation to the user avatars.
	$("#users").addClass("animated flipInY");
	
	$(".plus").bind("tap", function() {
		var avatar = $('<a data-username="Javier Roslyn" href="#" class="avatar" data-avatar="static/demo/autumn.jpg" />');
		avatar.css("background-image", "url("+ avatar.attr("data-avatar") +")");
		$("#avatars").append(avatar);
		avatar.addClass("animated bounceInDown").delay(1000).queue(function(){ 
			$(this).removeClass("animated bounceInDown");
			$(this).clearQueue();
		});
		$(this).hide();
	});
	
	// Reveal login form when an avatar is clicked
	$(".avatar").live("tap", function() {
		$.notification( 
			{
				title: "Hi, " + $(this).attr("data-username"),
				content: "Just leave the fields empty to enter the actual Dashboard. If you do type <em>something</em> be prepared for a cute wobble animation.",
				img: $(this).attr("data-avatar"),
				fill: true,
				showTime: true
			}
		);
		$("#password .input.username .avatar").remove();
		var avatar = $(this).clone().wrap('<div>').parent().html();
		$("#password .input.username").append(avatar);
		$("#password .input.username input").attr( "value", $(this).attr("data-username") );
		
		$("#users").addClass("animated flipOutY").delay(1000).queue(function(){ 
			$(this).removeClass();
			$(this).hide();
			$(this).clearQueue();
		});
		$("#password").removeClass().addClass("animated fadeInDown").show();
		
		$("#password .input.password input").focus();
	});
	
	$("#password a.back").bind("tap", function() {
		$("#users").removeClass().addClass("animated flipInY active").show();
		$("#password").addClass("animated fadeOutUp").delay(1000).queue(function(){ 
			$(this).removeClass();
			$(this).hide();
			$(this).clearQueue();
		});
	});
	
	$(".avatar").each(function() {
		var source = $(this).attr("data-avatar");
		$(this).css("background-image", "url("+ source +")");
	});
	
	$("#password button").bind("tap", function() {
		forgot();
	});
	
	$("#password .input.password input").keyup(function(event) {
		if (event.which == 13) {
			forgot();
		}
	});
	
	function forgot() {
		if($("#password .input.password input").attr("value")!='') {
			$.notification( 
				{
					title: "Wrong password",
					content: "Just leave the password field empty to log in.",
					icon: "!"
				}
			);
			$("#password").removeClass().addClass("animated wobble").delay(1000).queue(function(){ 
				$(this).removeClass();
				$(this).clearQueue();
			});
			$("#password .input.password input").attr("value", "").focus();
		} else {
			document.location.href = "home.html";
		}
	}
};

$(document).ready(function() {
	$.initializeLogin();
});