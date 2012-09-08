$.initialize = function() {
	// --------------- Overlay initialization ----------------
	$("body").append('<div id="overlays"></div>');
	$("#overlays.dark").live("tap", function() {
		$(this).removeClass("dark");
		$("#overlays .modal").remove();
	});
	// -------------------------------------------------------
		
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
	
	// --------------- Navigation ----------------------------
	$('a').bind("tap", function(e) {
		if($(this).attr("rel") != "external") {
			if(!$(this).data("href")) {
				return false;
			}
			var element = $( $(this).data("href") );
			if(!$(this).parents("ul.tabs").length>0) {
				if ($(this).data("href").charAt( 0 ) == '#' ) {
					if( $(this).hasAttr('data-reveal') ) {
						if( element.is(":hidden") ) {
							element.fadeIn(200);
						} else {
							element.fadeOut(200);
						}	
					} else if ( $(this).hasAttr('data-modal') ) {
						if(element.size()>0) {
							element.modal();
						} else {
							$.info({desc: "The hash <strong>"+$(this).data("href")+"</strong> is not valid"});
						}
					} else {
						var page = $(this).data("href");
						var title = element.data("title");
						
						if(title==undefined) {
							title = $(this).text();
						}
						$.change(page, title);
					}
				} else {
					if ( $(this).hasAttr('data-modal') ) {
						$.fn.modal(
							{
								url: $(this).data("href")
							}
						);
					}
				}
			} else {
				var tab = $("div.tabs > " + $(this).data("href"));
				if(tab.length>0) {
					$(this).parents("ul.tabs, .section").children("div.tabs").children(".tab.current").removeClass("current");
					$(this).parents("ul.tabs, .section").children("div.tabs").children($(this).data("href")).addClass("current");
					$(this).parents("ul.tabs").children("li.current").removeClass("current");
					$(this).parents("li").addClass("current");
				} else {
					$.info({desc: "The hash <strong>"+$(this).data("href")+"</strong> is not valid"});
				}
			}
			e.preventDefault();
		} else {
			window.location.href = $(this).attr("data-href");
		}
	});
	if (window.location.hash) {
		var url = location.hash;
		var caption = $(url).data("title");
		window.location.hash = "";
		$.change(url, caption);
	} else {
		var url = "#" + $(".section.current").attr("id");
		var caption = $(url).data("title");
		$.change(url, caption, true);
	}
	$(window).hashchange( function(){
	    var page = location.hash;
	    var title = $(page).data("title");
	    if($(page).length>0) {
		    if(title==undefined) {
		    	document.title = "Dashboard"
		    } else {
		    	document.title = title + " - Dashboard";
		    }
		    $(".section.current").removeClass("current").hide();
		    $('a[data-href*="#"].current').removeClass("current");
		    
		    $('a[data-href*="' + page + '"]').addClass("current");
		    $(page).addClass("current").show();
		    $(document).scrollTop(0);
	    } else {
	    	$.info({desc: "The page <strong>"+page+"</strong> was not found."});
	    }
	});	
	// -------------------------------------------------------
	
	
	// --------------- Add class to body ---------------
	$("body").addClass("dashboard");
	// -------------------------------------------------------
	

	// --------------- Check for touch devices ---------------
	if (window.Touch) {
		// Do
	};
	// -------------------------------------------------------


	// --------------- Span image replace --------------------
	$("#header ul li > ul > li > img.avatar").each(function() {
		$(this).replaceWith( $('<span />').addClass("avatar").css("background-image", "url("+$(this).attr("src")+")") );
	});
	$("#header ul li.avatar, .comment .avatar").each(function() {
		var src = $(this).children("img").attr("src");
		$(this).children("img").remove();
		$(this).css("background-image", "url("+src+")");
	});
	// -------------------------------------------------------
	
	
	// --------------- Checkbox toggle replace ---------------
	$("input:checkbox").each(function () {
		$(this).checkbox();
	});
	
	
	
	$(".checkbox input").change(function () {
		$(this).parents("span").toggleClass("checked");
	});
	// -------------------------------------------------------
	
	
	// --------------- File input replace --------------------
	$('input[type="file"]').file();
	// -------------------------------------------------------
	
	
	// --------------- Tabs in carton ------------------------
	$(".carton, .carton .column").each(function() {
		if($(this).children(".content").length>1) {
			var len = $(this).children(".content").length;
			$(this).addClass("multiple");
			$(this).children(".content:first").addClass("current");
			
			var round = $('<ul class="round" />');
			
			for (var i = 0; i < len; i++) {
				$('<li />').appendTo(round);
			}
			
			round.children("li:first").addClass("current");
			
			$('ul.round li', this).live("tap", function() {
				var index = $(this).index();
				var carton = $(this).parent("ul").parent();
				
				carton.children("ul").children("li.current").removeClass("current");
				$(this).addClass("current");
				
				carton.children(".content.current").removeClass("current");
				carton.children(".content").eq(index).addClass("current");
			})
			
			$(this).append(round);
			
		}
	});
	// -------------------------------------------------------
	
	
	// --------------- Select replace ------------------------
	$("select").chosen();
	// -------------------------------------------------------
	
	
	// --------------- Menu elements -------------------------
	$("#header > ul > li").bind("tap", function() {
		var menu = $(this).children("ul");
		$("#header").removeClass("inactive");
		
		if(menu.length>0) {
			$("#header > ul > li").removeClass("active");
			$(this).addClass("active");
			$("#header > ul > li > ul").not(menu).hide();
			$("#header").addClass("inactive");
			if(menu.is(":hidden")) {
				menu.show();
			} else {
				menu.hide();
				$(this).removeClass("active");
				$("#header").removeClass("inactive");
			} 	
			
		} else {
			$("#header > ul > li > ul").hide();
			$("#header").removeClass("inactive");
			$("#header > ul > li").removeClass("active");
		}
		return false;
	});
	$("body").bind("tap", function() {
		$("#header > ul > li > ul").hide();
		$("#header").removeClass("inactive");
		$("#header > ul > li").removeClass("active");
	});
	// -------------------------------------------------------
	
	
	// --------------- Removal of title attribute ------------
	$('[title]').attr('title', function(i, title) {
	    $(this).data('title', title).removeAttr('title');
	});
	
	$('a[href]').attr('href', function(i, title) {
		$(this).data('href', title).removeAttr('href').attr('data-href', title);
	});
	// -------------------------------------------------------
	
	
	// --------------- Tooltip initialization ----------------
	$(".tooltip").tooltip();
	// -------------------------------------------------------

	// --------------- Tabs initialization -------------------
	$("ul.tabs").each(function() {
		var hash = $(this).children("li.current").children("a").data("href");
		var tab = $(this).siblings("div.tabs").children(hash);
		if(tab.length>0) {
			tab.addClass("current");
		} else {
			tab = $(this).siblings("div.tabs").children("div.tab:first-child");
			href = "#" + tab.attr("id");
			$(this).children("li.current").removeClass("current");
			$('li a[data-href="'+href+'"]', this).parent("li").addClass("current");
			tab.addClass("current");
		}
	});
	// -------------------------------------------------------
	
	
	// --------------- Pull to refresh -----------------------
	if ($.browser.webkit && navigator.platform=='MacIntel') {
		var distance;
		$('body').append('<div class="pull"><span class="icon">w</span><div>Pull <span>to refresh</span></div></div>');
		$(window).scroll(function () {
			if($(window).scrollTop() < 0) {
				distance = -$(window).scrollTop()*1.6;
				$("#stream").addClass("hide");
				if(distance < 2) {
					distance = 0;
					$("#stream").removeClass("hide");
				}
				if(distance > 62) {
					$('.pull div').html('Release <span>to refresh</span>');
					$('.pull .icon').addClass('release');
				} else {
					$('.pull div').html('Pull <span> to refresh</span>');
					$('.pull .icon').removeClass('release');
				}
				
				if(distance > 300) {
					distance = 300;
				}
				
				$("#dashboard").css("-webkit-transform", "translateY("+distance+"px"+")");
			} else if ($(window).scrollTop() > 0) {
				$("#stream").removeClass("hide");
			} else {
				$("dashboard").css("-webkit-transform", "translateY(0)");
			}
		});
	}
	// -------------------------------------------------------
	
	
};

//This $.demo function can easily be deleted without hurting core functionality - just be aware that demo won't function properly.
$.demo = function() {
	//Prospect to færdige funktioner
	$("li.layer > ul").bind("tap", function() {
		if( !$(this).hasClass("turn") ) {
			$("li.layer > ul.turn").addClass("back").delay(800).queue(function(){ 
				$(this).removeClass("turn");
				$(this).removeClass("back");
				$(this).clearQueue();
			});
			$(this).addClass("turn");
		} else {
			$(this).addClass("back").delay(800).queue(function(){ 
				$(this).removeClass("turn");
				$(this).removeClass("back");
				$(this).clearQueue();
			});
		}
	});
	$("li.todo").each(function() {
		$(this).prepend('<span class="box" />');
	});
	$("li.todo span").bind("tap", function() {
		if( !$(this).parent("li.todo").hasClass("unchecked") ) {
			$(this).parent("li.todo").removeClass("checked").addClass("unchecked");
		} else {
			$(this).parent("li.todo").removeClass("unchecked").addClass("checked");
		}
		return false;	
	});
	// PROSPECT END
	
	// --------------- Validator -----------------------------
	$('form#demo').isHappy({
		fields: {
			'#firstname': {
			  required: true,
			  message: 'Might we at least inquire your first name?'
			},
			'#username': {
			  required: true,
			  message: 'A username is required'
			},
			'#key': {
			  required: true,
			  message: 'A password is required'
			}
		}
	});
	// ------------------------------------------------------- 
	
	// Animation & Modal demo
	var animation = "flipInX";
	$("#modals button").bind("tap", function() {
		var attr = $(this).attr("data-function");
		var options;
		
		switch(attr) {
		
			case "default-theme":
				options = { animation: animation, content: "<strong>Standard</strong> modal" };
				break;
				
			case "dark-theme":
				options =  { animation: animation, theme: "dark", content: "<strong>Dark</strong> modal" };
				break;
				
			case "blue-theme":
				options = { animation: animation, theme: "blue", content: "<strong>Blue</strong> modal" };
				break;
				
			case "elastic-layout":
				options = { animation: animation, layout: "elastic"};
				$.fn.maps(
							{
								place: "magasin du nord, kongens nytorv, copenhagen", 
								zoom: 16, 
								caption: "Magasin du Nord, <span>Copenhagen</span>",
								texture: false,
								modal: {animation: animation, padding: 0, layout: "elastic", close: "light"}
							}
				);
				return false;
				
			case "no-padding":
				$.fn.maps(
							{
								place: "magasin du nord, kongens nytorv, copenhagen", 
								zoom: 16, 
								caption: "Magasin du Nord, <span>Copenhagen</span>",
								texture: false,
								modal: {animation: animation, padding: 0, width: "1100", close: "light"}
							}
				);
				return false;
				
			case "ajax-load":
				options = {animation: animation, url: "static/demo/ajax.html"};
				break;
				
			case "full-overlay":
				if(animation=="flipInX") {
					var n_animation = "fadeInDown";
				} else {
					n_animation = animation;
				}
				$("#typography").overlay("<span>Thin</span> header", undefined, n_animation);
				$.notification( 
					{
						title: 'Full overlay',
						content: 'Press <strong>escape</strong> to exit',
						icon: "O"				
					}
				);
				return false;
				
			default:
				return false;
		}
		
		$("#buttons").modal(options);
		
	});
	$("#select-animations").change(function() {
		var animate = $(this).children('option:selected').text();
		$("#typography").modal({animation: animate});
		
		if( $("#animationDemo").attr("checked") ) {
			animation = animate;
		}
	})
	$("#animationDemo").change(function() {
		if( $(this).attr("checked") ) {
			animation = $("#select-animations").children('option:selected').text();
		} else {
			animation = "flipInX";
		}
	});
	
	// Notifications demo
	$("#alerts button").bind("tap", function() {
		var attr = $(this).attr("data-function");
		var options;
		
		switch(attr) {
		
			case "standard":
				options = {title: 'Standard notification', content: 'This is the content area. Even <strong>HTML</strong>-tags are allowed!', img: "static/demo/avatar92.jpg"}
				break;
				
			case "time":
				options = {title: 'Time notification', content: 'You can easily include time tags on every notification.', showTime: true, img: "static/demo/boy_avatar.jpg"}
				break;
				
			case "timeout":
				options = {title: 'Timeout notification', content: 'This notification will close itself in five seconds!', timeout: 5000, img: "static/demo/obama.jpg"}
				break;
				
			case "callback":
				options = 
					{
						title: 'Callback', 
						content: 'By clicking on the notification, you can call a function.', 
						img: "static/demo/avatar.jpg",
						click: function() {
							$.notification(
	                            {
	                                content: 'This notification was just created.',
	                                title: 'Callback!',
	                                icon: "I"
	                            }
	                        );
						}
					}
				break;
			
			case "border":
				options = {title: 'Borderless image', content: 'Notice how the cloud does not have a border.', img: "static/demo/cloud.png", border: false}
				break;
				
			case "fill":
				options = {title: 'Image fill', content: 'Image fills out the entire left section of the notification.', img: "static/demo/avatar2.jpg", fill: true}
				break;
				
			case "icon":
				options = {title: 'Notification with icon', content: 'An image is not even neccesary. Pastel includes an icon font.', icon: '&amp;'}
				break;
				
			case "error":
				options = {title: 'Error notification', content: 'Easily catch the attention of the user.', error: true }
				break;
			
			default:
				return false;
		}
		
		$.notification(options);
		
	});
	
	$("#more a").bind("tap", function() {
		$("#more").hide();
	});
	
	// Error pages demo
	$("#errors button").bind("tap", function() {
		var attr = $(this).attr("data-function");
		var options;
		
		switch(attr) {
		
			case "standard":
				options = {}
				break;
				
			case "black":
				options = {theme: "black"}
				break;
				
			case "rose":
				options = {theme: "rose"}
				break;
				
			case "white":
				options = {theme: "blues", particles: "FFFFFF"}
				break;
				
			case "icon":
				options = {icon: "N"}
				break;
			
			default:
				return false;
		}
		
		$.info(options);
		
	});
	
	// Tooltip demo
	$("#tooltips button").each(function() {
		var attr = $(this).attr("data-function");
		var options;
		var content = 'Lorem ipsum dolor sit amet, <strong>consectetur</strong> adipiscing elit. Suspendisse cursu turpis.<br><br>Phasellus ac nunc turpis, a euismod diam.';
		
		switch(attr) {
			case "top":
				options = {content: content, maxWidth: "320px", defaultPosition: "top", edgeOffset: 10}
				break;
				
			case "bottom":
				options = {content: content, maxWidth: "320px", defaultPosition: "bottom", edgeOffset: 10}
				break;
				
			case "left":
				options = {content: content, maxWidth: "320px", defaultPosition: "left", edgeOffset: 10}
				break;
				
			case "right":
				options = {content: "Here!", maxWidth: "90px", defaultPosition: "right", edgeOffset: 10}
				break;
				
			case "title":
				options = {content: content, title: "Lorem ipsum dolor", defaultPosition: "top", edgeOffset: 10}
				break;
				
			case "edge":
				options = {content: content, defaultPosition: "top", edgeOffset: 80}
				break;
			
			default:
				return false;
		}
		
		$(this).tooltip(options);
		//$.notification(options);
		
	});
	
	// Maps demo
	$('ul.tabs li a.mapdemo').bind("tap", function() {
		if(!$(this).hasAttr('data-toggle')) {
			var section = $($(this).data('href'));
			var attr = section.attr('id');
			var options;
			$(this).attr('data-toggle', 'true');
			
			switch(attr) {
			
				case "roadmap":
					options = {
						texture: false, 
						place: "kongens nytorv, copenhagen", 
						type: "roadmap", 
						caption: "King's New Square, <span>Copenhagen</span>"
					};
					break;
					
				case "satellite":
					options = {
						place: "kongens nytorv, copenhagen", 
						zoom: 16, 
						caption: "King's New Square, <span>Copenhagen</span>",
						texture: false
					};
					break;
					
				case "hybrid":
					options = {
						texture: false, 
						place: "kongens nytorv, copenhagen", 
						type: "hybrid", 
						caption: "King's New Square, <span>Copenhagen</span>"
					};
					break;
					
				case "currentlocation":
					options = {
						geo: true, 
						caption: "<span>Your</span> current <span>location</span>"
					};
					break;
				
				default:
					return false;
			}
			
			section.maps(options);
		}
	});
	$('#mapmodals button').bind("tap", function() {
		var attr = $(this).attr('data-function');
		var options;
		
		switch(attr) {
		
				
			case "standard":
				options = {
					place: "kongens nytorv, copenhagen", 
					zoom: 16, 
					caption: "King's New Square, <span>Copenhagen</span>",
					texture: false
				};
				break;
			
			case "roadmap":
				options = {
					texture: false, 
					place: "kongens nytorv, copenhagen", 
					type: "roadmap", 
					caption: "King's New Square, <span>Copenhagen</span>"
				};
				break;
				
			case "current":
				options = {
					geo: true, 
					caption: "<span>Your</span> current <span>location</span>"
				};
				break;
				
			case "custom":
				options = {
					texture: false, 
					place: "marmorkirken, copenhagen", 
					type: "hybrid", 
					zoom: 15,
					caption: "Marble Church, <span>Copenhagen</span>",
					modal: {padding: 0, layout: "elastic", animation: "bounceInDown", close: "light"},
				};
				break;
			
			default:
				return false;
		}
		
		$.fn.maps(options);
	});
	
	// Chat demo
	$(".text-con textarea").keydown(function(event) {
		if (event.which == 13) {
			$(this).parent().children("button").click();
			event.preventDefault();	
		}
	});
	$(".text-con.demo button").bind("tap", function() {
		var textarea = $(this).parent().children("textarea");
		var value = textarea.val();
		if(value.length>0) {
			$(window).scrollTop($(document).height());
			var theme = $(this).attr("data-theme");
			var comment = $('<div class="com-con right '+theme+'"><div class="comment"><p>'+value+'</p><div class="avatar"></div></div><div class="byline"><strong>You</strong> Just now</div></div>');
			comment.hide();
			comment.appendTo( $(this).parent().parent() );
			comment.fadeIn();
			textarea.val('');
		}
	});
	
	// Datepicker
	$("input#date").date();
	
	//Tags
	$("#tags").tags();
	
	// Table initialization
	$("table")
	.table()
	.pagination();
	
	$("#home").append('<ul class="round"><li class="current">Page one</li><li>Page two</li><li>Page three</li></ul>');
	
	// Bind events to the tiles
	$("#article").bind("tap", function() {
		$.editor("static/demo/editor.txt", "#editor-textarea", "#editor-preview");
		$.change("#text");	
	});

	$("#comment").bind("tap", function() {
		$.fn.gallery("static/demo/montage.html");
		
		if(!$(this).attr("data-toggle")) {
			$.notification( 
				{
					title: 'The Photo Montage',
					content: 'Please wait while it\'s loading. The montage can be closed at any time, simply by pressing <strong>Escape</strong>',
					icon: "3"				
				}
			);
			$(this).attr("data-toggle", "true")
		}
	});
	
	// Icon demo
	$("#icons .icons span").hover(function() {
		var icon = $(this).text();
		$("#big span.icon").html(icon);
		$("#big span.character").html("Character: <strong>" + icon + "</strong>");
	});
	
	// Change theme, temporary function
	$("#footer").bind("tap", function() {
		if($("body").hasClass("feather")) {
			$("body").removeClass("feather");
		} else {
			$("body").addClass("feather");
		}
	});
	
	//Documentation
	$("#docs ul.tabs li a").bind("tap", function() {
		if(!$(this).hasAttr("data-loaded") && $(this).data("href")!="#introduction") {
			var element = $( $(this).data("href") );
			var reference = "docs/reference/" + $(this).data("href").replace(/^#docs_+/, "") + ".md";
			$(this).attr("data-loaded", "true");
					
			$.get(reference + "?time=" + (new Date()).getTime(), function(data){
				var docs = new Showdown.converter();
				
				var text = $(docs.makeHtml(data));
				text.find('pre').addClass('prettyprint');
				text.find('p code').addClass('prettyprint');
				text.find('code').each(function() {
				    $(this).html(prettyPrintOne($(this).html()));
				});
				element.html(text);	
				$(document).scrollTop(0);
			}).error(function() {
				$.notification( 
					{
						title: 'Reference was not found',
						content: 'The reference <strong>' + reference + "</strong> was not found",
						error: true
					}
				);	
			});
		}
	})
	
	//Retina demo
		var left = 0;
        var top = 0;
        var sizes = { 
						retina: { width:190, height:190 },
		        		app:	{ width:220, height:330 } 
					};
        var retina;
    	$("#iphone_con .retina").css("background-image","url(static/demo/screen.jpg)");
    	$("#iphone_small_white .retina").css("background-image","url(static/demo/todo.jpg)");
    	$("#iphone_small .retina").css("background-image","url(static/demo/maps.jpg)");
        $('.screenshot').mousemove(function(e){
        
            offset  = { left: $(this).offset().left, top: $(this).offset().top };
            title = $(this).attr('title');
            retina  = $(this).children(".retina");
            left = (e.pageX-offset.left);
            top = (e.pageY-offset.top);
            if(retina.is(':not(:animated):hidden')){
                $(this).trigger('mouseenter');
            }
    
            if(left<0 || top<0 || left > sizes.app.width ||
                top > sizes.app.height)
            {
    
                if(!retina.is(':animated')){
                    $(this).trigger('mouseleave');
                }
                return false;
            }
    
            retina.css({
                left                : left - sizes.retina.width/2,
                top                 : top - sizes.retina.height/2,
                backgroundPosition  : '-'+(2.15*left)+'px -'+(2.5*top)+'px'
            });
    
        }).mouseleave(function(){
            $(this).children(".retina").fadeOut('fast');
        }).mouseenter(function(){
            $(this).children(".retina").hide();
            $(this).children(".retina").fadeIn('fast');
    });	
	
	$("#orbit_1").orbit(
		{
			animation: "rollIn",
			one: {color: "#F6BCAD", tooltip: "Research In Motion", speed: 10},
			two: {color: "#C3C48D", tooltip: "Apple", speed: 1},
			three: {color: "#7BB392"},
			four: {color: "#343738"}
		}
	);
	
	$("#orbit_2").orbit(
		{
			animation: "bounceInDown",
			texture: false,
			one: {color: "#bbb", tooltip: "Research In Motion", speed: 50},
			two: {color: "#999", tooltip: "Apple", speed: 21},
			three: {color: "#666"},
			four: {color: "#333"}
		}
	);
	
	$("#orbit_3").orbit();
	
	
//	-------------------------------------------------------------------------------------------------------------------------------------------

	if ($.browser.msie  && parseInt($.browser.version, 10) === 8) {
		// IE8 doesn't like Canvas.
	} else {
	
		var d1 = [];
	    for (var i = 0; i <= 10; i += 1)
	        d1.push([i, parseInt(Math.random() * 250)]);
	    
	    var d2 = [];
	    var d3 = [];
	    for (var i = 0; i <= 10; i += 0.4)
	        d3.push([i, parseInt(Math.random() * 140)]);
	        
		var d4 = [];
	    for (var i = 0; i <= 10; i += 0.1)
	        d4.push([i, Math.sqrt(i * 10)]);
	    
	    var d5 = [];
	    var d6 = [];
	    for (var i = 0; i <= 10; i += 0.5 + Math.random())
	        d6.push([i, Math.sqrt(2*i + Math.sin(i) + 5)]);      
	
	    var stack = 1, bars = false, lines = true, steps = false;
	    
	    
	    d5 = [ [0, 42], [1, 50], [2, 65], [3, 76], [4, 77], [5, 180], [6, 199], [7, 220], [8, 240], [9, 340], [10, 398] ];
	    d2 = [ [0, 2], [1, 30], [2, 25], [3, 186], [4, 150], [5, 200], [6, 189], [7, 120], [8, 140], [9, 200], [10, 198] ];
	    ds = [ [0, 2], [1, 30], [2, 25], [3, 186] ];
	    ds2 = [ [0, 6], [1, 20], [2, 69], [3, 286] ];
	    
		$.plot($("#chart1"), 
			[
				{
					label: "DR NU",
					data: d5,
					lines: { show: true, fill: 0.4 },
					color: "#8AB4B5",
					hoverable: true
				},
				{
					label: "Pattern.dk",
					data: d1,
					lines: { show: true, lineWidth: 4 },
					color: "#FC354C"
				},
				{
					label: "Pouteria",
					data: d3,
					lines: { show: true, lineWidth: 2 },
					color: "#1E2528"
				},
				{
					label: "Halifaxed.com",
					data: d2,
					lines: { show: true, lineWidth: 2 },
					color: "#008C83"
				}
			], 
				
				{
					series	:	{ lines: { show: true }, points: { show: true }, curvedLines: { active: true } },
					grid	:	{ hoverable: true, clickable: true },
					legend	:	{ show: false },
					yaxis	:	{ position: "right" }
				}
		);
		
		
		
		
		function demo_chart() {
			$.plot($("#chart_linear_stack"), [ { data: d1, label: "iPhone", color: "#333333" }, { data: d2, label: "iPad", color: "#3B8686" }, { data: d3, label: "Mac", color: "#79BD9A" } ], {
			   series: {
			       stack: stack,
			       lines: { show: lines, fill: 0.8, steps: steps, clickable: true, lineWidth: 2 },
			       bars: { show: bars, barWidth: 0.6 },
			       points: { show: true }
			   },
			   grid: { hoverable: true }
			});
		   
		   
			$.plot($("#chart_linear"), 
				[
					{label: "DR NU", data: d5, lines: {show: true, fill: 0.8 }, color: "#355C7D"},
					{label: "Pattern.dk", data: d1, lines: { show: true, lineWidth: 4 }, color: "#F67280"},
					{label: "Pouteria", data: d3, lines: { show: true, lineWidth: 2 }, color: "#F8B195"},
					{label: "Halifaxed.com", data: d2, lines: { show: true, lineWidth: 2 }, color: "#6C5B7B"}
				], 
				{	
					series	:	{ lines: { show: true }, points: { show: true }, curvedLines: { active: true } },
					grid	:	{ hoverable: true, clickable: true }
				}
			);
			
			
			$.plot($("#small_chart"), [ { data: ds, label: "iPhone", color: "#666" }, { data: ds2, label: "iPad", color: "#999" }], {
			   series: {
			       stack: stack,
			       lines: { show: lines, fill: 0.8, steps: steps, clickable: true, lineWidth: 2 },
			       bars: { show: bars, barWidth: 0.6 },
			       points: { show: true }
			   },
			   grid: { hoverable: true }
			});
			
			$("#chart_linear").tooltipColor();
			$("#small_chart, #chart_linear_stack").tooltipColor("devices");
			
		   
			var males = {'15%': [[2, 88.0], [3, 93.3], [4, 102.0], [5, 108.5], [6, 115.7], [7, 115.6], [8, 124.6], [9, 130.3], [10, 134.3], [11, 141.4], [12, 146.5], [13, 151.7], [14, 159.9], [15, 165.4], [16, 167.8], [17, 168.7], [18, 169.5], [19, 168.0]], '90%': [[2, 96.8], [3, 105.2], [4, 113.9], [5, 120.8], [6, 127.0], [7, 133.1], [8, 139.1], [9, 143.9], [10, 151.3], [11, 161.1], [12, 164.8], [13, 173.5], [14, 179.0], [15, 182.0], [16, 186.9], [17, 185.2], [18, 186.3], [19, 186.6]], '25%': [[2, 89.2], [3, 94.9], [4, 104.4], [5, 111.4], [6, 117.5], [7, 120.2], [8, 127.1], [9, 132.9], [10, 136.8], [11, 144.4], [12, 149.5], [13, 154.1], [14, 163.1], [15, 169.2], [16, 170.4], [17, 171.2], [18, 172.4], [19, 170.8]], '10%': [[2, 86.9], [3, 92.6], [4, 99.9], [5, 107.0], [6, 114.0], [7, 113.5], [8, 123.6], [9, 129.2], [10, 133.0], [11, 140.6], [12, 145.2], [13, 149.7], [14, 158.4], [15, 163.5], [16, 166.9], [17, 167.5], [18, 167.1], [19, 165.3]], 'mean': [[2, 91.9], [3, 98.5], [4, 107.1], [5, 114.4], [6, 120.6], [7, 124.7], [8, 131.1], [9, 136.8], [10, 142.3], [11, 150.0], [12, 154.7], [13, 161.9], [14, 168.7], [15, 173.6], [16, 175.9], [17, 176.6], [18, 176.8], [19, 176.7]], '75%': [[2, 94.5], [3, 102.1], [4, 110.8], [5, 117.9], [6, 124.0], [7, 129.3], [8, 134.6], [9, 141.4], [10, 147.0], [11, 156.1], [12, 160.3], [13, 168.3], [14, 174.7], [15, 178.0], [16, 180.2], [17, 181.7], [18, 181.3], [19, 182.5]], '85%': [[2, 96.2], [3, 103.8], [4, 111.8], [5, 119.6], [6, 125.6], [7, 131.5], [8, 138.0], [9, 143.3], [10, 149.3], [11, 159.8], [12, 162.5], [13, 171.3], [14, 177.5], [15, 180.2], [16, 183.8], [17, 183.4], [18, 183.5], [19, 185.5]], '50%': [[2, 91.9], [3, 98.2], [4, 106.8], [5, 114.6], [6, 120.8], [7, 125.2], [8, 130.3], [9, 137.1], [10, 141.5], [11, 149.4], [12, 153.9], [13, 162.2], [14, 169.0], [15, 174.8], [16, 176.0], [17, 176.8], [18, 176.4], [19, 177.4]]};
			var females = {'15%': [[2, 84.8], [3, 93.7], [4, 100.6], [5, 105.8], [6, 113.3], [7, 119.3], [8, 124.3], [9, 131.4], [10, 136.9], [11, 143.8], [12, 149.4], [13, 151.2], [14, 152.3], [15, 155.9], [16, 154.7], [17, 157.0], [18, 156.1], [19, 155.4]], '90%': [[2, 95.6], [3, 104.1], [4, 111.9], [5, 119.6], [6, 127.6], [7, 133.1], [8, 138.7], [9, 147.1], [10, 152.8], [11, 161.3], [12, 166.6], [13, 167.9], [14, 169.3], [15, 170.1], [16, 172.4], [17, 169.2], [18, 171.1], [19, 172.4]], '25%': [[2, 87.2], [3, 95.9], [4, 101.9], [5, 107.4], [6, 114.8], [7, 121.4], [8, 126.8], [9, 133.4], [10, 138.6], [11, 146.2], [12, 152.0], [13, 153.8], [14, 155.7], [15, 158.4], [16, 157.0], [17, 158.5], [18, 158.4], [19, 158.1]], '10%': [[2, 84.0], [3, 91.9], [4, 99.2], [5, 105.2], [6, 112.7], [7, 118.0], [8, 123.3], [9, 130.2], [10, 135.0], [11, 141.1], [12, 148.3], [13, 150.0], [14, 150.7], [15, 154.3], [16, 153.6], [17, 155.6], [18, 154.7], [19, 153.1]], 'mean': [[2, 90.2], [3, 98.3], [4, 105.2], [5, 112.2], [6, 119.0], [7, 125.8], [8, 131.3], [9, 138.6], [10, 144.2], [11, 151.3], [12, 156.7], [13, 158.6], [14, 160.5], [15, 162.1], [16, 162.9], [17, 162.2], [18, 163.0], [19, 163.1]], '75%': [[2, 93.2], [3, 101.5], [4, 107.9], [5, 116.6], [6, 122.8], [7, 129.3], [8, 135.2], [9, 143.7], [10, 148.7], [11, 156.9], [12, 160.8], [13, 163.0], [14, 165.0], [15, 165.8], [16, 168.7], [17, 166.2], [18, 167.6], [19, 168.0]], '85%': [[2, 94.5], [3, 102.8], [4, 110.4], [5, 119.0], [6, 125.7], [7, 131.5], [8, 137.9], [9, 146.0], [10, 151.3], [11, 159.9], [12, 164.0], [13, 166.5], [14, 167.5], [15, 168.5], [16, 171.5], [17, 168.0], [18, 169.8], [19, 170.3]], '50%': [[2, 90.2], [3, 98.1], [4, 105.2], [5, 111.7], [6, 118.2], [7, 125.6], [8, 130.5], [9, 138.3], [10, 143.7], [11, 151.4], [12, 156.7], [13, 157.7], [14, 161.0], [15, 162.0], [16, 162.8], [17, 162.2], [18, 162.8], [19, 163.3]]};
		   
			var dataset = [
				{ label: 'Female mean', data: females['mean'], lines: { show: true }, color: "#F55B98" },
				{ id: 'f15%', data: females['15%'], lines: { show: true, lineWidth: 0, fill: false }, color: "#F55B98" },
				{ id: 'f25%', data: females['25%'], lines: { show: true, lineWidth: 0, fill: 0.2 }, color: "#F55B98", fillBetween: 'f15%' },
				{ id: 'f50%', data: females['50%'], lines: { show: true, lineWidth: 0.5, fill: 0.4, shadowSize: 0 }, color: "#F55B98", fillBetween: 'f25%' },
				{ id: 'f75%', data: females['75%'], lines: { show: true, lineWidth: 0, fill: 0.4 }, color: "#F55B98", fillBetween: 'f50%' },
				{ id: 'f85%', data: females['85%'], lines: { show: true, lineWidth: 0, fill: 0.2 }, color: "#F55B98", fillBetween: 'f75%' },
				
				{ label: 'Male mean', data: males['mean'], lines: { show: true }, color: "#6EAFFA" },
				{ id: 'm15%', data: males['15%'], lines: { show: true, lineWidth: 0, fill: false }, color: "#6EAFFA" },
				{ id: 'm25%', data: males['25%'], lines: { show: true, lineWidth: 0, fill: 0.2 }, color: "#6EAFFA", fillBetween: 'm15%' },
				{ id: 'm50%', data: males['50%'], lines: { show: true, lineWidth: 0.5, fill: 0.4, shadowSize: 0 }, color: "#6EAFFA", fillBetween: 'm25%' },
				{ id: 'm75%', data: males['75%'], lines: { show: true, lineWidth: 0, fill: 0.4 }, color: "#6EAFFA", fillBetween: 'm50%' },
				{ id: 'm85%', data: males['85%'], lines: { show: true, lineWidth: 0, fill: 0.2 }, color: "#6EAFFA", fillBetween: 'm75%' }
			]
		   
			$.plot($("#percentiles"), dataset, {
				xaxis: { tickDecimals: 0 },
				yaxis: { tickFormatter: function (v) { return v + " cm"; } },
				legend: { position: 'se' }
			});
		   
		   
			var data = [];
			var series = Math.floor(Math.random()*7)+1;
			for( var i = 0; i<series; i++) {
				data[i] = { label: "Series"+(i+1), data: Math.floor(Math.random()*100)+1 }
			}
			
			$.plot($("#pie_chart"), data,
			{
			       series: {
			           pie: { 
			               show: true
			           }
			       }
			});
			
			$.plot($("#donut"), data,
			{
			        series: {
			            pie: { 
			                innerRadius: 0.5,
			                show: true
			            }
			        }
			});
		   
		}
		
		$("#charts_init").bind("tap", function() {
			if(!$(this).attr("data-toggle")) {
				demo_chart();
				$(this).attr("data-toggle", "true");
			}
		});
		
		if(window.location.hash=="#charts") {
			demo_chart();
		}
		
	}
	
	
//	-------------------------------------------------------------------------------------------------------------------------------------------
	$.notification( 
		{
			title: 'Welcome to Pastel!',
			content: '<strong>Please</strong> take a look around, I hope you like it!',
			img: "static/demo/alone.jpg",
			fill: true
		}
	);
	
	$.notification( 
		{
			title: 'This is the notification area',
			content: 'Check the <em>Notifications</em> section for more information.',
			icon: '&amp;'
		}
	);
	
	
	
	
}

// Initializing of the Pastel Dashboard!
$(document).ready(function() {
	$.initialize();
	$.demo();
});