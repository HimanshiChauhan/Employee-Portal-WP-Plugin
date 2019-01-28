<?php
$getParam = isset($_REQUEST['param'])?$_REQUEST['param']:'';

if(!empty($getParam)) {
    if($getParam == "get_message") {
        echo json_encode(array(
            "name"=>"Employee Portal",
            "author"=>"Himanshi Chauhan"
        ));
        die;
    }

    if($getParam=="post_form_data") {
        echo json_encode($_REQUEST);
        die;
    }
}