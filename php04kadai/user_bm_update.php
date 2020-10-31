<?php

require_once('funcs.php');

$user_id = $_POST['user_id'];
$user_name = $_POST['user_name'];
$user_lid = $_POST['user_lid'];
$user_lpw = $_POST['user_lpw'];
$user_kanri_flg = $_POST['user_kanri_flg'];
$user_life_flg = $_POST['user_life_flg'];
// var_dump($_POST);
//2. D接続します
$pdo = db_conn();

//３．データ登録SQL作成
$stmt = $pdo->prepare("UPDATE
                        gs_user_table
                        SET
                        user_name = :user_name,
                        user_lid = :user_lid,
                        user_lpw = :user_lpw,
                        user_kanri_flg = :user_kanri_flg,
                        user_life_flg = :user_life_flg
                        WHERE
                        user_id = :user_id;
                        ");


// $stmt = $pdo->prepare("INSERT INTO gs_user_table(user_id,user_name,user_lid,user_lpw,user_kanri_flg,user_life_flg)VALUES(NULL,:user_name,:user_lid,:user_lpw,:user_kanri_flg,:user_life_flg)");
$stmt->bindValue(':user_name',$user_name,PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':user_lid',$user_lid,PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':user_lpw',$user_lpw,PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':user_kanri_flg',$user_kanri_flg,PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':user_life_flg',$user_life_flg,PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':user_id',$user_id,PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)

$status = $stmt->execute(); //実行

//４．データ登録処理後
if ($status == false) {
    sql_error($stmt);
} else {
    redirect('index_user.php');
}

?>