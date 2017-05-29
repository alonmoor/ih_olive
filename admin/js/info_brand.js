 
var countJson_dec;

// prepare the form when the DOM is ready 
$(document).ready(function() { 
	$('#my_find_ol').css('list-style','none');	
	$('#find_cat_dec_dest').hide();
   var options = { 
        beforeSubmit:  showRequest,  // pre-submit callback
        success:  processJson,
        dataType: 'json'
    }; 
    // bind form using 'ajaxForm'
    $('#find_cat_dec').ajaxForm(options); 

 function showRequest(formData, jqForm) {
 var extra = [ { name: 'json', value: '1' }];
 $.merge( formData, extra)
    return true;
} 
//---------------------// post-submit callback//
function processJson(data) {
	countJson_dec = data;
    var countList_dec_1 = '';
    // 'data' is the json object returned from the server
   $.each(data, function(i){
 countList_dec_1 += '<li><a href="find3.php?decID='+this.decID+'"   class=href_modal3 >'+this.decName+'</a></li>';
 });

 $('#targetDiv_dec1').html('<ul id="countList_dec">'+countList_dec_1+'</ul>').find('a.href_modal3').each(function(i){
    var index = $('a.href_modal3').index(this);
    var v = countJson_dec[i].decName;
    var id=countJson_dec[i].decID;
   });
 $('a.href_modal3').css({'background':'#B4D9D7'}).bind('click', function() {
	  	var link=$(this).attr('href') ;
	   	 openmypage3(link); 
		return false;
   });
}

//------------------PULL THE DIV------------------------------

     $('form#brand_org fieldset').find('select#brand_pdf').change(function(){
         $('div#display_div').empty();
     if($('#brandID').val())
         var brandID = $('#brandID').val();

        // var brand_date = '';
        // if($('#brand_date2').val()) {
        //      var brand_date = $('#brand_date2').val();
        //  }else if($('#brand_date3').val() &&  Date.parse($('#brand_date3').val())  ){
        //      brand_date = $('#brand_date3').val();
        //  }
        //  var brandPrefix = $('#brandPrefix').val();
       // if( !( brandID == undefined || brandID == '' ) && !( brand_date == undefined  || brand_date == '') && !( brandPrefix == undefined || brandPrefix == '' ) ) {
       //     $.ajax
       //     ({
       //         url: '../admin/ajax2.php',
       //         data: "page_num=" + this.value + "&brandID=" + brandID+ "&brand_date=" + brand_date+ "&brandPrefix=" + brandPrefix,
       //         cache: false,
       //         success: function (r) {
       //             $("#display_div").html(r);
       //         }
       //     });
       // }else{
           //$('form#brand_org fieldset').find("wrapper_brand").css('border','3px solid red').append('<div id="display_div"></div>');
           $("#display_div").empty();
           $.ajax
           ({
               url: '../admin/ajax2.php',
               data: "brandName=" + this.value,
               cache: false,
               success: function (r) {
                   $("#display_div").html(r);
                   var page_val= $("#my_pageNum").val();
                   $('#num_page').find('#pdf_page_num').val(page_val);




                   var brand_date_val= $("#my_brand_date").val();
                   $("#brand_date2").val(brand_date_val);

               }
           });
      // }
    });
//------------------------------------------
//     $('form#brand_org fieldset').find('select#brand_pdf').change(function(){
//         if($('#brandID').val())
//             var brandID = $('#brandID').val();
//         var brand_date = $('#brand_date2').val();
//         var brandPrefix = $('#brandPrefix').val();
//         if(brandID.length && brand_date.length && brandPrefix.length ) {
//             $.ajax
//             ({
//                 url: '../admin/ajax2.php',
//                 //data: 'action=showAllSqure',
//                 data: "brandID =" + this.value + "&brandID=" + brandID+ "&brand_date=" + brand_date+ "&brandPrefix=" + brandPrefix,
//                 cache: false,
//                 success: function (r) {
//                     // $("#display").html(r);
//                     $('div#target_Brand').html(r);
//                 }
//             });
//         }
//     });
//--------------------------------------
//     $.ajax({
//
//         type: "POST",
//         url:url+ "ajax2.php",
//         dataType: 'json',
//         data: "src="+ this.value + "&dest=" + $(this).parent().find(':first').val() + "&forum_decID=" + forum_decID + "&decID=" + decID ,
//         success: function(json){
//             if(json.list==="fail") {
//                 alert("כבר קיים משתמש בשם זה:");
//
//             }else{
//
//                 $('input#member'+forum_decID+userID).attr("value",json.list.full_name);
//
//                 $('input#my_button_'+forum_decID+userID).attr('Onclick', 'editReg_user('+src_userID+' ,\''+url+'\')');
//                 $('input#my_button_'+forum_decID+userID).attr("id",'my_button_'+forum_decID+src_userID);
//             }
//         }//end success
//
//     });


//-------------------------------

});//end DCR
 $("#loading img").ajaxStart(function(){
   $(this).show();
 }).ajaxStop(function(){
   $(this).hide();
 });




 
