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