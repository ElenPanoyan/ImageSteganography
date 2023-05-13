$(document).ready(function(e) {
$('#save_form_decode').submit(function(e) {
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
            location.reload();
            $("#textarea-txt-decode").innerHTML =
                "<textarea  name='text' rows='4' cols='50'>asasasasass</textarea> ";
            this.reset();
        },
        error: function(data) {}
    });

});



var btnUpload = $("#upload_file_decode"),
btnOuter = $(".button_outer_decode");
btnUpload.on("change", function(e) {
var ext = btnUpload.val().split('.').pop().toLowerCase();
if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
    $(".error_msg_decode").text("Not an Image...");
} else {
    $(".error_msg_decode").text("");
    btnOuter.addClass("file_uploading_decode");
    setTimeout(function() {
        btnOuter.addClass("file_uploaded_decode");
    }, 3000);
    var uploadedFile = URL.createObjectURL(e.target.files[0]);
    setTimeout(function() {
        $("#uploaded_view_decode").append('<img src="' + uploadedFile + '" />').addClass(
        "show");
    }, 3500);
}
});
$(".file_remove_decode").on("click", function(e) {
$("#uploaded_view_decode").removeClass("show");
$("#uploaded_view_decode").find("img").remove();
btnOuter.removeClass("file_uploading_decode");
btnOuter.removeClass("file_uploaded_decode");
});
















});