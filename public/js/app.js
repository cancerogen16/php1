$('.addToCart').click(function(e) {
    e.preventDefault();
    const product_id = $(this).data('id');
    const quantity = 1;

    $.ajax({
        type: "POST",
        url: "addToCart.php",
        data: { product_id: product_id, quantity: quantity },
        dataType: "json"
    }).done(function(json) {
        if (json['success']) {
            const $modal = $('#modal');

            $modal.find('.modal-content').html('<div class="popup-wrap">' +
                '<h4>Товар успешно добавлен в корзину</h4>' +
                '<a class="btn" href="/order.php" ><b>Перейти к заказу</b></a>' +
                '</div>');

            $modal.fadeIn();

            let headerCart = '<a class="cart__link" href="/cart.php">Корзина (' + json['count'] + ')</a>';

            if (json['products']) {
                headerCart += '<div class="cart-content">';
                headerCart += '<table><tbody>';
                for (const key in json['products']) {
                    if (Object.hasOwnProperty.call(json['products'], key)) {
                        const product = json['products'][key];
                        headerCart += '<tr>';
                        headerCart += '<td><img src="img/' + product.image + '" alt="' + product.name + '" width="24"></td>';
                        headerCart += '<td><a class="cart__link" href="/product.php?product_id=' + product.product_id + '">' + product.name + '</a></td>';
                        headerCart += '<td class="price">' + product.price + '</td>';
                        headerCart += '<td>' + product.quantity + '</td>';
                        headerCart += '<td class="price">' + product.total + '</td>';
                        headerCart += '</tr>';
                    }
                }
                headerCart += '</tbody><tfoot>';
                headerCart += '<tr><td colspan="3">Итого</td><td>' + json.count + '</td><td class="price">' + json.total + '</td></tr>';
                headerCart += '</tfoot></table>';

                headerCart += '<div class="order-button"><a class="btn" href="/order.php">Оформить заказ</a></div>';

                headerCart += '</div>';
            }

            $('.header-cart').html(headerCart);

            $('html, body').animate({ scrollTop: 0 }, 'slow');
        }
    });
});

//выбираем все теги с именем  modal
$('a[rel=modalimg]').click(function(e) {
    e.preventDefault();

    const $modal = $('#modalimg');
    const $modalImg = $modal.find('img');

    $modalImg.attr('src', $(this).attr('href'));
    $('#caption').html($(this).find('img').attr('alt'));

    //эффект перехода
    $modal.fadeIn(500);
});

$('.modal .close').click(function(e) {
    e.preventDefault();
    $('.modal').fadeOut(500);
});

function changeQuantity(product_id, quantity) {
    $.ajax({
        type: "POST",
        url: "changeQuantity.php",
        data: { product_id: product_id, quantity: quantity },
        dataType: "json"
    }).done(function(json) {
        if (json['success']) {
            $('.quantity-value').val(quantity);
            alert('Количество товара изменено');
            return quantity;
        } else {
            alert('Ошибка изменения количества товара');
            return false;
        }
    });
}

$('.quantity-btn').click(function(e) {
    e.preventDefault();
    const product_id = $(this).data('id');

    let action = 'minus';

    if ($(this).hasClass('plus')) {
        action = 'plus';
    }

    const quantity = parseInt($('.quantity-value').val());

    let newQuantity = quantity;

    if (action == 'plus') {
        newQuantity++;
    } else
    if (action == 'minus' && quantity > 1) {
        newQuantity--;
    }

    if (newQuantity !== quantity) {
        changeQuantity(product_id, newQuantity);
    }
});

$('.quantity-value').blur(function(e) {
    const product_id = $(this).data('id');

    let quantity = parseInt($(this).val());

    if (quantity > 0) {
        changeQuantity(product_id, quantity);
    }
});