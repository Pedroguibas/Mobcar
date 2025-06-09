$('#loginSelectorBtn').on('click', function() {
    $(this).parent().addClass('left');
    $(this).parent().removeClass('right');  
});

$('#signupSelectorBtn').on('click', function() {
    $(this).parent().addClass('right');
    $(this).parent().removeClass('left');
});