<?php

    function getWord(){
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=2.doc");    
        echo "<html>";
        echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
        echo "<body>";
        echo "<b>caca</b>";
        echo "</body>";
        echo "</html>";
}