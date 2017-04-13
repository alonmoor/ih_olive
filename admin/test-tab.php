<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Simple JQuery Tabs</title>
<style>
body {
font: 12px Arial, Helvetica, sans-serif;
}
#myDemoLinks {
display: block;
}

#myDemoLinks ul {
margin: 1em 0 0 0;
list-style-type: none;
padding: 3px 10px 0 10px;
}
#myDemoLinks ul li {
display: inline;
padding: 3px 4px;
background: #ccc;
margin-right: 5px;
cursor: hand;
}
#myDemoLinks ul li.myCurrentItemStyle {
display: inline;
padding: 3px 4px;
background: #333;
color: #fff;
margin-right: 5px;
cursor: hand;
}

#myDemoContainer {
margin:3px;
width: 440px;
height: 80px;
padding: 10px;
border: 1px solid #333;
}
#firstContainer {
background: #069;
color: #fff;
display: none;
height: 40px;
padding: 20px;
}
#secondContainer {
background: #00496C;
color: #fff;
display: none;
height:40px;
padding: 20px;
}
</style>

<script type="text/javascript" src="jquery/jquery-1.4.2.min.js"></script>
<script>
$(document).ready(function(){

$("#firstContainer").show();
$("#firstLink").addClass("myCurrentItemStyle");

$("#myDemoLinks #firstLink").click(function () {
$("#firstContainer").show("slow").siblings(".demoContent").hide();
$(this).addClass("myCurrentItemStyle");
$(this).siblings(".links").removeClass("myCurrentItemStyle");
});

$("#myDemoLinks #secondLink").click(function () {
$("#secondContainer").show("slow").siblings(".demoContent").hide();
$(this).addClass("myCurrentItemStyle");
$(this).siblings(".links").removeClass("myCurrentItemStyle");
});

});
</script>

</head>

<body>
<div id="myDemoLinks">
<ul>
<li class="links" id="firstLink">First Container</li>
<li class="links" id="secondLink">Second Container</li>
</ul>
</div>
<div id="myDemoContainer">
<div id="firstContainer" class="demoContent">First Container</div>
<div id="secondContainer" class="demoContent">Second Container</div>
</div>
</body>
</html>




<!DOCTYPE html>
<html>
<head>
	<title>jQuery UI Tabs</title>

	<link rel="stylesheet" type="text/css" media="all"
		href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/ui-darkness/jquery-ui.css"/>

	<script type="text/javascript" 
		src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js">
	</script>

	<script type="text/javascript" 
		src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/jquery-ui.min.js">
	</script>

	<script type="text/javascript">
	$(function() {
		$("#tabs").tabs({
			ajaxOptions: {
				eror: function(xhr, status, index, anchor) {
					$(anchor.hash).html("Failed to load this tab!");
				}
			}
		});

		$('#tabs div.ui-tabs-panel').height(function() {
			return $('#tabs-container').height()
				   - $('#tabs-container #tabs ul.ui-tabs-nav').outerHeight(true)
				   - ($('#tabs').outerHeight(true) - $('#tabs').height())
                                   // visible is important here, sine height of an invisible panel is 0
				   - ($('#tabs div.ui-tabs-panel:visible').outerHeight(true)  
					  - $('#tabs div.ui-tabs-panel:visible').height());
		});
	});
	</script>

	<style type="text/css">
		.ui-tabs .ui-tabs-panel {
			overflow: auto;
		}
	</style>
</head>

<body>
	<div id="tabs-container" style="height:250px; border:1px #aaa solid;">
	<div id="tabs" style="width:70%">
		<ul>
			<li><a href="#tab1">Tab 1</a></li>
			<li><a href="#tab2">Tab 2</a></li>
			<li><a href="#tab3">Tab 3</a></li>
		</ul>

		<div id="tab1">
			This is the content for tab1.
			This is the content for tab1.
			This is the content for tab1.
			This is the content for tab1.
			This is the content for tab1.
			This is the content for tab1.
			This is the content for tab1.
			This is the content for tab1.
		</div>

		<div id="tab2">
				<pre>
Reads some number of bytes from the input stream and stores them into the 
buffer array b. The number of bytes actually read is returned as an integer. 
This method blocks until input data is available, end of file is detected, 
or an exception is thrown.

If the length of b is zero, then no bytes are read and 0 is returned; 
otherwise, there is an attempt to read at least one byte. If no byte is 
available because the stream is at the end of the file, the value -1 is 
returned; otherwise, at least one byte is read and stored into b.

The first byte read is stored into element b[0], the next one into b[1], 
and so on. The number of bytes read is, at most, equal to the length of b. 
Let k be the number of bytes actually read; these bytes will be stored in 
elements b[0] through b[k-1], leaving elements b[k] through b[b.length-1] 
unaffected. 
			</pre>
		</div>

		<div id="tab3">
			Only one line.
		</div>
	</div>
	</div>
</body>
</html>
<?php
