<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('defaultFont', 'Helvetica');
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);

$html = ''; 
$i = 0;

foreach ($payslipData as $index => $row) {
    $i = $index + 1; 
    
    ob_start();
    include __DIR__ . '/payslip-pdf-template2.php'; 
    $html .= ob_get_clean();

    
    if ($i < $totalPayslips) {
        $html .= '<div style="page-break-after: always;"></div>';
    }
}

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();

$dompdf->stream("Payslips.pdf", ["Attachment" => true]);
exit;
