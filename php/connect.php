<?php
	/**
	 * Created by PhpStorm.
	 * User: kill370354
	 * Date: 2017/12/28
	 * Time: 17:37
	 */
	$dbms='mysql';  	//数据库类型 ,对于开发者来说，使用不同的数据库，只要改这个，不用记住那么多的函数
	$host='localhost'; 	//数据库主机名
	$dbName='grwz-vue'; //使用的数据库
	$user='grwzvue';    	//数据库连接用户名
	$pass='qaz123';   	//对应的密码
	$dsn="$dbms:host=$host;dbname=$dbName";
	$pdo = new PDO($dsn, $user, $pass); 	//初始化一个PDO对象，就是创建了数据库连接对象$pdo

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);