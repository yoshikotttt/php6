<?php


//接続用 新しいインスタンスを作成
function db_conn($database_name, $host, $user, $database_password)
{
    try {
        return  new PDO("mysql:dbname={$database_name};charset=utf8mb4;host={$host}", $user, $database_password); //$pdoにデータが入ってくる
    } catch (PDOException $e) {
        exit('DBConnectError:' . $e->getMessage());
    }
}

// function db_conn(){
//     try {
//         $db_name = "gs_db3";    //データベース名
//         $db_id   = "root";      //アカウント名
//         $db_pw   = "root";          //パスワード
//         $db_host = "localhost"; //DBホスト
//         return new PDO('mysql:dbname='.$db_name.';charset=utf8;host='.$db_host, $db_id, $db_pw);
//     } catch (PDOException $e) {
//         exit('DB Connection Error:'.$e->getMessage());
//     }
//     }

//SQLエラー関数 :sql_error($stmt) //$stmtもらってこないと空っぽ
function sql_error($stmt)
{
    $error = $stmt->errorInfo();
    exit("SQLError:" . $error[2]);
}

//リダイレクト関数:redirect($file_name)
function redirect($page)
{
    header("Location: " . $page);
    exit();
}

//XSS
function h($val)
{
    return htmlspecialchars($val, ENT_QUOTES);
}


//SessionCheck
//SessionID持っていて、合っていなかったらエラー、合っていれば新しいSession IDがもらえる
function sschk()
{
    if (!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"] != session_id()) {
        exit("Login Error");
    } else {
        session_regenerate_id(true);
        $_SESSION["chk_ssid"] = session_id();
    }
}
