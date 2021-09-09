 
var countJson_dec;

// prepare the form when the DOM is ready 
$(document).ready(function() {


    $("#create_brand a:contains('הקמה של ברנד')").parent().hover().addClass('active');
    $("#brand_plan a:contains('בניית תוכנית עבודה')").parent().hover().addClass('active');



    //Use smooth scrolling when clicking on navigation
    $('.navbar a[href*=#]:not([href=#])').click(function() {
        if (location.pathname.replace(/^\//,'') ===
            this.pathname.replace(/^\//,'') &&
            location.hostname === this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
            if (target.length) {
                $('html,body').animate({
                    scrollTop: target.offset().top-topoffset+2
                }, 500);
                return false;
            } //target.length
        } //click function
    }); //smooth scrolling


    flag_level=$('#flag_level').val();
	$('#my_find_ol').css('list-style','none');	
	$('#find_cat_dec_dest').hide();




        $('.input-group.date').datetimepicker({
            locale: 'he',
            format: 'YYYY-MM-DD',
        });




    // $("#display_div").remove();
//------------------EVENT CHANGE PULL THE DIV------------------------------
     $('form#brand_org fieldset').append('<div id="target_div" class="row" ></div>').find('select#brand_pdf').on('change',function(){
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
                            $('<div><button type="submit" class="mybutton btn btn-primary"  id="send_pdf"  name=form["submitpdf"]  style="margin: 10px 30px 20px 0;height: 38px;" >SEND PDF TO FTP</button><br/></div>\n').appendTo($("#display_div"));
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


        $('div#display_div').remove();
        if($('#brandID').val())
            var brandID = $('#brandID').val();
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
//   setInterval(callAjax,30000);


    //  alert( $('form#brand_org fieldset').find('select#brand_pdf').val());






//------------------------------------------------------------------
//     $(".wrapper_brand").css('border','3px sloid red');
   // $("#brand_org").find("#loading").css('border','3px sloid red');
    // $(".wrapper_brand").find("#loading img").ajaxStart(function(){
    //     $(this).show();
    // }).ajaxStop(function(){
    //     $(this).hide();
    // });


    // $('#loading').bind('ajaxStart', function(){
    //     $(this).show();
    // }).bind('ajaxStop', function(){
    //     $(this).hide();
    // });


    $(document).ajaxStart(function(){
        $("#loading").css("display", "block");
    });
    $(document).ajaxComplete(function(){
        $("#loading").css("display", "none");
    });

});//end DCR




 
