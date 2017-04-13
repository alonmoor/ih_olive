<?php
function mkSelectBox($name, $arr_name, $arr_id, $selected, $str="") {
        if( !is_array($selected) )
                $selected = array($selected);

        $data = "\n<select name='$name' dir=rtl $str >\n";
        
		if( is_array($arr_id) && count($arr_id) ) {
				foreach ($arr_id as $i=>$id)    {
					if( in_array($id, $selected) )
						$data.=  "<option value='$id' selected>$arr_name[$i]</option>";
					else
						$data.=  "<option value='$id'>$arr_name[$i]</option>";
				$data.=  "\n";
			}		    
		}
		$data.=  "</select>\n";
		return $data;
}        
?>