function isDigit(str) {
   let n = parseInt(str);

    if (isNaN(n))
        return false;

    return true;
}

function fetchAddress(str) {
    $.ajax({
        url: 'https://viacep.com.br/ws/' + str + '/json/',
        success: function(r) {
            if (!("erro" in r)) {
                $('#signupStateInput').val(r.estado);
                $('#signupCityInput').val(r.localidade);
                $('#signupStreetInput').val(r.logradouro);
            } else {
                $('#signupCepInput').addClass('is-invalid');
            }
        }
    }).then(function() {
        $('#searchingCpfSpinner').hide();
        $('#signupCepInput').prop('disabled', false);
    });
}

$('#loginSelectorBtn').on('click', function() {
    $(this).parent().addClass('left');
    $(this).parent().removeClass('right'); 
    $('#signupForm').addClass('d-none'); 
    $('#loginForm').removeClass('d-none');
});

$('#signupSelectorBtn').on('click', function() {
    $(this).parent().addClass('right');
    $(this).parent().removeClass('left');
    $('#loginForm').addClass('d-none');
    $('#signupForm').removeClass('d-none');
});

$('#signupCepInput').on('focus', function() {
    $(this).removeClass('is-invalid')
});

$('#signupCepInput').on('input', function() {
    let str = $(this).val();
    let j=0;

    while (j < str.length) {
        if (!isDigit(str.charAt(j))) {
            str = str.slice(0,j) + str.slice(j+1, str.length);
            $(this).val(str);
        } else {
            j++;
        }
    }
    
    if (str.length >= 6 && isDigit(str.charAt(str.length -1))) {
        let i = str.indexOf('-');
        if (i != -1)
            str = str.slice(0,i) + str.slice(i+1,str.length);
        str = str.slice(0,5) + '-' + str.slice(5,str.length);

        if (str.length >= 9) {
            $('#searchingCpfSpinner').show();
            $(this).prop('disabled', true);
            fetchAddress(str.slice(0,5) + str.slice(6,9))
        } else {
            $('#signupStateInput').val('');
            $('#signupCityInput').val('');
            $('#signupStreetInput').val('');
        }
        if (str.length > 9)
            str = str.slice(0, str.length-1);
        $(this).val(str);
        
    } else {
        $('#signupStateInput').val('');
        $('#signupCityInput').val('');
        $('#signupStreetInput').val('');
    }
});