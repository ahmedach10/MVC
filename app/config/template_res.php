<?php

return [
    'template'          => [
        'header'        => APP_TEMPLATE . 'header.php',
        '__view'        => 'actionView',
        'footer'        => APP_TEMPLATE . 'footer.php',
    ],
    'header_res'        => [
        'css'           => [
            'header'    => CSS . 'components/header/header.style.css',
            '__css'     => 'Style',
            'footer'    => CSS . 'components/footer/footer.style.css'
        ],
        'js'            => []
    ],
    'footer_res'        => [
        'header'        => JS . 'components/header/header.script.js',
        '__js'          => 'Script'
    ]
];

