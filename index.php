<?php

// 定数
require_once '../../const.php';
// sql関連
require_once 'model/sql/sql.php';
// img関連
require_once 'model/img/filesImg.php';
// CRUD インスタンス作成
$link = new CRUD();
// FILES インスタンス作成
$FILES = new FILES($_FILES);
// 一覧表示
$imgList = $link->sqlRead();
// ボタン送信
if (isset($_POST['submit'])) {
    //日本語に変更
    $file_name = $FILES->jpEncode();
    // $file_name = $_FILES['file']['name'];
    // 投稿
    $link->sqlCreate($_POST['msg'], $file_name);
    // ファイルアップロード
    if ($FILES->uploadFile()) {
        // サムネイル作成
        $FILES->imgCompress();
    }
    // header('Location:index.php');
    // exit;
}

require_once 'view/index.php';
