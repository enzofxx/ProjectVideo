
// admin/course/{id}/edit opens file input field
$('#OpenImgUpload').click(function(){
    $('#coursePicture').trigger('click');
});

// admin/course/{id}/edit and admin/course/add Preview selected file
$('#coursePicture').change(function () {
    var url = URL.createObjectURL(this.files[0]);
    $('#pic').attr('src', url);
});

// admin/course/{id}/edit reset button jquery, removes img tag
$('#clearForm').click(function () {
    $('#pic').attr('src', '');
});

//bootstrap default function to validate if all required form input fields are completed
(function() {
    'use strict';
    window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

//validate selected file format
if ( file = document.getElementById('coursePicture'))
{
    file.onchange = function (e) {
        var ext = this.value.match(/\.([^\.]+)$/)[1];
        switch (ext) {
            case 'jpg':
            case 'bmp':
            case 'png':
            case 'tif':
            case 'gif':

                document.getElementById('picErr').style.display = "none";
                // alert('Allowed');
                break;
            default:
                // alert('Not allowed');
                document.getElementById('picErr').style.display = "block";
                this.value = '';
        }
    };
}