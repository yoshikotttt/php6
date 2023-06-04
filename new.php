<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規登録</title>
</head>

<body>
    <form action="new_backend.php" method="post">
    <div class="container">
        <div>
            お名前：<input type="text" name="name">
        </div>
        <div>
            ユーザーID
            <input type="text" name="user_id">
        </div>
        <div>
            パスワード<input type="password" name="password">
        </div>
        <div>管理フラグ
            管理者<input type="radio" name="kanri_flg" value="0">
             一般<input type="radio" name="kanri_flg" value="1">
        </div>
        <div>
            <input type="submit" value="登録">
        </div>
    </div>
    </form>

</body>

</html>