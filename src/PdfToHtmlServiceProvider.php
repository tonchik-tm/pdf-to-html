<?php
namespace TonchikTm\PdfToHtml;

use Illuminate\Support\ServiceProvider;

/**
 * Class PdfToHtmlServiceProvider
 * @package Mxgel\PdfToHtml
 */
class PdfToHtmlServiceProvider extends ServiceProvider {
    /**
     * Boot
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . "/../config/pdftohtml.php" => config_path("pdftohtml.php")
        ]);
    }
}