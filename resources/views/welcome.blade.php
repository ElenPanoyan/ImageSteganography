<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Diplomain</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <link href="{{ asset('front/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('front/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('front/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('front/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('front/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('front/assets/css/variables.css') }}" rel="stylesheet">
    <link href="{{ asset('front/assets/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('front/assets/css/custom.css') }}" rel="stylesheet">
</head>
<body>
<!-- ======= Header ======= -->
<header id="header" class="fixed-top" data-scrollto-offset="0">
</header><!-- End Header -->
<section id="hero-fullscreen" class="hero-fullscreen d-flex align-items-center">
    <div class="container d-flex flex-column align-items-center position-relative" data-aos="zoom-out">
        <div class="row">
            <div class="col-6 mt-5 pt-5 text-center ">
                <h2 style="color: white;">ONLINE STEGANOGRAPHY</h2>
                <br>
                <p style="color: #141c44;font-family: monospace;">It allows you to hide a password encrypted message
                    within the png using LSB encryption algorithm.</p>
                <a href="#about" style="background: white;color: #141c44;font-size: larger;height: 50px;width: 250px"
                   class="btn btn-lg  mt-3">GET STARTED</a>
            </div>
            <div class="col-6">
                <img class="w-100" src="{{asset('front/assets/img/1.jpg')}}">
            </div>
        </div>
    </div>
</section>
<main id="main">
    <section id="about" class="features">
        <div class="container" data-aos="fade-up">
            <ul class="nav nav-tabs row gy-4 d-flex">
                <li class="nav-item col-6 col-md-6 col-lg-6">
                    <a class="nav-link active show" data-bs-toggle="tab" data-bs-target="#tab-1">
                        <h4 style="font-family: monospace"><i class="bi bi-lock"></i>
                            Encode message</h4>
                    </a>
                </li>
                <li class="nav-item col-6 col-md-6 col-lg-6">
                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-2">
                        <h4 style="font-family: monospace"><i class="bi bi-unlock "></i>
                            Decode hidden message</h4>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active show" id="tab-1">
                    <form method="POST" enctype="multipart/form-data" id="save_form" action="javascript:void(0)">
                        @csrf
                        <div class="container">
                            <div class="panel">
                                <div class="button_outer_encode mt-1">
                                    <div class="btn_upload btn btn-outline-info text-white rounded-0 mb-3 "
                                         style=" border-radius: 0.5rem;">
                                        <input type="file" id="upload_file_encode" name="image"
                                               style="background: white;color:black;">
                                        UPLOAD IMAGE
                                    </div>
                                    <div class="processing_bar"></div>
                                    <div class="success_box_encode"></div>
                                </div>
                            </div>
                            <div class="error_msg_encode"></div>
                            <div class="uploaded_file_view" id="uploaded_view_encode">
                                <span class="file_remove">X</span>
                            </div>
                        </div>
                        <div class="row">
                            <div style="margin-top: 10px" class="col-lg-8 order-2 order-lg-1 " data-aos="fade-up "
                                 data-aos-delay="100">
                                <input type="radio" id="text" value="text" name="options">
                                <label class="lab" for="text" style="font-family: monospace"><i
                                        class="bi bi-file-earmark-text  "></i> Text
                                </label>
                                <input class="custom-file-input" id="image" type="radio" value="file"
                                       name="options">

                                <label for="image" style="font-family: monospace"><i class="bi bi-files"></i>
                                    File</label>
                                <div id="textarea-txt" style="margin-top: 20px;">
                                </div>
                                <div class="custom">

                                </div>
                                <input name="password" type="text" class="form-control" placeholder="PASSWORD (optional)" style="width: 70%;height: 50px;font-family: monospace">
                            </div>
                            <div class="col-lg-4 order-1 order-lg-2 text-center">
                                <div class="mt-2  img-append" id="imgAppend">

                                </div>
                            </div>

                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn p-3 text-white mt-3 rounded-0"
                                    style="background-color: #121b46; width: 250px;  border-radius: 0.5rem!important;">
                                ENCODE
                            </button>
                            <a class="btn btn-dark p-3 text-white mt-3 rounded-0 try_again"
                               href="" style="width: 200px; display:none; border-radius: 0.5rem!important;">TRY
                                AGAIN</a>
                        </div>
                    </form>
                </div>
                <div class="tab-pane" id="tab-2">
                    <form method="POST" enctype="multipart/form-data" id="save_form_decode"
                          action="javascript:void(0)">
                        @csrf
                        <div class="container">
                            <div class="panel">
                                <div class="button_outer_decode mt-1">
                                    <div class="btn_upload btn btn-outline-info text-white rounded-0  mb-3"
                                         style="border-radius: 0.5rem;">
                                        <input type="file" id="upload_file_decode" name="image">
                                        UPLOAD IMAGE
                                    </div>
                                    <div class="processing_bar_decode"></div>
                                    <div class="success_box_decode"></div>
                                </div>
                            </div>
                            <div class="error_msg_decode"></div>
                            <div class="uploaded_file_view " id="uploaded_view_decode">
                                <span class="file_remove">X</span>
                            </div>
                        </div>
                        <div class="row">
                            <div style="margin-top: 10px" class="col-lg-8 order-2 order-lg-1" data-aos="fade-up"
                                 data-aos-delay="100">
                                <input type="radio" id="text-decode" value="text" name="options">
                                <input name="password" type="text" class="form-control" placeholder="PASSWORD" style="width: 75%; height: 50px;font-family: monospace">
                            </div>
                            <div class="col-lg-4 order-1 order-lg-2 text-center">
                                <div class="text-append">
                                    <textarea class='form-control mb-3' id="textarea-txt-decode" name='text' rows='5'
                                              cols='20' style="width:70%"></textarea>
                                </div>
                            </div>

                        </div>
                        <div class="text-center mt-5">
                            <button type="submit" class="btn p-3 text-white mt-3 rounded-0"
                                    style="background-color: #121b46; width: 250px;border-radius: 0.5rem!important;">
                                DECODE
                            </button>
                            <a class="btn btn-danger p-3 text-white mt-3 rounded-0 reset"
                               style="width: 250px; display:none;border-radius: 0.5rem!important;"
                               href="">RESET</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <section id="faq" style="padding-bottom: 0">
        <div class="row  pt-3 justify-content-center pb-5" style="background: #bcdffd;">
            <h2 style="color: white" class="my-5 text-center">FAQ's</h2>
            <div class="accordion col-9 mt-3" id="accordionPanelsStayOpenExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                                aria-controls="panelsStayOpen-collapseOne">
                            Why is png the best format for steganography?
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show"
                         aria-labelledby="panelsStayOpen-headingOne">
                        <div class="accordion-body" style="color:#121b46">
                            <strong>PNG</strong> is often considered the best format for steganography because it uses lossless compression, which means that the image quality remains the same after being compressed and uncompressed.
                                PNG also has a larger color depth than other image formats like GIF, which means that it can store more information in each pixel.
                            It supports transparency, which means that pixels can be partially transparent, allowing for more complex hiding techniques. For example, a message could be hidden in the transparent parts of an image, or in the alpha channel.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false"
                                aria-controls="panelsStayOpen-collapseTwo">
                            What are the main advantages of LSB algorithm?
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse"
                         aria-labelledby="panelsStayOpen-headingTwo">
                        <div class="accordion-body" style="color:#121b46">
                            <strong>Simplicity:</strong> It is relatively simple and easy to implement. It involves replacing the least significant bits of the pixel values in an image with the bits of the message that needs to be hidden.
<br>
                            <strong>Capacity:</strong> LSB algorithm has a high capacity to hide data within an image.
<br>
                            <strong>Robustness:</strong> LSB algorithm is relatively robust against compression and other image processing operations.
<br>
                            <strong>Compatibility:</strong> The LSB algorithm is compatible with a wide range of image formats, including popular formats like BMP, PNG, and JPEG.
<br>
                            <strong>Detectability:</strong> LSB algorithm is relatively difficult to detect using standard image analysis techniques, especially when the hidden message is embedded in a large image with a high resolution.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false"
                                aria-controls="panelsStayOpen-collapseThree">
                            What are the main disadvantages of LSB algorithm?
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse"
                         aria-labelledby="panelsStayOpen-headingThree">
                        <div class="accordion-body" style="color:#121b46">
                            <strong>This is the third item's accordion body.</strong> It is hidden by default, until the
                            collapse plugin adds the appropriate classes that we use to style each element. These
                            classes
                            control the overall appearance, as well as the showing and hiding via CSS transitions. You
                            can
                            modify any of this with custom CSS or overriding our default variables. It's also worth
                            noting that
                            just about any HTML can go within the <code>.accordion-body</code>, though the transition
                            does limit
                            overflow.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer id="footer" class="footer p-2" style="height: 50px!important;background: #121b46; color:white">
        <p>&copy; 2023 . All Rights Reserved</p>
    </footer>
</main>

<a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i
        class="bi bi-arrow-up-short"></i></a>
<div id="preloader"></div>
<script src="{{ asset('front/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('front/assets/vendor/aos/aos.js') }}"></script>
<script src="{{ asset('front/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
<script src="{{ asset('front/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('front/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('front/assets/js/main.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
</body>
<script>
    $(document).ready(function (e) {


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#save_form').submit(function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('save-encode') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    if(data.error){
                        alert(data.error);
                    }else{
                        $('.try_again').show();
                        var image = $('<img style="width:100%">').attr('src', data.base64);
                        $('#imgAppend').append(image);
                        $('#inputImage').val(data.base64);
                    }

                },
                error: function (data) {
                }
            });
        });
        var btnUpload = $("#upload_file_encode"),
            btnOuter = $(".button_outer_encode");
        btnUpload.on("change", function (e) {
            var ext = btnUpload.val().split('.').pop().toLowerCase();
            if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                $(".error_msg_encode").text("Not an Image...");
            } else {
                $(".error_msg_encode").text("");
                btnOuter.addClass("file_uploading_encode");
                setTimeout(function () {
                    btnOuter.addClass("file_uploaded_encode");
                }, 3000);
                var uploadedFile = URL.createObjectURL(e.target.files[0]);
                setTimeout(function () {
                    $("#uploaded_view_encode").append('<img src="' + uploadedFile + '" />')
                        .addClass("show");
                }, 3500);
            }
        });
        $(".file_remove").on("click", function (e) {
            $("#uploaded_view_encode").removeClass("show");
            $("#uploaded_view_encode").find("img").remove();
            btnOuter.removeClass("file_uploading");
            btnOuter.removeClass("file_uploaded");
        });

        document.getElementById("textarea-txt").innerHTML =
            " <textarea class='form-control  mb-3' name='text' rows='5' cols='20' style='width:70%'>@if (isset($staff->text)) {{ $staff->text }} @endif</textarea> ";
        let labels = document.querySelectorAll('label');
        let inputs = document.querySelectorAll('input[name="options"]');
        let selected = document.querySelector('span');
        labels.forEach(function (label) {
            label.addEventListener('click', function () {
                inputs.forEach(function (input) {
                    if (input === label.previousElementSibling) {
                        if (input.value == 'text') {
                            document.getElementById("textarea-txt").innerHTML =
                                "<textarea  class='form-control  mb-3' name='text' rows='5' cols='20' style='width:70%'>@if (isset($staff->text)) {{ $staff->text }} @endif</textarea> ";
                        } else {
                            document.getElementById("textarea-txt").innerHTML =
                                "<input class='custom-file-input' accept='.txt,.docx' type='file' name='file' id='inputGroupFile03'>"
                        }
                        $('#inputGroupFile03').on('change', function (e) {
                            var fileName = e.target.files[0].name;
                            $('.file-append').css("display", "block");
                            $('.custom').html(fileName);

                        });
                    }
                });
            });
        });

    });
</script>

<script>
    $(document).ready(function (e) {

        $('#save_form_decode').submit(function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('save-decode') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    $(".reset").show();
                    var text = data.message;
                    $("#textarea-txt-decode").val(text);


                },
                error: function (data) {
                }
            });

        });

        var btnUpload = $("#upload_file_decode"),
            btnOuter = $(".button_outer_decode");
        btnUpload.on("change", function (e) {
            var ext = btnUpload.val().split('.').pop().toLowerCase();
            if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                $(".error_msg_decode").text("Not an Image...");
            } else {
                $(".error_msg_decode").text("");
                btnOuter.addClass("file_uploading_decode");
                setTimeout(function () {
                    btnOuter.addClass("file_uploaded_decode");
                }, 3000);
                var uploadedFile = URL.createObjectURL(e.target.files[0]);
                setTimeout(function () {
                    $("#uploaded_view_decode").append('<img src="' + uploadedFile + '" />')
                        .addClass(
                            "show");
                }, 3500);
            }
        });
        $(".file_remove").on("click", function (e) {
            $("#uploaded_view_decode").removeClass("show");
            $("#uploaded_view_decode").find("img").remove();
            btnOuter.removeClass("file_uploading_decode");
            btnOuter.removeClass("file_uploaded_decode");
        });

    });
</script>

</html>
