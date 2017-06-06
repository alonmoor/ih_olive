 
var countJson_dec;

// prepare the form when the DOM is ready 
$(document).ready(function() {
    flag_level=$('#flag_level').val();
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
           $("#display_div").empty();
           $.ajax
           ({
               url: '../admin/ajax2.php',
               data: "brandName=" + this.value + "&flag_level="+flag_level,
               cache: false,
               success: function (r) {
                   $("#display_div").html(r);
                   var page_val= $("#my_pageNum").val();
                   $('#num_page').find('#pdf_page_num').val(page_val);
                   var brand_date_val= $("#my_brand_date").val();
                   $("#brand_date2").val(brand_date_val);
               }
           });
    });
//------------------------------------------
    $(".olive_cbx").click( function(){
        if( $(this).is(':checked') ) {
            var div_id = 'my_'+ this.id;
            $('.wrapper_brand').find('#my_pdfs'+this.id).removeClass('my_task').attr('style', '');
//--------------------------------------------------



//-------------------------------------------------
        }else {
            var ischecked= $(this).is(':checked');
            if(!ischecked)
                $('.wrapper_brand').find('#my_pdfs'+this.id).addClass('my_task')
        }
    });

//--------------------------------------
});//end DCR
 $("#loading img").ajaxStart(function(){
   $(this).show();
 }).ajaxStop(function(){
   $(this).hide();
 });




 
