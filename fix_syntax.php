<?php
$files = [
    'application/user/modules/rapor/views/rapor_harian.php',
    'application/user/modules/rapor/views/add_cp_rapor.php'
];

foreach ($files as $file) {
    if (!file_exists($file)) continue;
    $content = file_get_contents($file);
    
    // Fix syntax error: updateCetakLinks(); } }
    // It should be: updateCetakLinks(); } function get_modal_edit_data
    $content = preg_replace("/\}\s*updateCetakLinks\(\);\s*\}\s*function\s+get_modal_edit_data/", "updateCetakLinks();\n\t\t}\n\n\t\tfunction  get_modal_edit_data", $content);
    
    file_put_contents($file, $content);
    echo "Fixed syntax in $file\n";
}
