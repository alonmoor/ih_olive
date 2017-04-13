////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$(document).ready(function() {//SHOW_DECISIONS
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$('form.paginated').each(function() {
	 
	//SET PAGER VARS
	var currentPage = 0;
	var numPerPage = 1;
	 var lastPage = 1;
	 var num='';
	//STORE EVENT CONTEXT, $ul
	var $form = $(this);
	
	//BIND EVENT TO repaginate, show CURRENT, hide OTHERS
	$form.bind('repaginate', function() {
		$form.find('div.div_count_dec').show()
			.slice(0, currentPage * numPerPage)
				.hide()
			.end()
			.slice((currentPage + 1) * numPerPage)
				.hide()
			.end();
		//$(this).addClass('hover').css({'color' : 'black'}).siblings().css({'color' : 'red'}).removeClass('hover');
	});
	
	
	
	//CALCULATE NUMBER OF PAGES, numRows / numPerPage
	var numRows = $form.find('div.div_count_dec').length;
	if(numRows>1){ 
	var numPages = Math.ceil(numRows / numPerPage);

	//CREATE PAGE NUMBERS, THEN insertAfter($ul)
	var $pager = $('<div class="pager"></div>').draggable();

	
	
	
////////////////////////////////////////////////////////////////////////////////////////////	
	
	$('<span id="page_number_prev" style="float:right;">« הקודם</span>')
	.bind('click', {'newPage': page}, function(event) {
		currentPage = lastPage-1;
		lastPage=lastPage-1;  
		num=parseInt(lastPage);
 
		
		
		if(num>=9){ 
			$form.trigger('repaginate');
			  $(this).addClass('active')
	            .siblings().removeClass('active');
			   $("span#"+num).addClass('hover')
			   .css({'color' : 'black','display' : 'inline'})
			   .siblings().css({'color' : 'red'}).removeClass('hover') ;
			   
			   $("span#"+(num+1)).hide();
			  
			   
				 
			}else if(!(num<0)){
				$form.trigger('repaginate');
				$("span#page_number_prev").show();
				
				$(this).addClass('active')
	            .siblings().removeClass('active');
			   $("span#"+num).addClass('hover')
			   .css({'color' : 'black' , 'display' : 'inline'})
			   .siblings().css({'color' : 'red'}).removeClass('hover') ;
			  
			}
		if(num<0){
			
			$("span#page_number_prev").hide();
			
		}	
		
		
		
		
		
		
		
		
		
		 $("span#page-number").show(); 
		$("span#final").css('color','black').show();
		
		  $(this).addClass('active')
            .siblings().removeClass('active');
		   $("span#"+num).addClass('hover').css({'color' : 'black'}).siblings().css({'color' : 'red'}).removeClass('hover') ;
		   $("span#final").css('color','black');
        }).appendTo($pager).addClass('clickable').css({ 'color':'red' }) ;
	
//////////////////////////////////////////////////////////////////////////////////////////	
		
	
	for (var page = 0; page < numPages; page++) {
		
		
		
		
	if(page <10){
				
		$('<span class="page-number" id= '+parseInt(page)+'>' + (page + 1) + '</span>')
		.bind('click', {'newPage': page}, function(event) {
			
		
			
			$("span#page_number_prev").show();
			$("span#page-number").show();
			$("span#final").show();
		 	 
			
			
	   		if(this.id==(numRows-1)){
	 
					 
				    $("span#page-number").hide();
					$("span#final").hide();
			    }		 
		

	   		

	   		if( (this.id<(10) ) ){ 
	   				
	   			var spans = $('.page-number').map(function(){
		            if (this.id > 10) return this;
		       }).get();		 
	   				if(spans)
	   					$(spans).fadeOut("slow");	
	   		
	   			$("span#"+9).show();
				
		    }		 

	   		
	   		
	   		
	            
			currentPage = event.data['newPage'];
			 lastPage = currentPage;
			$form.trigger('repaginate');
			
			$(this).addClass('active')
	           .siblings().removeClass('active');
			  $(this).addClass('hover').css({'color' : 'black'}).siblings().css({'color' : 'red'}).removeClass('hover') ;
			  $("span#final").css('color','black');
			  
			  
			  
		}).appendTo($pager).addClass('clickable').css({'float' : 'right' , 'color':'red' }) ;
		}else{
			$('<span class="page-number" id= '+parseInt(page)+'   style="display:none;">' + (page + 1) + '</span>')
			.bind('click', {'newPage': page}, function(event) {
				
				currentPage = event.data['newPage'];
			   lastPage = currentPage;
				$form.trigger('repaginate');
		
				$(this).addClass('active')
		           .siblings().removeClass('active');
				  $(this).addClass('hover').css({'color' : 'black'}).siblings().css({'color' : 'red'}).removeClass('hover') ;
				  $("span#final").css('color','black');
			}).appendTo($pager).addClass('clickable').css({'float' : 'right' , 'color':'red' }) ;
			}
			
	}
	
	
//////////////////////////////////////////////////////////////////////////////////////////
	$('<span id="final" style="color:black;font-weight:bold;">...</span>').appendTo($pager);
	
//////////////////////////////////////////////////////////////////////////////////////////	
	
	$('<span id="page-number" style="margin-left:15px;"> הבא » </span>')
	.bind('click', {'newPage': page}, function(event) {
		
		$("span#page_number_prev").show();
		
		currentPage = lastPage+1;
		lastPage=lastPage+1;  
		num=parseInt(lastPage);
		$form.trigger('repaginate');
		if(num>=10){ 
		  $(this).addClass('active')
            .siblings().removeClass('active');
		   $("span#"+num).addClass('hover')
		   .css({'color' : 'black','display' : 'inline'})
		   .siblings().css({'color' : 'red'}).removeClass('hover') ;
		   
		   $("span#"+(num-1)).hide();
		   $("span#final").css('color','black');   
		   
		}else{
			$("span#page-number").show();
			$("span#final").show();
			$(this).addClass('active')
            .siblings().removeClass('active');
		   $("span#"+num).addClass('hover')
		   .css({'color' : 'black' , 'display' : 'inline'})
		   .siblings().css({'color' : 'red'}).removeClass('hover') ;
		   $("span#final").css('color','black');
		}
		
		if(num==numRows-1){
			
			$("span#page-number").hide();
			$("span#final").hide();
		}	
		
    }).appendTo($pager).addClass('clickable').css({'color':'red' }) ;
	
	
	
//////////////////////////////////////////////////////////////////////////////////////////	 
	
	
	
	$pager.insertBefore($form).find('span.page-number:first').addClass('active');
	//TRIGGER EVENT
	$form.trigger('repaginate');
	}
});
});


















///////////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$(document).ready(function() {//SHOW_DECISIONS
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$('div.paginated').each(function() {
	 
	//SET PAGER VARS
	var currentPage = 0;
	var numPerPage = 1;
	 var lastPage = 1;
	 var num='';
	//STORE EVENT CONTEXT, $ul
	var $form = $(this);
	
	//BIND EVENT TO repaginate, show CURRENT, hide OTHERS
	$form.bind('repaginate', function() {
		$form.find('div.div_count_dec').show()
			.slice(0, currentPage * numPerPage)
				.hide()
			.end()
			.slice((currentPage + 1) * numPerPage)
				.hide()
			.end();
		//$(this).addClass('hover').css({'color' : 'black'}).siblings().css({'color' : 'red'}).removeClass('hover');
	});
	
	
	
	//CALCULATE NUMBER OF PAGES, numRows / numPerPage
	var numRows = $form.find('div.div_count_dec').length;
	if(numRows>1){ 
	var numPages = Math.ceil(numRows / numPerPage);

	//CREATE PAGE NUMBERS, THEN insertAfter($ul)
	var $pager = $('<div class="pager"></div>').draggable();

	
	
	
////////////////////////////////////////////////////////////////////////////////////////////	
	
	$('<span id="page_number_prev" style="float:right;">« הקודם</span>')
	.bind('click', {'newPage': page}, function(event) {
		currentPage = lastPage-1;
		lastPage=lastPage-1;  
		num=parseInt(lastPage);
 
		
		
		if(num>=9){ 
			$form.trigger('repaginate');
			  $(this).addClass('active')
	            .siblings().removeClass('active');
			   $("span#"+num).addClass('hover')
			   .css({'color' : 'black','display' : 'inline'})
			   .siblings().css({'color' : 'red'}).removeClass('hover') ;
			   
			   $("span#"+(num+1)).hide();
			  
			   
				 
			}else if(!(num<0)){
				$form.trigger('repaginate');
				$("span#page_number_prev").show();
				
				$(this).addClass('active')
	            .siblings().removeClass('active');
			   $("span#"+num).addClass('hover')
			   .css({'color' : 'black' , 'display' : 'inline'})
			   .siblings().css({'color' : 'red'}).removeClass('hover') ;
			  
			}
		if(num<0){
			
			$("span#page_number_prev").hide();
			
		}	
		
		
		
		
		
		
		
		
		
		 $("span#page-number").show(); 
		$("span#final").css('color','black').show();
		
		  $(this).addClass('active')
            .siblings().removeClass('active');
		   $("span#"+num).addClass('hover').css({'color' : 'black'}).siblings().css({'color' : 'red'}).removeClass('hover') ;
		   $("span#final").css('color','black');
        }).appendTo($pager).addClass('clickable').css({ 'color':'red' }) ;
	
//////////////////////////////////////////////////////////////////////////////////////////	
		
	
	for (var page = 0; page < numPages; page++) {
		
		
		
		
	if(page <10){
				
		$('<span class="page-number" id= '+parseInt(page)+'>' + (page + 1) + '</span>')
		.bind('click', {'newPage': page}, function(event) {
			
		
			
			$("span#page_number_prev").show();
			$("span#page-number").show();
			$("span#final").show();
		 	 
			
			
	   		if(this.id==(numRows-1)){
	 
					 
				    $("span#page-number").hide();
					$("span#final").hide();
			    }		 
		

	   		

	   		if( (this.id<(10) ) ){ 
	   				
	   			var spans = $('.page-number').map(function(){
		            if (this.id > 10) return this;
		       }).get();		 
	   				if(spans)
	   					$(spans).fadeOut("slow");	
	   		
	   			$("span#"+9).show();
				
		    }		 

	   		
	   		
	   		
	            
			currentPage = event.data['newPage'];
			 lastPage = currentPage;
			$form.trigger('repaginate');
			
			$(this).addClass('active')
	           .siblings().removeClass('active');
			  $(this).addClass('hover').css({'color' : 'black'}).siblings().css({'color' : 'red'}).removeClass('hover') ;
			  $("span#final").css('color','black');
			  
			  
			  
		}).appendTo($pager).addClass('clickable').css({'float' : 'right' , 'color':'red' }) ;
		}else{
			$('<span class="page-number" id= '+parseInt(page)+'   style="display:none;">' + (page + 1) + '</span>')
			.bind('click', {'newPage': page}, function(event) {
				
				currentPage = event.data['newPage'];
			   lastPage = currentPage;
				$form.trigger('repaginate');
		
				$(this).addClass('active')
		           .siblings().removeClass('active');
				  $(this).addClass('hover').css({'color' : 'black'}).siblings().css({'color' : 'red'}).removeClass('hover') ;
				  $("span#final").css('color','black');
			}).appendTo($pager).addClass('clickable').css({'float' : 'right' , 'color':'red' }) ;
			}
			
	}
	
	
//////////////////////////////////////////////////////////////////////////////////////////
	$('<span id="final" style="color:black;font-weight:bold;">...</span>').appendTo($pager);
	
//////////////////////////////////////////////////////////////////////////////////////////	
	
	$('<span id="page-number" style="margin-left:15px;"> הבא » </span>')
	.bind('click', {'newPage': page}, function(event) {
		
		$("span#page_number_prev").show();
		
		currentPage = lastPage+1;
		lastPage=lastPage+1;  
		num=parseInt(lastPage);
		$form.trigger('repaginate');
		if(num>=10){ 
		  $(this).addClass('active')
            .siblings().removeClass('active');
		   $("span#"+num).addClass('hover')
		   .css({'color' : 'black','display' : 'inline'})
		   .siblings().css({'color' : 'red'}).removeClass('hover') ;
		   
		   $("span#"+(num-1)).hide();
		   $("span#final").css('color','black');   
		   
		}else{
			$("span#page-number").show();
			$("span#final").show();
			$(this).addClass('active')
            .siblings().removeClass('active');
		   $("span#"+num).addClass('hover')
		   .css({'color' : 'black' , 'display' : 'inline'})
		   .siblings().css({'color' : 'red'}).removeClass('hover') ;
		   $("span#final").css('color','black');
		}
		
		if(num==numRows-1){
			
			$("span#page-number").hide();
			$("span#final").hide();
		}	
		
    }).appendTo($pager).addClass('clickable').css({'color':'red' }) ;
	
	
	
//////////////////////////////////////////////////////////////////////////////////////////	 
	
	
	
	$pager.insertBefore($form).find('span.page-number:first').addClass('active');
	//TRIGGER EVENT
	$form.trigger('repaginate');
	}
});
});
