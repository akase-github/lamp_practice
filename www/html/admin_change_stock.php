<?php
//定数ファイル読み込み
require_once '../conf/const.php';
//汎用関数ファイル読み込み
require_once MODEL_PATH . 'functions.php';
//userデータに関する関数ファイル読み込み
require_once MODEL_PATH . 'user.php';
//itemデータに関する関数ファイル読み込み
require_once MODEL_PATH . 'item.php';

//ログインチェックを行うためにセッション開始
session_start();

//ログインチェック関数を利用
if(is_logined() === false){
  //ログインされていない場合はログインページにリダイレクト
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

//item_idを取得
$item_id = get_post('item_id');
//stockを取得
$stock = get_post('stock');


if(update_item_stock($db, $item_id, $stock)){
  set_message('在庫数を変更しました。');
} else {
  set_error('在庫数の変更に失敗しました。');
}

redirect_to(ADMIN_URL);