<?php
require_once 'vendor/autoload.php';

use Knp\Snappy\Pdf;

$pdf = new Pdf('/usr/local/bin/wkhtmltopdf');
$pdf->setOption('encoding', 'UTF-8');

$template = file_get_contents('template.html');

$pdf->generateFromHtml($template, 'output.pdf');