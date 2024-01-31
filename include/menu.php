<header class="d-flex justify-content-center py-3 sticky-top bg-light border-bottom shadow-sm">
    <ul class="nav nav-pills">
        <li class="nav-items"><a href="<?= $base_url?>/index.php" class="nav-link">Home</a></li>
        <li class="nav-items"><a href="<?= $base_url?>/product-list.php" class="nav-link">Product</a></li>
        <li class="nav-items"><a href="<?= $base_url?>/cart.php" class="nav-link">Cart (<?php echo array_sum($_SESSION['cart'] ?? []) ?>)</a></li>
    </ul>
</header>