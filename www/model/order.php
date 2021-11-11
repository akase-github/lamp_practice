<?php
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';

function insert_order($db, $user_id){
    $sql = "
      INSERT INTO
        orders(user_id)
      VALUES (?);
    ";
  
    return execute_query($db, $sql, array($user_id));
  }
  
function insert_order_detail($db, $order_id, $item_id, $price, $amount){
    $sql = "
      INSERT INTO
        order_details(order_id, item_id, price, amount)
      VALUES(?, ?, ?, ?)
    ";
  
    execute_query($db, $sql, array($order_id, $item_id, $price, $amount));
}

function get_user_order($db, $user_id){
  $sql = "
    SELECT
      orders.order_id,
      orders.created,
      SUM(order_details.price * order_details.amount) as total
    FROM
      orders
    INNER JOIN
      order_details
    ON
      orders.order_id = order_details.order_id
    WHERE
      orders.user_id = ?
    GROUP BY
      orders.order_id
    ORDER BY
      orders.created DESC;
  ";

  return fetch_all_query($db, $sql, array($user_id));
}

function get_admin_order($db){
  $sql = "
    SELECT
      orders.order_id,
      orders.created,
      SUM(order_details.price * order_details.amount) as total
    FROM
      orders
    INNER JOIN
      order_details
    ON
      orders.order_id = order_details.order_id
    GROUP BY
      orders.order_id
    ORDER BY
      orders.created DESC;
  ";

  return fetch_all_query($db, $sql);
}

function get_order_detail($db, $order_id){
  $sql = "
    SELECT
      order_details.price,
      order_details.amount,
      order_details.price * order_details.amount as total,
      items.name
    FROM
      order_details
    INNER JOIN
      items
    ON
      order_details.item_id = items.item_id
    WHERE
      order_details.order_id = ?;
  ";

  return fetch_all_query($db, $sql, array($order_id));
}

function get_user_order_detail($db, $user_id, $order_id){
  $sql = "
    SELECT
      orders.order_id,
      orders.created,
      SUM(order_details.price * order_details.amount) as total
    FROM
      orders
    INNER JOIN
      order_details
    ON
      orders.order_id = order_details.order_id
    WHERE
      orders.user_id = ? AND orders.order_id = ?
    GROUP BY
      orders.order_id
    ORDER BY
      orders.created DESC;
  ";

  return fetch_all_query($db, $sql, array($user_id, $order_id));
}

function get_admin_order_detail($db, $order_id){
  $sql = "
  SELECT
    orders.order_id,
    orders.created,
    SUM(order_details.price * order_details.amount) as total
  FROM
    orders
  INNER JOIN
    order_details
  ON
    orders.order_id = order_details.order_id
  WHERE
    orders.order_id = ?
  GROUP BY
    orders.order_id
  ORDER BY
    orders.created DESC;
    ";

  return fetch_all_query($db, $sql, array($order_id));
}

