<?php

session_start();


//関数とパスワードの取得
require('function.php');
require_once('config.php');

//SessionCheck関数をログインしないと見れないページ全てに入れる
sschk();


//選択されたidを取得
$select_id = $_GET["id"];


//DB接続後のdb_connをもらう
$pdo = db_conn($database_name, $host, $user, $database_password);

//データ取得SQL作成
$sql = "SELECT * FROM php6_list_table WHERE id=:select_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':select_id', $select_id, PDO::PARAM_INT);
$status = $stmt->execute();

//確認
$values = "";
if ($status == false) {
    sql_error($stmt);
}

$low = $stmt->fetch();
$json = json_encode($low, JSON_UNESCAPED_UNICODE);

?>





<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>選択ページ</title>
    <style>
        img {
            height: 150px;
            width: 150px;
        }
        .container {
            margin-bottom: 50px;
        }
    </style>
</head>

<body>
  
    <div class="container">
        <div class="title">タイトル：<?= h($low["title"]) ?></div>
        <div class="img"><img src="./img/<?= h($low["img"]) ?>"></div>
        <div class="comment">コメント：<?= h($low["comment"]) ?></div>

    </div>
    <div>
        <a href="update.php?id=<?=h($low['id'])?>"><input type="submit" value="更新"></a>

        <?php if($_SESSION["kanri_flg"]==0 ){?>
        <a href="delete.php?id=<?=$low['id']?>">削除</a>  
        <?php }?>
        
    </div>


</body>

</html>