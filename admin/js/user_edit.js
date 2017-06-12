$(document).ready(function() {


//     $('form#brand_org fieldset').append('<div id="targetDiv"></div>').find('select#brand_pdf').change(function(){
//
//         if($('#brandID').val())
//             var brandID = $('#brandID').val();
//         //$("#display_div").empty();
//         $('div#display_div').remove();
//         $.ajax
//         ({
//             url: '../admin/ajax.php',
//             data: "brandName=" + this.value + "&flag_level="+flag_level,
//             cache: false,
//             success: function (r) {
//                 // $("#display_div").html(r);
//
//                 //  $("#display_div").html(' ').append('<p>'+r+'</p>');
//
//                 $("#targetDiv").html(r);
//                 var page_val= $("#my_pageNum").val();
//                 $('#num_page').find('#pdf_page_num').val(page_val);
//                 var brand_date_val= $("#my_brand_date").val();
//                 $("#brand_date2").val(brand_date_val);
//             }
//         });
//     });
//
//     $('body').on('click', '.olive_cbx', function () {
//         console.log("yeahhhh!!! but this doesn't work for me :(");
//     });
// //-----------------------------------------------------------------------
//
//        $('body').on('click', '.olive_cbx', function () {
//         if( $(this).is(':checked') &&  $(".modify_elem").val() == 'modify') {
//             var div_id = 'my_'+ this.id;
//             if($('#targetDiv').children().length > 0) {
//                 $('#targetDiv').find('#my_pdfs' + this.id).removeClass('my_task').attr('style', '');
//             }else{
//                 $('#display_div').find('#my_pdfs' + this.id).removeClass('my_task').attr('style', '');
// 			}
//             var isChange = true;
//             $.ajax
//             ({
//                 url: '../admin/ajax.php',
//                 data: "isChange=" + "checked" + "&flag_level="+flag_level+ "&pdf_name="+this.id,
//                 cache: false,
//                 success: function (msg) {
//                     $('.wrapper_brand')..append('<p>'+msg+'</p>');
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
//-------------------------------------------------------------------
//          $(".olive_cbx").click( function(){
//              if( $(this).is(':checked') &&  $(".modify_elem").val() == 'modify') {
//                  var div_id = 'my_'+ this.id;
//                  $('.wrapper_brand').find('#my_pdfs'+this.id).removeClass('my_task').attr('style', '');
//                  var isChange = true;
//                  $.ajax
//                  ({
//                      url: '../admin/ajax.php',
//                      data: "isChange=" + "checked" + "&flag_level="+flag_level+ "&pdf_name="+this.id,
//                      cache: false,
//                      success: function (msg) {
//                          //$("#display_div").html(r);
//                          $('.wrapper_brand')..append('<p>'+msg+'</p>');
//                          var page_num = $('#pdf_page_num').val();
//                          var check_num =$(":checkbox:checked").length;
//                          var my_button = $('#send_pdf').val();
//                          if(page_num == check_num ){
//
//                              if(my_button == undefined || my_button == null){
//                                  $('<div><button type="submit" class="mybutton"  id="send_pdf"  name=form["submitpdf"]  style="margin: 10px 30px 20px 0;height: 38px;" >SEND PDF TO FTP</button><br/></div>\n').appendTo($("#display_div"));
//                              }
//                          }
//                      }
//                  });
//              }else if($('.wrapper_brand').find('#my_pdfs'+this.id).hasClass('change_elem')){
//                  var ischecked= $(this).is(':checked');
//                  if(!ischecked)
//                      $('.wrapper_brand').find('#my_pdfs'+this.id).addClass('my_task')
//              }
//          });
//--------------------------------------------------------------------

/////////////////////
});//END READY//////
///////////////////	