<?php
session_start();

//関数とパスワードの取得
require('function.php');
require_once('config.php');

//SessionCheck関数をログインしないと見れないページ全てに入れる
sschk();

//idを取得
$id=$_POST["id"];


//DB接続   new PDOはデータベースへの接続を表すPDOクラスのインスタンスを作成
$pdo = db_conn($database_name, $host, $user, $database_password);


//$pdo->prepare($sql)は、$pdo(先に作った接続)を利用して
//SQL文を準備するためのPDOStatementクラスのインスタンスを取得する、という役割分担
$sql ="DELETE FROM php6_user_table WHERE id=:id"; //sql文を決める
$stmt = $pdo->prepare($sql);             //prepareメソッドで
$stmt->bindValue(":id", $id , PDO::PARAM_INT);
$status = $stmt->execute();

//データ処理後
if($status==true){
  $response = array("status"=>"success");
}else{
  $response =array("status"=>"error");
}
echo json_encode($response);
?>
