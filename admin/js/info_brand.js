 
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
    // $("#display_div").remove();
//------------------EVENT CHANGE PULL THE DIV------------------------------
     $('form#brand_org fieldset').append('<div id="target_div" ></div>').find('select#brand_pdf').change(function(){
     $("#display_div").remove();
     if($('#brandID').val())
         var brandID = $('#brandID').val();

           $.ajax
           ({
               url: '../admin/ajax.php',
               data: "brandName=" + this.value + "&flag_level="+flag_level,
               cache: false,
               success: function (r) {
                   $("#target_div").html(r);
                   var page_val= $("#my_pageNum").val();
                   $('#num_page').find('#pdf_page_num').val(page_val);
                   var brand_date_val= $("#my_brand_date").val();
                   $("#brand_date2").val(brand_date_val);
               }
           });
    });

//-------------------------------------------------------------
    $('body').on('click', '.olive_cbx', function () {
        if( $(this).is(':checked') &&  $(".modify_elem").val() == 'modify') {
            var div_id = 'my_'+ this.id;
           // $('.wrapper_brand').find("#display_div").find('#my_pdfs'+this.id).removeClass('my_task').attr('style', '');
            $('#my_pdfs'+this.id).removeClass('my_task').attr('style', '');
            var isChange = true;
            $.ajax
            ({
                url: '../admin/ajax.php',
                data: "isChange=" + "checked" + "&flag_level="+flag_level+ "&pdf_name="+this.id,
                cache: false,
                success: function (msg) {
                    //$("#display_div").html(r);
                    $('div#display_div').append('<p>'+msg+'</p>');
                    var page_num = $('#pdf_page_num').val();
                    var check_num =$(":checkbox:checked").length;
                    var my_button = $('#send_pdf').val();
                    if(page_num == check_num ){

                        if(my_button == undefined || my_button == null){
                            $('<div><button type="submit" class="mybutton"  id="send_pdf"  name=form["submitpdf"]  style="margin: 10px 30px 20px 0;height: 38px;" >SEND PDF TO FTP</button><br/></div>\n').appendTo($("#display_div"));
                        }
                    }
                }
            });
        }else if($('.wrapper_brand').find('#my_pdfs'+this.id).hasClass('change_elem')){
            var ischecked= $(this).is(':checked');
            if(!ischecked)
                $('.wrapper_brand').find('#my_pdfs'+this.id).addClass('my_task')
        }
    });
//---------------checkbox click event--------------------------
//     $(".olive_cbx").click( function(){
//         if( $(this).is(':checked') &&  $(".modify_elem").val() == 'modify') {
//             var div_id = 'my_'+ this.id;
//             $('.wrapper_brand').find('#my_pdfs'+this.id).removeClass('my_task').attr('style', '');
//             var isChange = true;
//             $.ajax
//             ({
//                 url: '../admin/ajax.php',
//                 data: "isChange=" + "checked" + "&flag_level="+flag_level+ "&pdf_name="+this.id,
//                 cache: false,
//                 success: function (msg) {
//                     //$("#display_div").html(r);
//                     $('div#display_div').append('<p>'+msg+'</p>');
//                     var page_num = $('#pdf_page_num').val();
//                     var check_num =$(":checkbox:checked").length;
//                     var my_button = $('#send_pdf').val();
//                     if(page_num == check_num ){
//
//                         if(my_button == undefined || my_button == null){
//                             $('<div><button type="submit" class="mybutton"  id="send_pdf"  name=form["submitpdf"]  style="margin: 10px 30px 20px 0;height: 38px;" >SEND PDF TO FTP</button><br/></div>\n').appendTo($("#display_div"));
//                         }
//                     }
//                 }
//             });
//         }else if($('.wrapper_brand').find('#my_pdfs'+this.id).hasClass('change_elem')){
//             var ischecked= $(this).is(':checked');
//             if(!ischecked)
//                 $('.wrapper_brand').find('#my_pdfs'+this.id).addClass('my_task')
//         }
//     });
//---------------------------------------------------

//------------------PULL THE DIV------------------------------
    // setInterval(callAjax,30000);
    var check_exist_files = 1;


    var callAjax = function(){
        var editID = $('form#brand_org fieldset').find('select#brand_pdf').val();
        // $.ajax({
        //     dataType:'json',
        //     type: "GET",
        //     cache: false,
        //     url: '../admin/pdf_brand.php',
        //     // data: "src="+ this.value
        //     data: "mode=" + 'read_data' + "&editID="+editID,
        //     success:function(json){
        //         if(json.list[0]=='fail') {
        //             // alert("files been added to ftp!!!!");
        //             return false;
        //         }
        //     }
        // });


        $('div#display_div').remove();
        if($('#brandID').val())
            var brandID = $('#brandID').val();
    //    $("#display_div").empty();
        $.ajax
        ({
            url: '../admin/ajax.php',
            data: "brandName=" + editID + "&flag_level="+flag_level,
            cache: false,
            success: function (msg) {
                $("#target_div").html(msg);
                var page_val= $("#my_pageNum").val();
                $('#num_page').find('#pdf_page_num').val(page_val);
                var brand_date_val= $("#my_brand_date").val();
                $("#brand_date2").val(brand_date_val);
            }
        });





    }
   setInterval(callAjax,30000);


    //  alert( $('form#brand_org fieldset').find('select#brand_pdf').val());


//------------------------------------------------------------------



});//end DCR
 $("#loading img").ajaxStart(function(){
   $(this).show();
 }).ajaxStop(function(){
   $(this).hide();
 });




 
