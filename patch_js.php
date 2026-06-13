<?php
$files = [
    'application/user/modules/rapor/views/rapor_harian.php',
    'application/user/modules/rapor/views/add_cp_rapor.php'
];

$modal_addition = <<<HTML
			<div class="modal-body">
                <!-- Opsi Tema dan Font -->
                <div class="row mb-3" style="padding: 0 15px;">
                    <div class="col-md-6">
                        <label>Warna Tema Bingkai:</label>
                        <select id="tema_warna_cetak" class="form-control" onchange="updateCetakLinks()">
                            <option value="biru">Biru (Default)</option>
                            <option value="merah">Merah</option>
                            <option value="kuning">Kuning</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Jenis Font:</label>
                        <select id="tema_font_cetak" class="form-control" onchange="updateCetakLinks()">
                            <option value="Arial">Arial (Default)</option>
                            <option value="Times">Times New Roman</option>
                            <option value="Helvetica">Helvetica</option>
                            <option value="Courier">Courier</option>
                        </select>
                    </div>
                </div>
				<table class="table table-striped">
HTML;

$js_addition = <<<JS
		function updateCetakLinks() {
            var color = $('#tema_warna_cetak').val();
            var font = $('#tema_font_cetak').val();
            var query = "?color=" + color + "&font=" + font;
            
            $('#cetak_data a').each(function() {
                var base = $(this).attr('data-base-href');
                if (base) {
                    $(this).attr('href', base + query);
                }
            });
        }
        
        function setCetakLink(elemId, url) {
            var elem = document.getElementById(elemId);
            if (elem) {
                elem.setAttribute('data-base-href', url);
            }
        }
JS;

foreach ($files as $file) {
    if (!file_exists($file)) continue;
    $content = file_get_contents($file);
    
    // Inject Modal HTML
    $content = str_replace('<div class="modal-body">'."\n\t\t\t\t".'<table class="table table-striped">', $modal_addition, $content);
    
    // Replace JS assignments
    $content = preg_replace('/document\.getElementById\("([^"]+)"\)\.href\s*=\s*(.+?);/', 'setCetakLink("$1", $2);', $content);
    
    // Add updateCetakLinks() right before edit_data modal logic
    $content = str_replace('function  get_modal_edit_data', "updateCetakLinks();\n\t\t}\n\n\t\tfunction  get_modal_edit_data", $content);
    
    // Add new JS functions inside <script>
    $content = str_replace('function  get_modal_cetak_data', $js_addition . "\n\n\t\tfunction  get_modal_cetak_data", $content);
    
    file_put_contents($file, $content);
    echo "Patched $file\n";
}
