<?php
$user_name = $_POST['user_name'];
$user_lid = $_POST['user_lid'];
$user_lpw = $_POST['user_lpw'];
$user_kanri_flg = $_POST['user_kanri_flg'];
$user_life_flg = $_POST['user_life_flg'];


//2. DB接続します
try {
    $db_name = "gs_db_kadai1017";    //データベース名
        $db_id   = "root";      //アカウント名
        $db_pw   = "root";      //パスワード：XAMPPはパスワード無しに修正してください。
        $db_host = "localhost"; //DBホスト
  //ID MAMP ='root'
  //Password:MAMP='root',XAMPP=''
  $pdo = new PDO('mysql:dbname='.$db_name.';charset=utf8;host='.$db_host, $db_id, $db_pw);
} catch (PDOException $e) {
  exit('DBConnectError:'.$e->getMessage());
}

//３．データ登録SQL作成
$stmt = $pdo->prepare("INSERT INTO gs_user_table(user_id,user_name,user_lid,user_lpw,user_kanri_flg,user_life_flg)VALUES(NULL,:user_name,:user_lid,:user_lpw,:user_kanri_flg,:user_life_flg)");
$stmt->bindValue(':user_name',$user_name,PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':user_lid',$user_lid,PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':user_lpw',$user_lpw,PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':user_kanri_flg',$user_kanri_flg,PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':user_life_flg',0,PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)

$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("ErrorMessage:".$error[2]);
}else{
  //５．index.phpへリダイレクト
header('Location: index_user.php');
exit();
}
?>
