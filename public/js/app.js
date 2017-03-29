function previewImage() {
    var preview = document.querySelector('.preview');
    var file    = document.querySelector('input[type=file]').files[0];
    var reader  = new FileReader();

    reader.addEventListener("load", function () {
        preview.src = reader.result;
    }, false);

    if (file) {
        reader.readAsDataURL(file);

    }
    setInterval(function(){
        var image = document.getElementById('image');
        var cropper = new Cropper(image, {
            aspectRatio: 300 / 180,
            crop: function(e) {
                x = e.detail.x;
                y = e.detail.y;
                width = e.detail.width;
                height = e.detail.height;
            }
        });
    }, 50);
}

function previewAvatar() {
    var preview = document.querySelector('.preview');
    var file    = document.querySelector('input[type=file]').files[0];
    var reader  = new FileReader();

    reader.addEventListener("load", function () {
        preview.src = reader.result;
    }, false);

    if (file) {
        reader.readAsDataURL(file);

    }
    setInterval(function(){
        var image = document.getElementById('image-file');
        var cropper = new Cropper(image, {
            aspectRatio: 1,
            crop: function(e) {
                x = e.detail.x;
                y = e.detail.y;
                width = e.detail.width;
                height = e.detail.height;
            }
        });
    }, 50);
}

//JQuery functions being called down bellow
$(document).ready(function () {
    $('#alertbox').hide();
    $('#upload-form').on('submit', function(e) {
        e.preventDefault();
        var form = $(this); //This is useless
        var url = $(this).attr('action');

        var some = $('#image-input')[0].files;
        var data = new FormData(some);
        data.append('post_id', $('#id').attr('value'));
        data.append('file-0', some[0]);
        data.append('x', x);
        data.append('y', y);
        data.append('width', width);
        data.append('height', height);
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            contentType: false,
            processData: false,
        })
        .done(function () {
            $('#alertbox').show();
        });

    });


    $('#myForm').on('submit', function (e) {
        e.preventDefault();
        var form = $(this); //This is useless
        var url = $(this).attr('action');

        var some = $('#image')[0].files;
      
        var data = new FormData(some);
        data.append('post_id', $('#id').attr('value'));
        data.append('file-0', some[0]);
        data.append('x', x);
        data.append('y', y);
        data.append('width', width);
        data.append('height', height);
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            contentType: false,
            processData: false,
        })
        .done(function () {
            $('#alertbox').show();
        });

    });
    
    //I'm gonna validate the data is this section below 
    $('#registerForm').submit(function (e) {
        e.preventDefault();
        $url = $(this).attr('action');
        $email = $("#email").val();
        $username= $("#username").val();
        data = new FormData();
        data.append('username', $username);
        data.append('email', $email);
        $.ajax({
            type: "POST",
            url: $url,
            data: data,
            contentType: false,
            processData: false
        })
        .done (function (data) {
            $email = $("#email-error");
            $username = $("#username-error");
            $password = $("#password").val();
            $passwordConfirmation = $("#confirmPassword").val();
            $passwordMatch = $("#confirm-error");
            if ($password != $passwordConfirmation) {
                $passwordMatch.text('Passwords does not match!!');
            } else {
                $passwordMatch.hide();
            }
            if (data.email == "exists") {
                //Change the inner html of the element
                $email.text('Email is already used!');
            } else {
                $email.hide();
            }
            if (data.username === "exists") {
                $username.text('This username is already taken by another user');
            } else {
                $username.hide();
            }

            //the form is valida and data is ready to be sent
            data.append('password', $password);
            $.ajax({
                type: "POST",
                url: url,
                data: data,
                contentType: false,
                processData: false
            })
            .done(function () {
                window.location.replace('/zendone/public/profile/edit')
            });
        });
    });

    //Validating the post insertion
    //Validating using the jquery plugin
    $("#postForm").validate({
        rules: {
            email: {
                email: true
            },
            title: {
                required: true,
                minlength: 5,
                maxlength: 50,
                remote: {
                    url: '/zendone/public/post/checktitle',
                    type: "POST"
                }
            },
            price: {
                required: true,
                number: true
            }
        },
        messages: {
            title: {
                required: 'This field cannot be empty',
                minlength: "Title cannot be shorter than 5 characters",
                maxlength: "Waay too long title",
                remote: "Title already used, please choose another one"
            },
            price: {
                number: "Please enter an integer or decimal value"
            }
        },
        invalidHandler: function (event, validator) {
        },
        submitHandler: function (form) {
            form.submit();
        }
    });

    $("#registerForm").validate({
        errorClass: 'text-danger',
        rules: {
            email: {
                required: true,
                email: true,
                remote: {
                    url: '/zendone/public/register/email',
                    type: "POST"
                }
            },
            username: {
                required: true,
                minlength: 4,
                maxlength: 30,
                remote: {
                    url: '/zendone/public/register/username',
                    type: "POST"
                }
            },
            password: {
                required: true,
                minlength: 6
            },
            confirmPassword: {
                required: true,
                equalTo: "#password"
            }

        },
        messages: {
            email: {
                required: 'Please enter your email this cannot be empty',
                email: "Enter a valide email",
                remote: "This email already in use, Choose another one"
            },
            username: {
                required: "This field cannot be empty",
                minlength: "Username cannot be shorter than 4 characters",
                maxlength: "This username is way too long, please chose a shorter one",
                remote: "This username is already taken please chose another one"
            },
            password: {
                required: "The password cannot be empty",
                minlength: "Please use a password with more than 6 characters"
            },
            confirmPassword: {
                equalTo: "Passwords do not match"
            }
        },
        invalidHandler: function (event, invalid) {

        },
        submitHandler: function (form) {
            form.submit();
        }
    });
    /*
    $("#title").focusout(function () {
        $title = $(this).val();
        data = new FormData();
        data.append('title', $title);
        $.ajax({
            type: "POST",
            url: '/zendone/public/post/checkname',
            data: data,
            contentType: false,
            processData: false
        })
        .done(function (response) {
            if (response.message === "taken") {
                $("#title-error").text('This name already exists');
            }
        });
    });
    */
});
