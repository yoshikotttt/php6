<?php




//関数とパスワードの取得
require('function.php');
require_once('config.php');


//isset()関数は、引数に渡された変数や式がセットされているかどうかを確認する
//isset()関数は、変数が宣言されていない、配列の要素が存在しない、値が代入されていない時、セットされていない場合にfalse
//セットされている＝予定していた場所（メモリ内の領域）に値が存在する ということ
if (!isset($_POST["title"]) || $_POST["title"] == "") {
    exit("ParamError:title");
}

if (!isset($_FILES["img"]["name"]) || $_FILES["img"]["name"] == "") {
    exit("ParamError:img");
}


if (!isset($_POST["comment"]) || $_POST["comment"] == "") {
    exit("ParamError:comment");
}
//一つ目はパラメータ(htmlのname属性)が送信されていない場合、２つめは送信されたが中身が空の場合
//今回はpostメソッドなので、$_POST[""]が引数になる


//POSTデータ取得
$title = $_POST["title"];
$img = $_FILES["img"]["name"];
$comment = $_POST["comment"];
$id = $_POST["id"];


$upload = "./img/"; //画像アップロードのパス

//move_uploaded_fileは正常にアップロードできるとtrue、失敗するとfalseを返す
//move_uploaded_file($_FILES['img']['tmp_name'],アップロード先のディレクトリ.画像のファイル名←結合している)){
if (move_uploaded_file($_FILES['img']['tmp_name'], $upload . $img)) {
    //true FileUpload OK
} else {
    //false FileUpload NG
    echo "Uplaod failed";
    echo $_FILES["img"]["error"];
}


//DB接続後のdb_connをもらう
//$pdoは設計図を見せて、作ってもらったデータベース接続の枠組み（インスタンス）
$pdo = db_conn($database_name, $host, $user, $database_password);


//$stmtは出来上がったインスタンスを使って、準備されたSQL文を実行するためのステートメント
//テーブルに新しいレコード(＝title,img,comment..の値をもつ)を挿入するから、仮の：〇〇（プレースホルダ）を作ってね、そこに＄〇〇を入れるよ
$sql = "UPDATE php6_list_table SET title=:title,img=:img,comment=:comment,update_date=CURRENT_TIMESTAMP WHERE id=:id";
$stmt = $pdo->prepare($sql);
//bindValueで無効化
$stmt->bindValue(':title', $title,   PDO::PARAM_STR);
$stmt->bindValue(':img',    $img,     PDO::PARAM_STR);
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
$stmt->bindValue(":id", $id, PDO::PARAM_STR);
//pdoを使って準備したステートメントを、execute(=実行)メソッドを呼び出すことで、クエリを実行。trueかfalseが返る。
$status = $stmt->execute();


//登録処理後のステータス確認
if ($status == false) {
    sql_error($stmt);
} else {
    redirect("list.php");
}

