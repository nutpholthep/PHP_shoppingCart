<?php

$image_name = $_FILES['profile_image']['name'];
$new_name = date("Ymdhis") . $image_name;
var_dump($new_name );