<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MX_Controller
{

	private $prefix         = 'dashboard';
	private $url            = 'dashboard';
	private $table_db       = '';
	private $table_prefix   = '';
	private $title 			= __CLASS__;

	public function index()
	{
		$data['title']		= ucwords(str_replace('_', ' ', $this->title));
		$data['breadcrumb'] = [$this->title => base_url() . $this->url];
		$data['url']		= base_url() . $this->url;
		$data['prefix']		= $this->prefix;

		$data['plugin'] 	= ['datatables'];

		$q_elemen_data = [
			'table'=> 't_sekolah_elemen s',
			'join'=> [['t_guru g', 'g.sekolah_id= s.sekolah_id'], 
					 ['t_sekolah_elemen_data td', 'td.sekolah_elemen_id= s.sekolah_elemen_id']],
			'where'=> ['guru_id'=> login_data('user_id'), 'sekolah_elemen_status'=> 1],
			'order'=> ['td.elemen_nomor', 'asc']
		];

		$q_notif=[
			'table'=> 't_notifikasi_update'];
		$data['notifikasi']= $this->m_global->get($q_notif);

		$data['elemen']= $this->m_global->get($q_elemen_data);
		$data['kelompok']= $this->m_global->get(['table'=> 't_master_elemen_kelompok']);
		$data['kelas']= $this->m_global->get(['table'=> 't_kelas_belajar', 'where'=> ['guru_id'=> login_data('user_id')]]);

		$data['kuota']= $this->m_global->get([
			'table'=> 't_guru g',
			'select'=> 'batas_semester, count(kelas_id) as kuota_saat_ini, guru_nama',
			'join'=> [['t_kelas_belajar k', 'k.guru_id= g.guru_id', 'left']],
			'where'=> ['g.guru_id'=> login_data('user_id')]

			])[0];

		$this->template->display('index', $data);

	}
	public function cek()
	{
		$img_path= $_POST['img_path'];
		echo $this->resizeImage($img_path, 512);
	}
	public function get_data_list()
	{
		$folderPath = 'assets/uploads/images/users';
// 		$folderPath = 'uploads';
		$data = $this->getFilesInFolder($folderPath);

		echo json_encode($data);
	}
	public function get_list(){
// 		$folderPath = 'uploads';
		$folderPath = 'assets/uploads/images/users';
		$data['fileArray'] = array_values($this->getFilesInFolder($folderPath));
		$this->load->view('ajax', $data);
	}

	public function getFilesInFolder($folderPath, $includeSubfolders= false) {


	    $files = [];

	    if (!is_dir($folderPath)) {
	        throw new Exception("Invalid folder path: $folderPath");
	    }

	    $iterator = $includeSubfolders
	        ? new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folderPath))
	        : new DirectoryIterator($folderPath);

	    $fileData = [];
	    foreach ($iterator as $fileInfo) {
	        if ($fileInfo->isFile()) {
	            $fileData[] = [
	                'path' => $fileInfo->getPathname(), // Path lengkap file
	                'size' => $fileInfo->getSize()      // Ukuran file dalam byte
	            ];
	        }
	    }

	    // Urutkan berdasarkan ukuran file terbesar
	    usort($fileData, function ($a, $b) {
	        return $b['size'] <=> $a['size']; // Urutan descending berdasarkan ukuran file
	    });

	    // Ambil hanya path file
	    foreach ($fileData as $file) {
	        $files[] = $file['path'];
	    }

	    return $files;



	    // // Periksa apakah folder ada
	    // if (!is_dir($folderPath)) {
	    //     return "Error: Folder does not exist.";
	    // }

	    // // Baca semua file dalam folder
	    // $files = array_filter(scandir($folderPath), function ($file) use ($folderPath) {
	    //     return is_file($folderPath . '/' . $file);
	    // });

	    // // Ubah menjadi array dengan nama lengkap file (path lengkap)
	    // $fileArray = array_map(function ($file) use ($folderPath) {
	    //     return $folderPath . '/' . $file;
	    // }, $files);

	    return $fileArray;
	}

	public function resizeImage($filePath, $maxSizeKB) {
    $maxSizeBytes = $maxSizeKB * 1024; // Convert KB to bytes
    $minFileSizeBytes = 0.8 * 1024 * 1024; // 1.5 MB in bytes
    $imageInfo = getimagesize($filePath);

    if ($imageInfo === false) {
        return "Error: File is not a valid image.";
    }

    $mimeType = $imageInfo['mime'];
    $originalSize = filesize($filePath);

    // Only resize if the file is larger than 1.5 MB
    if ($originalSize <= $minFileSizeBytes) {
        return "File size is below 1.5 MB. No resize required.";
    }

    // If the file is already smaller than the maximum size
    if ($originalSize <= $maxSizeBytes) {
        return "No resize needed. File is already smaller than {$maxSizeKB}KB.";
    }

    // Create an image resource based on format
    switch ($mimeType) {
        case 'image/jpeg':
        case 'image/jpg':
            $image = imagecreatefromjpeg($filePath);
            break;
        case 'image/png':
            $image = imagecreatefrompng($filePath);
            break;
        default:
            return "Unsupported file format. Only JPEG, JPG, and PNG are supported.";
    }

    // Get original dimensions
    $originalWidth = $imageInfo[0];
    $originalHeight = $imageInfo[1];

    // Calculate new dimensions
    $scale = sqrt($maxSizeBytes / $originalSize); // Scale factor
    $newWidth = (int)($originalWidth * $scale);
    $newHeight = (int)($originalHeight * $scale);

    // Create a new blank image with the new dimensions
    $resizedImage = imagecreatetruecolor($newWidth, $newHeight);

    // Preserve transparency for PNG
    if ($mimeType === 'image/png') {
        imagealphablending($resizedImage, false);
        imagesavealpha($resizedImage, true);
    }

    // Copy and resize the original image
    imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);

    // Save the resized image back to the original file
    $success = false;
    if ($mimeType === 'image/jpeg' || $mimeType === 'image/jpg') {
        $quality = 90; // Kualitas awal untuk JPEG (0-100)
	    $success = false;

	    do {
	        ob_start();
	        if ($mimeType === 'image/jpeg' || $mimeType === 'image/jpg') {
	            imagejpeg($image, null, $quality);
	        } elseif ($mimeType === 'image/png') {
	            imagepng($image, null, (10 - $quality / 10)); // Skala kualitas untuk PNG
	        }
	        $data = ob_get_clean();

	        if (strlen($data) <= $maxSizeBytes) {
	            // Simpan gambar ke file asli
	            file_put_contents($filePath, $data);
	            $success = true;
	            break;
	        }

	        $quality -= 5; // Turunkan kualitas secara bertahap
	    } while ($quality > 10);

    } elseif ($mimeType === 'image/png') {
        $success = imagepng($resizedImage, $filePath, 9); // Compression level 6 (balanced)
    }

    // Free memory
    imagedestroy($image);
    imagedestroy($resizedImage);

    return $success ? "Image resized successfully by adjusting dimensions." : "Failed to resize image.";
}


	// public function resizeImage($filePath, $maxSizeKB) {
	//     $maxSizeBytes = $maxSizeKB * 1024; // Konversi KB ke Byte
	//     $minFileSizeBytes = 0.8 * 1024 * 1024; // 1.5 MB dalam byte
	//     $imageInfo = getimagesize($filePath);

	//     if ($imageInfo === false) {
	//         return "Error: File is not a valid image.";
	//     }

	//     $mimeType = $imageInfo['mime'];
	//     $originalSize = filesize($filePath);

	//     // Hanya lakukan resize jika file lebih besar dari 1.5 MB
	//     if ($originalSize <= $minFileSizeBytes) {
	//         return "File size is below 1.5 MB. No resize required.";
	//     }

	//     // Jika file sudah di bawah ukuran maksimum
	//     if ($originalSize <= $maxSizeBytes) {
	//         return "No resize needed. File is already smaller than {$maxSizeKB}KB.";
	//     }

	//     // Buat resource gambar berdasarkan format
	//     switch ($mimeType) {
	//         case 'image/jpeg':
	//         case 'image/jpg': // Menangani format JPG
	//             $image = imagecreatefromjpeg($filePath);
	//             break;
	//         case 'image/png':
	//             $image = imagecreatefrompng($filePath);
	//             break;
	//         default:
	//             return "Unsupported file format. Only JPEG, JPG, and PNG are supported.";
	//     }

	//     // Kurangi kualitas secara bertahap hingga ukuran sesuai
	//     $quality = 90; // Kualitas awal untuk JPEG (0-100)
	//     $success = false;

	//     do {
	//         ob_start();
	//         if ($mimeType === 'image/jpeg' || $mimeType === 'image/jpg') {
	//             imagejpeg($image, null, $quality);
	//         } elseif ($mimeType === 'image/png') {
	//             imagepng($image, null, (10 - $quality / 10)); // Skala kualitas untuk PNG
	//         }
	//         $data = ob_get_clean();

	//         if (strlen($data) <= $maxSizeBytes) {
	//             // Simpan gambar ke file asli
	//             file_put_contents($filePath, $data);
	//             $success = true;
	//             break;
	//         }

	//         $quality -= 5; // Turunkan kualitas secara bertahap
	//     } while ($quality > 10);

	//     // Hancurkan resource gambar
	//     imagedestroy($image);

	//     return $success ? "Image resized successfully." : "Failed to resize image. Quality limit reached.";
	// }




	public function set_elemen(){
		if ($_POST) {
			$this->load->model('M_helpers');

			$cek_sekolah= $this->m_global->get(['table'=> 't_sekolah_elemen', 'where'=> ['sekolah_id'=> login_data('sekolah_id')]]);

			

			if ($cek_sekolah ==null) {
				
				$kelompok= $this->m_global->get(['table'=> 't_master_elemen_kelompok', 'where'=> ['kelompok_id'=> $_POST['kelompok_id']]])[0];
				$insert= [
					'table'=> 't_sekolah_elemen',
					'datas'=> [
						'sekolah_elemen_kelompok_id'=> $kelompok->kelompok_id,
						// 'elemen_nomor'=> $kelompok->elemen_nomor,
						'sekolah_elemen_status'=> 1,
						'sekolah_id'=> login_data('sekolah_id')]];

				$sekolah_elemen_id=$this->m_global->insert($insert)['id'];

				$this->M_helpers->set_elemen_data($sekolah_elemen_id);

				$result['status']     = 1;
				$result['message']    = 'Elemen Berhasil Ditambahkan';

				echo json_encode($result);	

			}else{

				$result['status']     = 2;
				$result['message']    = 'Elemen Sudah Ada';

				echo json_encode($result);	
			}
		}
	}
}

/* End of file Dashboard.php */
/* Location: ./application/modules/dashboard/controllers/Dashboard.php */
