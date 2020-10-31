<?php 
require_once('funcs.php');
$unique_book = $_GET['unique_book'];
// var_dump($id);
$pdo = db_conn();
//３．データ登録SQL作成
$stmt = $pdo->prepare('DELETE FROM gs_bm_table WHERE unique_book= :unique_book');
$stmt->bindValue(':unique_book', h($unique_book), PDO::PARAM_INT);      //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute(); //実行
//４．データ登録処理後
if ($status == false) {
    sql_error($stmt);
} else {
    redirect('select.php');
}

?>

