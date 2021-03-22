<?php
$user_id = 0;

if (isset($_SESSION["user_id"]) && $_SESSION["user_id"]) {
    $user_id = (int)$_SESSION["user_id"];
}

$product_id = filter_input(INPUT_GET, 'product_id', FILTER_SANITIZE_SPECIAL_CHARS);

$addToCart = filter_input(INPUT_GET, 'addToCart', FILTER_SANITIZE_SPECIAL_CHARS);

if ($product_id) {
    if ($addToCart) {
        addToCart($product_id, $user_id);
    }
}

$cart_products = [];

if ($cart = getCart($user_id)) {
    $cart_products = $cart['products'];
}
?>

<div class="header-cart">
    <a class="cart__link" href="/cart.php">Корзина (<?= $cart['count'] ?>)</a>
    <?php if (!empty($cart_products)) : ?>
    <div class="cart-content">
        <table>
            <tbody>
                <?php foreach ($cart_products as $product) : ?>
                <tr>
                    <td><img src="img/<?= $product['image'] ?>" alt="<?= $product['name'] ?>" width="24"></td>
                    <td><a class="cart__link"
                            href="/product.php?product_id=<?= $product['product_id'] ?>"><?= $product['name'] ?></a>
                    </td>
                    <td class="price"><?= $product['price'] ?></td>
                    <td><?= $product['quantity'] ?></td>
                    <td class="price"><?= $product['total'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">Итого</td>
                    <td><?= $cart['count'] ?></td>
                    <td class="price"><?= $cart['total'] ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
    <?php endif; ?>
</div>