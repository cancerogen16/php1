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

            $modal.find('.modal-content').html('<div class="popup-wrap"><div class="popup-title">' +
                '<h4>Товар успешно добавлен в корзину</h4>' +
                '</div>' +
                '<div class="content">' +
                '<div class="text">' +
                '<div class="name">' +
                '</div>' +
                '<div class="price">' +
                '</div>' +
                '</div>' +
                '<a class="btn" href="/order.php" ><b>Перейти к заказу</b></a>' +
                '</div></div>');

            $modal.fadeIn();

            $('.header-cart').html(json['total']);

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