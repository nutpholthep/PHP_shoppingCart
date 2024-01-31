<?php
session_start();
include 'config.php';


$productIds = [];
foreach (($_SESSION['cart'] ?? []) as $cartId => $cartQty) {
    $productIds[] = $cartId;
}
//productAll
$ids = 0;
if (count($productIds) > 0) {
    $ids = implode(",", $productIds);
    // var_dump($ids);
}
$query = mysqli_query($conn, "SELECT * FROM products WHERE id IN ($ids)");
$row = mysqli_num_rows($query);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bg-body-tertiary">
    <?php include "include/menu.php" ?>
    <div class="container mt-4">
        <?php if (!empty($_SESSION['message'])) { ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <p class="fs-4 fw-bold"><?= $_SESSION['message'] ?></p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php }
        unset($_SESSION['message']);
        ?>
        <h4>Cart</h4>
        <div class="row ">
            <div class="col-12">
               <form action="<?php echo $base_url; ?>/cart-update.php" method="post">
               <table class="table table-bordered border-info">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>ProductName</th>
                            <th>Price</th>
                            <th style="width: 100px;">Quantity</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($row > 0) {
                            while ($product = mysqli_fetch_assoc($query)) {  ?>
                                <tr>
                                    <td><?php if (!empty($product['profile_image'])) { ?>
                                            <img src="<?php echo $base_url . '/upload_image/' . $product['profile_image'] ?>" alt="Product Image" width="100">
                                        <?php } else { ?>
                                            <img src="<?php echo $base_url . '/assets/no-image.png' ?>" alt="Product Image" width="100">
                                        <?php  } ?>
                                    </td>
                                    <td><?php echo $product['product_name'] ?>
                                        <div>
                                            <small class="text-mute"><?php echo nl2br($product['detail']) ?></small>
                                        </div>
                                    </td>
                                    <td><?php echo number_format($product['price'], 2) ?></td>
                                    <td><input type="number" name="product[<?php echo $product['id'] ?>][quantity]" id="" value="<?php echo $_SESSION['cart'][$product['id']] ?>" class="form-control"></td>
                                    <td><?php echo number_format(($_SESSION['cart'][$product['id']] * $product['price']), 2) ?></td>
                                    <td>
                                        <a href="<?php echo $base_url . '/cart-delete.php?id=' . $product['id'] ?>" role="button" class="btn btn-danger" onclick="return confirm('Are You sure want to delete??')">Delete</a>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="6" class="text-end">
                                    <button type="submit" class="btn btn-lg btn-success">Update</button>
                                    <a href="<?php echo $base_url ?>/checkout.php" class="btn btn-lg btn-primary">Checkout Orders</a>
                                </td>
                            </tr>
                        <?php } else { ?>
                            <tr>
                                <td colspan="6" class="text-center text-danger">ไม่มีรายการสินค้า</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
               </form>
            </div>
        </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>