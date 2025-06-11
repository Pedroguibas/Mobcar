function isDigit(str) {
   let n = parseInt(str);

    if (isNaN(n))
        return false;

    return true;
}

function fetchAddress(str) {
    let result = true;
    $.ajax({
        url: 'https://viacep.com.br/ws/' + str + '/json/',
        success: function(r) {
            if (!("erro" in r)) {
                result = false;
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
    return result;
}

async function validateEmail() {
    let returnBool = true;
    let emailValue = $('#signupEmailInput').val();
    await $.ajax({
        url: baseurl + 'forms/validateEmail.php',
        method: 'GET',
        data: {
            email: emailValue
        },
        success: function(r) {
            if (r >= 1) {
                returnBool = false;
                $('#signupEmailInput').addClass('is-invalid');
            }
        }
    });
    
    return returnBool;
}

function validatePassword() {
    let password = $('#signupPasswordInput').val();
    let count = 0;

    if (password.length < 8 || password.length >30) {
        $('#passwordLengthRequirement').addClass('invalid');
        $('#passwordLengthRequirement').removeClass('valid');
        count++;
    } else {
        $('#passwordLengthRequirement').addClass('valid');
        $('#passwordLengthRequirement').removeClass('invalid');
    }

    if (!(/[A-Z]/.test(password))) {
        count++;
        $('#passwordCapRequirement').addClass('invalid');
        $('#passwordCapRequirement').removeClass('valid');
    } else {
        $('#passwordCapRequirement').addClass('valid');
        $('#passwordCapRequirement').removeClass('invalid');
    }

    if (!(/[a-z]/.test(password))) {
        count++;
        $('#passwordLowerRequirement').addClass('invalid');
        $('#passwordLowerRequirement').removeClass('valid');
    } else {
        $('#passwordLowerRequirement').addClass('valid');
        $('#passwordLowerRequirement').removeClass('invalid');
    }

    if (!(/[1-9]/.test(password))) {
        count++;
        $('#passwordNumberRequirement').addClass('invalid');
        $('#passwordNumberRequirement').removeClass('valid');
    } else {
        $('#passwordNumberRequirement').addClass('valid');
        $('#passwordNumberRequirement').removeClass('invalid');
    }

    if (password.indexOf('@') == -1 &&
        password.indexOf('$') == -1 &&
        password.indexOf('!') == -1 && 
        password.indexOf('%') == -1 &&
        password.indexOf('*') == -1 &&
        password.indexOf('#') == -1 &&
        password.indexOf('?') == -1 &&
        password.indexOf('&') == -1 &&
        password.indexOf('+') == -1 &&
        password.indexOf('-') == -1) {

        $('#passwordSpecialCharRequirement').addClass('invalid');
        count++
    } else {
        $('#passwordSpecialCharRequirement').removeClass('invalid');
        $('#passwordSpecialCharRequirement').addClass('valid');
    }
    
    if (count == 0)
        return true;

    return false;
}
function validatePasswordConfirmation() {
    
    if ($('#signupPasswordConfirmationInput').val() == $('#signupPasswordInput').val())
        return true;

    $('#signupPasswordConfirmationInput').addClass('is-invalid');
    return false;
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

$('input').on('focus', function() {
    $(this).removeClass('is-invalid')
});

$('#signupCepInput').on('focus', function() {
    $(this).removeClass('is-invalid')
    $('#signupStateInput').removeClass('is-invalid');
    $('#signupCityInput').removeClass('is-invalid');
    $('#signupStreetInput').removeClass('is-invalid');
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

$('#signupPasswordInput').on('input', function() {
    if ($(this).val().length == 0) {
        $('.passwordRequirement').removeClass('invalid')
        $('.passwordRequirement').removeClass('valid')
    } else {
        validatePassword();
    }
});


// Cancels form submition for validation and submits if every field fits the criteria
$('#signupForm form').on('submit', async function(e) {
    e.preventDefault();

    let count=0;

    cpf = $('#signupCepInput').val()
    cpf = cpf.slice(0,cpf.indexOf('-')) + cpf.slice(cpf.indexOf('-')+1, cpf.length);
    $('#signupCepInput').val(cpf);

    if (!fetchAddress(cpf)) {
        $('#signupStateInput').addClass('is-invalid');
        $('#signupCityInput').addClass('is-invalid');
        $('#signupStreetInput').addClass('is-invalid');
    }

    if (!validatePassword()) {
        $('#signupPasswordInput').addClass('is-invalid');
        count++;
    }

    if (!validatePasswordConfirmation())
        count++;

    if (!(await validateEmail())) {
        count++;
        $('#signupEmailInput').get(0).scrollIntoView({behavior: 'smooth'});
    }
    
    
    if (count == 0)
        $('#signupForm form')[0].submit();
});