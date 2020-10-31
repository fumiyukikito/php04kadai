<?php
session_start();

include("funcs.php");
sessionCheck();

//１．PHP
//select.phpのPHPコードをマルっとコピーしてきます。
//※SQLとデータ取得の箇所を修正します。
$user_id = $_GET['user_id'];
// require_once("funcs.php");

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

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_user_table
                        WHERE user_id=:user_id");
$stmt->bindValue(':user_id',$user_id, PDO::PARAM_INT);
$status = $stmt->execute();
//３．データ表示
$view = "";
if ($status == false) {
    // sql_error($status);
        $error = $stmt->errorInfo();
        exit("SQLError:".$error[2]);
} else {
    $result = $stmt->fetch();
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>フリーアンケート表示</title>
    <link rel="stylesheet" href="css/range.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        div {
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>
<body id="main">
    <!-- Head[Start] -->
    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                <a class="navbar-brand" href="index_user.php">ユーザー登録</a>
              　<a class="navbar-brand" href="user_select.php">ユーザー一覧</a>
            　　<a class="navbar-brand" href="login.php">ログイン</a>
      　　　　　　<a class="navbar-brand" href="logout.php">ログアウト</a>

                </div>
            </div>
        </nav>
    </header>
    <!-- Head[End] -->
    <!-- Main[Start] -->

    <!-- <div>
        <div class="container jumbotron">
            <a href="bm_update_view.php"></a>
            <?= $view ?>
        </div>
    </div> -->

<!-- Main[Start] -->
    <form method="POST" action="user_bm_update.php">
        <div class="jumbotron">
            <fieldset>
                <legend>ユーザー情報</legend>
                <label>ユーザー名：<input type="text" name="user_name" value=<?= $result['user_name'] ?>></label><br>
                <label>ID：<input type="text" name="user_lid" value=<?= $result['user_lid'] ?>></label><br>
                <label>PASS：<input type="text" name="user_lpw" value=<?= $result['user_lpw'] ?>></label><br>
                <label>管理者：<input type="checkbox" name="user_kanri_flg" id="user_kanri_flg" value="1"  <?php echo ($result['user_kanri_flg']==1 ? 'checked' : '') ?>></label><br>
                <label>退職者：<input name="user_life_flg" type="hidden" value="0" /><input name="user_life_flg" type="checkbox" value="1" /></label><br>
                <input type="hidden" name="user_id" value=<?= $user_id ?>>

                <input type="submit" value="送信">  
            </fieldset>
        </div>
    </form>
    <!-- Main[End] -->
</body>
</html>
