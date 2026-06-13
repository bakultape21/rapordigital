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
    
    // Remove all injected blocks first
    $pattern = '/\s*\/\/\s*---\s*SETUP DYNAMIC THEME\s*---.*?\$pdf->AddPage\(\);/s';
    $content = preg_replace($pattern, "\n                \$pdf->AddPage();", $content);
    
    // Put exactly one logic block BEFORE the FIRST $pdf->AddPage();
    $logic = <<<LOGIC

                // --- SETUP DYNAMIC THEME ---
                if (!empty(\$theme_color)) {
                    if (\$theme_color == 'merah') {
                        \$pdf->setBorderColor(231, 76, 60);
                        \$bg_r = 231; \$bg_g = 76; \$bg_b = 60;
                    } elseif (\$theme_color == 'kuning') {
                        \$pdf->setBorderColor(241, 196, 15);
                        \$bg_r = 241; \$bg_g = 196; \$bg_b = 15;
                    } else {
                        \$pdf->setBorderColor(41, 128, 185);
                        \$bg_r = 41; \$bg_g = 128; \$bg_b = 185;
                    }
                } else {
                    \$pdf->setBorderColor(41, 128, 185);
                    \$bg_r = 41; \$bg_g = 128; \$bg_b = 185;
                }
                
                \$font = (!empty(\$theme_font)) ? \$theme_font : 'Arial';
                
                \$pdf->AddPage();
LOGIC;
    
    // Only replace the FIRST occurrence
    $content = preg_replace('/\$pdf->AddPage\(\);/', $logic, $content, 1);
    
    file_put_contents($file, $content);
    echo "Fixed $file\n";
}
