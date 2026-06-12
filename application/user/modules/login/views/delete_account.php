
    <div class="contact-wthree" id="contact" style="background: white;">
        <div class="container">
            <div class="row">
               
                <div class="col-lg-12">
                    <div class="py-lg-5 pt-4">
                        <h3 class="title-head-w3l">Permohonan Penghapusan Akun</h3>
                        <div class="mt-lg-0 mt-3">
                            <form action="<?php echo base_url('login/save_action'); ?>" method="post" id="form-action" autocomplete="off" class="register-wthree my-login-validation">

                                <div class="form-group">
                                    <label for="email">Email Akun</label>
                                    <input class="form-control" type="email" id="email" placeholder="Masukkan email Anda" name="email" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="password">Kata Sandi</label>
                                    <input class="form-control" type="password" name="password" required id="password">
                                </div>

                                <div class="form-group">
                                    <label for="reason">Alasan Penghapusan</label>
                                    <select id="reason" name="reason" class="form-control" required>
                                        <option value="">-- Pilih Alasan --</option>
                                        <option value="tidak_lagi_digunakan">Saya tidak lagi menggunakan layanan ini</option>
                                        <option value="privasi">Khawatir tentang privasi dan data pribadi</option>
                                        <option value="banyak_email">Terlalu banyak notifikasi/email</option>
                                        <option value="akun_ganda">Saya memiliki akun lain</option>
                                        <option value="pengalaman_buruk">Pengalaman penggunaan yang kurang memuaskan</option>
                                        <option value="lainnya">Alasan lainnya</option>
                                    </select>
                                </div>

                                <div class="terms">
                                    <strong>Syarat dan Ketentuan:</strong>
                                    <ul>
                                        <li>Permohonan ini bersifat permanen dan tidak dapat dibatalkan setelah diproses.</li>
                                        <li>Seluruh data yang terhubung dengan akun akan dihapus secara permanen.</li>
                                        <li>Proses penghapusan membutuhkan waktu hingga 7 hari kerja.</li>
                                        <li>Pastikan tidak ada transaksi yang sedang berjalan sebelum menghapus akun.</li>
                                    </ul>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="agree" required>
                                        Saya telah membaca dan menyetujui syarat dan ketentuan di atas.
                                    </label>
                                </div>
                                
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-warning btn-block w-100 font-weight-bold text-uppercase bg-theme1">Ajukan Penghapusan Akun</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
jQuery(document).ready(function() {
    $('#form-action').on('submit', function(e) {
        // 1. Mencegah form dari submit standar (yang me-refresh halaman)
        e.preventDefault();

        // Variabel untuk form dan tombol submit
        var form = $(this);
        var submitButton = form.find('button[type="submit"]');

        // --- VALIDASI SEDERHANA (bisa Anda kembangkan) ---
        let allInputsValid = true;
        form.find('[required]').each(function() {
            if ($(this).is(':checkbox')) {
                if (!$(this).is(':checked')) {
                    alert('Anda harus menyetujui syarat dan ketentuan.');
                    allInputsValid = false;
                    return false; // Hentikan loop .each()
                }
            } else {
                if ($(this).val().trim() === '') {
                    alert('Harap isi semua kolom yang wajib diisi.');
                    allInputsValid = false;
                    return false; // Hentikan loop .each()
                }
            }
        });

        // Jika validasi gagal, hentikan eksekusi
        if (!allInputsValid) {
            return;
        }
        // --- AKHIR VALIDASI ---

        // 2. Kirim data menggunakan AJAX
        $.ajax({
            // Ambil URL dari atribut 'action' di form
            url: form.attr('action'),
            // Ambil method dari atribut 'method' di form
            type: form.attr('method'),
            // Ambil semua data input dari form
            data: form.serialize(),
            // Tipe data yang diharapkan dari server (opsional, tapi disarankan)
            dataType: 'json',

            // Fungsi yang dijalankan sebelum request dikirim
            beforeSend: function() {
                submitButton.prop('disabled', true); // Nonaktifkan tombol
                submitButton.text('Mengirim...');   // Ubah teks tombol
            },

            // Fungsi yang dijalankan jika request BERHASIL
            success: function(response) {
                // Anda bisa menambahkan logika pengecekan response dari server
                // Contoh: if(response.status == 'success') { ... }
                alert(response.message);

                // 3. Reload halaman jika berhasil
                location.reload(); 
            },

            // Fungsi yang dijalankan jika request GAGAL
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Terjadi kesalahan saat mengirim data. Silakan coba lagi.');
                console.error('AJAX Error:', textStatus, errorThrown);
            },

            // Fungsi yang dijalankan SETELAH request selesai (baik berhasil maupun gagal)
            complete: function() {
                submitButton.prop('disabled', false); // Aktifkan kembali tombol
                submitButton.text('Ajukan Penghapusan Akun'); // Kembalikan teks tombol
            }
        });
    });
});
</script>