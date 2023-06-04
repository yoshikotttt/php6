<?php

session_start();
if (isset($_SESSION['errorMessage'])) {
    echo $_SESSION['errorMessage'];
    unset($_SESSION['errorMessage']); // エラーメッセージを表示したらセッションから削除する
}


?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="jquery-3.6.0.min.js"></script>

    <title>ログイン</title>
  
</head>

<body>


    <form action="login_backend.php" method="post">
        <div class="container">
            <div>
                ユーザーID　<input type="text" name="user_id">
            </div>
            <div>
                パスワード　<input type="password" name="password">
            </div>
            <div>
                <input type="submit" value="ログイン">
            </div>

        </div>
    </form>
    <div id="error-message"></div>


    <!-- <script> //jsなくてもエラー表示できる(echo)
        //$_SESSION['errorMessage'] がセットされているかどうかを確認し、値が存在する場合はその値を代入。値が存在しない場合は空の文字列を代入。
        const errorMessage = "<?php echo isset($_SESSION['errorMessage']) ? $_SESSION['errorMessage'] : ''; ?>";
        console.log(errorMessage);
        if (errorMessage !== '') {
            $("#error-message").html(errorMessage);
        }
    </script> -->

   


</body>

</html>