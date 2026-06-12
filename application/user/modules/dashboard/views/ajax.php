<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajax Loop with Sequential Processing</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Sequential Ajax Processing</h1>
    <button id="startProcess">Start Processing</button>
    <div id="progress">Click "Start Processing" to begin.</div>

    <script>

        $(document).ready(function() {
            let dataToProcess;

            $.ajax({
                url: '<?= base_url() ?>/dashboard/get_data_list',
                type: 'GET',
                dataType: 'json',
                async: false,
                success: function(response) {
                    dataToProcess= response;

                    let index = 0;

                    for (let [key, value] of Object.entries(dataToProcess)) {
                        img_path= `${value}`;

                        jalankan(img_path);
                    }
                    function jalankan(img_path) {
                       $.ajax({
                        url: '<?= base_url() ?>/dashboard/cek',
                        type: 'POST',
                        async: false,
                        data: { img_path: img_path },
                        success: function(response) {
                            console.log( response );

                             // Panggil lagi fungsi ini
                        },
                        error: function() {
                            console.log( dataToProcess[index]);
                            }
                        });
                    }

                        // if (index < dataToProcess.length) {
                        //     // Menampilkan status pemrosesan
                        //     $('#progress').append('<p>Processing ID ' + dataToProcess[index] + '...</p>');

                        //     // Ajax untuk memproses data
                        //     $.ajax({
                        //         url: '<?= base_url() ?>/dashboard/cek',
                        //         type: 'POST',
                        //         data: { img_path: dataToProcess[index] },
                        //         success: function(response) {
                        //             $('#progress').append('<p>' + response + '</p>');

                        //             processNext(); // Panggil lagi fungsi ini
                        //         },
                        //         error: function() {
                        //             $('#progress').append('<p>Error processing ID ' + dataToProcess[index] + '</p>');

                        //             // Tetap lanjutkan meskipun ada error
                        //             index++;
                        //             processNext();
                        //         }
                        //     });
                        // } else {
                        //     $('#progress').append('<p>All data processed!</p>');
                        // }
                    

                }
            });

            

            
        });
    </script>
</body>
</html>
