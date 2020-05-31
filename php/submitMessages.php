<?php
header('Content-Type:text/html; charset=utf-8');
date_default_timezone_set("Asia/Shanghai");
$arr = array("code" => 0);

include "checkToken.php";

if (trim($_POST['messageContent']) != "") {
    function get_user_device($ua)
    {
        if (stripos($ua, "HONOR") !== false || stripos($ua, "HUAWEI") !== false) {
            return "华为";
        }

        if (preg_match("/MI(?!cro|x)/i", $ua)) {
            return "小米";
        }

        if (stripos($ua, "SM-") !== false) {
            return "三星";
        }

        if (preg_match("/MX(?!B48T)/i", $ua)) {
            return "魅族";
        }

        if (stripos($ua, "OPPO") !== false) {
            return "OPPO";
        }

        if (stripos($ua, "vivo") !== false) {
            return "vivo";
        }

        if (preg_match("/(YQ|OD|SM)\d{3}/i", $ua)) {
            return "锤子坚果";
        }

        if (stripos($ua, "Coolpad") !== false) {
            return "酷派";
        }

        if (stripos($ua, "GIONEE") !== false) {
            return "金立";
        }

        if (stripos($ua, "iPhone") !== false) {
            return "iPhone ";
        }

        if (stripos($ua, "ipad") !== false) {
            return "iPad ";
        }

        if (stripos($ua, "Nokia") !== false) {
            return "诺基亚";
        }

        if (preg_match("/letv|Le {0,1}X|EUI/i", $ua)) {
            return '乐视';
        }

        if (stripos($ua, "ZTE") !== false) {
            return "中兴";
        }

        if (stripos($ua, "Lenovo") !== false) {
            return "联想";
        }

        return "";
    }

    function get_user_OS($ua)
    {
        $device = get_user_device($ua);
        if (stripos($ua, "Android") || stripos($ua, "ADR") !== false) {
            return $device . "安卓版";
        }

        if (stripos($ua, "win") !== false) {
            if (stripos($ua, "windows phone") !== false) {
                return $device . "WP系统";
            }

            if (stripos($ua, "NT 6.1") !== false) {
                return $device . "Win7系统";
            }

            if (stripos($ua, "NT 6.4") !== false || stripos($ua, "NT 10.0") !== false) {
                return $device . "Win10系统";
            }

            if (stripos($ua, "NT 5.1") !== false || stripos($ua, "NT 5.2") !== false) {
                return $device . "WinXP系统";
            }

            if (stripos($ua, "NT 6.2") !== false) {
                return $device . "Win8系统";
            }

            if (stripos($ua, "NT 6.3") !== false) {
                return $device . "Win8.1系统";
            }

            if (stripos($ua, "NT 6.0") !== false) {
                return $device . "WinVista系统";
            }

            if (stripos($ua, "NT 5.2") !== false) {
                return $device . "Win2003系统";
            }

            if (stripos($ua, "NT 5.0") !== false) {
                return $device . "Win2000系统";
            }

            return $device . "Windows系统";
        }
        if (stripos($ua, "iPhone") !== false) {
            return $device . "iPhone版";
        }

        if (stripos($ua, "ipad") !== false) {
            return $device . "iPad版";
        }

        if (stripos($ua, "iOS") !== false) {
            return $device . "iOS版";
        }

        if (stripos($ua, "Symbian") !== false) {
            return $device . "塞班版";
        }

        if (stripos($ua, "mobile") !== false) {
            return $device . "手机版";
        }

        if (stripos($ua, "Mac") !== false) {
            return $device . "Mac系统";
        }

        if (stripos($ua, "Linux") !== false) {
            return $device . "Linux系统";
        }

        if (stripos($ua, "Unix") !== false) {
            return $device . "Unix系统";
        }

        return $device . "";
    }

    function get_user_browser()
    {
        $ua = $_SERVER['HTTP_USER_AGENT'];
        if ($ua == "") {
            return '';
        }

        $os = get_user_OS($ua);
        // //echo $ua;
        if (stripos($ua, "MicroMessenger") !== false) {
            return $os . '微信';
        }

        if (stripos($ua, "QQBrowser") !== false) {
            if (stripos($ua, "QQ/") !== false) {
                return $os . 'QQ客户端';
            }

            return $os . 'QQ';
        }
        if (stripos($ua, "2345Explorer") !== false) {
            return $os . '2345加速';
        }

        if (stripos($ua, "MetaSr") !== false) {
            return $os . '搜狗高速';
        }

        if (stripos($ua, "LBBROWSER") !== false) {
            return $os . '猎豹';
        }

        if (stripos($ua, "Maxthon") !== false) {
            return $os . '傲游';
        }

        if (stripos($ua, "TheWorld") !== false) {
            return $os . '世界之窗';
        }

        if (stripos($ua, "weibo") !== false) {
            return $os . '微博';
        }

        if (stripos($ua, "IDU") !== false) {
            return $os . '百度';
        }

        if (stripos($ua, "AliApp") !== false) {
            return $os . '阿里应用';
        }

        if (stripos($ua, "UC") !== false || stripos($ua, "UBrowser") !== false) {
            return $os . 'UC';
        }

        if (stripos($ua, "360SE") !== false) {
            return $os . '360安全';
        }

        if (stripos($ua, "360EE") !== false) {
            return $os . '360极速';
        }

        if (stripos($ua, "360") !== false) {
            return $os . '360';
        }

        if (stripos($ua, "EUI") !== false) {
            return $os . '乐视';
        }

        if (stripos($ua, "Edge") !== false) {
            return $os . 'Edge';
        }

        if (stripos($ua, "Firefox") !== false) {
            return $os . 'Firefox';
        }

        if (stripos($ua, "OPR") !== false || stripos($ua, "Opera") !== false) {
            return $os . 'Opera';
        }

        if (stripos($ua, "MSIE") !== false) {
            if (stripos($ua, "rv:11") !== false) {
                return $os . 'IE11';
            }

            if (stripos($ua, "MSIE 10.0") !== false) {
                return $os . 'IE10';
            }

            if (stripos($ua, "MSIE 9.0") !== false) {
                return $os . 'IE9';
            }

            if (stripos($ua, "MSIE 8.0") !== false) {
                return $os . 'IE 8.0';
            }

            if (stripos($ua, "MSIE 7.0") !== false) {
                return $os . 'IE 7.0';
            }

            if (stripos($ua, "MSIE 6.0") !== false) {
                return $os . 'IE 6.0';
            }

            return $os . 'IE';
        }
        if (stripos($ua, "Chrome") !== false) {
            return $os . 'Chrome';
        }

        if (stripos($ua, "Safari") !== false) {
            return $os . 'Safari';
        }

        return $os;
    }

    function GetIpAddr()
    {
        $realip = '';
        $unknown = 'unknown';
        if (isset($_SERVER)) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']) && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], $unknown)) {
                $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                foreach ($arr as $ip) {
                    $ip = trim($ip);
                    if ($ip != 'unknown') {
                        $realip = $ip;
                        break;
                    }
                }
            } elseif (isset($_SERVER['HTTP_CLIENTIP']) && !empty($_SERVER['HTTP_CLIENTIP']) && strcasecmp($_SERVER['HTTP_CLIENTIP'], $unknown)) {
                $realip = $_SERVER['HTTP_CLIENTIP'];
            } elseif (isset($_SERVER['REMOTE_ADDR']) && !empty($_SERVER['REMOTE_ADDR']) && strcasecmp($_SERVER['REMOTE_ADDR'], $unknown)) {
                $realip = $_SERVER['REMOTE_ADDR'];
            } else {
                $realip = $unknown;
            }
        } else {
            if (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), $unknown)) {
                $realip = getenv("HTTP_X_FORWARDED_FOR");
            } elseif (getenv('HTTP_CLIENTIP') && strcasecmp(getenv('HTTP_CLIENTIP'), $unknown)) {
                $realip = getenv("HTTP_CLIENTIP");
            } elseif (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), $unknown)) {
                $realip = getenv("REMOTE_ADDR");
            } else {
                $realip = $unknown;
            }
        }
        $realip = preg_match("/[\d\.]{7,15}/", $realip, $matches) ? $matches[0] : $unknown;
        return $realip;
    }

    $IP = GetIpAddr();
    $addressString = @file_get_contents("http://freeapi.ipip.net/" . $IP);
    //echo ("f" . $addressString);
    $address = json_decode($addressString);
    //var_dump($address);
    include "connect.php";

    try {
        error_reporting(0);
        //$user_name = $_GET["username"];
        $dir = 'tmp/';
        session_save_path($dir);
        session_start();
        if (trim($_POST["contactMethod"])=="") {
            $_POST["contactType"]="undefinedContactMethod";
        }
        // switch ($_POST["selected"]) {
        //     case "QQ":$QQ = $_POST["contactMethodString"];
        //         break;
        //     case "email":$email = $_POST["contactMethodString"];
        //         break;
        //     case "wechat":$wechat = $_POST["contactMethodString"];
        //         break;
        //     case "phone":$phone = $_POST["contactMethodString"];
        //         break;
        //     case "undefined":$undefinedContactMethod = $_POST["contactMethodString"];
        //         break;
        // }
        $time = date("Y-m-d H:i:s");
        $microtime = number_format(microtime(true), 3, '', '');

        $agent = get_user_browser(); //判断浏览器
        $query = "insert into tb_vue_messages
             (messageContent,contactType,contactMethod,
             userAgent,agentJudge,IP,address,country,province,city,time,microtime)
              values
              (:messageContent,:contactType,:contactMethod,
              :userAgent,:agentJudge,:IP,:address,:country,:province,:city,:time,:microtime)";

        $result = $pdo->prepare($query);
        $result->bindParam(":messageContent", $_POST["messageContent"]);
        $result->bindParam(":contactType", $_POST["contactType"]);
        $result->bindParam(":contactMethod", $_POST["contactMethod"]);

        $result->bindParam(":userAgent", $_SERVER['HTTP_USER_AGENT']);
        $result->bindParam(":agentJudge", $agentJudge);
        $result->bindParam(":IP", $IP);
        $result->bindParam(":address", $addressString);

        // $result->bindParam(":address", "7");//加上就错，真奇怪
        $result->bindParam(":country", $address[0]);

        $result->bindParam(":province", $address[1]);
        $result->bindParam(":city", $address[2]);
        $result->bindParam(":time", $time);
        $result->bindParam(":microtime", $microtime);
        $pdo->beginTransaction();

        $result->execute();
        // //echo 'SQL Query:' . $query;

        $code = $result->errorCode(); //$result是查询结果集
            if ($code == '00000') { //echo "ok";
                // $message_count = $_GET["messagecount"] + 1;
                // $page_size = $_GET["pagesize"];
                // $quotient = $message_count / $page_size;
                // if (is_int($quotient)) {
                //     $page = $quotient;  //根据记录总数除以每页显示的记录数求出所分的页数
                // } else $page = ceil($quotient);
                // $_GET["ok"]=1;
                //

                $arr["code"] = 1;
            } else {

//echo '数据库错误：<br/>';
                //echo 'SQL Query:' . $query;
                //echo '<pre>';
                $arr["code"] = 0;
                $arr["msg"]=$result->errorInfo();
                // var_dump($result->errorInfo());
                //echo '</pre>';
            }
        
        $pdo->commit();
    } catch (PDOException $e) {
        //echo $e->getMessage();
        //echo "<br/><br/>PDO事务处理失败，请告知kill370354@qq.com";
        $pdo->rollBack();
        $arr["code"] = 0;
        $arr["msg"] = $e->getMessage();
    }
} else {
    $arr["msg"] = "传参有误";
}
;
echo json_encode($arr);
