$(document).ready(function () {

    $('.menu button.register').bind('click',function () {
        $('.ui.modal.register').modal('show');
    });
    $('.menu button.login').bind('click',function () {
        $('.ui.modal.login').modal('show');
    });
    $('.menu button.logout').bind('click',function () {
        window.location.replace("logout.php");
    });
    $('.message.warning').bind('click',function () {
        $(this).closest('.message').transition('fade');
    });

});