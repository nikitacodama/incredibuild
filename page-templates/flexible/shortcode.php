<?php

$shortcode = get_sub_field('shortcode');

if($shortcode) {
    echo do_shortcode($shortcode);
}

?>