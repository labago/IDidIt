$(document).ready(function(){

	suffolk.quickLinks('#nav-quicklinks');
	suffolk.navGlobal('#nav-global.openable', '#nav-tray');
	suffolk.inputClear('.mod-search input, .mod-contact input, .mod-contact textarea, .mod-tripanel input');
	suffolk.modTabs('.mod-upper .mod-tabs', '.tab-item');
	suffolk.modTabs('.tabs-v.content', '.tab-item');
	suffolk.modTabs('.tabs-h', '.tab-item');
	suffolk.showHide('.mod-showhide', '.trigger');
	suffolk.equalColumns('.mod-tripanel', '[class^=col-]');
	suffolk.equalColumns('.equalized', '.content');
	suffolk.carousel('.mod-carousel', '.item');
	suffolk.resize('.resizable-aspect', true);
	suffolk.resize('.resizable', false);
	suffolk.photos('.mod-photos');
	suffolk.zebra('table.zebra', 'tr');
	$('table.mod-tablesort').tableSort();

//  Boilerplate functions
//	prj.randomizer('.element', '.item');
	$(window).resize(function() {
		suffolk.resize();
		suffolk.equalColumns('.mod-tripanel', '[class^=col-]');
		suffolk.equalColumns('.equalized', '.content');
	});
});

var opts = {
	speed : 350,
	qlH : $('#nav-quicklinks .item').outerHeight(),  // Height of quicklinks nav
	panels : 0,
	qlTrigger : $('#nav-quicklinks').find('.trigger')
};

var suffolk = {

	// Set up the javascript-enabled page
	setup : function() {
		// Position body & quicklinks nav
		$('body').css({
			'padding-top' : opts.qlH,
			'margin-top'  : -opts.qlH
		});
		$('#nav-quicklinks').css({
			'height' : opts.qlH,
			'top'    : -opts.qlH
		});
		// Set trigger position
		opts.qlTrigger.css('bottom', -opts.qlTrigger.outerHeight());
		// Check for touch devices
		if ( suffolk.isTouchDevice() == true ) {
			$('body').addClass('touch-enabled');
		};
	},

	// Quicklinks navigation
	quickLinks : function(el) {
		var obj = $(el);
		var body = $('body');
		
		var item = obj.find('ul');
		// Set nav & trigger position
		suffolk.setup();
		// Click action
		opts.qlTrigger.on('click', function() {
			item.addClass('open');
			if( obj.hasClass('open') === false ) {
				// If the menu is not open, open it
				slideEl( {marginTop : 0}, 'open' );
			} else {
				// If the menu is open, close it
				slideEl( {marginTop : -opts.qlH}, 'close' );
			};
		});
		// Animation function
		function slideEl(ani, dir) {
			body.stop().animate(ani, opts.speed, function() {
				if( dir === 'open' ) {
					// If opening the nav
					obj.addClass('open');
				} else if( dir === 'close' ) {
					// If closing the nav
					obj.removeClass('open');
					item.removeClass('open').removeAttr('style');
				};
			});
		};
		$(window).resize(function() {
			opts.qlH = $('#nav-quicklinks .item').outerHeight();
			// Position body & quicklinks nav
			$('body').css( 'padding-top' , opts.qlH );
			if( $('#nav-quicklinks').hasClass('open') === false ) {
				$('body').css( 'margin-top' , -opts.qlH );
			};
			// Set trigger position
			opts.qlTrigger.css('bottom', -opts.qlTrigger.outerHeight());
		});
	},

	// Global navigation tray
	navGlobal : function(el) {
		var obj = $(el);
		var btns = obj.find('.btn');
		var target = $('#masthead').after('<div id="nav-tray"></div>').parent().find('#nav-tray');
		target.append( obj.find('.row') );
		opts.panels = target.find('.row');
		var close = target.append('<p class="close"><span/></p>').find('.close');
		suffolk.resize();
		// Click action
		obj.find('a').on('click', function(event) {
			event.preventDefault();
			// Find which button was clicked
			for (i=0; i < btns.length; i++) {
				if (btns[i] == this ) {
					break;
				};
			};
			// Check to see if the clicked button is already active
			if( $(this).hasClass('btnOpen') === false ) {
				// If this button is not active
				btns.removeClass('btnOpen');
				$(this).addClass('btnOpen');
				// Get height of desired panel
				var height = opts.panels.eq(i).outerHeight();
				// Check to see if the menu is open or not
				if( obj.hasClass('open') === false ) {
					// If the menu panel is not open
					loadAssoc( opts.panels.eq(i).find('.assoc') );
					obj.addClass('open');
					target.addClass('open');
					opts.panels.hide().removeClass('vis');
					opts.panels.eq(i).fadeIn(opts.speed).addClass('vis');
				} else {
					// If the menu is already open
					opts.panels.fadeOut(opts.speed).removeClass('vis');
					setTimeout(function(){
						opts.panels.find('.assoc').empty();
						loadAssoc( opts.panels.eq(i).find('.assoc') );
						opts.panels.eq(i).fadeIn(opts.speed).addClass('vis');
					}, opts.speed );
				};
				animateTray(height);
			} else {
				// If this button is active
				closeTray();
			};
			close.on('click', function(){
				closeTray();
			});
			function closeTray(el) {
				// Close the tray
				animateTray(0);
				btns.removeClass('btnOpen');
				obj.removeClass('open');
				target.removeClass('open');
				opts.panels.find('.assoc').empty();
				opts.panels.fadeOut(opts.speed).removeClass('vis');
			};
			function loadAssoc(el) {
				var imgsrc = $(el).attr('data-imgsrc');
				var videoid = $(el).attr('data-videoid');
				if( imgsrc ) {
					// Load the image
					$(el).empty().append('<img src="'+imgsrc+'" alt="">');
				} else if( videoid ) {
					// Load the YouTube video
					console.log(videoid)
					$(el).empty().append('<iframe width="316" height="178" src="http://www.youtube.com/embed/'+videoid+'?wmode=opaque" frameborder="0" allowfullscreen></iframe>');
				};

			};
			// Animate navTray
			function animateTray(h) {
				target.stop().animate({
					'height' : h
				}, opts.speed, function() {
					if( h == 0 ) {
						target.css('overflow', 'hidden');
					} else {
						target.css('overflow', 'visible');
					};
				});
			};
		});
		$(window).resize(function() {
			for (var i = 0; i < opts.panels.length; i++) {
				$(opts.panels[i]).find($("[class^=col-]")).removeAttr('style').height(opts.panels.eq(i).height());

				if( $('#nav-global').hasClass('open') === true ) {
					$('#nav-tray').height( $('#nav-tray .vis').outerHeight() );
				};	
			};
		});
	},

	equalColumns : function(container, item) {
		$(container).find($(item)).css('min-height', 1);
		// Each row
		$(container).each(function() {
			var row = $(this);
			// Set the base height
			var thisHeight = 0;
			// Get the items that will be resized
			var items = row.find(item);
			items.each(function() {
				var newHeight = $(this).height();
				if( newHeight > thisHeight ) {
					thisHeight = newHeight;
				};
			});
			// Make all items the same height
			items.css('min-height', thisHeight);
		});
	},

	// Function for resizing elements with inline width & height properties,
	// such as iframes. If aspect==true, it keeps the elements aspect ratio.
	// If aspect==false, the height will equal the width (square).
	resize : function(el, aspect) {

		$(el).each(function() {
			var obj = $(this);
			var parent = obj.parent();
			var winW = $(window).width();
			var w = parent.width();
			if( w > winW ) {
				w = winW;
			};
			if( $(window).width() < 1080 ) {
				obj.attr('width', w);
				if( aspect === true ) {
					obj.attr('height', Math.round(w*0.5625));
				} else if( aspect === false ) {
					obj.attr('height', w);
				};
			};
			$(window).resize(function() {
				if( $(window).width() < 1080 ) {
					w = parent.width();
					obj.attr('width', w);
					if( aspect === true ) {
						obj.attr('height', Math.round(w*0.5625));
					} else {
						obj.attr('height', w);
					};
				};
			});
		});
	},

	//  Create tabbed content from items within a container
	modTabs : function(container, item) {
		$(container).each(function() {
			var obj = $(this);
			var items = obj.children(item);
			var activeItem = obj.find(item+'.active');
			//  Create tabNav
			var tabNav = obj.prepend('<ul class="tab-nav" />').find('.tab-nav');
			for (var i=0; i < items.length; i++) {
				var tabTitle = $(items[i]).find('.tab-title:first').text();
				$(items[i]).find('.tab-title:first').hide();
				if( $(items[i]).hasClass('active') == true ) {
					tabNav.append('	<li class="tab active" data-name="tab"><a href="#">'+tabTitle+'</a></li>\n');
				} else {
					tabNav.append('	<li class="tab" data-name="tab"><a href="#">'+tabTitle+'</a></li>\n');
				}
			};
			//  Show active tab only. If there is no active tab, make the first tab active
			if( activeItem.length > 0) {
				obj.children(item+':not(.active)').hide();
			} else {
				obj.children(item+':gt(0)').hide();
				obj.children(item+':first').addClass('active');
				tabNav.find('.tab:first').addClass('active');
			};

			// Suffolk specific: If this is a navstrip, make the necessary tabNav adjustments
			// Removed because we're not using _navstrip on these. Compression will remove this comment
//			if( obj.hasClass('_navstrip') === true ) {
//				obj.removeClass('_navstrip');
//				tabNav.find('.tab:not(:last-child)').after('\n	<li class="div">|</li>');
//				tabNav.addClass('_navstrip').prepend('\n	<li>&nbsp;</li>\n').append('	<li>&nbsp;</li>\n	<li class="fill">&nbsp;</li>\n');
//			};

			//  Tab click
			var tabs = tabNav.find('.tab');
			tabs.bind('click', function(event) {
				event.preventDefault();
				tabs.removeClass('active');
				$(this).addClass('active');
				//  Get the location of the tab in the array
				for (loc=0; loc < tabs.length; loc++) {
					if (tabs[loc] == this ) {break;}
				};
				items.hide().removeClass('active');
				var active = obj.children(item+':eq('+loc+')');
				active.show().addClass('active');
				suffolk.equalColumns(active.find('.equalized'), '.content');
			});
		});
	},

	showHide : function(el, trigger) {
		$(el).each(function() {
			var obj = $(this);
			obj.find($(trigger)).on('click', function() {
				$(this).parent().toggleClass('open');
			});
		});
	},

	carousel : function(container, item) {
		$(container).each(function() {

			// Get container & tray
			var obj = $(container);
			var tray = obj.find('.tray');
			// Get array of items
			var items = obj.find($(item));
			// Assign z-index
			var c = items.length+1;
			for (var i = 0; i < items.length; i++) {
				$(items[i]).css('z-index', c);
				c--
			};
			// Hide all the others & set height on tray
			items.hide();
			$(items[0]).show().addClass('current');
			$(window).load(function() {
				sizeCarousel();
			});
			$(window).on('resize', function(){
				sizeCarousel();
			});

			// Build bullet nav
			var nav = obj.append('<ul class="nav-carousel">').find('.nav-carousel');
			// Add bullet for each item
			for (var t = 0; t < items.length; t++) {
				// Add data-num to tile for reference later
				$(items[t]).attr('data-num', t);
				// Create the button
				var button = nav.append('<li class="nav-link" data-num="'+t+'">&bull;</li>').find('li:last');
				nav.find('li:first').addClass('active');

				// Bind each button to corresponding item
				button.bind('click', function(event) {
					event.preventDefault();
					// Only animate if no animation is already active
					if( $(this).hasClass('active') != true && obj.find('.current .content').is(':animated') != true ) {
						// Find the corresponding target tile by getting the data-num
						var curr = $(container).find('.current .link');
						var target = parseInt($(this).attr('data-num'));
						animateTray( curr, $(items[target]) );
						nav.children().removeClass('active');
						$(this).addClass('active');
					};
				});
			};

			// Resize elements in the carousel
			function sizeCarousel() {
				var add = obj.find('.current .add');
				var iframe = obj.find('.current iframe');
				// YouTube iframes
				if( add.width() < 544 ) {
					iframe.attr({
						'width': add.width(),
						'height' : iframe.parent().width()*0.5625
					});
				} else {
					iframe.attr({
						'width': 544,
						'height' : 306
					});
				};
				// Tray container
				tray.height( obj.find('.current').outerHeight() );
			};

			function animateTray(current, next) {

				// Get content, image, item, and next item
				var top = $(current).parent();
				var content = $(current).find('.content');
				var add = $(current).find('.add');
				var item = $(current).parent();

				// Get the next item
				if( $(next).length > 0) {
					var nextItem = $(next);
				} else if( item.next().length > 0 ) {
					var nextItem = item.next();
				} else {
					var nextItem = $(items[0]);
				};

				// Arrange current & next to prepare for animation
				top.css('z-index', 10);
				nextItem.show().addClass('current').css('z-index', 9);

				// Resize container to height of new item
				tray.animate({
					height : nextItem.height()
				}, opts.speed*2);

				// Animate image left
				add.stop().animate({
					left : -add.width()
				}, opts.speed*2);

				// Animiate content right
				content.animate({
					left : content.outerWidth()
				}, opts.speed*2, function() {
					// Move this layer to bottom (z-index to zero)
					item.hide().css('z-index', 1).removeClass('current');
					// Put image & content back where they belong
					add.removeAttr('style');
					content.removeAttr('style');
					// Reassign sibling z-indexes
					item.siblings().each(function() {
						$(this).css('z-index', parseInt($(this).css('z-index'))+1);
					});
					if( add.hasClass('video') === true ) {
						add.find('iframe').clone().appendTo(add);
						add.find('iframe:first').remove();
					};
					// If there's a video, we need js to resize it
					if( nextItem.find('.add').hasClass('video') === true ) {
						sizeCarousel();
					};
				});
			};

		});
	},

	photos : function(el) {
		// Quick and dirty slider for a flickr 10-image badge
		$(el).each(function() {
			var obj = $(this);
			var tray = obj.find('.flickr_badge_wrapper');
			// Add previous & next buttons
			var prev = obj.find('.content').append('<span class="prev btn"/>').find('.prev');
			var next = obj.find('.content').append('<span class="next btn visible"/>').find('.next');
			// Add function calls to buttons
			prev.on('click', function() { move('0'); });
			next.on('click', function() { move('-515px'); });
			// Tray animation
			function move(distance) {
				obj.find('.btn').toggleClass('visible');
				tray.stop().animate({
					left : distance
				}, opts.speed );
			};
		});
	},

	// Add a class="odd" to odd-number children inside a parent container
	zebra : function(container, item) {
		$(container+' '+item+':nth-child(even)').addClass('even');
	},

	//	Clear inputs on focus
	inputClear : function(target) {
		var target = target || "input";
		$(target).each(function() {
			if( $(this).attr('type') == 'text' || $(this).attr('type') == 'password' || $(this).is('textarea') ) {
				var obj = $(this);
				// Move label text into form value attribute
				obj.attr('value', obj.prev('label').text());
				obj.prev('label').hide();
				var value = obj.val();
				$(this).focus(function() {
					obj.addClass('focus');
					if(obj.val() == value) {
						obj.val('');
					};
				});
				obj.blur(function() {
					obj.removeClass('focus');
					if(obj.val() == '') {
						obj.val(value);
					};
				});
			};
		});
	},

	isTouchDevice : function() {
		var el = document.createElement('div');
		el.setAttribute('ontouchmove', 'return;');
		if(typeof el.ontouchmove == "function"){
			return true;
		}else {
			return false;
		};
	}

};



(function(g){g.fn.tableSort=function(h){var i=this,h=h||{},h=g.extend({},{"int":function(e,f){return parseInt(e,10)-parseInt(f,10)},"float":function(e,f){return parseFloat(e)-parseFloat(f)},string:function(e,f){return e<f?-1:e>f?1:0}},h);i.delegate("th","click",function(){var e=i.find("tbody tr"),f=g(this).index(),a=g(this).attr("class"),c=null;g(this).toggleClass("sorted").siblings().removeClass("sorted");if(a){for(var a=a.split(/\s+/),b=0;b<a.length;b++)if(-1!=a[b].search("type-")){c=a[b];break}c=c?c.split("-")[1]:"string"}if(!c)return!1;a=h[c];column=[];e.each(function(c,b){var a=g(b).children().eq(f),a=a.attr("data-order-by")||a.text();column.push(a)});var d=column,c=d.slice(0),b=d.slice(0).reverse(),d=d.slice(0).sort(a);if(c&&d&&!(c<d||d<c)||b&&d&&!(b<d||d<b)){column.reverse();a=[];for(f=column.length-1;0<=f;f--)a.push(f)}else{for(var c=column,a=c.slice(0).sort(a),b=[],j=d=0;j<c.length;j++){for(d=g.inArray(c[j],a);-1!=g.inArray(d,b);)d++;b.push(d)}a=b}c=e.slice(0);for(b=0;b<a.length;b++)newIndex=a[b],c[newIndex]=e[b];e=g(c);i.find("tbody").append(e)})}})(jQuery);




// for the stream modules
function get_posts(media, facebook, twitter, itunes, flickr, youtube, keywords, amount) {
     $.ajax({
            type: "GET",
            url: "/suffolkwebdata/resources/Ajax/get_posts.php",
            data: "media="+media+"&facebook="+facebook+"&twitter="+twitter+"&itunes="+itunes+"&flickr="+flickr+"&youtube="+youtube+"&keywords="+keywords+"&amount="+amount,
            success: function(data){
                $('ul.stream').hide().html(data).fadeIn();
             }
    });
    return false;
}

// for the stream modules
function change_radio(me, radio){
    
    var original = '<option value="All" >All</option><option value="Twitter" >Twitter</option><option value="Facebook" >Facebook</option><option value="Flickr" >Flickr</option><option value="YouTube" >YouTube</option><option value="iTunesU" >iTunesU</option>';
    
    var replace = '<option value="All" >All</option><%con_Keywords%>';
    document.getElementById(radio).checked = false;
    
    var list = document.getElementById('topic-list');
    if(radio == 'platform-social'){    
        list.innerHTML = replace;
    }
    else {
        list.innerHTML = original;
    }
}

function send_request(r_email, url, headline, message, form) {
      var request = form.textarea1.value;
      var fname = form.text1.value;
      var lname = form.text2.value;  
      var s_email = form.text3.value;
      var country = form.select1.value;
      var state = form.select2.value;
      var interest = form.select3.value;
     $.ajax({
            type: "GET",
            url: "/suffolkwebdata/resources/Ajax/send_request_email.php",
            data: "fname="+fname+"&lname="+lname+"&s_email="+s_email+"&r_email="+r_email+"&country="+country+"&state="+state+"&interest="+interest+"&message="+request+"&hdl="+headline+"&url="+url,
            success: function(){
                $('div._separator').hide().html(message).fadeIn();
             }
    });
    return false;
}

function check_form(form)
{
var checked = true;  
var email = true;
  
if(form.text1.value == 'First name*'){
    checked = false;  
}
if(form.text2.value == 'Last name*'){
    checked = false;  
}
if(form.text3.value == 'Email address*'){
    checked = false;  
}
if(form.text4.value == 'Confirm email address*'){
    checked = false;  
}
if(form.text4.value != form.text3.value){
    checked = false;
    email = false;
}
if(checked){
    return true;
}
else {
    if(!email){
        alert("Emails do not match");
    }
    else{
        alert("Make sure all required parts are filled out");
    }
}
return false;  
}