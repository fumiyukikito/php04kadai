<?php

//最初にSESSIONを開始！！ココ大事！！
session_start();


//POST値
$user_lid = $_POST['user_lid'];
$user_lpw = $_POST['user_lpw'];

//1.  DB接続します
include("funcs.php");
$pdo = db_conn();

//2. データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_user_table WHERE user_lid=:user_lid AND user_lpw=:user_lpw");
$stmt->bindValue(':user_lid',$user_lid, PDO::PARAM_STR);
$stmt->bindValue(':user_lpw',$user_lpw, PDO::PARAM_STR);
$status = $stmt->execute();

//3. SQL実行時にエラーがある場合STOP
if($status==false){
    sql_error($stmt);
}

//4. 抽出データ数を取得
$val = $stmt->fetch();         //1レコードだけ取得する方法
//$count = $stmt->fetchColumn(); //SELECT COUNT(*)で使用可能()

//5. 該当レコードがあればSESSIONに値を代入
//if(password_verify($lpw, $val["lpw"])){ //* PasswordがHash化の場合はこっちのIFを使う
    // IF文でカラでなければ取得するコード
// もし管理者フラグが1ならselect.phpに飛ばす
// もし管理者フラグが0ならselect.phpに飛ばす

// if( $val["user_id"] != "" ){
//     //Login成功時
//     $_SESSION["chk_ssid"]  = session_id();
//     $_SESSION["user_kanri_flg"] = 0;
//     // $_SESSION["user_name"]      = $val['user_name'];
//     header('Location: select.php');
if( $val["user_kanri_flg"] == 0 ){
    //Login成功時
    $_SESSION["chk_ssid"]  = session_id();
    // $_SESSION["user_kanri_flg"] = 0;
    // $_SESSION["user_name"]      = $val['user_name'];
    header('Location: top_0.html');
}
elseif( $val["user_kanri_flg"] == 1 ){
 
    $_SESSION["chk_ssid"]  = session_id();
    // $_SESSION["user_kanri_flg"] = 1;
    // $_SESSION["user_name"]      = $val['user_name'];
    header('Location: top_1.html');

}

else{
    //Login失敗時(Logout経由)
    // header('Location: login.php');
    $samural_alert = "エラーでございます。";
// ②
    $alert = "<script type='text/javascript'>alert('". $samural_alert. "');</script>";
// ③
    echo $alert;
    // header('Location: login.php', true, 301); 
}

exit();
