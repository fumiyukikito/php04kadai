<?php
session_start();

//１．PHP
//select.phpのPHPコードをマルっとコピーしてきます。
//※SQLとデータ取得の箇所を修正します。
$unique_book = $_GET['unique_book'];
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
$stmt = $pdo->prepare("SELECT * FROM gs_bm_table
                        WHERE unique_book=:unique_book");
$stmt->bindValue(':unique_book',$unique_book, PDO::PARAM_INT);
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
                    <a class="navbar-brand" href="select.php">データ一覧</a>
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

    <!-- Main[End] -->
    <!--
２．HTML
以下にindex.phpのHTMLをまるっと貼り付ける！
理由：入力項目は「登録/更新」はほぼ同じになるからです。
※form要素 input type="hidden" name="id" を１項目追加（非表示項目）
※form要素 action="update.php"に変更
※input要素 value="ここに変数埋め込み"
-->
<!-- Main[Start] -->
    <form method="POST" action="bm_update.php">
        <div class="jumbotron">
            <fieldset>
                <legend>bookmark</legend>
                <label>書籍名：<input type="text" name="bookname" value=<?= $result['bookname'] ?>></label><br>
                <label>URL：<input type="text" name="bookURL" value=<?= $result['bookURL'] ?>></label><br>
                <label><textArea name="bookcomment" rows="4" cols="40"> <?= $result['bookcomment'] ?> </textArea></label><br>
                <input type="hidden" name="unique_book" value=<?= $result['unique_book'] ?>>
                <input type="submit" value="送信">
            </fieldset>
        </div>
    </form>
    <!-- Main[End] -->
</body>
</html>
