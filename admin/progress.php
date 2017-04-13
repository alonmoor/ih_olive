<!--<html>-->
<!--<head>-->
<!--  <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>-->
<!--  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>-->
<!--  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>-->
<!---->
<!--  <script>-->
<!--    var val = 40;-->
<!---->
<!--    $(document).ready(function() {-->
<!--      $("#progressbar").progressbar({ value: val });-->
<!--      $("#plusTen").bind("click", function ()-->
<!--      {-->
<!--        setValue($( "#progressbar" ), val + 10 );-->
<!--        val += 10;-->
<!--      });-->
<!---->
<!--      $("#minusTen").bind("click", function ()-->
<!--      {-->
<!--        setValue($( "#progressbar" ), val - 10 );-->
<!--        val -= 10;-->
<!--      });-->
<!--    });-->
<!---->
<!--    function setValue(bar, value)-->
<!--    {-->
<!--      if (value > 100)-->
<!--      {-->
<!--        value -= 100;-->
<!--        bar.removeClass("belowMax");-->
<!--        bar.addClass("aboveMax");-->
<!--      }-->
<!--      else-->
<!--      {-->
<!--        bar.removeClass("aboveMax");-->
<!--        bar.addClass("belowMax");-->
<!--      }-->
<!---->
<!--      bar.progressbar( "option", "value", value);-->
<!--    }-->


//(function($) {
//
//       $.widget("ui.progressbar", {
//
//            init: function() {
//
//                 //  wrap the element in the required markup
//
//                 $(this.element)
//
//                     //  build the DIV strucutre
//
//                    .html('<div class="progress-outer"><div class="progress-inner"><div class="progress-indicator"></div></div></div>');
//
//                
//
//               //  kick off the animation
//
//               if(this.options.autostart){
//
//                   this.start();
//
//               }
//
//           },
//
//           
//
//           start: function() {
//
//               var o = this.options;
//
//               
//
//               //  stop the animation if it is runnin
//
//               this.stop();        
//
//               
//
//               //  start the animation
//
//               $('.progress-indicator', this.element)
//
//                   //  queue up the animation function
//
//                   .queue(function(){$.ui.progressbar.animations[o.animation](this, o);})
//
//                   //  and let it rip
//
//                  .dequeue();
//
//           },
//
//           
//
//           stop: function() {
//
//               //  stop the animation and set its width
//
//               //  back to zero
//
//              $('.progress-indicator', this.element).stop(true).width(0);
//
//           }
//
//       });
//
//    
//
//      $.extend($.ui.progressbar, {
//
//          defaults: {
//
//               autostart:true,
//
//              speed:1000,
//
//               animation:'slide'
//         },
//
//          animations : {
//
//               slide: function(e, options) {
//
//                  //  set the width to zero
//
//                  $(e).width(0);    
//
//                  //  animate
//
//                  var args = arguments;
//
//                   $(e).animate({width: $(e).parent().width()}, options.speed, function(){ args.callee.call(this, e, options); } );
//
//              },
//
//              slideback: function(e, options) {
//
//                  //  set the width to zero
//
//                   $(e).width(0);    
//
//                  //  animate
//
//                  var args = arguments;
//
//                   $(e)
//
//                       .animate({width: $(e).parent().width()}, options.speed)
//
//                       .animate({width: 0}, options.speed, function(){ args.callee.call(this, e, options); } );
//
//               },
//
//              slidethru: function(e, options) {
//
//                   //  set the position and left
//
//                   $(e).css({width: 0, position:'absolute', left:'0px'});                     
//
//                   
//
//                   //  animate
//
//                   var args = arguments;
//
//                  $(e)
//
//                       .animate({width: $(e).parent().width()}, options.speed)
//
//                       .animate({left: $(e).parent().width()}, options.speed, function(){ args.callee.call(this, e, options); } );
//
//               },
//
//              fade: function(e, options) {
//
//                   //  set the width to zero
//
//                   $(e).css({width: 0, opacity: '1.0'});  
//
//                              
//
//                   //  animate
//
//                 var args = arguments;
//
//                  $(e)
//
//                      .animate({width: $(e).parent().width()}, options.speed)
//
//                       .animate({opacity: '0.0'}, options.speed, function(){ args.callee.call(this, e, options); });
//
//               }                                                   
//
//           }
//
//       });
//
//  })(jQuery);

<!--  </script>-->

  <style type='text/css'>
 /* 
  
  .ui-progressbar {
 height: 20px;
 width: 50%;
 border: silver 4px solid;
 margin: 0;
 padding: 0;
}
.ui-progressbar-value {
 height: 20px;
 margin: 0;
 padding: 0;
 text-align: right;
 background: #080;
 width: 10%;
}
.ui-progressbar-text {
 position: relative;
 top: -3px;
 left: 0;
 padding: 0 5px;
 font-size: 14px;
 font-weight: bold;
 color: #000;
}
  
  
    #progressbar.aboveMax.ui-progressbar
    {
      background-image: none;
      background-color: #00FF00;
    }

    #progressbar.aboveMax .ui-progressbar-value
    {
      background-image: none;
      background-color: #FF0000;
    }

    #progressbar.belowMax.ui-progressbar
    {
      background-image: none;
      background-color: #FFFFFF;
    }

    #progressbar.belowMax .ui-progressbar-value
    {
      background-image: none;
      background-color: #00FF00;
    }*/
  </style>

<!--</head>-->
<!--<body style="font-size:62.5%;">-->
<!---->
<!--<div id="progressbar" class="ui-progressbar ui-widget ui-widget-content ui-corner-all">-->
<!-- <div class="ui-progressbar-value ui-widget-header ui-corner-left">-->
<!--  <span class="ui-progressbar-text">10%</span>-->
<!-- </div>-->
<!--</div>-->
<!---->
<!--  <div id='progressbar' class='belowMax'></div>-->
<!--  <br />-->
<!--  <input type='button' value='+10' id='plusTen' />-->
<!--  <input type='button' value='-10' id='minusTen' />-->
<!---->
<!--</body>-->
<!--</html>-->
<!-- --------------------------------------------------------------------------------------------------------------------- -->

<html>
    <head>
        
        <title>jQuery UI Progressbar Effects</title>
        
        <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>-->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<!--  <script type="text/javascript" src="progresseffects.js"></script>-->
        
    </head>
    <body>
        
        <div id="progressbar"></div>
                    
    </body>
</html>


<script>

//Create the new progeffects widget by extending  the progressbar.
$.widget('ui.progeffects', $.extend({}, $.ui.progressbar.prototype, {
 
    //We need to redefine the progressbar options and add a duration.
    options: {
        value: 0,
        max: 100,
        duration: 250
    },
    
    //This is used to keep track of the refresh frequency.
    refreshed: 0,
      
    //Initialize our widget by initializing the base progressbar.
    _init: function() {
        $.ui.progressbar.prototype._init.call(this);
    },
    
    //Redefined in our widget to provide animations.
    _refreshValue: function() {
        
        //Some variables we need.
        var value = this.value();
        var percentage = this._percentage();
        var time = new Date().getTime();
        var duration = this.options.duration;
        var max = this.options.max;
        
        //This is part of the default implementation, but still required.
        if ( this.oldValue !== value ) {
            this.oldValue = value;
            this._trigger('change');
        }
        
        //Here, we're making sure the progressbar isn't refreshed more
        //often than the animation duration will allow.
        if (time - this.refreshed < duration && value < max) {
            return;
        }
        
        //Store the time for the next refresh.
        this.refreshed = time;

        //Perform the refresh, using an animation.
        this.valueDiv
            .toggle( value > this.min )
            .toggleClass('ui-corner-right', value === this.options.max)
            .stop()
            .animate({width:percentage.toFixed(0)+'%'}, duration);
            
        this.element.attr('aria-valuenow', value);
    }
        
}));

//Example usage.
$(document).ready(function(){
    
    //Periodic update function to set the value of the progressbar.
    var update = function(){
        var value = $('#progressbar').progeffects('value');
        var max = $('#progressbar').progeffects('option', 'max');
        if (value < max) {
            $('#progressbar').progeffects('value', value + 1);
            setTimeout(update, 100)
        }
    };
    
    //Create the widget and start updating the progress.
    $('#progressbar').progeffects();
    update();




    /****************************************************************/ 
    function updateProgressBar3(prog_bar,taskID) {
    	//$('#progress_'+taskID).hide();
    /* initial value for progressbar */
    var progressvalue = 0;
    /* every 2 seconds progress status will be obtained */
    var myInterval = setInterval(function(){
          /* get progress status */
          
             /* update jQueryUI progressbar */
    	$('#progress_'+taskID).progressbar({
                         value:prog_bar,
             /* onComplete actions */
             complete: function(event, ui) {
                 /* close progressbar */
    		$('#progress_'+taskID).progressbar( "destroy" );
                 /* reset interval */
                 clearInterval(myInterval);
                 /* show the link again */
                 
             }

             });
          
    /* 2 seconds*/
    }, 2000);
    }
    /****************************************************************/ 
    function updateProgressBar4(prog_bar,taskID) {
    	
    var timer = setInterval(function(){
         
        $("#progress_"+taskID+" .ui-progressbar-value").animate({width: prog_bar+"%"}, 500);
        //This does static sets of the value
        $("#progress_"+taskID+" .ui-progressbar-value").progressbar("option","value",prog_bar).css({"width":prog_bar});
       
       clearInterval(timer);
          
    },500);
    }
    ////////////////////////////////////////////////////////////////////////////////////////////
    function updateProgressBar5(prog_bar,taskID) {
      /* initial value for progressbar */
           var progressvalue = 0;
           /* every 2 seconds progress status will be obtained */
           var myInterval = setInterval(function(){
                 /* get progress status */
                
                    /* update jQueryUI progressbar */
                    $('#progress_'+taskID).progressbar({
                                value: prog_bar,
                    /* onComplete actions */
                    complete: function(event, ui) {
                        /* close progressbar */
                        $('#progress_'+taskID).progressbar( "destroy" );
                        /* reset interval */
                        clearInterval(myInterval);
                        /* show the link again */
                        $('#progress_'+taskID).show();
                    }

                    });
                
        /* 2 seconds*/
        }, 2000);

    }




/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    function setValue2(bar, value)
    {
    //  if (value > 100)
    //  {
//        value -= 100;
        bar.removeClass("ui-progressbar-value");
        bar.removeClass("ui-widget-header");
        
//        bar.addClass("aboveMax");
    //  }
    //  else
    //  {
//        bar.removeClass("aboveMax");
//        bar.addClass("belowMax");
    //  }

      bar.progressbar( "option", "value", value);
    }
        
        
    
});


</script>

