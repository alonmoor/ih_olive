
/********************************************************************************************/
// update the post_date field when the user changes the calendar's date
	        function updatePostDate(type,args,obj)
	        {
	            var month = (args[0][0][1] < 10) ? '0' + args[0][0][1] : args[0][0][1];
	            var day = (args[0][0][2] < 10) ? '0' + args[0][0][2] : args[0][0][2];
	            var year = args[0][0][0];

	            document.getElementById('post_date').value = month + '/' + day + '/' + year;
	            window.cal1.hide();
	            post_date.hide();
	        }
/********************************************************************************************************/
	        // update the calendar's date when the user changes the post_date field
	        function updateCalendar1()
	        { 
	            var field = document.getElementById('post_date'); 

	            if (field.value)
	            { 
	                window.cal1.select(field.value); 
	                var selectedDates = window.cal1.getSelectedDates(); 
	                if (selectedDates.length > 0)
	                { 
	                    var firstDate = selectedDates[0]; 
	                    window.cal1.cfg.setProperty('pagedate',
	                        (firstDate.getMonth() + 1) + '/' + firstDate.getFullYear()); 
	                }
	            } 
	            window.cal1.render(); 
	        }
/********************************************************************************************************/
	        // update the calendar's date when the user changes the post_date field
	        function updateCalendar  ()
	        { 
	            var field = document.getElementById('post_date'); 

	            if (field.value)
	            { 
	             //   $('#post_date').val();
	            	window.post_date.select(field.value); 
	                var selectedDates = window.post_date.getSelectedDates(); 
	                if (selectedDates.length > 0)
	                { 
	                    var firstDate = selectedDates[0]; 
	                    $('#post_date').setProperty('pagedate',
	                        (firstDate.getMonth() + 1) + '/' + firstDate.getFullYear()); 
	                }
	            } 
	            $('#post_date').render(); 
	        }
/********************************************************************************************************/	        
	        // unhide the form when the user choses to modify a page
	        function show_form()
	        {
 	        
	        	
	        	// fetch_info();
	            
	            document.getElementById('form_select').style.display = 'none';
	            document.getElementById('form_fields').style.display = '';
	            if (document.getElementById('post_id').value == 'new')
	            {
	                document.getElementById('delete_field').style.display = 'none';
	            }
	            else
	            {
	                document.getElementById('delete_field').style.display = '';
	            }
	        }
/********************************************************************************************************/
	        // confirm is user checked delete 
	        function submit_form()
	        {
	            if (document.getElementById('delete').checked)
	            {
	                return confirm('Are you sure you wish to delete this entry?');
	            }
	        }
/**************************************************************************************************/
	        // highlight the submit button if record will be deleted
	        function submit_warning()
	        {
	            if (document.getElementById('delete').checked)
	            {
	                document.getElementById('form_submit').style.backgroundColor =
	                    '#FF9999';
	            }
	            else
	            {
	                document.getElementById('form_submit').style.backgroundColor = '';
	            }    
	        }
/*****************************************************************************************************/
	        // clear form
	        function reset_form()
	        {
	            if (!confirm('Are you sure you wish to cancel?')) return false;

	            document.getElementById('form_fields').style.display = 'none';
	            document.getElementById('form_select').style.display = '';

	            // manually clear the RTE area
	            document.getElementById('post_text').value = '';
	            tinyMCE.updateContent(tinyMCE.getInstanceById('mce_editor_0').formElement.id);

	            // default action of reset button will clear fields and reset select index
	            // so an explicit clearing is not needed so long as we return true to not
	            // break that bubble
	            return true;
	        }
/********************************************************************************************************/
	        // retrieve existing information via "AJAX" 
	        var httpObj;
	        function fetch_info()
	        {
	            var select = document.getElementById('post_id') ;
	           
	            if (select.options[select.selectedIndex].value == 'new') 
	            {
	                return;
	            }

	            var url = 'fetch_admin.php?post_id=' +
	                 select.options[select.selectedIndex].value + "&nocache=" +(new Date()).getTime();

	            httpObj = createXMLHTTPObject();
	            httpObj.open('GET', url, true);
	            httpObj.onreadystatechange = function()
	            {
	                // populate the fields
	                if (httpObj.readyState == 4 && httpObj.responseText)
	                {
	                    var r = eval('(' + httpObj.responseText + ')');

	                    document.getElementById('post_title').value = r.post_title;
	                    document.getElementById('post_date').value = r.post_date;
	                     
	                    document.getElementById('post_text').value = r.post_text;
	                    tinyMCE.updateContent(tinyMCE.getInstanceById('mce_editor_0').formElement.id);
	                 
	                }
	            }
	            httpObj.send(null);
	        }

/********************************************************************************************************/

	        function getElementsByClass(search)
	        {
	            var classElements = new Array();
	            var els = document.getElementsByTagName('*');
	            var pattern = new RegExp('(^|\\s)' + search + '(\\s|$)');

	            for (var i = 0, j = 0; i < els.length; i++)
	            {
	                if (pattern.test(els[i].className))
	                {
	                    classElements[j] = els[i];
	                    j++;
	                }
	            }
	            
	            return classElements;
	        }
/*************************************************************************************************/
	        /* create an XML HTTP Request object for "ajax" calls */
	        function createXMLHTTPObject()
	        {
	            if (typeof XMLHttpRequest != 'undefined')
	            {
	                return new XMLHttpRequest();
	            }
	            else if (window.ActiveXObject)
	            {
	                var vers = [
	                    'Microsoft.XmlHttp',
	                    'MSXML2.XmlHttp',
	                    'MSXML2.XmlHttp.3.0',
	                    'MSXML2.XmlHttp.4.0',
	                    'MSXML2.XmlHttp.5.0'
	                ];

	                for (var i = vers.length - 1; i >= 0; i--)
	                {
	                    try
	                    {
	                        httpObj = new ActiveXObject(vers[i]);
	                        return httpObj;
	                    }
	                    catch(e) {}
	                }
	            }
	            throw new Error('XMLHTTP not supported');
	        }
 /****************************************BLOG.js*****************************************************/
	        //toggle the comments display of a particular post
	        function toggleComments(id, link)
	        {
	            var div = document.getElementById('comments_' + id);

	            if (div.style.display == 'none')
	            {
	                link.innerHTML = 'הסתר הערות';
	                fetchComments(id);
	                div.style.display = '';
	            }
	            else
	            {
	                link.innerHTML = 'הראה הערות';
	                div.style.display = 'none';
	            }
	        }
/*********************************************************************************************************/	        

	        // retrieve existing comments via "AJAX" 
	        window.httpObj;
	        function fetchComments(id)
	        {
	        	// $('div#middle_div').css('width','80%') ;
	            var div = document.getElementById('comments_' + id);

	            var url = 'fetch.php?post_id=' + id + "&nocache=" + 
	                (new Date()).getTime();

	            window.httpObj = createXMLHTTPObject();
	            window.httpObj.open('GET', url , true);
	            window.httpObj.onreadystatechange = function()
	            {
	                // populate the fields
	                if (window.httpObj.readyState == 4 && httpObj.responseText)
	                {
	                	
	                    div.innerHTML = httpObj.responseText;
	                }
	            }
	            window.httpObj.send(null);
	        }

	        // submit a comment via "AJAX"
	        function postComment(id, form)
	        {
	            var url = form.action + "&nocache=" + (new Date()).getTime();
//	            var data = 'person_name=' + escape(form.person_name.value) +
//	                '&post_comment=' + escape(form.post_comment.value);
	            
	            var data = 'person_name=' +  form.person_name.value  +
                '&post_comment=' + form.post_comment.value;

	            window.httpObj = createXMLHTTPObject();
	            window.httpObj.open('POST', url , true);
	            window.httpObj.setRequestHeader('Content-type',
	                'application/x-www-form-urlencoded');
	            window.httpObj.setRequestHeader('Content-length', data.length);
	            window.httpObj.setRequestHeader('Connection', 'close');

	            window.httpObj.onreadystatechange = function()
	            {
	                // populate the fields
	                if (window.httpObj.readyState == 4 && window.httpObj.responseText)
	                {
	                    if (window.httpObj.responseText == 'OK')
	                    {
	                        fetchComments(id);
	                    }
	                    else
	                    {
	                        alert('Error posting comment.');
	                    }
	                }
	            }
	            window.httpObj.send(data);
	            return false;
	        }
