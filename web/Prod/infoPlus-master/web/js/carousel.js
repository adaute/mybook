jQuery(document).ready(function($) {
    $('#myCarousel').carousel({
        interval: 5000
    });
    var id = 0;
    $('#carousel-text').html($('#slide-content-' + id).html());
    $('[id^=carousel-selector-]').click( function(){
        id = this.id.substring(this.id.lastIndexOf('-'));
        id = parseInt(id.replace('-',''));
        $('#myCarousel').carousel(id);
    });
    $('#myCarousel').on('slid.bs.carousel', function (e) {
        id = $('#myCarousel .active').index('#myCarousel .item');
        $('#carousel-text').html($('#slide-content-'+id).html());
    });
});