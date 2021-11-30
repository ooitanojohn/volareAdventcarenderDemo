<?php
// 定数
require_once '../../const.php';
// sql関連
require_once 'model/sql/sql.php';
$link = sqlLink();
// 一覧表示
$imgList = sqlRead($link);
// ボタン送信
if (isset($_POST['submit'])) {
    //日本語に変更
    require_once 'model/img/jpEncode.php';
    $file_name = jpEncode($_FILES['file']['name']);
    $file_name = $_FILES['file']['name'];
    // 投稿
    sqlCreate($link, $_POST['msg'], $file_name);
    // ファイルアップロード
    require_once 'model/img/uploadFile.php';
    if (uploadFile($file_name)) {
        // サムネイル作成
        require_once 'model/img/imgCompress.php';
        imgCompress($file_name);
    }
    header('Location:index.php');
    exit;
}

require_once 'view/index.php';
