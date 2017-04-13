		 
 function shalom(bar) {
  
			if (confirm("?האם בטוח שרוצה לבצע פעולה זו")) {
				document.getElementById('mode_'+  bar).value='delete';
			
            return true;
            }else {
            
            return false;
        }
			 
	}

	
	
	