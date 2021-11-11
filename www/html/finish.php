<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';
require_once MODEL_PATH . 'order.php';

session_start();

if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

$get_token = get_post('token');
if(is_valid_csrf_token($get_token) === false){
  redirect_to(LOGIN_URL);
}

$db = get_db_connect();
$user = get_login_user($db);

$carts = get_user_carts($db, $user['user_id']);

if(purchase_carts($db, $carts) === false){
  set_error('商品が購入できませんでした。');
  redirect_to(CART_URL);
} else {
  insert_order($db, $user['user_id']);
  $order_id = $db->lastInsertId();
  foreach ($carts as $cart) {
    insert_order_detail($db, $order_id, $cart['item_id'], $cart['price'], $cart['amount']);
  }
}

$total_price = sum_carts($carts);

include_once '../view/finish_view.php';