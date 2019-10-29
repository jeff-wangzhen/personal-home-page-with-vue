<?php
if (!isset($_SERVER["HTTP_REFERER"]) || (!stripos($_SERVER["HTTP_REFERER"], "kill370354.gz01.bdysite.com") && !stripos($_SERVER["HTTP_REFERER"], "a.yangy97.top"))) {
    $arr["referer"] = false; //echo "禁止盗链！";
    //    //echo stripos($_SERVER["HTTP_REFERER"],"kill370354.gz01.bdysite.com");
    //    return;
}
