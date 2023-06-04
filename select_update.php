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





<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>選択ページ</title>
    <style>
        img {
            height: 150px;
            width: 150px;
        }

        .container {
            margin-bottom: 50px;
        }

        /* モーダルウィンドウ */
        .modal-window {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 600px;
            height: 700px;
            background-color: #f5ecf4;
            border-radius: 5px;
            z-index: 11;
            padding: 2rem;
            /* display: flex;
            flex-direction: column; */
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            background-color: rgba(0, 0, 0, 0.5);
            width: 100%;
            height: 100%;
            z-index: 10;
        }

        .container {
            display: flex;
            justify-content: center;
            flex-direction: column;
        }

        h3 {
            text-align: left;
        }

        .modal-window .button-link {
            height: 38px;
            display: block;
        }

        .box5 {
            display: flex;
            margin-top: 30px;
            justify-content: space-around;
        }

        .re-button {
            margin-top: 20px;
        }


        .action {
            display: flex;
            align-items: center;
        }

        .d-button {
            width: 20px;
            margin-left: 20px;
            height: 20px;
        }
    </style>
</head>

<body>
    <!-- オーバーレイ -->
    <div id="overlay" class="overlay"></div>
    <!-- モーダルウィンドウ -->
    <div class="modal-window">
        <form action="update_backend.php" method="post" enctype="multipart/form-data">
            <div class="box1">
                <h3>タイトル</h3>
                <input type="text" name="title" value="<?= h($low["title"]) ?>">
            </div>
            <div class="box1">
                <h3>画像</h3>
                <input type="file" name="img" accept=".png,.jpg,.jpeg,.pdf,.doc" onchange="previewImage(event)">
                <div class="img_style">
                    <img id="preview" src="./img/<?= h($low["img"]) ?>" width='100px'>
                </div>
            </div>


            <div class="box1">
                <h3>コメント</h3>
                <textarea name="comment" id="" cols="30" rows="10"><?= h($low["comment"]) ?></textarea>
            </div>
            <input type="hidden" name="id" value="<?= $low["id"] ?>">
            <input type="submit" value="更新する" class="re-button">

        </form>

        <input type="submit" class="close button-open" value=" キャンセル">
    </div>

    <!-- 最初から見えている部分 -->

    <a href="index.php">TOP</a>
        <a href="list.php">一覧に戻る</a>
    <div class="container">
        <div class="title">タイトル：<?= h($low["title"]) ?></div>
        <div class="img"><img src="./img/<?= h($low["img"]) ?>"></div>
        <div class="comment">コメント：<?= h($low["comment"]) ?></div>

        <?php $date = $low["indate"];
                    $datetime = new Datetime($date);
                    $formattedDate = $datetime->format('Y年m月d日'); ?>
                    <p>登録日：　　<?= $formattedDate; ?></p>
        <?php $u_date = $low["update_date"];
                    $datetime = new Datetime($u_date);
                    $u_formattedDate = $datetime->format('Y年m月d日'); ?>
                    <p>最終更新日：<?= $u_formattedDate; ?></p>

    </div>
    <div class="action">
        <input type="submit" value="更新" class="button-open">
        <?php if ($_SESSION["kanri_flg"] == 0) { ?>
            <a href="delete.php?id=<?=$low['id']?>">削除</a>  
        <?php } ?>

    </div>

    <script>
        //不要...?
        const json = JSON.parse('<?= $json ?>');
        console.log(json);

        //モーダルの表示と非表示
        $(function() {
            $('.button-open').on("click", function() {
                $('#overlay,.modal-window').fadeIn();
            });
            $('.close').on('click', function() {
                $('#overlay, .modal-window').fadeOut();
            });


        });

        //選択されていた画像の表示（リンクまで選択された状態はできない）
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