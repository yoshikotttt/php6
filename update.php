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
 
    <title>更新</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
        }
    </style>
</head>

<body>
    <form action="update_backend.php" method="post" enctype="multipart/form-data">
        <div class="box1">
            <h3>タイトル</h3>
            <input type="text" name="title" value="<?= h($low["title"]) ?>">
        </div>
        <div class="box1">
            <h3>画像</h3>
            <input type="file" name="img" accept=".png,.jpg,.jpeg,.pdf,.doc" previewImage(event)>
            <p class="img_style">

                <img id="preview" src="./img/<?= h($low["img"]) ?>" width='100px'>
            </p>
        </div>

        </div>
        <div class="box1">
            <h3>コメント</h3>
            <textarea name="comment" id="" cols="30" rows="10"><?= h($low["comment"]) ?></textarea>
        </div>
        <input type="hidden" name="id" value="<?= $low["id"] ?>">
        <div class="box1">
            <input type="submit" value="更新する">
        </div>



    </form>
    <script src="jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        function previewImage(event) {
            const input = event.target;
            const reader = new FileReader();
            reader.onload = function() {
                $('#preview').attr('src', reader.result);
            };
            reader.readAsDataURL(input.files[0]);
        }

        $('input[type=file]').change(function(event) {
            previewImage(event);
        });
    });
    </script>
</body>

</html>