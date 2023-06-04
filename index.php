<?php
session_start();

//関数とパスワードの取得
require('function.php');
require_once('config.php');

//SessionCheck関数をログインしないと見れないページ全てに入れる
sschk();

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TOP</title>
    <style>
        body {
            background-color: #f4f4ff;
            display: flex;
            flex-direction: column;
        }

        a {
            text-decoration: none;
            color: white;
        }

        .box1 {
            height: 50px;
            width: 200px;
            background-color: #da81b2;
            margin: 40px;
            border-radius: 5px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .box2 {
            height: 50px;
            width: 200px;
            background-color: #8989ff;
            margin: 40px;
            border-radius: 5px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .box3 {
            height: 50px;
            width: 200px;
            background-color: #ede4e1;
            margin: 40px;
            border-radius: 5px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .box3 a {
            text-decoration: none;
            color: red;
        }

        a {
            text-decoration: none;
            color: white;
        }

        .logout {
            color: #8989ff;
        }
    </style>
</head>

<body>
<div><span style="color:#8989ff"><?=$_SESSION["name"]?></span>さん、こんにちは　　
<a class="logout"  href="logout.php">ログアウト</a></div>
    <div class="box1">
        <a href="post.php">記録をする</a>
    </div>
    <div class="box2">
        <a href="list.php">記録を見る</a>
    </div>
   
        <?php if( $_SESSION["kanri_flg"] == 0) { ?>
            <div class="box3">
            <a href="admin.php">管理者用</a>
            </div>
        <?php } ?>



</body>

</html>