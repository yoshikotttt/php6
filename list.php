<?php

session_start();


//関数とパスワードの取得
require('function.php');
require_once('config.php');

//SessionCheck関数をログインしないと見れないページ全てに入れる
sschk();


//DB接続後のdb_connをもらう
//$pdoは設計図を見せて、作ってもらったデータベース接続の枠組み（インスタンス）
$pdo = db_conn($database_name, $host, $user, $database_password);

//$stmtは出来上がったインスタンスを使って、準備されたSQL文を実行するためのステートメント
$sql = "SELECT * FROM php6_list_table";
$stmt = $pdo->prepare($sql);
//pdoを使って準備したステートメントを、execute(=実行)メソッドを呼び出すことで、クエリを実行。trueかfalseが返る。
$status = $stmt->execute();


//登録処理後のステータス確認
if ($status == false) {
    sql_error($stmt);
}
//全データ取得   fetch=取得する assoc = associative = 連想配列
$values = $stmt->fetchAll(PDO::FETCH_ASSOC);
// $json = json_encode($values, JSON_UNESCAPED_UNICODE);



?>






<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <script src="jquery-3.6.0.min.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>一覧</title>
    <style>
        .img {
            text-align: right;
        }

        .img img {
            height: 80px;
            width: 80px;
        }


        body {
            width: 700px;
            background-color: #f4f4ff;
            color: #8989ff;
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-gap: 30px;
        }

        .box {
            background-color: #8989ff;
            height: 150px;
            width: 250px;
            border-radius: 5px;
            color: white;
            display: flex;

        }

        .box-small {
            height: 120px;
            width: 250px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        a {
            text-decoration: none;
            width: 250px;
        }


        a:visited {
            color: inherit;
        }

        p {
            padding: 0px;
            margin: 0px;
        }

        .title {
            width: 150px;
            padding-left: 5px;
            padding-right: 5px;
        }

        .delete-button-container {
            margin-left: auto;
        }
        .ymt {
            color: white;
        }

     
    </style>
</head>

<body>
<a href="index.php">TOP　　　</a>
    <a class="logout"  href="logout.php">ログアウト</a>
    <div class="grid-container">

        <?php foreach ($values as $v) { ?>

            <div class="box">
                <a href="select_update.php?id=<?= h($v["id"]) ?>">
                    <div class="box-small">
                        <div class="title">
                            <p>タイトル</p>
                            <p>「<?= h($v["title"]) ?>」</p>
                        </div>
                        <div class="img"><img src="./img/<?= h($v["img"]) ?>"></div>
                    </div>
                    <?php $u_date = $v["update_date"];
                    $datetime = new Datetime($u_date);
                    $u_formattedDate = $datetime->format('Y年m月d日'); ?>
                    <p class="ymt">最終更新日：<?= $u_formattedDate; ?></p>
                </a>
                <div class="delete-button-container">
                    <?php if ($_SESSION["kanri_flg"] == 0) { ?>
                        <img src="./myimg/trash.svg" alt="" data-id="<?= $v["id"] ?>" class="d-button">
                    <?php } ?>
                </div>
            </div>
        <?php } ?>

    </div>
    <script>
        //削除アラート
        $(document).ready(function() {
            $('.d-button').click(function() {
                const dataId = $(this).data('id'); // 削除するデータのIDを取得
                console.log(dataId);
                Swal.fire({
                    title: '削除',
                    text: '本当に削除しますか？',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '削除',
                    cancelButtonText: 'キャンセル'
                }).then((result) => {
                    if (result.dismiss !== Swal.DismissReason.cancel) {
                        // 削除を押した場合の処理
                        ajax(dataId);
                    } else { // キャンセルボタンがクリックされたら
                        Swal.fire(
                            'キャンセルしました',
                            '投稿は削除されませんでした',
                            'info'
                        )
                    }
                });
            })
        });

        function ajax(dataId) {
            $.ajax({
                    type: "post", //HTTPメソッド
                    url: "delete.php", //データの送信先
                    data: {
                        id: dataId
                    }, //送信するデータ
                    dataType: "json" //レスポンスの型、種類
                })
                .done(function(data) {
                    if (data.status === "success") {
                        Swal.fire({
                            title: '削除しました',
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload(); //
                        });
                    } else {
                        Swal.fire({
                            title: '削除に失敗しました',
                            icon: 'error',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }

                })
        };
    </script>

</body>

</html>