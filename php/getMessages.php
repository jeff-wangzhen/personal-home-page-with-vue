<?php
header('Content-Type:text/html; charset=utf-8');
date_default_timezone_set("Asia/Shanghai");
$arr = array("code" => 0);
// var_dump($_GET) ;
// include "checkToken.php";

function maskEmail(&$email)
{
    $regex = '/^(.*)@(.*)$/i';
    $matches = array();

    if (preg_match($regex, $email, $matches)) {
        // var_dump($matches);
        $arr["s"] = $matches;
        $username = $matches[1];
        if (mb_strlen($username) > 2) {
            $email = mb_substr($username, 0, 1);
            $j = 0;

            for ($i = mb_strlen($username) - 2; ($i > 0 && $j < 5); $i--) {
                $email .= "*";
                $j++;
            }
            $email .= mb_substr($username, mb_strlen($username) - 1, 1);
        } else {
            $email = str_repeat("*", mb_strlen($username));
        }
        $email .= "@" . $matches[2];
    } else {
        $email = "*****";
    }
}
function maskString(&$string)
{  
    // $regex = '/^(.*)@(.*)$/i';
    // $matches = array();

    if (empty($string)) {
        return; 
    } 
    $temp = $string;
    if (mb_strlen($temp) > 2) {
        $string = mb_substr($temp, 0, 1);
        $j = 0;
        for ($i = mb_strlen($temp) - 2; ($i > 0 && $j < 5); $i--) {
            $string .= "*";
            $j++;
        }
        $string .= mb_substr($temp, mb_strlen($temp) - 1, 1);
    } else {
        $string = str_repeat("*", mb_strlen($temp));
    }
}

include "connect.php";
$start = (int)$_GET['start'];
$length = (int)$_GET['length'];
$lastest = $_GET['lastest'];
if ($start + $length > 0 && $length > 0) {
    if ($start < 0) {
        $start = 0;
        if ($lastest != "true") {
            $arr["allLoaded"] = true;
        }
    }

    if ($lastest == "true") {
        $messagesql = "select id,province,city,messageContent,contactType,contactMethod,
             microtime from  tb_vue_messages ORDER BY  id DESC  limit 0,$length ";
    }
    // $start_size = 10; //每页显示4条记录
    // var_dump($_GET);
    // $offset = ($start - 1) * $start_size; //计算下一页从第几条数据开始循环
    else {
        $messagesql = "select * from  tb_vue_messages WHERE id >=$start AND id<($start+$length)  ORDER BY   id DESC";
    }
    // echo "11111",$messagesql;

    $result = $pdo->prepare($messagesql);
    try {
        $pdo->beginTransaction();
        // $messagescount->execute();
        // $message_count = $messagescount->fetch(PDO::FETCH_BOTH)[0]; //查询符合条件的记录总条数
        // $start_count = ceil($message_count / $start_size); //根据记录总数除以每页显示的记录数求出所分的页数
        
        $result->execute();
        // while ($row = $result->fetch(PDO::FETCH_OBJ));
        $rows = $result->fetchAll(PDO::FETCH_ASSOC);
        $pdo->commit();
        for ($i = (count($rows) - 1); $i > -1; $i--) {
            // if($rows[$i]["contactMethod"]=="undefined"){

            //          break;
            // }
            switch ($rows[$i]["contactType"]) {
                case "email":
                    maskEmail($rows[$i]["contactMethod"]);
                    break;
                default:
                    if (!empty($rows[$i]["contactMethod"])) {
                        maskString($rows[$i]["contactMethod"]); //str_repeat("*", mb_strlen($rows[$i]["contactMethod"]));
                    }
// ;

                    break;
            }
        }

        $arr["code"] = 1;
        $arr["messages"] = $rows;
     if(count($rows)<10)   $arr["allLoaded"] = true;
    } catch (PDOException $e) {
        // echo "PDO事务处理失败，请告知kill370354@qq.com";
        $pdo->rollBack();
        $arr["code"] = 0;
        $arr["msg"] = $e->getMessage();
    }
    // $arr["get"] = $_GET;
} else {
    $arr["get"] = $_GET;
}
// var_dump($arr);
//   var_dump($arr);


// foreach ($arr["messages"] as $key=>$arr_item) {
    // foreach ($arr_item as $a=>$b) {
        // $arr["messages"][$key]["messageContent"]= "f";//str_replace('"', "'", $arr[$i]);// array($key => "d" );//[] ="q";
    // }
    //  var_dump($key, $arr_item);
    // $arr["messages"][$key]["messageContent"] = "1";//str_replace('"', "'", $arr_item["messageContent"]);
    // echo json_encode($arr["messages"]);
    // echo json_encode($arr["messages"][$key]);
    // var_dump($arr["messages"][$key]);

    // var_dump($arr["messages"][$key]);
// }


// for ($i = 0; $i < count($arr); $i++) {
//     $arr[$i] = str_replace('"', "'", $arr[$i]);
// }

   echo json_encode(
       $arr
);
