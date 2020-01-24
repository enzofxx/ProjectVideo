import '../css/style.scss';

import 'jquery/dist/jquery.slim.min.js';
import 'bootstrap/dist/js/bootstrap.min.js';
import 'popper.js/dist/popper.min.js';

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
