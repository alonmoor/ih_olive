function setupAjaxForm(form_id, form_validations) {
    if (document.getElementById('forum_decID') != null)
        var forum_decID = document.getElementById('forum_decID').value;
    var countJson;
    var form = '#' + form_id;
    var form_message = form + '-message';
    // setup loading message
    $(form).ajaxSend(function () {
        $(form_message).removeClass().addClass('loading').html('Loading...').fadeIn().fadeOut();
    });
    var options = {
        beforeSubmit: showRequest,
        // pre-submit callback
        success: processJson,
        dataType: 'json'
    };
    // bind form using 'ajaxForm'
    $('#forum').ajaxForm(options);
    function showRequest(formData, jqForm) {
        var extra = [{name: 'json', value: '1'}];
        $.merge(formData, extra);
        return true;
    }

// post-submit callback
    function processJson(data) {
        theme = {
            newUserFlashColor: '#ffffaa',
            editUserFlashColor: '#bbffaa',
            errorFlashColor: '#ffffff'
        };
        countJson = data;
        countJson1 = data;
        if (!forum_decID) {
            var forum_decID = document.getElementById('forum_decID').value;
            if (!(forum_decID) || forum_decID == 'undefine')
                forum_decID = data.forum_decID;
        }
        var countList = '';
        var forumList = '';
        var managerList = '';
        var appointList = '';
        var countList1 = '';
        var countList2 = '';
        var countList3 = '';
        var infoList = '';
        var categoryList = '';
        var manager_typeList = '';
        var decList = '';
        var j = 0;

        /**************************************/
        if (data.type == 'success') {       /*
         /*************************************/
            $('#menu_items_forum_8').show();
            $('div#my_forum_entry_c').show();
            $('div#my_forum_entry_b').show();
            $('.my_menu_items_forum_title').show();

            $('#my_error_message').hide();

            $("#ui-datepicker-div").css("zIndex", 2002);
            $("#duedate3").css("zIndex", 2002);
            $('.ui-sortable').css("zIndex", 1001);


            /**********************************NEW_APPOINT************************************************************/
            $('#manager_date').val(data.manager_date);//.attr(data.manager_date);
            //$('#forum_decision_link').css('width','400px');
            //$('.mycontrol').css('width','400px');

            if ($('#my_newAppoint').val() && !($('#my_newAppoint').val() == 'none')) {
                var new_appointItem = $("#my_newAppoint :selected").text();
                var new_appointItem2 = $('#my_newAppoint').val();
                $('#my_appoint').append('<option value=' + data.appoint_forum + '>' + new_appointItem + '</option>').attr("selected", 'selected');
                $('#my_appoint').val(data.appoint_forum).attr('selected', 'selected');
                $('#my_newAppoint').val('');

                var insert_appoint = ( $('#insert_appoint').val());
                if (insert_appoint) {
                    $('#insert_appoint').val('');
                }

            }

            /**********************************NEW_MANAGER************************************************************/

            if ($('#my_newManager').val() && !($('#my_newManager').val() == 'none')) {
                var new_managerItem = $("#my_newManager :selected").text();
                var new_managerItem2 = $('#my_newManager').val();
                $('#my_manager').append('<option value=' + data.manager_forum + '>' + new_managerItem + '</option>').attr("selected", 'selected');
                $('#my_manager').val(data.manager_forum).attr('selected', 'selected');
                $('#my_newManager').val('');

                var insert_manager = ( $('#insert_manager').val());
                if (insert_manager) {
                    $('#insert_manager').val('');
                }

            }


            /**********************************NEW_FORUM************************************************************/

            if ($('#newforum').val() && !($('#newforum').val() == 'none')) {
                $('div#my_forum_entry_b').hide();
                $('div#my_forum_entry_c').remove();
                var newItem = $('#newforum').val();
                $('#forum_decision_link').append('<option value=' + data.forum_decID + '>' + newItem + '</option>').attr("selected", 'selected');
                $('#forum_decision_link').val(data.forum_decID).attr('selected', 'selected');

                $('#newforum').val('');


                var insertID = ( $('#insert_forum').val());
                if (insertID) {
                    $('#insert_forum').val('');
                }


                var frmID = ( $('#forum_decision_link').val());

                data_a = [];
                data_a[0] = insertID;
                data_a[1] = frmID;


                $.ajax({
                    type: "POST",
                    url: "dynamic_12.php",
                    data: "entry=" + data_a,
                    success: function (msg) {
                        /*********************************DYNAMIC_12********************************************************/


                        $('div#forum_decision6').html(' ').append('<p>' + msg + '</p>');


                    }
        });

                $(form_message).removeClass().addClass('loading').html(' ').fadeOut();

            }
            /************************************NEW_FORUMS_TYPE*********************************************************/


            if ($('#insert_forumType').val() && !($('#insert_forumType').val() == 'none')) {
                var val_insert = $('#insert_forumType').val();
                $('#insert_forumType').append('<option value=' + data.dest_forumsType[0].catID + '>' + newItem + '</option>').attr("selected", true);
            }

            if ($('#textarea_frmType' + forum_decID).val() && !($('#textarea_frmType' + forum_decID).val() == 'none')) {
                var newItem = $('#textarea_frmType' + forum_decID).val();
                $('#src_forumsType').append('<option value=' + data.dest_forumsType[0].catID + '>' + newItem + '</option>').attr("selected", true);

                $('#dest_forumsType').html(' ');
                $('#dest_forumsType').append('<option value=' + data.dest_forumsType[0].catID +'>' + newItem + '</option>').attr("selected", true);

                $('#textarea_frmType' + forum_decID).val('');


                /***********************************************************************************/
                $('#src_forumsType').empty().append('<select name="src_forumsType" id="src_forumsType" >\n');


////////////////////////////////////////////////////////////////////////////
                $.each(data.frmType, function (i, item) {
////////////////////////////////////////////////////////////////////////////    

                    var listentry = listentry ? listentry : item[0];
                    listentry = listentry.replace(/^[ \t]+/gm, function (x) {
                        return new Array(x.length + 1).join('&nbsp;')
                    });

                    $('#src_forumsType').append("<OPTION   value=" + item[1] + " " + (item[0] == newItem ? "Selected" : "") + ">" + listentry + "</option>\n");

                });
                $('#src_forumsType').append($('</select>'));

            }
            /******************************************************************************************/
//     			$('#src_forumsType').append("<OPTION   value="+item[1]+" "    + (item[0]==newItem ? "Selected" : "")+     ">" );  			
//     			
//     			var listentry =listentry?listentry:item[0];	
//     			  listentry= listentry.replace(/^[ \t]+/gm, function(x){ return new Array(x.length + 1).join('&nbsp;') });		  
//     		
//				  
//				  $('#src_forumsType').append( listentry + "</option>\n");//.attr("selected",true);  
//				 });
//					$('#src_forumsType').append($('</select>'));		
            /*******************************************NEW_MGR_TYPE*********************************************************/

            if ($('#textarea_mgrType_' + forum_decID).val() && !($('#textarea_mgrType' + forum_decID).val() == 'none')) {
                var newItem = $('#textarea_mgrType_' + forum_decID).val();
                $('#src_managersType').append('<option value=' + data.dest_managersType[0].managerTypeID + '>' + newItem + '</option>').attr("selected", true);
                $('#dest_managersType').html(' ');
                $('#dest_managersType').append('<option value=' + data.dest_managersType[0].managerTypeID + '>' + newItem + '</option>').attr("selected", true);
                $('#insert_managerType').append('<option value=' + data.dest_managersType[0].managerTypeID + '>' + newItem + '</option>').attr("selected", true);

                $('#textarea_mgrType_' + forum_decID).val('');
            }


            /******************************************************************************************************************************************/
            $(form_message).removeClass().addClass(data.type).html(data.message).css({'margin-right': '50px'}).css({'width': '79%'}).fadeIn('slow');
            /********************************************************************************************************************************************/

            if (!forum_decID) {
                var forum_decID = document.getElementById('forum_decID').value;

                if (!(forum_decID) || forum_decID == 'undefine')
                    forum_decID = data.forum_decID;
            }

            /***********************************************FORUM_DEC*********************************************************/
            $('#forum_decision_a').removeClass().addClass(data.type).html(data.message).effect("highlight", {color: theme.newUserFlashColor}, 3000)
                .css({'margin-right': '50px'}).css({'width': '79%'}).fadeIn('slow');

            data.forum_decName = data.forum_decName ? data.forum_decName : data.subcategories;
            countList += '<li><a href="../admin/find3.php?forum_decID=' + data.forum_decision + '"  class="maplink" >' + data.forum_decName + '</a></li>';
            $('#forum_decision_a').html('<ul id="countList1"><b style="color:#800137;">שם הפורום' + countList + '</b></ul>').find('a.maplink').each(function (i) {
                var index = $('a.maplink').index(this);
                var v = countJson.forum_decName;
                var id = countJson.forum_decID;

                /*****************************************CLICK****************************/
                $(this).click(function () {
                    $.get('../admin/find3.php?forum_decID=' + id + '', $(this).serialize(), function (data) {

                        $('#forum_decision')
                            .addClass('forum_decision').css({'width': '79%'})
                            .css({'height': '400px'})
                            .css({'margin-right': '60px'})

                            .css({'padding': '5px'})
                            .css({'overflow': 'hidden'})
                            .css({'overflow': 'scroll'})
                            .css({'background': '#2AAFDC'})//3BDEE1
                            .css({'border': '3px solid #666'});


                        $('#forum_decision').html(data);


                    });


                    return false;
                });
                $('#forum_decision').html(' ');

            });//end forum_dec


            /***************************************MANAGER**********************************************/
            $('#forum_decision3').removeClass().addClass(data.type).html(data.message).effect("highlight", {color: theme.newUserFlashColor}, 3000).css({'margin-right': '50px'}).css({'width': '79%'}).fadeIn('slow');
            managerList += '<li><a href="../admin/find3.php?managerID=' + data.manager_forum + '"  class="mng" >' + data.managerName + '>>' + data.manager_date + '</a></li>';

            $('#forum_decision3').html('<ul id="managerList1"><b style="color:#800137;">מרכז ועדה' + managerList + '</b></ul>').find('a.mng').each(function (i) {
                var index = $('a.mng').index(this);
                var v = countJson.managerName;
                var mng_id = countJson.manager_forum;
                /*****************************************CLICK****************************/
                $(this).click(function () {
                    $.get('../admin/find3.php?managerID=' + mng_id + '', $(this).serialize(), function (data) {

                        $('#forum_decision')
                            .addClass('forum_decision').css({'width': '79%'})
                            .css({'height': '400px'})
                            .css({'margin-right': '60px'})
                            .css({'padding': '5px'})
                            .css({'overflow': 'hidden'})
                            .css({'overflow': 'scroll'})
                            .css({'background': '#B4D9D7'})
                            .css({'border': '3px solid #666'});


                        $('#forum_decision').html(data);


                    });


                    return false;
                });
                $('#forum_decision').html(' ');
            });//end manager

            /***************************************APPOINT*********************************************/
            $('#forum_decision4').removeClass().addClass(data.type).html(data.message).effect("highlight", {color: theme.newUserFlashColor}, 3000).css({'margin-right': '50px'}).css({'width': '79%'}).fadeIn('slow');
            appointList += '<li><a href="../admin/find3.php?appointID=' + data.appoint_forum + '"  class="app" >' + data.appointName + '>>' + data.appoint_date1 + '</a></li>';

            $('#forum_decision4').html('<ul id="appointList1"><b style="color:#800137;">ממנה ועדה' + appointList + '</b></ul>').find('a.app').each(function (i) {
                var index = $('a.app').index(this);
                var appointName = countJson.appointName;
                var app_id = countJson.appoint_forum;
                /*****************************************CLICK****************************/
                $(this).click(function () {
                    $.get('../admin/find3.php?appointID=' + app_id + '', $(this).serialize(), function (data) {

                        $('#forum_decision')
                            .addClass('forum_decision').css({'width': '79%'})
                            .css({'height': '400px'})
                            .css({'margin-right': '60px'})
                            .css({'padding': '5px'})
                            .css({'overflow': 'hidden'})
                            .css({'overflow': 'scroll'})
                            .css({'background': '#2CE921'})
                            .css({'border': '3px solid #666'});


                        $('#forum_decision').html(data);


                    });


                    return false;
                });
                $('#forum_decision').html(' ');
            });//end appoint
            /************************************************************MANAGER_TYPE**********************************************************************/
            $.each(data.dest_managersType, function (i) {


                var managerTypeName = this.managerTypeName;

                var managerTypeID = countJson.dest_managersType[i].managerTypeID;

                var url = '../admin/';
                var idx = i;


                manager_typeList += '<li><a href="../admin/find3.php?managerTypeID=' + managerTypeID + '"  class="type_manager" >' + this.managerTypeName + '</a></li>';


            });

            /**************************************************************************************************************/


            $('#forum_decision_d').removeClass().addClass(data.type).html(data.message).effect("highlight", {color: theme.newUserFlashColor}, 3000).css({'margin-right': '50px'}).css({'width': '79%'}).fadeIn('slow');
            $('#forum_decision_d').html('<ol id="manager_typeList1"><b style="color:#800137;">סוג מנהל/ים' + manager_typeList + '</b></ol>').find('a.type_manager').each(function (i) {

                var index = $('a.type_manager').index(this);
                var v = countJson.managerTypeName;
                var id = countJson.dest_managersType[i].managerTypeID;
                /*****************************************CLICK***************************************************/
                $(this).click(function () {
                    $.get('../admin/find3.php?managerTypeID=' + id + '', $(this).serialize(), function (data) {


                        $('#forum_decision')
                            .addClass('forum_decision').css({'width': '79%'})
                            .css({'height': '400px'})
                            .css({'margin-right': '60px'})
                            .css({'padding': '5px'})
                            .css({'overflow': 'hidden'})
                            .css({'overflow': 'scroll'})
                            .css({'background': '#C6EFF0'})
                            .css({'border': '3px solid #666'});


                        $('#forum_decision').html(data);


                    });


                    return false;
                });
                $('#forum_decision').html(' ');
            });//end manager/type

            /************************************************************FORUM_TYPE**********************************************************************/
            $.each(data.dest_forumsType, function (i) {


                var catName = this.catName;
                var catID = countJson.dest_forumsType[i].catID;

                var url = '../admin/';
                var idx = i;


                categoryList += '<li><a href="../admin/find3.php?cat_forumID=' + catID + '"  class="cat" >' + this.catName + '</a></li>';


            });

            /**************************************************************************************************************/

            $('#forum_decision_c').removeClass().addClass(data.type).html(data.message).effect("highlight", {color: theme.newUserFlashColor}, 3000).css({'margin-right': '50px'}).css({'width': '79%'}).fadeIn('slow');
            $('#forum_decision_c').html('<ol id="categoryList1"><b style="color:#800137;">סוג הפורום/ים' + categoryList + '</b></ol>').find('a.cat').each(function (i) {

                var index = $('a.cat').index(this);
                var v = countJson.catName;
                var id = countJson.dest_forumsType[i].catID;
                /*****************************************CLICK***************************************************/
                $(this).click(function () {
                    $.get('../admin/find3.php?cat_forumID=' + id + '', $(this).serialize(), function (data) {


                        $('#forum_decision')
                            .addClass('forum_decision').css({'width': '79%'})
                            .css({'height': '400px'})
                            .css({'margin-right': '60px'})
                            .css({'padding': '5px'})
                            .css({'overflow': 'hidden'})
                            .css({'overflow': 'scroll'})
                            .css({'background': '#8EF6F8'})
                            .css({'border': '3px solid #666'});


                        $('#forum_decision').html(data);


                    });


                    return false;
                });
                $('#forum_decision').html(' ');
            });//end decision/type


            /**********************************************************USERS***********************************/

            if (data.dest_user) {

                var name = '';
//$('#forum_decision3').html('<ul id="managerList1">מרכז ועדה'+managerList+'</ul>').find('a.mng')  
                $.each(data.dest_user, function (i) {

                    var name = this.full_name;
                    var user_id = countJson1.dest_user[i].userID;
                    var url = '../admin/';
                    var idx = i;

                    countList3 += '<li><a href="../admin/find3.php?userID=' + this.userID + '"  class="usr" >' + this.full_name + '>>' + data.member_date[i] + '</a></li>';

                });

                /*************************************************************************************************/
                if (!(data.dest_user.length < data.src_user.length) && data.dest_user.length - 1 >= 0) {
                    $('#my_table').empty();
                    $.each(data.dest_user, function (i) {
                        if (!forum_decID) {
                            var forum_decID = document.getElementById('forum_decID').value;

                            if (!(forum_decID) || forum_decID == 'undefine')
                                forum_decID = data.forum_decID;
                        }
                        var status = '';
                        var name = data.dest_user[i].full_name;

                        var usr_id = data.dest_user[i].userID;
                        var active = data.active[usr_id];

                        if (active == 2)
                            status = 1;
                        else
                            status = 0;


                        var idx = i;
                        var url = '../admin/';
                        $('#my_table').append($(" <tr>\n" +

                            '<td id="my_active' + usr_id + forum_decID + '">' +
                            '<a href="javascript:void(0)" onclick="edit_active(' + usr_id + ',' + forum_decID + ',\'' + url + '\',' + active + '); return false;">' +
                            '<img src="../images/icon_status_' + status + '.gif" width="16" height="10" alt="" border="0" />' +
                            '</a>' +
                            '</td>' +

                            "<td>\n" +
                            "חבר פורום: <input type='text' name='member'  class='mycontrol'  value=\'" + data.dest_user[idx].full_name + "\'  />\n" +
                            '<input type="button"  class="mybutton"  id="my_button_' + usr_id + '"   value="ערוך מישתמש"  onClick="return editUser3(' + usr_id + ',' + forum_decID + ',\'' + url + '\',' + idx + ');" />\n' +
                            " תאריך צרוף לפורום:<input type='text' name='form[member_date" + idx + "]'  id='member_date" + idx + "'  class='mycontrol dp'   size=10  value=" + data.member_date[idx] + "  />\n" +
                            "</td>\n" +
                            "</tr>\n"
                        ));


                        $(function () {
                            $('.dp').datepicker($.extend({}, {
                                showOn: 'button',
                                buttonImage: '../images/calendar.gif', buttonImageOnly: true,
                                changeMonth: true,
                                changeYear: true,
                                showButtonPanel: true,
                                buttonText: "Open date picker",
                                dateFormat: 'dd-mm-yy',
                                altField: '#actualDate'
                            }, $.datepicker.regional['he']));
                        });
                        $('ul#my_ulUsers').remove();


                    });
                }
                /********************************************************************************************************/

                if ((data.dest_user.length < data.src_user.length) && data.dest_user.length - 1 >= 0) {

                    $('#my_table').empty();

                    $.each(data.dest_user, function (i) {
                        var name = data.dest_user[i].full_name;
                        if (!forum_decID) {
                            var forum_decID = document.getElementById('forum_decID').value;

                            if (!(forum_decID) || forum_decID == 'undefine')
                                forum_decID = data.forum_decID;
                        }
                        var usr_id = data.dest_user[i].userID;
                        var idx = i;


                        var url = '../admin/';


                        $('#my_table').append($(" <tr id='my_tr" + i + "'>\n" +
                            '<td id="my_active' + usr_id + forum_decID + '">' +
                            '<a href="javascript:void(0)" onclick="edit_active(' + usr_id + ',' + forum_decID + ',\'' + url + '\',' + active + '); return false;">' +
                            '<img src="../images/icon_status_' + status + '.gif" width="16" height="10" alt="" border="0" />' +
                            '</a>' +
                            '</td>' +

                            "<td>\n" +

                            "חבר פורום: <input type='text' name='member'  class='mycontrol'  value=\'" + data.dest_user[idx].full_name + "\'  />\n" +

                            "<input type='button'  class='mybutton'  id='my_button_" + usr_id + "'   value='ערוך מישתמש'  onClick='return editUser3(" + usr_id + "," + forum_decID + ", \"" + url + "\" ," + idx + ");' />\n" +
                            " תאריך צרוף לפורום:<input type='text' name='form[member_date" + idx + "]'  id='member_date" + idx + "'  class='mycontrol dp'   size=10  value=" + data.member_date[idx] + "  />\n" +

                            "</td>\n" +
                            "</tr>\n"));

                        $(function () {
                            $('.dp').datepicker($.extend({}, {
                                showOn: 'button',
                                buttonImage: '../images/calendar.gif', buttonImageOnly: true,
                                changeMonth: true,
                                changeYear: true,
                                showButtonPanel: true,
                                buttonText: "Open date picker",
                                dateFormat: 'dd-mm-yy',
                                altField: '#actualDate'
                            }, $.datepicker.regional['he']));
                        });

                    });


                }
                if ($('#new_multi_year').val())
                    document.getElementById('new_multi_year').value = "none";
                if ($('#new_multi_month').val())
                    document.getElementById('new_multi_month').value = "none";
                if ($('#new_multi_day').val())
                    document.getElementById('new_multi_day').value = "none";

                /*********************************************************************************************************/

                $('#forum_decision_b').removeClass().addClass(data.type).html(data.message).effect("highlight", {color: theme.newUserFlashColor}, 3000).css({'margin-right': '50px'}).css({'width': '79%'}).fadeIn('slow');
                $('#forum_decision_b').html('<ol id="countList3"><b style="color:#800137;">חברי הפורום' + countList3 + '</b></ol>').find('a.usr').each(function (i) {
                    var index = $('a.usr').index(this);
                    var v = countJson1.full_name;
                    var userid = countJson1.dest_user[i].userID;
                    /*****************************************CLICK*************************************************************/
                    $(this).click(function () {
                        $.get('../admin/find3.php?userID=' + userid + '', $(this).serialize(), function (data) {

                            $('#forum_decision')
                                .addClass('forum_decision').css({'width': '79%'})
                                .css({'height': '400px'})
                                .css({'margin-right': '60px'})
                                .css({'padding': '5px'})
                                .css({'overflow': 'hidden'})
                                .css({'overflow': 'scroll'})
                                .css({'background': '#ffdddd'})
                                .css({'border': '3px solid #666'}
                                );


                            $('#forum_decision').html(data);

                        });


                        return false;
                    });//end click
                    $('#forum_decision').html(' ');
                });//end  $('#forum_decision2')
                /*****************************************************************************************/
            }//end if(data.dest_user)
            else {
                $('#my_table').empty();
                $('#forum_decision2').empty();
            }


            /********************************GENERAL_INFORMATION*******************************************/
            $('#forum_decision5').removeClass().addClass(data.type).html(data.message).effect("highlight", {color: theme.newUserFlashColor}, 3000).css({'margin-right': '50px'}).css({'width': '79%'}).fadeIn('slow');
            infoList += '<li><a href="../admin/forum_demo12.php"  class="my_msg" ><b style="color:#800137;"> מידע כללי</b></a></li>';

            $('#forum_decision5').html('<ul id="infoList1">' + infoList + '</ul>').find('a.my_msg').each(function (i) {
                var index = $('a.my_msg').index(this);
                /*****************************************CLICK****************************/
                $(this).click(function () {
                    $.get('../admin/forum_demo12.php', $(this).serialize(), function (data) {

                        $('#forum_decision')
                            .addClass('forum_decision').css({'width': '79%'})
                            .css({'height': '400px'})
                            .css({'margin-right': '60px'})
                            .css({'padding': '5px'})
                            .css({'overflow': 'hidden'})
                            .css({'overflow': 'scroll'})
                            .css({'background': '#AE77BE'})
                            .css({'border': '3px solid #666'});


                        $('#forum_decision').html(data);


                    });


                    return false;
                });//end click
                $('#forum_decision').html(' ');

            });//end general info
            /************************************************************DECISIONS**********************************************************************/
            if (data.decision) {

                $.each(data.decision, function (i) {


                    var decName = this.decName;
                    var decID = countJson.decision[i].decID;

                    var url = '../admin/';
                    var idx = i;


                    decList += '<li><a href="../admin/find3.php?decID=' + decID + '"  class="dec_find" >' + this.decName + '</a></li>';


                });

                /**************************************************************************************************************/

                $('#forum_decision_e').removeClass().addClass(data.type).html(data.message).effect("highlight", {color: theme.newUserFlashColor}, 3000).css({'margin-right': '50px'}).css({'width': '79%'}).fadeIn('slow');
                $('#forum_decision_e').html('<ol id="decList1"><b style="color:#800137;">החלטה/ות' + decList + '</b></ol>').find('a.dec_find').each(function (i) {

                    var index = $('a.dec_find').index(this);
                    var v = countJson.decName;
                    var id = countJson.decision[i].decID;
                    /*****************************************CLICK***************************************************/
                    $(this).click(function () {
                        $.get('../admin/find3.php?decID=' + id + '', $(this).serialize(), function (data) {


                            $('#forum_decision')
                                .addClass('forum_decision').css({'width': '79%'})
                                .css({'height': '400px'})
                                .css({'margin-right': '60px'})
                                .css({'padding': '5px'})
                                .css({'overflow': 'hidden'})
                                .css({'overflow': 'scroll'})
                                .css({'background': '#8EF6F8'})
                                .css({'border': '3px solid #666'});


                            $('#forum_decision').html(data);


                        });


                        return false;
                    });
                    $('#forum_decision').html(' ');
                });//end decision
            }
            /**************************************************************************/

        }//end success
        /***************************************************************************************/
        else {

            var forum_decID = data.forum_decID;
            $.each(data, function (i, item) {
                var messageError = i;

                $("#forum-message").html(' ').fadeIn();

                if (messageError != 'forum_decID')
                    countList2 += '<li class="error">' + item + '</li>';

            });

            $('#my_error_message').html('<ul id="countList_check">' + countList2 + '</ul>').css({'margin-right': '90px'});
            $('#my_error_message').append($('<p ID="bgchange"   ><b style="color:blue;">הודעת שגיאה!!!!!</b></p>\n'));

            if ($('#menu_items_forum').val())
                $('#menu_items_forum_8').hide();
            $('#my_error_message').show();
            turn_red();
            //  blinkFont()
        }

    }//end prossec_json


    /************************************************************************************************/
}//end function 
///************************************************************************************************/


/*****************************************/
$(document).ready(function () {
    /***************************************/

    $("#ui-datepicker-div").css("zIndex", 2002);
    $("#duedate3").css("zIndex", 2002);

    if ((document.getElementById('forum_decID').value) != null || (document.getElementById('forum_decID').value) == undefined) {
//if($('#forum_decID').val()){ 
        var forum_decID = document.getElementById('forum_decID').value;
    }


    /***********************************CHANGE_CONN_ENTRY1************************************************************/
    /***********************************CHANGE_CONN_ENTRY1************************************************************/
    /***********************************CHANGE_CONN_ENTRY1************************************************************/
    /***********************************CHANGE_CONN_ENTRY1************************************************************/


    $('form#forum fieldset').append('<div id="my_forum_entry_b"></div>').find('select#insert_forum').change(function () {
        var flag_level = $('#flag_level').val();
        if (flag_level == 1) {
            if ($('#forum_decision_link').val() && $('#newforum').val()) {
                return;
            }
            var frmID = ( $('#forum_decision_link').val());
            data_a = [];
            data_a[0] = this.value;
            data_a[1] = frmID;

            $.ajax({
                type: "POST",
                url: "dynamic_10.php",
                data: "entry=" + data_a,
                success: function (msg) {
                    $('div#my_forum_entry_c').remove();
                    $('#my_forum_entry_b').remove();
                    $('#my_forum_entry_first').remove();

                    $('div#forum_decision_tree').html(' ').append('<p>' + msg + '</p>');

                }
            });


            $(form_message).removeClass().addClass('loading').html(' ').fadeOut();
        }
    });


    /***********************************READ_DATA_CHANGE_SELECT***************************************************************/
    $('form#forum fieldset').find('select#forum_decision_link').change(function () {
        $('#menu_items_forum_8').hide();
        tz = -1 * (new Date()).getTimezoneOffset();
        nocache = '&rnd=' + Math.random();
        var insertID = '';
        var frmID = ( $('#forum_decision_link').val());
        var forum_decName = $("#forum_decision_link :selected").text();
        var option_str = 'none';
        /*************************************************GET_JSON**********************************************************************/


        $.getJSON('dynamic_10.php?read_data2&editID=' + frmID + '&tz=' + tz + nocache, function (json) {


//////////////////////////////////////////////////////////////////////////////////////////////				
            $.each(json.formdata, function (i, item) {
//////////////////////////////////////////////////////////////////////////////////////////////

                $('#treev1').empty();
                $('#treev2').empty();


                insertID = item.insert_forum;
                data_a = [];
                data_a[0] = insertID;
                data_a[1] = frmID;
                /*****************************INIT***************************************/
                document.getElementById('forum_decision_link').value = item.forum_decision;
                document.getElementById('forum_date').value = (item.forum_date);
                document.getElementById('appoint_date1').value = (item.appoint_date);
                document.getElementById('manager_date').value = (item.manager_date);
                document.getElementById('my_appoint').value = (item.appoint_forum);
                document.getElementById('insert_forum').value = (item.insert_forum);
                document.getElementById('my_manager').value = (item.manager_forum);
                /***********************************************************************************************/
                var link_frm = '../admin/find3.php?managerID=' + item.manager_forum + '';
                var my_href = '<a href="javascript:void(0)"  onClick="return openmypage3(\'' + link_frm + '\' );this.blur();return false;" >' +
                    '<b style="color:red;font-size:1.4em;text-decoration: underline;">' + item.managerName + '</b>' +
                    '</a>';


                $('#my_manager_td').find('.module').find('h2').html(' ').html('מנהל הפורום:' + my_href + '');

                /***************************************FORUMS_TYPE**********************************************/
                if (item.dest_forumsType) {
                    $('#dest_forumsType').empty();
                    $.each(item.dest_forumsType, function (i) {


                        var catForumName = this.catName;
                        var catForumID = item.dest_forumsType[i].catID;
                        $('#dest_forumsType').append('<option value=' + catForumID + '>' + catForumName + '</option>').attr('selected', 'selected');
                    });
                }
                /***************************************MANAGERS_TYPE**********************************************/
                if (item.dest_managersType) {
                    $('#dest_managersType').empty();
                    $.each(item.dest_managersType, function (i) {


                        var catName = this.managerTypeName;
                        var catID = item.dest_managersType[i].managerTypeID;
                        $('#dest_managersType').append('<option value=' + catID + '>' + catName + '</option>').attr('selected', 'selected');
                    });
                }


                /***************************************LINK_TREE***********************************************************************/

                $.ajax({
                    type: "POST",
                    url: "dynamic_10.php",
                    data: "entry=" + data_a,
                    success: function (msg) {

                        $('#my_forum_entry_b').remove();
                        $('#my_forum_entry_first').remove();
                        $('#msg_update').remove();

                        $('div#forum_decision_tree').html(' ').append('<p>' + msg + '</p>');

                    }
                });


                /************************************users***********************************************/

                if (item.dest_user) {
                    $('#my_new_usr').empty();
                    $('#dest_users').empty();
                    $('#my_table').empty();
                    /*****************************ADD_TO_SELECT_BOX********************************************/

                    $.each(item.dest_user, function (i) {
                        var userName = this.full_name;
                        var usrID = item.dest_user[i].userID;
                        $('#dest_users').append('<option value=' + usrID + '>' + userName + '</option>').attr('selected', 'selected');
                    });

                    /***************************************READ_USERS**********************************/
                    $.ajax({
                        type: "GET",
                        url: "../admin/dynamic_10.php",
                        data: "read_users=" + frmID,
                        success: function (msg) {

                            var link_frm = '../admin/find3.php?forum_decID=' + frmID + '';
                            var my_href = '<a href="javascript:void(0)"  onClick="return openmypage3(\'' + link_frm + '\' );this.blur();return false;" >' +
                                '<b style="color:red;font-size:1.4em;">' + forum_decName + '</b>' +
                                '</a>';

                            $('div#my_div_table').html(' ').append('<p>' + msg + '</p>');

                            $('#my_Frm_users_td').find('.module').find('h2').html(' ').html('חברי הפורום:' + my_href + '');


////////////         
                        }       ///
                    });	   ///
/////////				


                }//end dest_user
                /***************************************RESTORE_DECISIONS_TREE***********************************/
                if (item.decision && item.decision[0].decID) {


/////////////////////////////	
                    nocache = '&rnd=' + Math.random();
                    $.ajax({
                        type: "GET",
                        url: "../admin/dynamic_10.php",
                        data: "read_decisions=" + frmID + nocache,
                        success: function (msg) {

                            var link_frm = '../admin/find3.php?forum_decID=' + frmID + '';
                            var my_href = '<a href="javascript:void(0)"  onClick="return openmypage3(\'' + link_frm + '\' );this.blur();return false;" >' +
                                '<b style="color:red;font-size:1.4em;">' + forum_decName + '</b>' +
                                '</a>';
                            $('#tree_content_target').html(' ').append('<p>' + msg + '</p>');
                            $('#my_tree_td').find('.module').find('h2').html(' ').html('ערוך החלטות של הפורום:' + my_href + '');
                        }
                    });

//////////////////////////////////////////////////////////////
                    nocache = '&rnd=' + Math.random();
                    $.ajax({
                        type: "GET",
                        url: "../admin/dynamic_10.php",
                        data: "read_decisions2=" + frmID + nocache,
                        success: function (msg) {

                            var link_frm = '../admin/find3.php?forum_decID=' + frmID + '';
                            var my_href = '<a href="javascript:void(0)"  onClick="return openmypage3(\'' + link_frm + '\' );this.blur();return false;" >' +
                                '<b style="color:red;font-size:1.4em;">' + forum_decName + '</b>' +
                                '</a>';

                            $('#tree_content_target2').html(' ').append('<p>' + msg + '</p>');
                            $('#my_tree_td2').find('.module').find('h2').html(' ').html('צפה בחלון בהחלטות של הפורום:' + my_href + '');
                        }
                    });


/////////////////////////////////////////////////////////////
                    return false;

                }
                /*****************************************************************************************/


            }); //end each

            /*************************************************************************************/

        });//end get_json

    });//end read_data

    /***********************************CHANGE_CONN_ENTRY1************************************************************/
    /***********************************CHANGE_CONN_ENTRY1************************************************************/
    /***********************************CHANGE_CONN_ENTRY1************************************************************/
    /***********************************CHANGE_CONN_ENTRY1************************************************************/
    /***********************************CHANGE_CONN_ENTRY1************************************************************/

















    $("#edittags1").autocomplete('/alon-web/olive_prj/admin/ajax2.php?suggestuserTags', {
        scroll: false,
        multiple: true,
        selectFirst: false,
        max: 8
    });
    /*****************************************************************************************************/
    $('a.href_info').css({'background': '#B4D9D7'}).bind('click', function () {
        var link = '../admin/find3.php?&forum_decID=' + forum_decID;
        openmypage(link);
        return false;
    });

    /************************************************************************************************/

    if ($.browser.mozilla == true) {
        $(function () {
            $("#menu_items_forum_8").sortable();
            $("#forum_decision").bind("mousedown", function () {
                return false;
            });
        });
    } else {
        $("#menu_items_forum_8").sortable();

    }


    /*******************************TOGGLE_MAIN_FIELDSET*******************************************/

    $(".my_main_fieldset" + forum_decID).addClass('link');
    $(".my_main_fieldset" + forum_decID).toggle(
        function () {


            $(this).addClass('hover');
            $("#main_fieldset" + forum_decID).slideToggle('slow');
        },
        function () {
            $(this).removeClass('hover');
            $("#main_fieldset" + forum_decID).slideToggle('slow');
        }
    );
    /*******************************TOGGLE_MENU_ITEM*******************************************/

    $(".my_menu_items_forum_title").addClass('link');
    $(".my_menu_items_forum_title").toggle(
        function () {


            $(this).addClass('hover');
            $("ul#menu_items_forum_8").slideToggle('slow');
        },
        function () {
            $(this).removeClass('hover');
            $("ul#menu_items_forum_8").slideToggle('slow');
        }
    );


    /******************************************************************/
    $(".my_title_trees").addClass('link');
    $(".my_title_trees").toggle(
        function () {


            $(this).addClass('hover');
            $("#tree_content").slideToggle();
        },
        function () {
            $(this).removeClass('hover');
            $("#tree_content").slideToggle();
        }
    );


    $(".my_title_trees2").addClass('link');
    $(".my_title_trees2").toggle(
        function () {


            $(this).addClass('hover');
            $("#tree_content2").slideToggle();
        },
        function () {
            $(this).removeClass('hover');
            $("#tree_content2").slideToggle();
        }
    );

    /*******************TOGGLE_USERS_FRM***********************************/
    $(".my_title_users").css({'cursor': 'pointer'}).addClass('link');
    $(".my_title_users").toggle(
        function () {


            $(this).addClass('hover');
            $(this).parent().find('#my_div_table').slideToggle();
        },
        function () {
            $(this).removeClass('hover');
            $(this).parent().find('#my_div_table').slideToggle();
        }
    );

    /*****************************************************************************/

    $('.bgchange_tree').css('width', '70%');
    turn_red_tree();


    /*******************************************************/
//TOGGLE DIV IE 
    /******************************************************/
    if (($.browser.msie == true)) {
        $(".my_title_trees_ajx_tab").hide();
        $(".my_title_trees_ajx_tab2").hide();
        $(".my_title_trees_ajx").show();
        $(".my_title_trees2_ajx").show();
        $(".my_title_trees_ajx").css({'cursor': 'pointer'}).addClass('link');
        $(".my_title_trees_ajx").toggle(
            function () {


                $(this).addClass('hover');
                $("#tree_content_ajx").slideToggle('slow');
            },
            function () {
                $(this).removeClass('hover');
                $("#tree_content_ajx").slideToggle('slow');
            }
        );


        $(".my_title_trees2_ajx").css({'cursor': 'pointer'}).addClass('link');
        $(".my_title_trees2_ajx").toggle(
            function () {


                $(this).addClass('hover');
                $("#tree_content_ajx2").slideToggle('slow');
            },
            function () {
                $(this).removeClass('hover');
                $("#tree_content_ajx2").slideToggle('slow');
            }
        );
    } else {
        /*******************************************************/
        //TOGGLE TABLE  FF
        /*******************************************************/

        $(".my_title_trees_ajx").hide();
        $(".my_title_trees2_ajx").hide();
        $(".my_title_trees_ajx_tab").show();
        $(".my_title_trees_ajx_tab2").show();

        $(".my_title_trees_ajx_tab").css({'cursor': 'pointer'}).addClass('link');
        $(".my_title_trees_ajx_tab").toggle(
            function () {


                $(this).addClass('hover');
                $("#tree_content1").slideToggle('slow');
            },
            function () {
                $(this).removeClass('hover');
                $("#tree_content1").slideToggle('slow');
            }
        );


        $(".my_title_trees_ajx_tab2").css({'cursor': 'pointer'}).addClass('link');
        $(".my_title_trees_ajx_tab2").toggle(
            function () {


                $(this).addClass('hover');
                $("#tree_content2").slideToggle('slow');
            },
            function () {
                $(this).removeClass('hover');
                $("#tree_content2").slideToggle('slow');
            }
        );

    }//end else
    /*****************************************************************/


///////////////////////////////////////////////////////////////
    new setupAjaxForm('forum');             ////////////////////
/////////////////////////////////////////////////////////////  	 

    $("#loading img").ajaxStart(function () {
        $(this).show();
    }).ajaxStop(function () {
        $(this).hide();
    });

    /**************************************/
});//end ready
/****************************************/
  