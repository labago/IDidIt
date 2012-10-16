(function($) {                                          // Compliant with jquery.noConflict()
$.fn.cpwmHpCarousel = function(o) {

    o = $.extend({
	CE: true, //update CE_SNAPSHOT_NAME
        auto: null,
	autopause: 2000,
	autointerval: 2000,
	slidwW: 0,
	slideH: 0, 
	showLoading: false,		
        speed: 500,
	easing: null,
        vertical: false,
        circular: true,
        visible: 3,
        start: 0,
        scroll: 1,

        init: null,
	 present: null,
        beforeStart: null,
        afterEnd: null
    }, o || {});

    return this.each(function() {                           // Returns the element collection. Chainable.

        var container = $(this), div =$("div.homeslider") , ul = $("ul", div), tLi = $("li", ul), tl = tLi.size(),
			nextBtn = $(".next", container), prevBtn = $(".prev", container);

		;

/*
if (o.showLoading && $(o.showLoading).size()) {
	o.showLoading = $('<div/>', {id: "hpcarouselLoading"})
			.css({opacity: "0.5", width: "100%", position: "absolute", zIndex: 20, textAlign: "center"})
			.append(  $('<div/>').append($(o.showLoading).clone())  )
			.append(  $('<div/>').css({ background: "#fff", margin: "auto", width: 300, padding: 10, position: "relative", top: Math.round(-20-o.slideH/2)+"px"}).append($('<div/>').text('One Moment...').css({background: 'url(/text/inc/hpcarousel/loading.gif) no-repeat center left',height: 66, fontSize: "24px", padding: "20px 0 0 80px" })));

	o.showLoading.insertBefore(div);
}
*/

// transparency left right
	$(".trans").css("height", o.slideH+"px");


// sanitize slideH
	o.slideH = (o.slideH>0)?o.slideH:tLi[0].height();

// sanitize slideW
	o.slideW = (o.slideW>0)?o.slideW:tLi[0].width();


/*
not in use - needs diff images
        if(prevBtn.size()) {
		prevBtn.hover( function () {$(this).css('backgroundPosition', '-100px center');}, function () {$(this).css('backgroundPosition', 'left center');} );
	}

        if(nextBtn.size()){
		nextBtn.hover( function () {$(this).css('backgroundPosition', (-200-100+$(this).width())+'px center');}, function () {$(this).css('backgroundPosition', 'right center');}); 
	}
*/
	$(window).resize(function () {
		resize();
	});



		function resize () {
			var contW = container.width(), sliderW = div.width(), offset = ( contW - sliderW ) /2, transW = (Math.round(contW-o.slideW)/2+0.5);

			// set width of slider container to 3 * width of slide
			div.css("width", o.slideW*o.visible+"px");
			// set left margin of slider container so it's centered inside the wrapper
			div.css("marginLeft", offset+"px");
			// set the width of the trans overlays to be half of wrapper width minus one (visible) slide
			$(".trans").css("width", transW+"px");
			$("#transright").css("left", (o.slideW+transW)+"px");
			$("#transleft").css("right", (o.slideW+transW)+"px");
			if (container.width()<o.slideW) {
				$(".trans").css("width", "0px");
				prevBtn.css("left", "0px");
				nextBtn.css("right","0px");
			} else {
				prevBtn.css("left", -30+(Math.round(contW-o.slideW)/2+0.5)+"px");
				nextBtn.css("right",-30+(Math.round(contW-o.slideW)/2+0.0)+"px");
			}
		}

		div.jCarousel({

		start: o.start,
		btnNext: [
				nextBtn, $("#transright")
			],
		btnPrev: [
				prevBtn, $("#transleft")
			],
		CE: o.CE,
		auto: o.auto,
		delay: o.delay,
		autopause: o.autopause,
		autointerval: o.autointerval,
		easing: o.easing,
		speed: o.speed,
		scroll: o.scroll,
		slideH: o.slideH,
		slideW: o.slideW,
		visible: o.visible,
		circular: o.circular,
		beforeStart: function(a) {
			$(".slideOverlays", a[1]).hide();
    		  },

		afterEnd: function(a,curr) {
			if (o.CE) window.CE_SNAPSHOT_NAME = $(a[1]).attr("CEname");
			if ($.browser.msie && parseInt($.browser.version)<9) {
				$(".slideOverlays", a[1]).show();
			} else {
				$(".slideOverlays", a[1]).fadeIn(800);
			}
		},
		present: function () {
					this.hide().css("visibility", "visible").fadeIn(1000);
					$(".arrow").delay(500).fadeIn();
/*					if ($(o.showLoading).size()) o.showLoading.fadeOut('fast');//, function () {o.showLoading.remove()}); */
				},
		init: function(a) {
			container.css("visibility", "visible");
			$(".slideOverlays", a[1]).show();
			if (o.CE) window.CE_SNAPSHOT_NAME = $(a[1]).attr("CEname");
			resize();
		}


		});

    });
};


})(jQuery);