<?php
session_start();
include 'config.php';

//productAll
$query = mysqli_query($conn, "SELECT * FROM products");
$row = mysqli_num_rows($query);

//var
$result = [
    'id' => '',
    'product_name' => '',
    'price' => '',
    'profile_image' => '',
    'detail' => ''
];

//getproductId
if (!empty($_GET['id'])) {
    $query_product = mysqli_query($conn, "SELECT * FROM products WHERE id = {$_GET['id']}");
    $row_product = mysqli_num_rows($query_product);
    if ($row_product == 0) {
        header('location:' . $base_url . '/index.php');
    }
    $result = mysqli_fetch_assoc($query_product);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Product</title>
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
        <h4>Home - Manage Product</h4>
        <div class="row g-5">
            <div class="col-md-8 col-sm-12">
                <form action="<?php echo $base_url ?>/product-form.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $result['id'] ?>">
                    <div class="row g-2 mb-3">

                        <div class="col-sm-6">
                            <label for="product_name">Product Name</label>
                            <input type="text" name="product_name" class="form-control" value="<?php echo $result['product_name'] ?>">
                        </div>

                        <div class="col-sm-6">
                            <label for="price">Price</label>
                            <input type="text" name="price" class="form-control" value="<?php echo $result['price'] ?>">
                        </div>

                        <div class="col-sm-6">
                            <?php if (!empty($result['profile_image'])) : ?>
                                <img src="<?php echo $base_url . '/upload_image/' . $result['profile_image'] ?>" alt="Product Image" width="100">
                                <?php else: ?>
                                    <img src="<?php echo $base_url . '/assets/no-image.png' ?>" alt="Product Image" width="100">
                                <?php endif ?>
                            <label for="profile_image">Image</label>
                            <input type="file" name="profile_image" class="form-control" accept="image/png ,image/jpg ,image/jpeg">
                        </div>

                        <div class="col-sm-12">
                            <label for="profile_image">Detail</label>
                            <textarea name="detail" id="" rows="3" class="form-control"><?php echo $result['detail']; ?>
                            </textarea>
                        </div>

                    </div>
                    <?php if (empty($result['id'])) : ?>
                        <button class="btn btn-primary" type="submit"><i class="fa-solid fa-floppy-disk mx-2"></i>Create</button>
                    <?php else : ?>
                        <button class="btn btn-primary" type="submit"><i class="fa-solid fa-floppy-disk mx-2"></i>Update</button>
                    <?php endif; ?>


                    <a role="button" class="btn btn-secondary" href="<?php echo $base_url . '/index.php' ?>"><i class="fa-solid fa-floppy-disk mx-2"></i>Cancel</a>

                    <hr class="my-4">
                </form>
            </div>
            <div class="row">
                <div class="col-12">
                    <table class="table table-bordered border-info">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>ProductName</th>
                                <th>Price</th>
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
                                        <td>
                                            <a href="<?php echo $base_url . '/index.php?id=' . $product['id'] ?>" role="button" class="btn btn-warning">Edit</a>
                                            <a href="<?php echo $base_url . '/product-delete.php?id=' . $product['id'] ?>" role="button" class="btn btn-danger" onclick="return confirm('Are You sure want to delete??')">Delete</a>
                                        </td>
                                    </tr>
                                <?php }
                            } else { ?>
                                <tr>
                                    <td colspan="4" class="text-center text-danger">ไม่มีรายการสินค้า</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>