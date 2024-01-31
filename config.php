<?php

//var url
$base_url ='http://localhost/shoppingcart';

//var database
$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'shoppingcart';

//connect
$conn = mysqli_connect($db_host,$db_user,$db_password,$db_name) or die ('connection failed');