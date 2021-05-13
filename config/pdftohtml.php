<?php
return [
    'pdftohtml_path' => '/usr/bin/pdftohtml',
    'pdfinfo_path' => '/usr/bin/pdfinfo',
    'generate' => [
        'singlePage' => false,
        'imageJpeg' => false,
        'ignoreImages' => false,
        'zoom' => 1.5,
        'noFrames' => true,
    ],
    'outputDir' => '',
    'removeOutputDir' => false,
    'clearAfter' => true,
    'html' => [
        'inlineImages' => true,
    ]
];

