<?php
class matriz
{
    var $num_rows;
    var $db_fields;
    var $db_table;
    var $db_sub;
    var $image_size;
    var $show_selected;
    var $url;    
    
    function SetValues($rows, $fields, $table, $type, $size=100)
    {
        $num_rows=$rows;
        $db_fields=$fields;
        $db_table=$table;
        $db_sub=$type;
        $image_size = $size;
        $show_selected = false;
        $url = "";        
    }
            
    //id, Path, title/name, description, date
    function GetMatriz()
    {
        $query = new query;
        $rows_count;
        $where = "";
        
        $rows = $query->getRows($this->db_fields, $this->db_table, $this->db_sub);              
        $components = split(",", $this->db_fields);                
        
        $rows_count = 0;
        $content .= "<table width='100%' class=\"MainMatrixTable\">";
        if ($image_size == "")
        {
            $image_size = 100;
        }            
            
        foreach($rows as $row)
        {
            $id = $row[utils::GetComponent($components[0])];
            $path = $row[utils::GetComponent($components[1])];
            $title = $row[utils::GetComponent($components[2])];
            
            if (count($components) > 3)
            {
                $description = $row[utils::GetComponent($components[3])];
            }
            if (count($components) > 4)
            {
                $date = $row[utils::GetComponent($components[4])];
            }
            
            if ($rows_count == 0)
            {
                $content .= "<tr valign='top'>";
            }
            $content .= "<td class='picture' align='center'>";
            
            //Begin picture
            $content .= "<table class=\"MatrixTable\">";
            if ($show_selected == true)
            {
                $content .= "<tr>";
                $content .= "<td align='right'><input type='radio' id='rdbSelected" . $id . "' name='PictureList'/></td>";
                $content .= "</tr>";
            }
            if ($title == '')
            {
                $title = "&nbsp;";
            }
            $content .= "<tr><td class=\"MatrixTitle\">" . $title . "</td></tr>";
            $content .= "<tr>";
            $content .= "<td class=\"MatrixImg\" colspan='2' width='" . $image_size . "px' align=\"center\">";
            $content .= "<img class='MatrixLink' src='images/jpg.php?name=" . $path . "&maxHeight=" . $image_size . "&maxWidth=100' ";            
            if ($this->url == "")
            {
                $content .= " onclick=\"OpenAjax('picture_viewer.php?id=" . $id . "','" . $id . "');\" />";
            }
            else
            {
                $content .= " onclick=\"window.location ='" . $this->url . "?id=" . $id . "'; \" />";
            }
            $content .= "</td>";
            $content .= "</tr>";
            if ($description != '')
            {
          	    $content .= "<tr><td colspan='2' width='" . ($image_size + 20) . "px' class=\"MatrixDescription\">" . $description . "</td></tr>";
          	}
          	if ($date != '')
            { 
                $content .= "<tr><td colspan='2'>" . $date . "</td></tr>";
          	}
            $content .= "</table>";
            $content .= "</td>";
            //End picture
            
            $rows_count = $rows_count + 1;            
            if ($rows_count == $this->num_rows)
            {
                $content .= "</tr>";
                $rows_count = 0;
            }     
        }        
        $content .= "</table>";        
        
        return $content;
    }  
}   
?>