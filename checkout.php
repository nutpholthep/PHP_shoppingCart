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
 $grandTotal = 0;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
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
        <div class="row g-5">

            <div class="col-md-5 col-lg-4 order-md-last">
            <form class="needs-validation" novalidate="" action="checkout-form.php" method="post">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-primary">Your cart</span>
                    <span class="badge bg-primary rounded-pill"><?php echo array_sum($_SESSION['cart']) ?></span>
                </h4>
                <ul class="list-group mb-3">
                    <?php if ($row > 0) : ?>
                        <?php while ($product = mysqli_fetch_assoc($query)) : ?>
                            <?php $grandTotal += $_SESSION['cart'][$product['id']] * $product['price']; ?>
                            <input type="hidden" name="product[<?php echo $product['id']?>][name]" value="<?= $product['product_name'] ?>">
                    <input type="hidden" name="product[<?php echo $product['id']?>][price]" value="<?= $product['price'] ?>">
                            <li class="list-group-item d-flex justify-content-between lh-sm">
                                <div>
                                    <h6 class="my-0"><?= $product['product_name']; ?>
                                    <span class="fw-bold">(<?php echo $_SESSION['cart'][$product['id']]; ?>)</span></h6>
                                    <small class="text-muted"><?= $product['detail'] ?></small>
                                </div>
                                <span class="text-muted"><?= number_format(($_SESSION['cart'][$product['id']] * $product['price']), 2) ?></span>
                            </li>
                        <?php endwhile ?>
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                                <div>
                                    <h6 class="my-0 text-success fw-bold">GrandTotal</h6>
                                    <small class=" text-success">amount</small>
                                </div>
                                <span class=" text-success fw-bold"><?= number_format($grandTotal, 2) ?></span>
                            </li>
                    <?php endif ?>
                </ul>
            </div>


            <!--------------------------- input form ----------------- -->
            <div class="col-md-7 col-lg-8">
                <h4 class="mb-3">Checkout</h4>
                
                    <input type="hidden" name="grand_total" value="<?= $grandTotal ?>">
                   
                    <div class="row g-3">
                        <div class="col-sm-12">
                            <label for="fullname" class="form-label">Fullname</label>
                            <input type="text" class="form-control" id="fullname" placeholder="" value="" required="" name="fullname">
                            <div class="invalid-feedback">
                                Valid first name is required.
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="tel" class="form-label">Tel</label>
                            <input type="text" class="form-control" id="tel" placeholder="" value="" required="" name="tel">
                            <div class="invalid-feedback">
                                Valid first name is required.
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="" value="" required="" name="email">
                            <div class="invalid-feedback">
                                Valid first name is required.
                            </div>
                        </div>
                        <hr class="my-4">

                        <div class="d-flex g-3 justify-content-end">
                            <a href="./product-list.php" class=" btn btn-secondary me-2 " role="button">Back to product</a>
                            <button class=" btn btn-primary " type="submit">Continue to checkout</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>