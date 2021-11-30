<?php

/**
 * ファイルアップロード
 * 引数 $_FILESの 一時保存dir 保存先dir+ファイル保存名
 */
function uploadFile($file_name)
{
    return move_uploaded_file($_FILES['file']['tmp_name'], 'img/' . $file_name);
}
