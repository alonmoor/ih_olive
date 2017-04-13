<?php 
require_once '../config/application.php';
if(!isAjax())
html_header();


?>	
	<style>
	.pager {padding:5px 0;}
.active {color:black; border:solid 1px black;}			
.clickable {font-size:11px; color:gray; background:#F5F5F5; border:solid 1px gray; padding:0 5px; margin:0 5px; cursor:pointer;}
	
	
	</style>
		<script type="text/javascript">
			$(document).ready(function() {
				//TARGET PAGER
				$('ul.paginated').each(function() {
					//SET PAGER VARS
					var currentPage = 0;
					var numPerPage = 4;
					//STORE EVENT CONTEXT, $ul
					var $ul = $(this);
					//BIND EVENT TO repaginate, show CURRENT, hide OTHERS
					$ul.bind('repaginate', function() {
						$ul.find('li.a').show()
							.slice(0, currentPage * numPerPage)
								.hide()
							.end()
							.slice((currentPage + 1) * numPerPage)
								.hide()
							.end();
					});
					//CALCULATE NUMBER OF PAGES, numRows / numPerPage
					var numRows = $ul.find('li.a').length;
					var numPages = Math.ceil(numRows / numPerPage);
					//CREATE PAGE NUMBERS, THEN insertAfter($ul)
					var $pager = $('<div class="pager"></div>');
					for (var page = 0; page < numPages; page++) {
						$('<span class="page-number">' + (page + 1) + '</span>')
						.bind('click', {'newPage': page}, function(event) {
							currentPage = event.data['newPage'];
							$ul.trigger('repaginate');
							$(this).addClass('active').siblings().removeClass('active');
						})
						.appendTo($pager).addClass('clickable');
					}
					$pager.find('span.page-number:first').addClass('active');
					$pager.insertAfter($ul);
					//TRIGGER EVENT
					$ul.trigger('repaginate');
				});
			});
		</script>
		<ul class="paginated"> 
		 
              
			<li class="a">alon </li>
			 
		         
                
	         

			<li class="a">tres</li>
			
			<li class="a">cuatro
			<ul>
			    <li>a
			        <ul>          
			            <li>111111111111111111111111111
			           <ul>  
			              <li>22222222222222222222222222222
			            
			                 <ul><li> cccccccc </li></ul>
			              </li> 
			           </ul> 
			           </li>  
			       </ul> 
			    </li>
			    <li>b</li>
			    <li>c</li>
			    <li>d</li>
			</ul>	    
			</li>
			
			
			
			
<ul>
   <li style="display: none;" class="a"> 1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111 </li>

       <ul>  777777777777777777777
           <ul>
             <li> aaaaaaa
              <ul>
                <li> bbbbbbbbb
                  <ul>
                   <li> cccccccc
                      <ul>
                        <li> ddddddd
           </li></ul>
           </li></ul>
            </li></ul>
             </li></ul>

 </li></ul>
<li style="display: none;" class="li_page"> 1yjjfghjfghjggg </li>
			
			
			
			
			
			
		  
			<li class="a">cinco</li>
			<li class="a">seis</li>
			<li class="a">siete</li>
<!--			    <ul><li> aaaaaaa </li>-->
<!--			          <ul><li> bbbbbbbbb </li>-->
<!--			              <ul><li> cccccccc </li>-->
<!--			                <ul><li> ddddddd </li>-->
<!--			          </ul>-->
<!--                   </ul>-->
<!--               </ul>   -->
<!--           </ul>  -->
                   

                
           

         
      
   
			<li class="a">ocho</li>
			<li class="a">nueve</li>
			<li class="a">diez</li>
			<li class="a">once</li>
			<li class="a">doce</li>
		 	
		</ul>
<!--		<h1>Paginating with jQuery</h1>-->
<!--		-->
<!-- <ul class="paginated"> -->
<!--		 <table>-->
<!--              -->
<!--			<li class="li_page">alon </li>-->
<!--			 -->
<!--		         -->
<!--                -->
<!--	         -->
<!---->
<!--			<li class="li_page">tres</li>-->
<!--			-->
<!--			<li class="li_page">cuatro-->
<!--			<ul>-->
<!--			    <li>a</li>-->
<!--			    <li>b</li>-->
<!--			    <li>c</li>-->
<!--			    <li>d</li>-->
<!--			</ul>	    -->
<!--			</li>-->
<!--		  -->
<!--			<li class="li_page">cinco</li>-->
<!--			<li class="li_page">seis</li>-->
<!--			<li class="li_page">siete</li>-->
<!--			<li class="li_page">ocho</li>-->
<!--			<li class="li_page">nueve</li>-->
<!--			<li class="li_page">diez</li>-->
<!--			<li class="li_page">once</li>-->
<!--			<li class="li_page">doce</li>-->
<!--		</table>	-->
<!--		</ul>-->
<!-- -->
<!--<ul class="paginated">-->
<!-- <li> החלטות בעין -השופט </li>-->
<!--<ul>-->
<!---->
<!---->
<!--<li class='li_page'> 1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111 </li>-->
<!---->
<!--<ul><li> 777777777777777777777 </li>-->
<!---->
<!--     <ul><li> aaaaaaa </li>-->
<!---->
<!--     <ul><li> bbbbbbbbb </li>-->
<!---->
<!--      <ul><li> cccccccc </li>-->
<!---->
<!--      <ul><li> ddddddd </li>-->
<!--            </ul>-->
<!---->
<!--          </ul>-->
<!--      </ul>-->
<!--     </ul>-->
<!--   </ul>-->
<!--<li class='li_page'> 1yjjfghjfghjggg </li>-->
<!--<li class='li_page'> 2222222222 </li>-->
<!--<li class='li_page'> 22222222222 </li>-->
<!--<li class='li_page'> 22222222222 </li>-->
<!--<li class='li_page'> 22222222222 </li>-->
<!--<li class='li_page'> 22222222222 </li>-->
<!---->
<!--<ul>-->
<!--    <li> gfgfghjfgj </li>-->
<!--</ul>-->
<!---->
<!--<li class='li_page'> 22222222222 </li>-->
<!--<li class='li_page'> 22222222222 </li>-->
<!--<li class='li_page'> 22222222222 </li>-->
<!--<li class='li_page'> 22222222222 </li>-->
<!--<li class='li_page'> 22222222222 </li>-->
<!--<li class='li_page'> 22222222222 </li>-->
<!--<li class='li_page'> 22222222222 </li>-->
<!--<li class='li_page'> 222222222223-->
<!--3-->
<!--3-->
<!--3-->
<!--3 </li>-->
<!--<li class='li_page'> 2222255555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555 </li>-->
<!--<li class='li_page'> 3 </li>-->
<!--<li class='li_page'> 3 </li>-->
<!--<li class='li_page'> 3 </li>-->
<!--<li class='li_page'> 33333333333333 </li>-->
<!---->
<!---->
<!--<ul><li> DDDDDDDDDDDDDDD </li>-->
<!--<li> DDDDDDDDDDDDDDD </li>-->
<!--<li> DDDDDDDDDDDDDDD </li>-->
<!--</ul>-->
<!---->
<!---->
<!--<li class='li_page'> 4 </li>-->
<!---->
<!--<ul><li> tttttttttt </li>-->
<!--</ul>-->
<!---->
<!---->
<!---->
<!--<li class='li_page'> 444444444444444 </li>-->
<!--<li class='li_page'> 444444444444444444444444444444444444444444444444444444444444444444444444 </li>-->
<!--<ul><li> tttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttt </li>-->
<!--<ul><li> 2 </li>-->
<!--<li> 2 </li>-->
<!--<li> 2 </li>-->
<!--<li> 2 </li>-->
<!--<li> 2 </li>-->
<!--<li> 2 </li>-->
<!--<li> 2 </li>-->
<!--<li> 2 </li>-->
<!--<li> 2 </li>-->
<!--<li> 2 </li>-->
<!--<li> 2 </li>-->
<!--<li> 2 </li>-->
<!--<li> 2 </li>-->
<!--<li> 2 </li>-->
<!--<li> 2 </li>-->
<!--<li> 2 </li>-->
<!--<li> 2 </li>-->
<!--</ul>-->
<!--</ul>-->
<!--</ul>		-->
<!--</ul>		-->
		
		
<?php html_footer(); ?>	