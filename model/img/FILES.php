<?php

/**
 * _FILES を受け取り　プロパティとして保持
 *@param array $FILES
 */
class FILES{
    protected array $FILES;
    public function __construct($FILES){
        $this->FILES = $FILES;
    }
    /**
     * ファイルアップロード
     * 引数 $FILESの 一時保存dir 保存先dir+ファイル保存名
     * @return boolean
     */
    public function uploadFile()
    {
        return move_uploaded_file($this->FILES['file']['tmp_name'], 'img/' . $this->FILES['file']['name']);
    }
    // /**
    //  * win sijsにエンコード
    //  * 引数 グローバル変数$_FILEの[name],変更先の文字コード,変更元の文字コード
    //  * @return string
    //  */
    // public function jpEncode()
    // {
    //     //日本語に変更
    //     return mb_convert_encoding($this->FILES['file']['name'], 'sjis', 'utf8');
    // }
}







