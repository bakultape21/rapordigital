<?php
$files = [
    'application/user/modules/rapor/views/cetak_rapor_harian_pdf_tanpa_foto.php',
    'application/user/modules/rapor/views/cetak_rapor_harian_pdf.php',
    'application/user/modules/rapor/views/cetak_rapor_pdf.php',
    'application/user/modules/rapor/views/cetak_rapor_cp_foto_pdf.php',
    'application/user/modules/rapor/views/cetak_rapor_harian_foto_pdf.php'
];

foreach ($files as $file) {
    if (!file_exists($file)) continue;
    $content = file_get_contents($file);
    
    // The exact string to look for
    $search = "                \$pdf->AddPage();\n                //\n                \$pdf->AddPage();";
    $replace = "                \$pdf->AddPage();";
    
    $content = str_replace($search, $replace, $content);
    
    // Sometimes it might just be without the //
    $search2 = "\$pdf->AddPage();\n                \$pdf->AddPage();";
    $replace2 = "\$pdf->AddPage();";
    
    $content = str_replace($search2, $replace2, $content);

    file_put_contents($file, $content);
    echo "Fixed $file\n";
}
