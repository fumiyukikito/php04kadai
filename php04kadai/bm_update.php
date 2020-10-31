<?php
//PHP:コード記述/修正の流れ
//1. insert.phpの処理をマルっとコピー。
//   POSTデータ受信 → DB接続 → SQL実行 → 前ページへ戻る
//2. $id = POST["id"]を追加
//3. SQL修正
//   "UPDATE テーブル名 SET 変更したいカラムを並べる WHERE 条件"
//   bindValueにも「id」の項目を追加
//4. header関数"Location"を「select.php」に変更
require_once('funcs.php');
//1. POSTデータ取得
$unique_book = $_POST["unique_book"];
$bookname  = $_POST["bookname"];
$bookURL = $_POST["bookURL"];
$bookcomment    = $_POST["bookcomment"];
//2. D接続します
//*** function化する！  *****************
// ※returnを変数にちゃんと入れる！
$pdo = db_conn();
//３．データ登録SQL作成
$stmt = $pdo->prepare("UPDATE
                            gs_bm_table
                        SET
                            bookname = :bookname,
                            bookURL = :bookURL,
                            bookcomment = :bookcomment,
                            indate = sysdate()
                        WHERE
                        unique_book = :unique_book;
                        ");
$stmt->bindValue(':bookname', h($bookname), PDO::PARAM_STR);    //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':bookURL', h($bookURL), PDO::PARAM_INT);        //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':bookcomment', h($bookcomment), PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':unique_book', h($unique_book), PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute(); //実行
//４．データ登録処理後
if ($status == false) {
    sql_error($stmt);
} else {
    redirect('bm_update_view.php');
}

?>