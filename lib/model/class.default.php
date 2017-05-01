<?php

 

class DefaultLang
{
	private $default_js = array
	(
		'actionNote' => "רשימות",
		'actionEdit' => "עריכה",
		'actionDelete' => "מחיקה",
	    'actionShowTask' => "הראה משימות שאני כתבתי בחלון",
	    'actionShowupTask' => "הראה משימות שאני כתבתי בדף",
	    'actionSendwinTask' => "הראה משימות שכתבו אלי בחלון",
	    'actionSendTask' => "הראה משימות שכתבו אלי בדף", 
	    'actionDairy' => "יומן אישי", 
		'taskDate' => array("function(date) { return 'added at '+date; }"),
		'confirmDelete' => "האים אתה בטוח?",
		'actionNoteSave' => "save",
		'actionNoteCancel' => "cancel",
		'error' => "Some error occurred (click for details)",
		'denied' => "Access denied",
		'invalidpass' => "Wrong password",
		'readonly' => "read-only",
		'tagfilter' => "תגית:",
	);

	private $default_inc = array
	(
		'My Tiny Todolist' => "ניהול משימות",
		'tab_newtask' => "משימה חדשה",
		'tab_search' => "חפש משימה",
	    'tab_users' => "ניהול משתמשים",
		'btn_add' => "הוסף משימה",
	    'btn_addUsr' => "הוסף משתמש", 
		'btn_search' => "חפש משימה",
		'searching' => "מחפש את המשימה",
	    'no_task' => "אין משימות כרגע", 
		'tasks' => "משימות",
	    'users' => "מנהל+חברי פורום", 
		'edit_task' => "ערוך משימה",
	    'edit_user' => "ערוך משתמש", 
		'priority' => "עדיפויות:",
	   	'forum_user' => "חבר פורום",
	    'admin' => "מנהל",
	    'suppervizer' => "מפקח", 
		'task' => "משימה",
	    'user' => "שם משתמש:", 
	    'email' => "דואר אלקטרוני:",
	    'upass' => "סיסמה:", 
	    'level' => "תאור תפקיד:",  
		'note' => "רשימות",
		'save' => "שמור",
		'cancel' => "בטל",
		'password' => "Password",
		'btn_login' => "Login",
		'a_login' => "Login",
		'a_logout' => "Logout",
		'tags' => "סנון לפי תגיות",
	    'usertags' => "סנון משתמשים לפי תגיות", 
		'tagfilter_cancel' => "בטל סינון לפי תגיות",
		'sortByHand' => "מיון ידני",
		'sortByPriority' => "מיון לפי עדיפויות",
		'sortByDueDate' => "מיון לפי תאריכים",
	    'sortBygroupBy' => "קבוץ משימות לפי שולחים",
	    'sortgroupBy' => "קבוץ משימות לפי מקבלים", 
		'due' => "תאריך",
		'daysago' => "מאחר ב-%d  ימים",
		'indays' => "בעוד %d ימים",
		'months_short' => array("ינואר","פבואר","מרץ","אפריל","מאי","יוני","יולי","אוגוסט","ספטמבר","אוקטובר","נובמבר","דצמבר"),
		//'days_min' => array("Su","Mo","Tu","We","Th","Fr","Sa"),
	    'days_min' => array("ראשון","שני","שלישי","רביעי","חמישי","שישי","שבת"),
		'date_md' => "%1\$s %2\$d",
		'date_ymd' => "%2\$s %3\$d, %1\$d",
		'today' => "היום",
		'yesterday' => "אתמול",
		'tomorrow' => "מחר",
		'f_past' => "מתעכבות",
	    'f_past1' => "מתעכבים",
		'f_today' => "היום ומחר",
		'f_soon' => "בקרוב",
		'tasks_and_compl' => "משימות+משימות שבוצעו",
	    'users_and_compl' => "משתמשים פתוחים+סגורים",
	    'users_compl' => "משתמשים סגורים",
	    'tasks_compl' => "משימות שבוצעו",
	    'sendBY'=>"נשלח מחבר פורום",
	    'too_a'=>"אל חבר פורום", 
	    'sendBY1'=>"מ..",
	    'too_a1'=>"אל..", 
	    'multiAction'=>"פעולות כפולות", 
	    'del_tasks'=>"מחק כמה משימות", 
	    'send_tasks'=>"שלח משימה לכמה אנשים",
	    'send2tasks'=>" משימות שאני כתבתי לחברי פורום או שכתבתי משימה לעצמי ",
	    'tasks2me'=>" משימות שחברי פורום כתבו אליי או שכתבתי משימה לעצמי ",
	    'forum_details'=>"נתוני פורום",
	    'dec_details'=>"נתוני החלטה", 
	    'active'=>"סטטוס חבר:", 
	    'phone'=>"טלפון:",  
	    'full_name'=>"שם החבר:", 
	
       'dueForum'=>"תאריך השמה בפורום:", 
       'dueLast'=>"מצב משימה אחרונה:",
	//not a part of class default	
	
	);
	var $js = array();
	var $inc = array();

	function makeJS()
	{
		$a = array();
		foreach($this->default_js as $k=>$v)
		{
			if(isset($this->js[$k])) $v = $this->js[$k];

			if(is_array($v)) {
				$a[] = "$k: ". $v[0];
			} else {
				$a[] = "$k: \"". str_replace('"','\\"',$v). "\"";   
			}
		}
		$t = array();
		foreach($this->get('days_min') as $v) { $t[] = '"'.str_replace('"','\\"',$v).'"'; }
		$a[] = "daysMin: [". implode(',', $t). "]";
		$t = array();
		foreach($this->get('months_short') as $v) { $t[] = '"'.str_replace('"','\\"',$v).'"'; }
		$a[] = "monthsShort: [". implode(',', $t). "]";
		return "lang = {\n". implode(",\n", $a). "\n};";
	}

	function get($key)
	{
		if(isset($this->inc[$key])) return $this->inc[$key];
		if(isset($this->default_inc[$key])) return $this->default_inc[$key];
		return $key;
	}

	function formatMD($m, $d)
	{
		$months = $this->get('months_short');
		return sprintf($this->get('date_md'), $months[$m-1], $d);
	}

	function formatYMD($y, $m, $d)
	{
		$months = $this->get('months_short');
		return sprintf($this->get('date_ymd'), $y, $months[$m-1],  $d);
	}
	
}

