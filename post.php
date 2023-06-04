<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="jquery-3.6.0.min.js"></script>
    <title>投稿フォーム</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            background-color: #f4f4ff;
            color: #8989ff;
        }

        a {
            text-decoration: none;
        }
    </style>
</head>

<body>
<a href="index.php">TOP</a>
    <!-- enctype 属性は、HTMLフォームが送信するデータのエンコード方式を指定するために使用
    enctype 属性の値を "multipart/form-data" に設定することで、マルチパート形式でデータをエンコードし、ファイルのアップロードができる。 -->
    <form action="post_backend.php" method="post" enctype="multipart/form-data">
        <div class="box1">
            <h3>タイトル</h3>
            <input type="text" name="title">
        </div>
        <!-- <div class="box1">
            <h3>いつ</h3>
            <input type="date" name="date">
        </div> -->
        <div class="box1">
            <h3>画像</h3>
            <input type="file" name="img" accept=".png,.jpg,.jpeg,.pdf,.doc">
            <p class="img_style"><img src="" alt="" width="150px"></p>

        </div>
        <div class="box1">
            <h3>コメント</h3>
            <textarea name="comment" id="" cols="30" rows="10"></textarea>
        </div>
        <div class="box1">
            <input type="submit" value="登録">
        </div>



    </form>

    <script>
        
        $('input[type=file]').change(function() {
            const file = $(this).prop('files')[0];
            if (!file.type.match('image.*')) {
                $(this).val('');
                $('.img_style > img').html('');
                return;
            }

            const reader = new FileReader();
            reader.onload = function() {
                $('.img_style > img').attr('src', reader.result);
            };
            reader.readAsDataURL(file);
        });
    </script>
</body>

</html>