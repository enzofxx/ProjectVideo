import '../css/style.scss';

import 'jquery/dist/jquery.slim.min.js';
import 'bootstrap/dist/js/bootstrap.min.js';
import 'popper.js/dist/popper.min.js';

// course/add/ reset button jquery, removes img tag

$('#OpenImgUpload').click(function(){ $('#coursePicture').trigger('click'); });
