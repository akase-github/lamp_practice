CREATE TABLE orders (
    order_id INT AUTO_INCREMENT,
    user_id INT,
    created DATETIME,
    PRIMARY KEY(order_id)
);

CREATE TABLE order_details (
    order_id INT,
    item_id INT,
    amount INT
);
