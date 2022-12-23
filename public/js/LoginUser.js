$(document).ready(function (){
    $('#message').hide();
    $('#main_form').on('click', function (){

        let data = {
            'email': $("#email").val(),
            'password': $("#password").val()
        }
        console.log(data);
        sendData(data);

        $('.login_form').hide();
    });

    function sendData(data) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });

        $.ajax({
            url: '/login',
            type: 'post',
            data: data,
            dataType: 'JSON',

            beforeSend:function(){
                    $(document).find('span.error-text').text('');
            },

            success: function (response) {
                console.log(response)
                if(response.status === 401)


                {
                    $.each(response.error,function (prefix, val){
                        $('span.'+prefix+'_error').text(val[0]);
                    });
                }


                if (response.status === 200) {

                    if (response.message === 'successfully') {
                        console.log(response.role);
                        if(response.role === 'admin'){
                            window.location = "/admin";
                        }else if(response.role === 'user'){
                            window.location = "/user";
                        }

                    } else {
                        window.location = "/";
                    }
                }
                else if (response.status=== 400)
                {
                    $('#message').show();
                    // console.log(response.error);
                    $("#message").append(
                        "<div class='login_form'>" +
                        "<li>" + response.error + "</li>" +
                        "</div>"
                    );
                }
            },
        });
    }});
