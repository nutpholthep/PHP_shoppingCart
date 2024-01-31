<?php
session_start();
include 'config.php';

//productAll
$query = mysqli_query($conn, "SELECT * FROM products");
$row = mysqli_num_rows($query);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
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
        <h4>Product-List</h4>
        <div class="row ">
            <?php if ($row > 0) : ?>
                <?php while ($product = mysqli_fetch_assoc($query)) :  ?>
                    <div class="col-3 mb-3 ">
                        <div class="card" style="width: 18rem;">
                            <?php if (!empty($product['profile_image'])) { ?>
                                <img src="<?php echo $base_url . '/upload_image/' . $product['profile_image'] ?>" alt="Product Image" class="card-img-top" style="width: 100%; height: 200px; object-fit: cover;">
                            <?php } else { ?>
                                <img src="<?php echo $base_url . '/assets/no-image.png' ?>" alt="Product Image" class="card-img-top" style="width: 100%; height: 200px; object-fit: cover;">
                            <?php  } ?>
                            <div class="card-body">
                                <h5 class="card-title"><?= $product['product_name'] ?></h5>
                                <p class="card-text text-success fw-bold mb-0"><?php echo number_format($product['price'], 2) ?> บาท</p>
                                <p class="card-text"><?= $product['detail'] ?></p>
                                <a href="<?php echo $base_url?>/cart-add.php?id=<?php echo $product['id']?>" class="btn btn-primary w-100">เพิ่มลงในตระกร้า <i class="fa-solid fa-cart-plus"></i></a>
                            </div>
                        </div>

                    </div>
                <?php endwhile  ?>
            <?php else : ?>
                <h4>ไม่มีรายการสินค้า</h4>
            <?php endif ?>

        </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>