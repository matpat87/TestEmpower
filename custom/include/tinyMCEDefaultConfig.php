<?php
    // Extended config from include/SugarTinyMCE.php
    $defaultConfig = array(
        'convert_urls' => false,
        'valid_children' => '+body[style]',
        'height' => 300,
        'width'	=> '100%',
        'theme'	=> 'advanced',
        'theme_advanced_toolbar_align' => "left",
        'theme_advanced_toolbar_location'	=> "top",
        'theme_advanced_buttons1'	=> "",
        'theme_advanced_buttons2'	=> "",
        'theme_advanced_buttons3'	=> "",
        'strict_loading_mode'	=> true,
        'mode'	=> 'exact',
        'language' => 'en',
        'plugins' => 'advhr,insertdatetime,table,preview,paste,searchreplace,directionality',
        'elements'	=> '',
        'extended_valid_elements' => 'style[dir|lang|media|title|type],hr[class|width|size|noshade],@[class|style]',
        'content_css' => 'custom/include/custom_tinymce_content.css',

    );