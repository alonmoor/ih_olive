 
 
//	$(document).ready(function(){
//		$('#content_page').pager('tr.page_tr');
//	});
 




/*********************************/
//$(document).ready(function() {
//  $('table.paginated').each(function() {
//	 // var decID = document.getElementById('decID').value; 
//	  //alert(decID);
//    var currentPage = 0;
//    var numPerPage = 5;
//    var $table = $(this);
//    $table.bind('repaginate', function() {
//      $table.find('tbody tr.page_tr').hide()
//     
//        .slice(currentPage * numPerPage,
//          (currentPage + 1) * numPerPage)
//        .show();
//    });
//    
//    
//    
//    
//    
//    var numRows = $table.find('tbody tr.page_tr').length;
//    
//    var numPages = Math.ceil(numRows / numPerPage);
//   // alert(numPages);
//    var $pager = $('<div class="pager"></div>');
//    for (var page = 0; page < numPages; page++) {
//      $('<span class="page-number"></span>').text(page + 1)
//        .bind('click', {newPage: page}, function(event) {
//          currentPage = event.data['newPage'];
//         $table.trigger('repaginate');
//          
//        	 
//        	 
//          $(this).addClass('active')
//            .siblings().removeClass('active');
//        }).appendTo($pager).addClass('clickable');
//    }
//    $pager.find('span.page-number:first').addClass('active').css({'border' : 'solid #C81ED2 3px'})
//	
//	 .css({'float' : 'right'})
// 	//.css({'color' : 'red'})
//	 .css({'margin-right' : '30px'})
//	//.css({'margin-left' : '50px'})
//	//.css({'bottom' : '10px'}) 
//	.css({'top' : '200px'}) 
//	// .css({'dispaly' : 'block'}) 
//	      	 
//	;
//    $pager.insertBefore($table)
//      .find('span.page-number:first').addClass('active');
//  });
//});
 
/*********************************************************************************************/


//$(document).ready(function() { 
//       $('table.paginated').each(function() {
//          var currentPage = 0;
//  var numPerPage = 10;  var $table = $(this); 
// var repaginate = function() {         
//     $table.find('tbody tr.page_tr').hide().slice(currentPage * numPerPage,(currentPage + 1) * numPerPage).show();};
// var numRows = $table.find('tbody tr.page_tr').length; 
// var numPages = Math.ceil(numRows / numPerPage);  
//var $pager = $('<div class="pager"></div>');  
// for(var page = 0; page < numPages; page++) {    
// $('<span class="page-number"></span>').text(page + 1)              
//  .bind('click', {newPage: page}, function(event) {  currentPage = event.data['newPage'];            
//    repaginate();  $(this).addClass('active').siblings().removeClass('active');  }).appendTo($pager).addClass('clickable'); }     
// //$pager.insertBefore($table).clone(true).insertAfter($table)     .find('span.page-number:first').addClass('active'); });});
//
//
//$pager.insertBefore($table)  .clone(true)    .insertAfter($table)    .find('span.page-number:first')    .addClass('active')    .end()  .addClass('active');
//});
// });
//




/******************************************/


//$(document).ready(function() {
//				//TARGET PAGER
//	               $('table.paginated').each(function() {
//					//SET PAGER VARS
//					var currentPage = 0;
//					var numPerPage = 4;
//					//STORE EVENT CONTEXT, $ul
//					var $table = $(this);
//					//BIND EVENT TO repaginate, show CURRENT, hide OTHERS
//					$table.bind('repaginate', function() {
//						$table.find('tbody tr.page_tr').show()
//							.slice(0, currentPage * numPerPage)
//								.hide()
//							.end()
//							.slice((currentPage + 1) * numPerPage)
//								.hide()
//							.end();
//					});
//					//CALCULATE NUMBER OF PAGES, numRows / numPerPage
//				//	var numRows = $ul.find('li').length;
//					var numRows = $table.find('tbody tr.page_tr').length;
//					var numPages = Math.ceil(numRows / numPerPage);
//					//CREATE PAGE NUMBERS, THEN insertAfter($ul)
//					var $pager = $('<div class="pager"></div>');
//					for (var page = 0; page < numPages; page++) {
//						$('<span class="page-number">' + (page + 1) + '</span>')
//						.bind('click', {'newPage': page}, function(event) {
//							currentPage = event.data['newPage'];
//							$table.trigger('repaginate');
//							$(this).addClass('active').siblings().removeClass('active');
//						})
//						.appendTo($pager).addClass('clickable');
//					}
//					$pager.find('span.page-number:first').addClass('active');
//					$pager.insertAfter($table);
//					//TRIGGER EVENT
//					$table.trigger('repaginate');
//				});
//			});

/***********************************************************************************************************/
//$(document).ready(function() {
//				//TARGET PAGER
//				$('ul.paginated').each(function() {
//					//SET PAGER VARS
//					var currentPage = 0;
//					var numPerPage = 10;
//					//STORE EVENT CONTEXT, $ul
//					var $ul = $(this);
//					//BIND EVENT TO repaginate, show CURRENT, hide OTHERS
//					$ul.bind('repaginate', function() {
//						$ul.find('li.li_page').show()
//							.slice(0, currentPage * numPerPage)
//								.hide()
//							.end()
//							.slice((currentPage + 1) * numPerPage)
//								.hide()
//							.end();
//					});
//					//CALCULATE NUMBER OF PAGES, numRows / numPerPage
//					var numRows = $ul.find('li.li_page').length;
//					var numPages = Math.ceil(numRows / numPerPage);
//					//CREATE PAGE NUMBERS, THEN insertAfter($ul)
//					var $pager = $('<div class="pager"></div>');
//					for (var page = 0; page < numPages; page++) {
//						$('<span class="page-number">' + (page + 1) + '</span>')
//						.bind('click', {'newPage': page}, function(event) {
//							currentPage = event.data['newPage'];
//							$ul.trigger('repaginate');
//							$(this).addClass('active').siblings().removeClass('active');
//						})
//						.appendTo($pager).addClass('clickable');
//					}
//					$pager.find('span.page-number:first').addClass('active');
//					$pager.insertAfter($ul);
//					//TRIGGER EVENT
//					$ul.trigger('repaginate');
//				});
//			});
/********************************************************************/
//UL
$(document).ready(function() {
	//TARGET PAGER
	$('ul.paginated').each(function() {
		//SET PAGER VARS
		var currentPage = 0;
		var numPerPage = 20;
		//STORE EVENT CONTEXT, $ul
		var $ul = $(this);
		//BIND EVENT TO repaginate, show CURRENT, hide OTHERS
		$ul.bind('repaginate', function() {
			$ul.find('li.li_page').show()
				.slice(0, currentPage * numPerPage)
					.hide()
				.end()
				.slice((currentPage + 1) * numPerPage)
					.hide()
				.end();
		});
		//CALCULATE NUMBER OF PAGES, numRows / numPerPage
		var numRows = $ul.find('li.li_page').length;
		var numPages = Math.ceil(numRows / numPerPage);
		//CREATE PAGE NUMBERS, THEN insertAfter($ul)
		var $pager = $('<div class="pager"></div>');
		for (var page = 0; page < numPages; page++) {
			$('<span class="page-number">' + (page + 1) + '</span>')
			.bind('click', {'newPage': page}, function(event) {
				currentPage = event.data['newPage'];
				$ul.trigger('repaginate');
				$(this).addClass('active').siblings().removeClass('active');
				$(this).addClass('hover').css({'color' : 'black'}).siblings().css({'color' : '#0063DC'}).removeClass('hover') ;
			})
			.appendTo($pager).addClass('clickable').css({'border' : 'solid #C81ED2 3px'})
			.css({'float' : 'right'})
			.css({'color' : 'red'})
			;
		}
		$pager.find('span.page-number:first').addClass('active').css({'border' : 'solid #C81ED2 3px'})
		
		 //.css({'float' : 'right'})
	 	//.css({'color' : 'red'})
    	 .css({'margin-right' : '30px'})
    	//.css({'margin-left' : '50px'})
    	//.css({'bottom' : '10px'}) 
    	.css({'top' : '200px'}) 
    	// .css({'dispaly' : 'block'}) 
    	      	 
		;
		$pager.insertAfter($ul);
		//TRIGGER EVENT
		$ul.trigger('repaginate');
	});
});//end UL
/*********************************************************************************************************/
//OL
$(document).ready(function() {
	//TARGET PAGER
	$('ol.paginated').each(function() {
		//SET PAGER VARS
		var currentPage = 0;
		var numPerPage = 10;
		//STORE EVENT CONTEXT, $ul
		var $ul = $(this);
		//BIND EVENT TO repaginate, show CURRENT, hide OTHERS
		$ul.bind('repaginate', function() {
			$ul.find('li.li_page').show()
				.slice(0, currentPage * numPerPage)
					.hide()
				.end()
				.slice((currentPage + 1) * numPerPage)
					.hide()
				.end();
		});
		//CALCULATE NUMBER OF PAGES, numRows / numPerPage
		var numRows = $ul.find('li.li_page').length;
		var numPages = Math.ceil(numRows / numPerPage);
		//CREATE PAGE NUMBERS, THEN insertAfter($ul)
		var $pager = $('<div class="pager"></div>');
		for (var page = 0; page < numPages; page++) {
			$('<span class="page-number" id="page_'+page+'">' + (page + 1) + '</span>')
			.bind('click', {'newPage': page}, function(event) {
				currentPage = event.data['newPage'];
				$ul.trigger('repaginate');
				$(this).addClass('active').siblings().removeClass('active');
				$(this).addClass('hover').css({'color' : 'black'}).siblings().css({'color' : '#0063DC'}).removeClass('hover') ;
			})
			.appendTo($pager).addClass('clickable').css({'border' : 'solid #C81ED2 3px'})
			.css({'float' : 'right'})
			.css({'color' : 'red'})
			;
		}
		$pager.find('span.page-number:first').addClass('active').css({'border' : 'solid #C81ED2 3px'})
		
		 //.css({'float' : 'right'})
	 	//.css({'color' : 'red'})
    	 .css({'margin-right' : '30px'})
    	//.css({'margin-left' : '50px'})
    	//.css({'bottom' : '10px'}) 
    	.css({'top' : '200px'}) 
    	// .css({'dispaly' : 'block'}) 
    	      	 
		;
		$pager.insertAfter($ul);
		//TRIGGER EVENT
		$ul.trigger('repaginate');
	});
});//end OL
/*********************************************************************************************************/
//$(document).ready(function() {
//	  $('table.paginated').each(function() {
//	    var currentPage = 0;
//	    var numPerPage = 2;
//	    var $table = $(this);
//	    $table.bind('repaginate', function() {
//	      $table.find('tbody tr.page_tr').hide()
//	        .slice(currentPage * numPerPage,
//	          (currentPage + 1) * numPerPage)
//	        .show();
//	    });
//	    var numRows = $table.find('tbody tr.page_tr').length;
//	    var numPages = Math.ceil(numRows / numPerPage);
//	    var $pager = $('<div class="pager"></div>');
//	    for (var page = 0; page < numPages; page++) {
//	      $('<span class="page-number"></span>').text(page + 1)
//	        .bind('click', {newPage: page}, function(event) {
//	          currentPage = event.data['newPage'];
//	          $table.trigger('repaginate');
//	          $(this).addClass('active')
//	            .siblings().removeClass('active');
//	        }).appendTo($pager).addClass('clickable');
//	    }
//	    $pager.insertBefore($table)
//	      .find('span.page-number:first').addClass('active');
//	  });
//	});
/****************************************************************************************/

//OL
$(document).ready(function() {
	//TARGET PAGER
	$('table2.paginated').each(function() {
		//SET PAGER VARS
		var currentPage = 0;
		var numPerPage = 2;
		//STORE EVENT CONTEXT, $ul
		var $ul = $(this);
		//BIND EVENT TO repaginate, show CURRENT, hide OTHERS
		$ul.bind('repaginate', function() {
			$ul.find('tr.page_tr').show()
				.slice(0, currentPage * numPerPage)
					.hide()
				.end()
				.slice((currentPage + 1) * numPerPage)
					.hide()
				.end();
		});
		//CALCULATE NUMBER OF PAGES, numRows / numPerPage
		var numRows = $ul.find('tr.page_tr').length;
		var numPages = Math.ceil(numRows / numPerPage);
		//CREATE PAGE NUMBERS, THEN insertAfter($ul)
		var $pager = $('<div class="pager"></div>');
		for (var page = 0; page < numPages; page++) {
			$('<span class="page-number" id="page_'+page+'">' + (page + 1) + '</span>')
			.bind('click', {'newPage': page}, function(event) {
				currentPage = event.data['newPage'];
				$ul.trigger('repaginate');
				$(this).addClass('active').siblings().removeClass('active');
				$(this).addClass('hover').css({'color' : 'black'}).siblings().css({'color' : '#0063DC'}).removeClass('hover') ;
			})
			.appendTo($pager).addClass('clickable').css({'border' : 'solid #C81ED2 3px'})
			.css({'float' : 'right'})
			.css({'color' : 'red'})
			;
		}
		$pager.find('span.page-number:first').addClass('active').css({'border' : 'solid #C81ED2 3px'})
		
		 //.css({'float' : 'right'})
	 	//.css({'color' : 'red'})
    	 .css({'margin-right' : '30px'})
    	//.css({'margin-left' : '50px'})
    	//.css({'bottom' : '10px'}) 
    	.css({'top' : '200px'}) 
    	// .css({'dispaly' : 'block'}) 
    	      	 
		;
		$pager.insertAfter($ul);
		//TRIGGER EVENT
		$ul.trigger('repaginate');
	});
});//end OL
/*****************************************************************************************/

//to anable/disable
 
//$(document).ready(function() {
//	//TARGET PAGER
//	$('table.paginated').each(function() {
//		//SET PAGER VARS
//		var currentPage = 0;
//		var numPerPage = 10;
//		//STORE EVENT CONTEXT, $ul
//		var $table = $(this);
//		//BIND EVENT TO repaginate, show CURRENT, hide OTHERS
//		$table.bind('repaginate', function() {
//			$table.find('tr.page_tr').show()
//				.slice(0, currentPage * numPerPage)
//					.hide()
//				.end()
//				.slice((currentPage + 1) * numPerPage)
//					.hide()
//				.end();
//		});
//		//CALCULATE NUMBER OF PAGES, numRows / numPerPage
// 		var numRows = $table.find('tr.page_tr').length;
// 		var numPages = Math.ceil(numRows / numPerPage);
// 		//CREATE PAGE NUMBERS, THEN insertAfter($ul)
// 		var $pager = $('<div class="pager"></div>');
//		for (var page = 0; page < numPages; page++) {
//			$('<span class="page-number">' + (page + 1) + '</span>')
//			.bind('click', {'newPage': page}, function(event) {
//				currentPage = event.data['newPage'];
//				$table.trigger('repaginate');
//				$(this).addClass('active').siblings().removeClass('active');
//				$(this).addClass('hover').css({'color' : 'black'}).siblings().css({'color' : '#0063DC'}).removeClass('hover') ;
//			})
//			.appendTo($pager).addClass('clickable');
//		}
// 		$pager.find('span.page-number:first').addClass('active');
///****************************************************/
// //this line make problem
// 		$pager.insertAfter($ul);
///*****************************************************/ 		
////		//TRIGGER EVENT
// 	$table.trigger('repaginate');
//	});
//});
// 


/********************************database******************************************************/

/**************************************************************************************************/
//OL
//$(document).ready(function() {
//	//TARGET PAGER
//	$('form.paginated').each(function() {
//		 
//		//SET PAGER VARS
//		var currentPage = 0;
//		var numPerPage = 10;
//		//STORE EVENT CONTEXT, $ul
//		var $form = $(this);
//		
//		//BIND EVENT TO repaginate, show CURRENT, hide OTHERS
//		$form.bind('repaginate', function() {
//			$form.find('div.primaryNode').show()
//				.slice(0, currentPage * numPerPage)
//					.hide()
//				.end()
//				.slice((currentPage + 1) * numPerPage)
//					.hide()
//				.end();
//		});
//		//CALCULATE NUMBER OF PAGES, numRows / numPerPage
//		var numRows = $form.find('div.primaryNode').length;
//		var numPages = Math.ceil(numRows / numPerPage);
//		//CREATE PAGE NUMBERS, THEN insertAfter($ul)
//		var $pager = $('<div class="pager"></div>');
//		for (var page = 0; page < numPages; page++) {
//			$('<span class="page-number">' + (page + 1) + '</span>')
//			.bind('click', {'newPage': page}, function(event) {
//				currentPage = event.data['newPage'];
//				$form.trigger('repaginate');
//				$(this).addClass('active').siblings().removeClass('active');
//				$(this).addClass('hover').css({'color' : 'black'}).siblings().css({'color' : '#0063DC'}).removeClass('hover') ;
//			})
//			.appendTo($pager).addClass('clickable').css({'border' : 'solid #C81ED2 3px'})
//			.css({'float' : 'right'})
//			.css({'color' : 'red'})
//			;
//		}
//		$pager.find('span.page-number:first').addClass('active').css({'border' : 'solid #C81ED2 3px'})
//		 .css({'margin-right' : '30px'})
//    	.css({'top' : '200px'}) ;
//		$pager.insertAfter($form);
//		//TRIGGER EVENT
//		$form.trigger('repaginate');
//	});
//	
//});//end OL
/*********************************************************************************************************/





/*********************************************************************************************************/
//OL
$(document).ready(function() {
	//TARGET PAGER
	$('table2.paginated').each(function() {
		//SET PAGER VARS
		var currentPage = 0;
		var numPerPage = 8;
		//STORE EVENT CONTEXT, $ul
		var $ul = $(this);
		//BIND EVENT TO repaginate, show CURRENT, hide OTHERS
		$ul.bind('repaginate', function() {
			$ul.find('tr.tr_page').show()
				.slice(0, currentPage * numPerPage)
					.hide()
				.end()
				.slice((currentPage + 1) * numPerPage)
					.hide()
				.end();
		});
		//CALCULATE NUMBER OF PAGES, numRows / numPerPage
		var numRows = $ul.find('tr.tr_page').length;
		var numPages = Math.ceil(numRows / numPerPage);
		//CREATE PAGE NUMBERS, THEN insertAfter($ul)
		var $pager = $('<div class="pager"></div>');
		for (var page = 0; page < numPages; page++) {
			$('<span class="page-number" id="page_'+page+'">' + (page + 1) + '</span>')
			.bind('click', {'newPage': page}, function(event) {
				currentPage = event.data['newPage'];
				$ul.trigger('repaginate');
				$(this).addClass('active').siblings().removeClass('active');
				$(this).addClass('hover').css({'color' : 'black'}).siblings().css({'color' : '#0063DC'}).removeClass('hover') ;
			})
			.appendTo($pager).addClass('clickable').css({'border' : 'solid #C81ED2 3px'})
			.css({'float' : 'right'})
			.css({'color' : 'red'})
			;
		}
		$pager.find('span.page-number:first').addClass('active').css({'border' : 'solid #C81ED2 3px'})
		
		 //.css({'float' : 'right'})
	 	//.css({'color' : 'red'})
    	 .css({'margin-right' : '30px'})
    	//.css({'margin-left' : '50px'})
    	//.css({'bottom' : '10px'}) 
    	.css({'top' : '200px'}) 
    	// .css({'dispaly' : 'block'}) 
    	      	 
		;
		$pager.insertBefore($ul);
		//TRIGGER EVENT
		$ul.trigger('repaginate');
	});
});//end OL
/////////////////////////////////////////////////////////////////////////////////////////////
$(document).ready(function() {
	  $('table1.paginated').each(function() {
	    var currentPage = 0;
	    var numPerPage = 5;
	    var $table = $(this);
	    $table.bind('repaginate', function() {
	      $table.find('tr.tr_page').hide()
	        .slice(currentPage * numPerPage,
	          (currentPage + 1) * numPerPage)
	        .show();
	    });
	    var numRows = $table.find('tr.tr_page').length;
	    var numPages = Math.ceil(numRows / numPerPage);
	    var $pager = $('<div class="pager"></div>');
	    for (var page = 0; page < numPages; page++) {
	      $('<span class="page-number"></span>').text(page + 1)
	        .bind('click', {newPage: page}, function(event) {
	          currentPage = event.data['newPage'];
	          $table.trigger('repaginate');
	          $(this).addClass('active')
	            .siblings().removeClass('active');
	        }).appendTo($pager).addClass('clickable');
	    }
	    $pager.insertBefore($table)
	      .find('span.page-number:first').addClass('active');
	  });
	});

