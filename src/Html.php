<?php
/**
 * Created by PhpStorm.
 * User: tonchik™
 * Date: 15.09.2015
 * Time: 19:18
 */

namespace TonchikTm\PdfToHtml;

use DOMDocument;
use DOMXPath;
use Pelago\Emogrifier\CssInliner;

/**
 * This class creates a collection of html pages with some improvements.
 *
 * @property integer $pages
 * @property string[] $content
 */
class Html extends Base
{
    private $pages = 0;
    private $content = [];

    private $defaultOptions = [
        'inlineCss' => true,
        'inlineImages' => true,
        'onlyContent' => false,
        'outputDir' => ''
    ];

    public function __construct($options = [])
    {
        $this->setOptions(array_replace_recursive($this->defaultOptions, $options));
    }

    /**
     * Add page to collection with the conversion, according to options.
     * @param integer $number
     * @param string $content
     * @return $this
     */
    public function addPage($number, $content)
    {
        if ($this->getOptions('inlineCss')) {
            $content = $this->setInlineCss($content);
        }

        if ($this->getOptions('inlineImages')) {
            $content = $this->setInlineImages($content);
        }

        if ($this->getOptions('onlyContent')) {
            $content = $this->setOnlyContent($content);
        }

        $this->content[$number] = $content;
        $this->pages = count($this->content);
        return $this;
    }

    /**
     * @param $number
     * @return string|null
     */
    public function getPage($number)
    {
        return isset($this->content[$number]) ? $this->content[$number] : null;
    }

    /**
     * @return array
     */
    public function getAllPages()
    {
        return $this->content;
    }

    /**
     * The method replaces css class to inline css rules.
     * @param $content
     * @return string
     * @throws \Symfony\Component\CssSelector\Exception\ParseException
     */
    private function setInlineCss($content)
    {
        $content = str_replace(['<!--', '-->'], '', $content);
        return CssInliner::fromHtml($content)->inlineCss()->render();
    }

    /**
     * The method looks for images in html and replaces the src attribute to base64 hash.
     * @param string $content
     * @return string
     */
    private function setInlineImages($content)
    {
        $dom = new DOMDocument();
        $dom->loadHTML($content);
        $xpath = new DOMXPath($dom);
        $xpath->registerNamespace("xml", "http://www.w3.org/1999/xhtml");

        $images = $xpath->query("//img");
        foreach ($images as $img) {
            /** @var \DOMNode $img */
            $attrImage = $img->getAttribute('src');
            $pi = pathinfo($attrImage);
            $image = $this->getOutputDir() . '/' . $pi['basename'];
            $imageData = base64_encode(file_get_contents($image));
            $src = 'data: ' . mime_content_type($image) . ';base64,' . $imageData;
            $content = str_replace($attrImage, $src, $content);
        }
        unset($dom, $xpath, $images, $imageData);
        return $content;
    }

    /**
     * The method takes from html body content only.
     * @param string $content
     * @return string
     */
    private function setOnlyContent($content)
    {
        $dom = new DOMDocument();
        $dom->loadHTML($content);
        $xpath = new DOMXPath($dom);
        $xpath->registerNamespace("xml", "http://www.w3.org/1999/xhtml");

        $html = '';
        $body = $xpath->query("//body")->item(0);
        foreach ($body->childNodes as $node) {
            $html .= $dom->saveHTML($node);
        }
        unset($dom, $xpath, $body, $content);
        return trim($html);
    }
}