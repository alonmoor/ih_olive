<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<title>
<?php // Use a default page title if one wasn't provided...
if (isset($page_title)) { 
		echo $page_title; 
} else { 
		//echo 'Knowledge is Power: And It Pays to Know'; 
} 
?>
</title>


   <link rel="stylesheet" type="text/css" media="all"  href="<?php echo CSS_DIR ?>/log_inout.css" />
  
   <link rel="stylesheet" type="text/css" media="all"  href="<?php echo CSS_DIR ?>/themes/start/jquery-ui-1.7.3.custom.css">
   <link rel="stylesheet" type="text/css" media="all"  href="<?php echo CSS_DIR ?>/themes/smoothness/ui.all.css">
 
 
   
  <script  language="JavaScript" src="<?php print JQ_ADMIN_WWW ?>/jquery-1.3.2.min.js"           type="text/javascript"></script> 
    <script  language=javascript" src="<?php print  JQ_ADMIN_WWW ?>/date_picker.js"           charset="utf-8"        type="text/javascript"></script> 
    <script  language="JavaScript" src="<?php print JQ_ADMIN_WWW ?>/jquery-ui-1.7.3.custom.min.js" charset="utf-8" type="text/javascript"></script> 
     
  
  
  
  
  
  <script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/ajx_multi.js"             charset="utf-8"          type="text/javascript"></script>
  <script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/ajx_multi_user.js"         charset="utf-8"              type="text/javascript"></script>

  <script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/answere.js"  charset="utf-8"   type="text/javascript"></script>
 
  <script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/log_inout.js"         charset="utf-8"              type="text/javascript"></script>
  <script  language="JavaScript" src="<?php print JS_ADMIN_WWW ?>/blog_admin.js"         charset="utf-8"              type="text/javascript"></script>
  
  <script type="text/javascript" src="<?php echo ROOT_WWW; ?>/tiny_mce/jquery.tinymce.js"></script>
  <script type="text/javascript" src="<?php echo ROOT_WWW; ?>/tiny_mce/tiny_mce.js"></script> 


 
</head>
<body>
 
<div id="wrap">

	<div class="header">
	<h3 style="align:center;"><a href="#">מערכת מעקב אחרי החלטות</a></h3>
		
	</div>
	<div id="nav">
		<ul>
			<!-- MENU -->
			<?php // Dynamically create header menus...
			
			// Array of labels and pages (without extensions):
			$pages = array (
			 	'דף הביית' => 'index.php?mode=home_page',
				'אודותינו' => '#',
				'צור קשר' => 'index.php?mode=talk2us',
				'הירשם' => 'index.php?mode=sighn_in'

			);

			if(!array_item($_GET,'mode'))
            $_GET['mode']='home_page';
            $mode= $_GET['mode'];	
            $mode="?mode=$mode";		
			// The page being viewed:
			$this_page = basename($_SERVER['PHP_SELF']);
			$this_page="$this_page$mode";
			 $TEMPLATE['extra_head']=(isset($TEMPLATE['extra_head']))?(string)$TEMPLATE['extra_head']:'';
			
			
			
			// Create each menu item:
			foreach ($pages as $k => $v) {
				
				// Start the item:
				echo '<li  ';
				
				// Add the class if it's the current page:
				 if ($this_page == $v){ 
				 echo ' class="selected"';
				 }
				// Complete the item:
				echo '><a href="' . $v . '" ><span>' . $k . '</span></a></li>';
				
			} // End of FOREACH loop.
			?>
			<!-- END MENU -->
		</ul>
	</div>
	
	<div class="page">
	
		<div class="content" id="my_home_content">
<?php if( !(array_item($_GET, 'mode')=='add_page')  
          && !(array_item($_POST, 'submit_addPage'))  
          && !(array_item($_REQUEST, 'mode')=='add_pdf')
          
          && !(array_item($_REQUEST, 'mode')=='add_polls')
          && !(array_item($_REQUEST, 'mode')=='view_polls')
          && !(array_item($_REQUEST, 'mode')=='edit_polls')
          && !(array_item($_REQUEST, 'mode')=='add_polls_item')
          && !(array_item($_REQUEST, 'mode')=='dell_polls')
           
          && !(array_item($_REQUEST, 'mode')=='view_blogs')
          && !(array_item($_REQUEST, 'mode')=='add_blog')
          && !(array_item($_REQUEST, 'mode')=='post_admin')
          
          && !(array_item($_REQUEST, 'mode')=='edit_forums')
          && !(array_item($_REQUEST, 'mode')=='editForum')
          && !(array_item($_REQUEST, 'mode')=='view_forums')
           && !(array_item($_REQUEST, 'mode')=='add_msgForum')
            && !(array_item($_REQUEST, 'mode')=='add_post')
            
            && !(array_item($_REQUEST, 'mode')=='act_file')
           && !(array_item($_REQUEST, 'mode')=='deact_file')
           && !(array_item($_REQUEST, 'mode')=='del_file')
           && !(array_item($_REQUEST, 'mode')=='edit_file')
           && !(array_item($_REQUEST, 'mode')=='edit_web')
           && !(array_item($_REQUEST, 'mode')=='add_file_item')
           
           
           
            && !(array_item($_REQUEST, 'mode')=='act_file_win')
           && !(array_item($_REQUEST, 'mode')=='deact_file_win')
           && !(array_item($_REQUEST, 'mode')=='del_file_win')
           && !(array_item($_REQUEST, 'mode')=='edit_file_win')
           && !(array_item($_REQUEST, 'mode')=='edit_web_win')
           && !(array_item($_REQUEST, 'mode')=='add_file_item_win')
           
           
         //  &&!(array_item($TEMPLATE ,'extra_head')=='<script type="text/javascript"  src="/alon-web/olive/admin/js/401.js" ></script>')
           &&!(array_item($TEMPLATE ,'extra_head')=='<script type="text/javascript"  src="'.ROOT_WWW.'/admin/js/401.js" ></script>')
           
          ){ ?>		          
<div class="sidebar column-left">	
			
			<!-- SIDEBAR -->
			<ul>	
				<li>
<!--					<h3>קישורים</h3>-->
            <div class="title" id="footer_title3">
				<h4>קישורים</h4>
			</div>
					<ul id="ul_link">
					    <li><a href="javascript:void(0)" title="free web templates">קיבוץ עין השופט</a></li>
						<li><a href="javascript:void(0)" title="webmaster forums">קיבוץ עין השופט</a></li>
						<li><a href="javascript:void(0)" title="mybb themes">קיבוץ עין השופט</a></li>
						<li><a href="javascript:void(0)" title="free phpbb3 themes">קיבוץ עין השופט</a></li>
					</ul>
				</li>
				
				<li>
<!--					<h3>קטגוריות</h3>-->
               <div class="title" id="footer_title4">
				<h4>קטגוריות</h4>
		       </div>

					<ul id="ul_link2">
					  <li><a href="javascript:void(0)">קיבוץ עין השופט</a></li>
					  <li><a href="javascript:void(0)">קיבוץ עין השופט</a></li>
					  <li><a href="javascript:void(0)">קיבוץ עין השופט</a></li>
					  <li><a href="javascript:void(0)">קיבוץ עין השופט</a></li>
			    	</ul>
				</li>
			</ul>
			<!-- SIDEBAR -->
	
		</div>
	 
			<!-- CONTENT -->
<?php }?>			