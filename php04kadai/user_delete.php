<?php 
require_once('funcs.php');
$user_id = $_GET['user_id'];
// var_dump($id);
$pdo = db_conn();
//３．データ登録SQL作成
$stmt = $pdo->prepare('DELETE FROM gs_user_table WHERE user_id= :user_id');
$stmt->bindValue(':user_id', h($user_id), PDO::PARAM_INT);      //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute(); //実行
//４．データ登録処理後
if ($status == false) {
    sql_error($stmt);
} else {
    redirect('user_select.php');
}

?>
