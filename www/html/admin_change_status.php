<?php
//定数ファイル読み込み
require_once '../conf/const.php';
//汎用関数ファイル読み込み
require_once MODEL_PATH . 'functions.php';
//userデータに関する関数ファイル読み込み
require_once MODEL_PATH . 'user.php';
//itemデータに関する関数ファイル読み込み
require_once MODEL_PATH . 'item.php';

//ログインチェックを行うため、セッションを開始する
session_start();

//ログインチェック関数を利用
if(is_logined() === false){
  //ログインしていない場合はログインページにリダイレクト
  redirect_to(LOGIN_URL);
}

//PDOを取得
$db = get_db_connect();

//PDOを利用してログインユーザーのデータを取得
$user = get_login_user($db);

//アドミンチェック関数を利用
if(is_admin($user) === false){
  //アドミンではない場合はログインページにリダイレクト
  redirect_to(LOGIN_URL);
}

//POSTで送られた値を代入
$item_id = get_post('item_id');
//POSTで送られた値を代入
$changes_to = get_post('changes_to');

//CSRF 対策
$token = get_post('token');
if(is_valid_csrf_token($token) !== true) {
  redirect_to(LOGIN_URL);
}

//変数の値をチェック
if($changes_to === 'open'){
  //アイテムの公開設定を変更
  update_item_status($db, $item_id, ITEM_STATUS_OPEN);
  //SESSIONにメッセージを保存
  set_message('ステータスを変更しました。');
//変数の値をチェック
}else if($changes_to === 'close'){
  //アイテムの公開設定を変更
  update_item_status($db, $item_id, ITEM_STATUS_CLOSE);
  //SESSIONにメッセージを保存
  set_message('ステータスを変更しました。');
}else {
  //SESSIONにエラーメッセージを保存
  set_error('不正なリクエストです。');
}

//admin.phpに遷移
redirect_to(ADMIN_URL);