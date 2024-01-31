<?php
session_start();
include 'config.php';
$now = date("Y-m-d H:i:s");
$fullname = $_POST['fullname'];
$email = $_POST['email'];
$tel = $_POST['tel'];
$grand_total = $_POST['grand_total'];

$query = mysqli_query(
    $conn,
    "INSERT INTO orders (order_date,fullname,email,tel,grand_total) VALUES('{$now}','{$fullname}','{$email}',
    '{$tel}','{$grand_total}')"
) or die("query failed");

if ($query) {
    $last_id = mysqli_insert_id($conn);
    foreach ($_SESSION['cart'] as $productId => $productqty) {
        $product_name = $_POST['product'][$productId]['name'];
        $product_price = $_POST['product'][$productId]['price'];
        $total = $product_price * $productqty;
    
        mysqli_query(
            $conn,
            "INSERT INTO order_details (order_id,product_id,product_name,price,quantity,total) VALUES('{$last_id}','{$productId}','{$product_name}','{$product_price}','{$productqty}','{$total}')"
        ) or die("query failed");
    }

    $_SESSION['message'] = 'Checkout order Success';
    unset($_SESSION['cart']);
    header('location:' . $base_url . '/checkout-success.php');
} else {
    $_SESSION['message'] = 'Checkout not Complete';
    header('location:' . $base_url . '/checkout.php');
}

// print_r($_POST);