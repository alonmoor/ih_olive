<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head profile="http://gmpg.org/xfn/11">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>AJAX File Upload - Web Developer Plus Demos</title>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.8/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/ajaxupload.3.5.js" ></script>
    <link rel="stylesheet" type="text/css" href="./styles.css" />
    <script type="text/javascript">
        $(document).ready(function() {
            $( "#files").sortable({
                handle : '.handle',
                placeholder: 'widget-placeholder',
                forcePlaceholderSize: true,
                revert: 300,
                delay: 100,
                update : function () {
                    var order = $('#files').sortable('serialize');
                    $("#info").load("includes/update_slider_order.php?list=1&"+order);
                }
            });
        });
    </script>
    <script type="text/javascript" >
        $(function(){
            var btnUpload=$('#upload');
            var status=$('#status');
            new AjaxUpload(btnUpload, {
                action: 'upload-file.php?pg=3',
                name: 'uploadfile',
                onSubmit: function(file, ext){
                    if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
                        // extension is not allowed
                        status.text('Only JPG, PNG or GIF files are allowed');
                        return false;
                    }
                    status.text('Uploading...');
                },
                onComplete: function(file, response){
                    //On completion clear the status
                    status.text('');
                    //Add uploaded file to list
                    if(response >'0'){
                        $('<li id="list_'+response+'"></li>').appendTo('#files').html('<center><input type="text" name="title" style="margin-bottom:10px;width:180px;" value=""><br><img class="handle" src="./uploads/3/'+file+'" alt="" /></center>').addClass('success');
                    } else{
                        $('<li></li>').appendTo('#files').text(file).addClass('error');
                    }
                }
            });

        });
    </script>
</head>
<body>
<div id="mainbody" >
    <div id="upload" ><span>Upload File</span></div><span id="status" ></span>
    <div id="info"></div>
    <ul id="files" >
    </ul>
</div>

</body>