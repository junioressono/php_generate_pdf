<?php
require_once 'vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;

// Récupérer les données de la facture (par exemple, depuis une base de données)

$data = array(
    'invoice_number' => 'INV-001',
    'date' => '2023-06-08',
    // ... autres données de la facture ...
);

// Charger le template HTML
$template = file_get_contents('template1.html');

// Remplacer les balises variables par les données réelles de la facture
foreach ($data as $key => $value) {
    $template = str_replace("{{" . $key . "}}", $value, $template);
}

// Convertir le HTML en PDF
$html2pdf = new Html2Pdf('P', 'A4', 'fr');
$html2pdf->writeHTML($template, isset($_GET['vuehtml']));
$html2pdf->output('invoice.pdf');
