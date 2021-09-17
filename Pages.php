<?php
    class Pages
    {
        public $page;

        function __construct(){
            $page = intval($_GET["page"]);
            if(empty($page) or $page <= 0) $page = 1; 
            $this->page = $page;
        }

        function pageStart($num)
        {
            return ($this->page - 1) * $num;
        }

        function pagesDb($db, $num, $sort)
        {
            $posts = (int) $db->select("SELECT COUNT(*) FROM `users` $sort;")[0];
            $total = intval($posts / $num) + 1;
            if (is_int(($posts / $num) + 1)) $total = $total - 1;
            return $total;
        }
        
        function pagesUp($total, $sort = "")
        {
            $path = "index.php?page=";

            if ($this->page != 1 || ($this->page-1)>1) $pervpage = "<a href=$path&login=".$sort."><<</a> 
                <a href=$path". ($this->page - 1) ."&login=".$sort."><</a> "; 
            if ($this->page != $total || ($this->page+1)<$total) $nextpage = " <a href=$path". ($this->page + 1) ."&login=".$sort.">></a> 
                <a href=$path" .$total. "&login=".$sort.">>></a>";

            if($this->page - 2 > 0) $page2left = "<a href=$path". ($this->page - 2) ."&login=".$sort.">". ($this->page - 2) ."</a> | "; 
            if($this->page - 1 > 0) $page1left = "<a href=$path". ($this->page - 1) ."&login=".$sort.">". ($this->page - 1) ."</a> | "; 

            if($this->page + 1 < $total) $page1right = " | <a href=$path". ($this->page + 1) ."&login=".$sort.">". ($this->page + 1) ."</a>";
            if($this->page + 2 < $total) $page2right = " | <a href=$path". ($this->page + 2) ."&login=".$sort.">". ($this->page + 2) ."</a>"; 

            echo "<br>".$pervpage." ".$page2left." ".$page1left."<b>".$this->page."</b>".$page1right." ".$page2right." ".$nextpage."<br><br>"; 
            echo "<br><a href=$path$this->page&login=".$sort.">Обновить страницу</a><br>";
            
            echo "<meta http-equiv='Refresh' content='60' />";
        }
    }
    