<?php




//関数とパスワードの取得
require('function.php');
require_once('config.php');


//データ取得
$name      = filter_input(INPUT_POST, "name");
$user_id   = filter_input(INPUT_POST, "user_id");
$password  = filter_input(INPUT_POST, "password");
$kanri_flg = filter_input(INPUT_POST, "kanri_flg");
$password  = password_hash($password, PASSWORD_DEFAULT); //ハッシュ化

// $name      = $_POST ["name"];
// $user_id   = $_POST["user_id"];
// $password  = $_POST["password"];
// $kanri_flg = $_POST["kanri_flg"];
// $password   = password_hash($password, PASSWORD_DEFAULT); //ハッシュ化

//db接続
$pdo = db_conn($database_name, $host, $user, $database_password);


//SQL作成 -> $pdo使ってprepareメソッドでインスタンス化 -> bindValueで無効化できるように -> execute!
$sql  = "INSERT INTO php6_user_table(name,user_id,password,life_flg,kanri_flg)VALUES(:name,:user_id,:password,0,:kanri_flg)";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":name"     ,$name,      PDO::PARAM_STR);
$stmt->bindValue(":user_id"  ,$user_id,   PDO::PARAM_STR);
$stmt->bindValue(":password" ,$password,  PDO::PARAM_STR);
$stmt->bindValue(":kanri_flg",$kanri_flg, PDO::PARAM_STR);
$status = $stmt->execute();

//確認
if($status == false){
    sql_error($stmt);
}else{
    redirect("login.php");
}
