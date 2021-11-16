<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  
  <title>商品一覧</title>
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'index.css'); ?>">
  <style>
    
  </style>
</head>
<body>
  <?php include VIEW_PATH . 'templates/header_logined.php'; ?>


  <div class="container">
    <h1>商品一覧</h1>
    <?php include VIEW_PATH . 'templates/messages.php'; ?>
    <form action="index.php" method="get">
      <select name="sort">
        <option value="new" <?php if($sort === 'new'){print('selected');} ?>>新着順</option>
        <option value="low" <?php if($sort === 'low'){print('selected');} ?>>価格の安い順</option>
        <option value="high" <?php if($sort === 'high'){print('selected');} ?>>価格の高い順</option>
      </select>
      <input type="submit" value="並び替え">
    </form>
    <div class="card-deck">
      <div class="row">
      <?php foreach($items as $item){ ?>
        <div class="col-6 item">
          <div class="card h-100 text-center">
            <div class="card-header">
              <?php print(h($item['name'])); ?>
            </div>
            <figure class="card-body">
              <img class="card-img" src="<?php print(IMAGE_PATH . $item['image']); ?>">
              <figcaption>
                <?php print(number_format($item['price'])); ?>円
                <?php if($item['stock'] > 0){ ?>
                  <form action="index_add_cart.php" method="post">
                    <input type="submit" value="カートに追加" class="btn btn-primary btn-block">
                    <input type="hidden" name="item_id" value="<?php print($item['item_id']); ?>">
                    <input type="hidden" name="token" value="<?php print($token); ?>">
                  </form>
                <?php } else { ?>
                  <p class="text-danger">現在売り切れです。</p>
                <?php } ?>
              </figcaption>
            </figure>
          </div>
        </div>
      <?php } ?>
      </div>
    </div>
    <p><?php print($count_items); ?>件中
<?php print($page * 8 - 7); ?>-<?php print($page * 8); ?>件目の商品  
    </p>
    <ul class="page">
<?php if($page >= 2){ ?>
      <li><a href=?page=<?php print($page - 1); ?>>前へ</a></li>
<?php } ?>
      <li><a href=?page=1 class="<?php if($page == 1 || $page === ''){print('blue');} ?>">1</a></li>
<?php for($i = 2; $total_page >= $i; $i++){ ?>
      <li><a href=?page=<?php print($i); ?> class="<?php if($page == $i){print('blue');} ?>"><?php print($i); ?></a></li>
<?php } ?>
<?php if($total_page > $page || $page === ''){ ?>      
      <li><a href=?page=<?php print($page + 1); ?>>次へ</a></li>
<?php } ?>
    </ul>
  </div>

</body>
</html>