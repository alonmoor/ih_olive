$(document).ready(function(){
		
	//Display Loading Image
	function Display_Load()
	{
		var url='../images/';
	    $("#loading").fadeIn(900,0);
		$("#loading").html("<img src='../images/loading1_24.gif' />");
	}
	//Hide Loading Image
	function Hide_Load()
	{
		$("#loading").fadeOut('slow');
	};
	

   //Default Starting Page Results
   
	$("#pagination li:first").css({'color' : '#FF0084'}).css({'border' : 'none'});
	
	Display_Load();
	
	$("#content").load("pagination_data.php?page_dec=1", Hide_Load());



	//Pagination Click
	$("#pagination li").click(function(){
			
		Display_Load();
		
		//CSS Styles
		$("#pagination li")
		.css({'border' : 'solid #dddddd 1px'})
		.css({'float' : 'right'})
		.css({'color' : '#0063DC'});
		
		$(this)
		.css({'color' : '#FF0084'})
		.css({'border' : 'none'});

		//Loading Data
		//var pageNum = this.id;

		var pageNum = this.id;

		$("#content").load("pagination_data.php?page_dec=" + pageNum, Hide_Load());
	});
	
	
});