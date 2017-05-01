$(document).ready(function() {

    function getAll(){

        $.ajax
        ({
            url: 'getproducts.php',
            data: 'action=showAll',
            cache: false,
            success: function(r)
            {
                $("#display").html(r);
            }
        });
    }

    getAll();

// $('#tree_content_target').hide();
//$('form#forum').append('<div id="targetDiv"></div>').find('select#insert_forumType').change(function(){
//	 
//});
	//$(".my_title_users").css({'cursor':'pointer'}).addClass('link'); 
//$(".my_title_users").toggle( 
// function(){ 
// 
//    
//	 $(this).addClass('hover');
//     $('#my_table').slideToggle();
//   
// },  
// function(){ 
//	$(this) .removeClass('hover'); 
//	 $('#my_table').slideToggle();
// } 
//);   




/*************************************************************************/	 
//if(($.browser.msie==true) ){
	// $('.my_users_panel h4').click(function() {
	//$('#users_fieldset h3').click(function() {
	
		//$(this).parent().find('table#my_table').slideToggle();
		//$(this).parent().find('#content_users').slideToggle();
		 //$(this).parent().find('#my_div_table').slideToggle();
		// $(this).parent().find('#users_fieldset').slideToggle();
		
	//  });

	 
// 	$(".my_title_users").css({'cursor':'pointer'}).addClass('link'); 
//	   $(".my_title_users").toggle( 
//	    function(){ 
//	    
//	       
//	      $(this).addClass('hover');
//	      $(this).parent().find('#my_div_table').slideToggle();
//	    },  
//	    function(){ 
//	      $(this).removeClass('hover'); 
//	      $(this).parent().find('#my_div_table').slideToggle();	    } 
//	  );  
	 
// }else if(($.browser.mozilla==true) ){
//	 
//	 $('.my_users_panel h3').click(function() {
//			
//			$(this).parent().find('table#my_table').slideToggle();
////			$(this).parent().find('.content_users').slideToggle();
//		  });
//
//	 
//	 $(".my_title_users").css({'cursor':'pointer'}).addClass('link'); 
//	   $(".my_title_users").toggle( 
//	    function(){ 
//	    
//	       
//	      $(this).addClass('hover');
//	      
//	    },  
//	    function(){ 
//	      $(this).removeClass('hover'); 
//	      
//	    } 
//	  );   
// } 
/**************************************************************/

/******************************************************************/   	 
//$(".my_title_trees").css({'cursor':'pointer'}).addClass('link'); 
//  $(".my_title_trees").toggle( 
//   function(){ 
//   
//      
//     $(this).addClass('hover');
//      $("#tree_content").slideToggle();
//   },  
//   function(){ 
//     $(this).removeClass('hover'); 
//    $("#tree_content").slideToggle();
//   } 
// );  
//  
//
//  
//  $(".my_title_trees2").css({'cursor':'pointer'}).addClass('link'); 
//  $(".my_title_trees2").toggle( 
//   function(){ 
//   
//      
//     $(this).addClass('hover');
//      $("#tree_content2").slideToggle();
//   },  
//   function(){ 
//     $(this).removeClass('hover'); 
//    $("#tree_content2").slideToggle();
//   } 
// );   	  
  
/**********************TOOGLE_HISTORY_PAST_USER************************************************/
  
//  $('.page_Pastuseredit h4').click(function() {
//	    $(this).parent().find('.contentPast_2').slideToggle();
//	  });
//
//	
//	$(".myPast_title").css({'cursor':'pointer'}).addClass('link'); 
//	  $(".myPast_title").toggle( 
//	    function(){ 
//	    
//	       
//	      $(this).addClass('hover');
//	     $("#contentPast_2").slideToggle();
//	    },  
//	    function(){ 
//	      $(this).removeClass('hover'); 
//	      $("#contentPast_2").slideToggle();
//	    } 
//	  );  
//
//$('#edit_Pastusr').bind('click',function(){
//
//$("#page_Pastuseredit").hide();
//
//
//
// });
// 
  
///*******************************************************/
// //TOGGLE DIV IE 
///******************************************************************/  
//  if(!($.browser.mozilla==true) ){
//	  $(".my_title_trees_ajx_tab").hide(); 
//	  $(".my_title_trees_ajx_tab2").hide(); 
//	  $(".my_title_trees_ajx").show();
//	  $(".my_title_trees2_ajx").show();
//  $(".my_title_trees_ajx").css({'cursor':'pointer'}).addClass('link'); 
//    $(".my_title_trees_ajx").toggle( 
//     function(){ 
//     
//        
//       $(this).addClass('hover');
//        $("#tree_content_ajx").slideToggle('slow');
//     },  
//     function(){ 
//       $(this).removeClass('hover'); 
//      $("#tree_content_ajx").slideToggle('slow');
//     } 
//   );  
//    
//
//    
//    $(".my_title_trees2_ajx").css({'cursor':'pointer'}).addClass('link'); 
//    $(".my_title_trees2_ajx").toggle( 
//     function(){ 
//     
//        
//       $(this).addClass('hover');
//        $("#tree_content_ajx2").slideToggle('slow');
//     },  
//     function(){ 
//       $(this).removeClass('hover'); 
//      $("#tree_content_ajx2").slideToggle('slow');
//     } 
//   ); 
//  } else{   
///*******************************************************/
////TOGGLE TABLE  FF 
///******************************************************************/   
//	 
//	  $(".my_title_trees_ajx").hide();
//	  $(".my_title_trees2_ajx").hide();
//	  $(".my_title_trees_ajx_tab").show(); 
//	  $(".my_title_trees_ajx_tab2").show(); 
//	  
// $(".my_title_trees_ajx_tab").css({'cursor':'pointer'}).addClass('link'); 
//   $(".my_title_trees_ajx_tab").toggle( 
//function(){ 
//
//   
//  $(this).addClass('hover');
//   $("#tree_content1").slideToggle('slow');
//},  
//function(){ 
//  $(this).removeClass('hover'); 
// $("#tree_content1").slideToggle('slow');
//    } 
//  );  
//   
//
//   
//   $(".my_title_trees_ajx_tab2").css({'cursor':'pointer'}).addClass('link'); 
//   $(".my_title_trees_ajx_tab2").toggle( 
//function(){ 
//
//   
//  $(this).addClass('hover');
//   $("#tree_content2").slideToggle('slow');
//},  
//function(){ 
//  $(this).removeClass('hover'); 
// $("#tree_content2").slideToggle('slow');
//        } 
//      );  
//   
//  }//end else  
///*************************CHANGE HREF FOR EDIT dynamic5b******************************/	  
 //$('div#treev1') .find('a.href_modal2').find('td.nodeText').css("border", "3px solid red");     //attr("class",'no_modal');
 //$('div#treev1').find('table.tvNodeTable').find('tr').find('td.nodeText').css("border", "3px solid red");//.find('a.href_modal2').css("border", "3px solid red");
 
  
 // $('table.tvNodeTable').css("border", "3px solid red");
  
 // $('div#treev1').css("border", "3px solid red");
// $('div#treev2').css("border", "3px solid red");
 // $("ul").find("li.b").css("border", "3px solid red");
	
	
	
	
	  
//	  $('.page_DecNewUser h4').click(function() { 
//		    $(this).parent().find('#content_DecNewUsr').slideToggle();
//		  });

		
//	$(".my_title_DecNewUsr1").css({'cursor':'pointer'}).addClass('link'); //for chang plus and minus
//		  $(".my_title_DecNewUsr").toggle( 
//		    function(){ 
//		      $(this).addClass('hover');
//		      $('#content_DecNewUsr').slideToggle();
//		    },  
//		    function(){ 
//		      $(this).removeClass('hover'); 
//		      $('#content_DecNewUsr').slideToggle();
//		    } 
//		  );  
	  

	/******************************************************************/

	  
	  
//		$(".my_dialog").css({'cursor':'pointer'}).addClass('link'); //for chang plus and minus
//		  $(".my_dialog").toggle( 
//		    function(){ 
//		      $(this).addClass('hover');
//		      $('#content_DecNewUsr').slideToggle();
//		    },  
//		    function(){ 
//		      $(this).removeClass('hover'); 
//		      $('#content_DecNewUsr').slideToggle();
//		    } 
//		  );  	
	  
	  
	  
//		  $('.my_dialog').click(function() {    
//			  $(this).next().slideToggle(250);
//			  return false;     
//			  }).next().hide();
	  
	  
	  
//$('.my_dialog h4').click(function() { 
//	    $(this).parent().find('.ui-dialog ').slideToggle();
//	  });

//	
//	$(".ui-dialog-titlebar").css({'cursor':'pointer'}).addClass('link'); //for chang plus and minus
//	  $(".ui-dialog").toggle( 
//	    function(){ 
//	      $(this).addClass('hover');
//	    },  
//	    function(){ 
//	      $(this).removeClass('hover'); 
//	    } 
//	  );  	
/*********************************************************************/  
	show2();	
	  var resizeOpts = {
		      autoHide: true,
			  minHeight: 170,
			  minWidth: 400
		    };
	
	$('#page_useredit').resizable( resizeOpts );  
	$('#page_useredit').css({'margin-right': '120px'}).draggable();
	
	//$('#data_table').draggable();
	$('#my_manager').draggable();

	$('.page_useredit h3').click(function() {
	    $(this).parent().find('.content').slideToggle();
	  });

	
	$(".my_title").css({'cursor':'pointer'}).addClass('link'); 
	  $(".my_title").toggle( 
	    function(){ 
	    
	       
	      $(this).addClass('hover');
	     
	    },  
	    function(){ 
	      $(this).removeClass('hover'); 
	      
	    } 
	  );  

$('#edit_usr').bind('click',function(){

$("#page_useredit").hide();



 });
  /**********************TOOGLE_edit_Dec_user************************************************/
  
  $('.page_Decuseredit h4').click(function() { 
	    $(this).parent().find('.contentDec_usr').slideToggle();
	  });

	
	$(".myDecuser_title").css({'cursor':'pointer'}).addClass('link'); //for chang plus and minus
	  $(".myDecuser_title").toggle( 
	    function(){ 
	      $(this).addClass('hover');
	    },  
	    function(){ 
	      $(this).removeClass('hover'); 
	    } 
	  );  
	  
	  
	  
	  
	  
	  

	  
	  
	  
	  
  
///////////////////// 	  
});//END READY//////
///////////////////	