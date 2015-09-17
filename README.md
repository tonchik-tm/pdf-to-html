# PDF to HTML PHP Class

This PHP class can convert your pdf files to html using poppler-utils.

## Thanks

Big thanks Mochamad Gufron ([mgufrone](https://github.com/mgufrone))! I did a packet based on its package (https://github.com/mgufrone/pdf-to-html).

## Important Notes

Please see how to use below.

## Installation

When you are in your active directory apps, you can just run this command to add this package on your app

```
  composer require tonchik-tm/pdf-to-html:~1
```

Or add this package to your `composer.json`

```json
{
  "tonchik-tm/pdf-to-html":"~1"
}
```

## Requirements
### 1. Install Poppler-Utils

**Debian/Ubuntu**
```bash
sudo apt-get install poppler-utils
```

**Mac OS X**
```bash
brew install poppler
```

**Windows**

For those who need this package in windows, there is a way. First download poppler-utils for windows here <http://blog.alivate.com.au/poppler-windows/>. And download the latest binary.

After download it, extract it.

### 2. We need to know where is utilities

**Debian/Ubuntu**
```bash
$ whereis pdftohtml
pdftohtml: /usr/bin/pdftohtml

$ whereis pdfinfo
pdfinfo: /usr/bin/pdfinfo
```

**Mac OS X**
```bash
$ which pdfinfo
/usr/local/bin/pdfinfo

$ which pdftohtml
/usr/local/bin/pdfinfo
```

**Windows**

Go in extracted directory. There will be a directory called `bin`. We will need this one.

### 3. PHP Configuration with shell access enabled

## Usage

**Example:**

```php
<?php
// if you are using composer, just use this
include 'vendor/autoload.php';

// initiate
$pdf = new \TonchikTm\PdfToHtml\Pdf('test.pdf', [
    'pdftohtml_path' => '/usr/bin/pdftohtml',
    'pdfinfo_path' => '/usr/bin/pdfinfo'
]);

// example for windows
// $pdf = new \TonchikTm\PdfToHtml\Pdf('test.pdf', [
//     'pdftohtml_path' => '/path/to/poppler/bin/pdftohtml.exe',
//     'pdfinfo_path' => '/path/to/poppler/bin/pdfinfo.exe'
// ]);

// get pdf info
$pdfInfo = $pdf->getInfo();

// get count pages
$countPages = $pdf->countPages();

// get content from one page
$contentFirstPage = $pdf->getHtml()->getPage(1);

// get content from all pages and loop for they
foreach ($pdf->getHtml()->getAllPages() as $page) {
    echo $page . '<br/>';
}
```

**Full list settings:**

```php
<?php

$full_settings = [
    'pdftohtml_path' => '/usr/bin/pdftohtml', // path to pdftohtml
    'pdfinfo_path' => '/usr/bin/pdfinfo', // path to pdfinfo

    'generate' => [ // settings for generating html
        'singlePage' => false, // we want separate pages
        'imageJpeg' => false, // we want png image
        'ignoreImages' => false, // we need images
        'zoom' => 1.5, // scale pdf
        'noFrames' => false, // we want separate pages
    ],

    'clearAfter' => true, // auto clear output dir (if removeOutputDir==false then output dir will remain)
    'removeOutputDir' => true, // remove output dir
    'outputDir' => '/tmp/'.uniqid(), // output dir

    'html' => [ // settings for processing html
        'inlineCss' => true, // replaces css classes to inline css rules
        'inlineImages' => true, // looks for images in html and replaces the src attribute to base64 hash
        'onlyContent' => true, // takes from html body content only
    ]
]
```

## Feedback & Contribute

Send me an issue for improvement or any buggy thing. I love to help and solve another people problems. Thanks :+1:
