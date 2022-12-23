$(document).ready(function () {

    $('#store_Form').on('click', function () {
        let data = {
            'username':$('#username').val(),
            'email': $('#email').val(),
            'password': $('#password').val(),
            'role': $('#role').val()
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });
        $.ajax({
            url: '/store',
            type: 'post',
            data: data,
            dataType: 'JSON',
            beforeSend: function () {
                $(document).find('span.error-text').text('');
            },
            success: function (response) {
                if (response.status === 200) {
                    window.location = '/storeIndex';

                    }
                else if (response.status === 400)
                {
                    $.each(response.error, function (prefix, val)
                    {
                        $('span.' + prefix + '_error').text(val[0]);
                    });
                }
                alert("data submitted successfully");

            },




        })


    })



})
