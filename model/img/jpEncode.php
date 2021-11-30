<?php

/**
 * win sijsにエンコード
 * 引数 グローバル変数$_FILEの[name],変更先の文字コード,変更元の文字コード
 */
function jpEncode($fileTmpName)
{
    //日本語に変更
    return mb_convert_encoding($fileTmpName, 'sjis', 'utf8');
}
