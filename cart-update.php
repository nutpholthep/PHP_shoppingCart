<?php 
session_start();
include 'config.php';

foreach($_SESSION['cart'] as $productId => $productqty){
    $_SESSION['cart'][$productId] = $_POST['product'][$productId]['quantity'];

}
// exit();
$_SESSION['message'] = 'Cart update Success';
header('location:'.$base_url.'/cart.php');