<?php 
session_start();
include 'config.php';

if(!empty($_GET['id'])){
    if(empty($_SESSION['cart'][$_GET['id']] )){
        $_SESSION['cart'][$_GET['id']] = 1;

    }else{
        $_SESSION['cart'][$_GET['id']] += 1;
    }

    $_SESSION['message'] = 'Cart add Success';
    // unset($_SESSION['cart'] );
    // print_r($_SESSION['cart']);
    // exit();
}

header('location:'.$base_url.'/product-list.php');