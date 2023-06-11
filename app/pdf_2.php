<?php
require_once 'vendor/autoload.php';

use Knp\Snappy\Pdf;
use Knp\Snappy\GeneratorInterface;
use Knp\Snappy\File\TemporaryFilesystem;

// Chemin du répertoire temporaire
$temporaryDirectory = './temp';
$filesystem = new TemporaryFilesystem($temporaryDirectory);
$filesystem->add('path/to/image.jpg');
$filesystem->add('path/to/styles.css');

try {
    $snappy = new Pdf('/usr/local/bin/wkhtmltopdf');
    $snappy->setOption('encoding', 'UTF-8');
    $snappy->setOption('no-stop-slow-scripts', true);
    $snappy->setOption('load-error-handling', 'ignore');

    $template = file_get_contents('template1.html');

    if ($template === false) {
        throw new Exception('Failed to read the template file.');
    }

    $outputPath = 'output2.pdf';

    try {
        $pdf = $snappy->getOutputFromHtml($template);
//        $pdf->generateFromHtml($template, $outputPath);
        file_put_contents('output2.pdf', $pdf);
    } catch (Exception $e) {
        echo 'Une erreur est survenue lors de la génération du PDF : ' . $e->getMessage();
        exit(1);
    }

    echo 'PDF generated successfully!';
} catch (Exception $e) {
    echo 'An error occurred: ' . $e->getMessage();
}
