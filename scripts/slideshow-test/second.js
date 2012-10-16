(function($) {                                          // Compliant with jquery.noConflict()
$.fn.jCarousel = function(o) {
    o = $.extend({
	 btnNext: false,
	 btnPrev: false,
        mouseWheel: false,
        auto: null,
	delay: 0,
	autopause: 2000,
	autointerval: 2000,
	slidwW: 0,
	slideH: 0, 
        speed: 200,
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
        var running = false, animCss=o.vertical?"top":"left", sizeCss=o.vertical?"height":"width";
        var div = $(this), ul = $("ul", div), tLi = $("li", ul), tl = tLi.size();


	var nextBtn = (o.btnNext.length===undefined)?[o.btnNext]:o.btnNext;
	var prevBtn = (o.btnPrev.length===undefined)?[o.btnPrev]:o.btnPrev;
	nextBtn = $(nextBtn);
	prevBtn = $(prevBtn);

	div.css("visibility", "hidden");


	buttons = $('<div/>', {id:"pagebuttons"}).css({width: tl*38+"px",  textAlign: "center",  margin: "auto"});

	for (var i=0; i<tl;i++) {
		var btn = $('<div/>', {id: "slide"+i}).css({cursor:"pointer", background: "url(test-images/button_sm4.png) no-repeat center bottom", height: 24, width: 24, margin: 2, float: "left"});
		btn.click(function () {			
			suspendAuto();
			o.auto = false;
			go((parseInt(this.id.replace(/slide/,''))+1), true)
		});
		btn.mouseover(function () {
			if ($(this).css("backgroundPosition")!="50% 0%") $(this).css("backgroundPosition","50% 50%");
		});
		btn.mouseout(function () {
			setButtonStates()
		});

		buttons.append(btn);
	}
	buttons.append($('<br clear="both"/>'));
	$(div).append(
		$('<div/>', {id:"buttoncontainer"})
			.css({position: "absolute",zIndex: 25,width:"100%", bottom: "10px"})
			.append(buttons)							
	);


// sanitize slideH
	o.slideH = (o.slideH>0)?o.slideH:tLi[0].height();

// sanitize slideW
	o.slideW = (o.slideW>0)?o.slideW:tLi[0].width();

// set width of each slide
//	tLi.each(function(i,o) {jQuery(o).css("width", o.slideW+"px");});
	div.css("height", o.slideH+"px");

// sanitize o.auto - only if circular
	o.auto = (o.circular)?o.auto:false;

// sanitize o.visible
	o.visible = (o.visible>tl)?tl:o.visible;

// sanitize start to between 0 and tl-1
	o.start= (o.start>tl)?o.start-tl-1:((o.start<0)?0:o.start);

// sanitize scroll to between 1 and vis
	o.scroll = (o.scroll<1)?1:((o.scroll>o.visible)?o.visible:o.scroll);

// if items visible is larger than avail items, don't carousel
	o.circular = (o.visible>tl) ?false :o.circular ;



        if(o.circular) {
	// prepend scroll items , counting from other side
//            ul.prepend(tLi.slice(tl-o.visible).clone())
//              .append(tLi.slice(0,o.visible).clone());

//		console.log("count: "+tl+", prepend: "+(tl-1)+","+tl+", append: 0,"+Math.round(o.visible/2))
            ul.prepend(tLi.slice(tl-Math.round(o.visible/2)).clone())
              .append(tLi.slice(0,Math.round(o.visible/2)).clone());
       	o.start += tl-Math.round(o.visible/2)-1;
       } else {
		if (o.start>0) {
			ul.append(tLi.splice(0,o.start))
		}
		// could have option to fill items so all frames of visible are filled
		if (tl%o.scroll) {
			add = 1+tl-parseInt(tl%o.scroll)*o.scroll;
              	ul.append(tLi.slice(0,add-o.start).clone());
		}
		o.start = 0;
	}

        var li = $("li", ul), itemLength = li.size(), curr = o.start;

        li.css({position: "relative", overflow: "hidden", float: o.vertical ? "none" : "left"});
        ul.css({margin: "0", padding: "0", position: "relative", "list-style-type": "none", "z-index": "1"});
        div.css({overflow: "hidden", position: "relative", "z-index": "2", left: "0px"});

        var liSize = o.vertical ? height(li) : width(li);   // Full li size(incl margin)-Used for animation
        var ulSize = liSize * itemLength;                   // size of full ul(total length, not just for the visible items)
        var divSize = liSize * o.visible;                   // size of entire div(total length for just the visible items)

        li.css({width: li.width(), height: li.height()});
        ul.css(sizeCss, ulSize+"px").css(animCss, -(curr*liSize));

        div.css(sizeCss, divSize+"px");                     // Width of the DIV. length of visible images


       disableNav();


	div.bind('swipeleft', function () {
			this.blur();
  		  suspendAuto();
                return go(curr-o.scroll);
	});
	div.bind('swiperight', function () {
			this.blur();
  		  suspendAuto();
                return go(curr+o.scroll);
	});



        if(prevBtn.size()) {
		prevBtn.each( function (i,e) {
			var btn = (typeof(e)==="string") ? $(e) : e ;
			btn.css({cursor: "pointer"});
			btn.click(function() {
				this.blur();
  		  		suspendAuto();
				o.auto = false;
                		return go(curr-o.scroll);
            		});
		});
	}

        if(nextBtn.size()){
		nextBtn.each( function (i,e) {
			var btn = (typeof(e)==="string") ? $(e) : e ;
			btn.css({cursor: "pointer"});
			btn.click(function() {
				this.blur();
				o.auto = false;
 		 		  suspendAuto();
       		         return go(curr+o.scroll);
            		});
		});
	}


        if(o.mouseWheel && div.mousewheel)
            div.mousewheel(function(e, d) {
  		  suspendAuto();
                return d>0 ? go(curr-o.scroll) : go(curr+o.scroll);
            });


	var imgstoload=$(".homeslider img"), imgsloaded = 0, start = new Date().getTime();
	

	function startandRender() {
		imgsloaded++;
		if (imgstoload.length>imgsloaded) return;
		if(o.auto) o.present.call(div);
		setButtonStates();
		var now = new Date().getTime();
		rotationdelay = ((now-start<o.delay)?o.delay-now+start:0) + o.autointerval+o.speed;
		setTimeout(function () {startAuto();}, rotationdelay);
	}

        if(o.init) o.init.call(this, vis());


	imgstoload.each( function () {
		$(this).load( startandRender());
	});

	

	function setButtonStates() {
		   $('div#pagebuttons div').css({backgroundPosition: "center bottom"});
			var btnidx = curr-1;
				btnidx = (btnidx>=tl)?btnidx-tl:btnidx;
				btnidx = (btnidx<0)?btnidx+tl:btnidx;

		   $($('div#pagebuttons div')[btnidx]).css({backgroundPosition: "center top"});
	}

	 function disableNav() {
                // Disable buttons when the carousel reaches the last/first, and enable when not
                if(!o.circular) {
                    $(o.btnPrev + "," + o.btnNext).removeClass("disabled");
                    $( (curr==0 && o.btnPrev)
                        ||
                       (itemLength-curr<=o.visible && o.btnNext)
                        ||
                       []
                     ).addClass("disabled");
                }
	 }

	 function startAuto() {
	     if (!o.auto) return;
                go(curr+o.scroll);
            o.interval = setInterval(function() {
                go(curr+o.scroll);
            }, o.autointerval+o.speed);
	 }

	 function suspendAuto() {
            clearInterval(o.interval);
	     clearTimeout(o.timeout);
	     if (!o.auto) return;
	     o.timeout = setTimeout(function () {startAuto(); }, o.autopause);
	 }


        function vis() {
            return li.slice(curr).slice(0,o.visible);
        };

        function go(to, nav) {
		to = parseInt(to);
            if(!running) {
                if(o.beforeStart) o.beforeStart.call(this, vis());

		var offset = 0;
                if(o.circular) {            // If circular we are in first or last, then goto the other end

if (nav) {

	if (Math.abs(to-curr)>1) {
		curr = (curr>to) ? 1+to: to-1; 
	}
       ul.css(animCss, -(curr*liSize)+"px");
	curr = to;

} else {
                	if(o.scroll>curr) {           // If first, then goto last
			offset = ((curr+tl)*liSize);
                       ul.css(animCss, -offset+"px");
                       curr = to + tl;
                    } else if(to+o.visible>itemLength) { // If last, then goto first
			offset = ( (curr-tl) * liSize );
                        ul.css(animCss, -offset + "px" );
                        curr = to-tl;
                    } else {
				curr = to;
			}

			if (o.auto==="once" && curr==1+tl) {
				suspendAuto();
				o.auto = false;
			}
}
                } else {                    // If non-circular and to points to first or last, we just return.

                    if(0>to) to=0; // return; // can't pass initial start position
		      if (to+o.visible>=itemLength) to=(itemLength-o.visible); //return ; // can't pass end
                    
			curr = to;
                }                           // If neither overrides it, the curr will still be "to" and we can proceed.
                running = true;

		curr = parseInt(curr);

                anim = (animCss == "left") ? { left: -(curr*liSize) } : { top: -(curr*liSize) } ;
			setButtonStates()
                ul.animate(
                    anim , o.speed, o.easing,
                    function() {
                        if(o.afterEnd) o.afterEnd.call(this, vis(), curr);
			   disableNav();
                        running = false;
                    }
                );

            }
            return false;
        };
    });
};


function css(el, prop) {
    return parseInt($.css(el[0], prop)) || 0;
};
function width(el) {
    return  el[0].offsetWidth + css(el, 'marginLeft') + css(el, 'marginRight');
};
function height(el) {
    return el[0].offsetHeight + css(el, 'marginTop') + css(el, 'marginBottom');
};


})(jQuery);