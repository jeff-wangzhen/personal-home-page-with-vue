<?php
header("Access-Control-Allow-Origin:*");
function getRandomString($len, $chars = null)
{
    if (is_null($chars)) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    }
    mt_srand(10000000 * (double)microtime());
    for ($i = 0, $str = '', $lc = strlen($chars) - 1; $i < $len; $i++) {
        $str .= $chars[mt_rand(0, $lc)];
    }
    return $str;
}
$arr = array("error" => '未判断isset($_FILES["myfile"])');
if (isset($_FILES["myfile"])) {
    $arr = array("error" => '未判断is_dir("/images")');
    $extensionArr = array("jpg", "png", "gif", "jpeg","bmp","tiff");
    if (!in_array(pathinfo($_FILES["myfile"]["name"], PATHINFO_EXTENSION), $extensionArr)) {
        $arr["error"]="文件类型不支持";
    // return false;
    } else {
        if (!is_dir("images")) { // is_dir()函数判断指定的文件夹是否存在
        mkdir("images"); // mkdir()函数创建文件夹
        }
        $microTime = microtime(true);

        $microTime = number_format($microTime, 3, '', '');
        $newName = $microTime . getRandomString(10) . "." . pathinfo($_FILES["myfile"]["name"], PATHINFO_EXTENSION);
        // $arr["error"]= '未move_uploaded_file';

        move_uploaded_file($_FILES["myfile"]["tmp_name"], "images/" . $newName);

        $path = "//" . $_SERVER["HTTP_HOST"] . "/grwz-vue/php/images/" . $newName;
        $arr = array("path" => $path);
        unset($arr["error"]);
    }
} else {
    $arr["error"]= 'isset($_FILES["myfile"])判断为非';
}
echo json_encode($arr, JSON_UNESCAPED_SLASHES);
