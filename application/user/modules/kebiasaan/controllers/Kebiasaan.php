<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kebiasaan extends MX_Controller
{

	private $prefix         = 'kebiasaan';
	private $url            = 'kebiasaan';
	private $table_db       = '';
	private $table_prefix   = '';
	private $title 			= __CLASS__;

	public function index($id = null)
	{

		$data['title']		= ucwords(str_replace('_', ' ', $this->title));
		$data['breadcrumb'] = [$this->title => base_url() . $this->url];
		$data['url']		= base_url() . $this->url;
		$data['prefix']		= $this->prefix;

		$data['plugin'] 	= ['datatables'];
		$data['id']			= $id;

		$data['kebiasaan']= $this->m_global->get([
			'table'=> 
			't_kelas_belajar_kebiasaan', 'where'=> ['kelas_id'=> $id]]);

		$data['deteil_pertanyaan']= $this->m_global->get([
			'select'=> 'opt.*',
			'table'=> 't_kelas_belajar_kebiasaan_option opt',
			'join'=> [['t_kelas_belajar_kebiasaan k', 'k.kebiasaan_id= opt.kebiasaan_id']],
			 'where'=> ['k.kelas_id'=> $id]]);
		

		$this->template->display(strtolower(__CLASS__) . '/index', $data);
	}
	public function tarik($id)
	{
		$this->load->model('Kebiasaan_model');
		$response = ['status' => 'error', 'message' => ''];

		if ($this->Kebiasaan_model->tarikKebiasaan($id)) {
			$response['status'] = 'success';
			$response['message'] = 'Kebiasaan berhasil ditarik.';
		} else {
			$response['message'] = 'Gagal menarik kebiasaan.';
		}

		echo json_encode($response);
	}
	public function select( $kelas_id = '')
	{
		$aCari = [
			'kelas_id'  => 'k.kelas_id',
		];

		$where      = NULL;
		$where_e    = NULL;
		$join 		= [
					['t_kelas_belajar_data kd', 'ka.siswa_kelas_id= kd.siswa_kelas_id'], 
					['t_kelas_belajar k ', 'k.kelas_id= kd.kelas_id'], 
					['t_siswa s', 's.siswa_id= kd.siswa_id']];

		if (@$_REQUEST['action'] == 'filter') {
			$where = [];
			foreach ($aCari as $key => $value) {
				if ($_REQUEST[$key] != '') {
					if ($key == 'lastupdate') {
						$tmp = explode(' ', $_REQUEST[$key]);
						$where_e = "DATE(" . $this->table_prefix . "lastupdate) BETWEEN '" . $this->db->escape_str($tmp[0]) . "' AND '" . $this->db->escape_str($tmp[1]) . "'";
					} else if ($key == 'role') {
						$where[$value] = $_REQUEST[$key];
					} else {
						$where[$value . ' LIKE '] = '%' . $_REQUEST[$key] . '%';
					}
				}
			}
		} else {
			// $where['k.sekolah_id']    = login_data("sekolah_id");
			// $where['k.guru_id']   	= login_data('user_id');
		}

		$keys   = array_keys($aCari);
		@$order = [$aCari[$keys[($_REQUEST['order'][0]['column'] - 1)]], $_REQUEST['order'][0]['dir']];

		$arr_config['table'] 	= ' t_kelas_belajar_kebiasaan_answer ka';
		$arr_config['where'] 	= $where;
		$arr_config['where_e'] 	= $where_e;
		$arr_config['join'] 	= $join;

		$iTotalRecords  = $this->m_global->count($arr_config);
		$iDisplayLength = intval($_REQUEST['length']);
		$iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
		$iDisplayStart  = intval($_REQUEST['start']);
		$sEcho          = intval($_REQUEST['draw']);

		$records        = array();
		$records["data"] = array();

		$end = $iDisplayStart + $iDisplayLength;
		$end = $end > $iTotalRecords ? $iTotalRecords : $end;

		$select = ' kebiasaan_jawaban_id, validasi_orang_tua, tanggal_input, nilai, nama_lengkap, ' . implode(',', $aCari);

		$arr_config['select'] 	= $select;
		$arr_config['order'] 	= $order;
		$arr_config['start'] 	= $iDisplayStart;
		$arr_config['show'] 	= $iDisplayLength;

		$result = $this->m_global->get($arr_config);

		$semester=[
			'1'=> '<label class="badge badge-primary"> Ganjil</label>',
			'2'=> '<label class="badge badge-danger"> Genap</label>'
		];


		$i = 1 + $iDisplayStart;
		foreach ($result as $rows) {
			$records["data"][] = array(
				$i,
				$rows->nama_lengkap,
				$rows->validasi_orang_tua,
				$rows->tanggal_input,	
				'<span class="badge badge-success">'.$rows->nilai.'/'.'28</span>',		
				$this->_button($rows->kebiasaan_jawaban_id),
			);
			$i++;
		}

		$records["draw"]            = $sEcho;
		$records["recordsTotal"]    = $iTotalRecords;
		$records["recordsFiltered"] = $iTotalRecords;

		echo json_encode($records);
	}
	public function _button($id)
	{
		$btn = '<button onclick="detailKebiasaan(' . $id . ')" class="btn btn-info btn-sm btn-icon-md tooltips" title="Detail"><i class="la la-eye"></i></button> ';
		return $btn;
	}
	public function detail($id)
{
    // ... query Anda tetap sama ...
    $queryResult = $this->m_global->get([
        'select' => 'ka.kebiasaan_jawaban_id, ka.validasi_orang_tua, ka.validasi_guru, ka.tanggal_input, ka.answer, ka.nilai, o.option_id, o.option, k.pertanyaan, k.icon',
        'table' => 't_kelas_belajar_kebiasaan_answer ka',
        'join' => [
            ['t_kelas_belajar_kebiasaan_option o', 'FIND_IN_SET(o.option_id, ka.answer) > 0'],
            ['t_kelas_belajar_kebiasaan k', 'k.kebiasaan_id = o.kebiasaan_id']
        ],
        'where' => ['ka.kebiasaan_jawaban_id' => $id]
    ]);

    if (!empty($queryResult)) {
        $data = $queryResult;
        $header = $data[0];

        // ... kode HTML untuk header dan list kebiasaan tetap sama ...
        $html = '<div class="laporan-detail">';
		// Bagian Header Laporan

		$html .= '
		<h5>Laporan ID: ' . htmlspecialchars($header->kebiasaan_jawaban_id) . '</h5>
		<p class="info-meta">
		<span><strong>Tanggal:</strong> ' . htmlspecialchars($header->tanggal_input) . '</span> |
		<span><strong>Nilai:</strong> ' . htmlspecialchars($header->nilai) . '</span>
		</p>
		';
		$status_ortu ='<span class="badge badge-success">'.$header->validasi_orang_tua.'</span>';
		$validasi_guru = !empty($header->validasi_guru) ? '<span class="badge badge-info">'.$header->validasi_guru.'</span>' : '<span class="badge badge-warning">Belum Divalidasi</span>';
		$html .= '<p class="info-meta"><strong>Validasi Ortu:</strong> ' . $status_ortu . '</p>';
		$html .= '<p class="info-meta"><strong>Validasi Guru:</strong> ' . $validasi_guru . '</p>';
		$html .= '<h6 class="mt-4">Kebiasaan yang Dilaporkan:</h6>';
		$html .= '<ul class="list-group list-group-flush">';
		
        foreach ($data as $item) {
            $html .= '
                <li class="list-group-item d-flex align-items-center">
                    <img src="' . base_url() . '../' . $item->icon . '" class="mr-3" width="24" alt="ikon">
                    <div class="flex-grow-1">
                        ' . htmlspecialchars($item->option) . '
                        <small class="d-block text-muted">' . htmlspecialchars($item->pertanyaan) . '</small>
                    </div>
                </li>';
        }
        $html .= '</ul>';

        // --- PERUBAHAN DI BAGIAN VALIDASI GURU ---
        $html .= '<hr>';
        $html .= '<h6>Validasi Guru</h6>';

        // Cek apakah guru sudah memberikan validasi (apakah kolomnya sudah terisi)
        if (empty($header->validasi_guru)) {
            // Jika BELUM, tampilkan form dengan satu textarea
            $html .= '
                <form id="formValidasiGuru" method="POST">
                    <div class="form-group">
                        <label for="validasi_guru_text">Tulis Validasi / Feedback Anda</label>
                        <textarea class="form-control" id="validasi_guru_text" name="validasi_guru" rows="4" placeholder="Contoh: Bagus, pertahankan terus kebiasaan baiknya!" required></textarea>
                    </div>
                    
                    <input type="hidden" name="kebiasaan_jawaban_id" value="' . htmlspecialchars($header->kebiasaan_jawaban_id) . '">
                    
                    <button type="submit" class="btn btn-primary btn-block">Simpan Validasi</button>
                </form>
            ';
        } else {
            // Jika SUDAH, tampilkan teks validasi yang sudah tersimpan
            $html .= '
                <div class="alert alert-info">
                    <strong>Feedback dari Guru:</strong>
                    <blockquote class="mb-0 mt-2">
                        ' . nl2br(htmlspecialchars($header->validasi_guru)) . '
                    </blockquote>
                </div>
            ';
        }

        $html .= '</div>';
        echo $html;

    } else {
        echo '<div class="alert alert-warning">Data laporan tidak ditemukan.</div>';
    }
}
public function simpan_validasi_guru()
{
    header('Content-Type: application/json');

    $id = $this->input->post('kebiasaan_jawaban_id');
    $validasi_text = $this->input->post('validasi_guru'); // Ini adalah teks dari textarea

    if (empty($id) || empty($validasi_text)) {
        echo json_encode(['status' => 'error', 'message' => 'ID Laporan dan Teks Validasi tidak boleh kosong.']);
        return;
    }

    $dataToUpdate = [
        'validasi_guru' => $validasi_text,
    ];

    $updateResult = $this->m_global->update([
        'table'=>'t_kelas_belajar_kebiasaan_answer',
        'datas'=>$dataToUpdate,
        'where'=>['kebiasaan_jawaban_id' => $id]]
    );

    if ($updateResult) {
        echo json_encode(['status' => 'success', 'message' => 'Validasi berhasil disimpan.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan validasi ke database.']);
    }
}
}