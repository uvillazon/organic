<?php
class utils
{
	function FormatName($FName, $MName, $LName)
	{
		if ($MName!="")		
			$name=$FName." ".strtoupper(substr($MName,0,1)).". ".$LName;			
		else
			$name=$FName." ".$LName;
			
		return $name;
	}
	
	function GetComponent($component)
    {
        $myarray = explode(".", trim($component));
        
        if (count($myarray) == 1)
        {
            return trim($component);
        }
        else
        {
            return $myarray[1];
        }        
    }
}
?>