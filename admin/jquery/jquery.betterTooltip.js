/*-------------------------------------------------------------------------------
	A Better jQuery Tooltip
	Version 1.0
	By Jon Cazier
	jon@3nhanced.com
	01.22.08
-------------------------------------------------------------------------------*/

$.fn.betterTooltip = function(options){
	
	/* Setup the options for the tooltip that can be 
	   accessed from outside the plugin              */
	var defaults = {
		speed: 200,
		delay: 300
	};
	
	var options = $.extend(defaults, options);
	
	/* Create a function that builds the tooltip 
	   markup. Then, prepend the tooltip to the body */
	getTip = function() {
		var tTip = 
			"<div class='tip'>" +
				"<div class='tipMid'>"	+
				"</div>" +
				"<div class='tipBtm'></div>" +
			"</div>";
		return tTip;
	}
	$("body").prepend(getTip());
	
	/* Give each item with the class associated with 
	   the plugin the ability to call the tooltip    */
	$(this).each(function(){
		
		var $this = $(this);
		var tip = $('.tip');
		var tipInner = $('.tip .tipMid');
		
		var tTitle = (this.title);
		this.title = "";
		
		var offset = $(this).offset();
		var tLeft = offset.left;
		var tTop = offset.top;
		var tWidth = $this.width();
		var tHeight = $this.height();
		
		/* Mouse over and out functions*/
		$this.hover(
			function() {
				tipInner.html(tTitle);
				setTip(tTop, tLeft);
			 	setTimer();
			}, 
			function() {
				stopTimer();
				//tip.hide();
				//tip.fadeOut(slow);
				 tip.animate({opacity: "hide"}, "slow");
				//tip.animate({"top": "+=20px", "opacity": "hide"}, "slow");
			}
		);		   
		
/*********************************************************/
//		$this.hover(
//				function() {
//	   $(this).animate({opacity: "show", top: "-75"}, "slow");
//				}, 
//				function() {
//		$(this).animate({opacity: "hide", top: "-85"}, "fast");
//				}
//			);		
//		
		
//$(this).find("em").animate({opacity: "show", top: "-75"}, "slow");
//		var hoverText = $(this).attr("title");
//	    $(this).find("em").text(hoverText);
//    	}, function() {
//	$(this).find("em").animate({opacity: "hide", top: "-85"}, "fast");		
		
/********************************************************/		
		
		/* Delay the fade-in animation of the tooltip */
		setTimer = function() {
			$this.showTipTimer = setInterval("showTip()", defaults.delay);
		}
		
		stopTimer = function() {
			clearInterval($this.showTipTimer);
		}
		
		/* Position the tooltip relative to the class 
		   associated with the tooltip                */
		setTip = function(top, left){
			var topOffset = tip.height();
			var xTip = (left-60)+"px";
			var yTip = (top-topOffset-60)+"px";
			tip.css({'top' : yTip, 'left' : xTip});
		}
		
		/* This function stops the timer and creates the
		   fade-in animation                          */
		showTip = function(){
			stopTimer();
			tip.animate({"top": "+=20px", "opacity": "toggle"}, defaults.speed);
		// tip.animate({opacity: "show", top: " 75"}, "slow");
		}
	});
};