<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Tanggal	: 02-11-2017
 * versi 	: 1.000.1.0
 */

class M_global extends CI_Model
{

	/**
	 * Cara menggunakan :
	 * $arr['table'] 	= 'table';		--------- wajib
	 * $arr['join'] 	= 'join';		--------- optional
	 * $arr['where'] 	= 'where';		--------- optional
	 * $arr['like'] 	= 'like'; 		--------- optional
	 * $arr['select'] 	= 'select';		--------- optional
	 * $arr['where_e']	= 'where_e';	--------- optional
	 * $arr['order'] 	= 'order';		--------- optional
	 * $arr['start'] 	= 'start';		--------- optional
	 * $arr['show'] 	= 'show';		--------- optional
	 * $arr['group'] 	= 'group';		--------- optional
	 * $arr['array'] 	= 'array';		--------- optional
	 * $arr['datas'] 	= 'datas';		--------- optional
	 * $arr['by'] 		= 'string';		--------- wajib ( for update_batch only )
	 *
	 * $result = $this->m_global->nama_fungsi($arr);
	 */

	/**
	 * nama tabel dari database
	 * @var string
	 */
	protected $table;

	/**
	 * menggabungkan 2 atau lebih tabel
	 * 
	 * [
	 * 	['nama_tabel', 'nama_tabel.id = nama_tabel2.id2'],
	 * 	['nama_tabel', 'nama_tabel.id = nama_tabel3.id3', 'inner/left/right (optional)']
	 * ]
	 *
	 * @var array
	 */
	protected $join 	= null;

	/**
	 * kondisi query
	 *
	 *[
	 *	'nama_kolom' 					=> 'kondisi',
	 *	"nama_kolom2 LIKE '%$param%'"	=> null,
	 *	'nama_kolom3 <>'				=> 'kondisi 3'
	 *]
	 * 
	 * @var array
	 */
	protected $where 	= null;

	/**
	 * @var array
	 */
	protected $like 	= null;

	/**
	 * kolom yang dipilih
	 *
	 * 'id, nama, umur, alamat, email, dll'
	 * 
	 * @var string
	 */
	protected $select 	= '*';

	/**
	 * pengkondisian manual
	 *
	 *	"tabel.id = 50, tabel.nama LIKE '%abc%'" 
	 * 
	 * @var string
	 */
	protected $where_e 	= null;

	/**
	 * memilih suatu nilai dari tabel atau kolom dan mengurutkan data tersebut
	 *
	 * [tabel.id, 'asc/desc']
	 * 
	 * @var array
	 */
	protected $order 	= null;

	/**
	 * menampilkan data mulai dari record ke-n
	 * @var integer
	 */
	protected $start 	= 0;

	/**
	 * mengembalikan record hanya n
	 * @var integer
	 */
	protected $show 	= null;

	/**
	 * menelompokkan suatu data
	 * 
	 * 'title'
	 * array('title', 'date')
	 * 
	 * @var string / array
	 */
	protected $group 	= null;

	/**
	 * tipe return data
	 * true 	= return result array
	 * false 	= return result
	 * 
	 * @var boolean
	 */
	protected $array 	= false;

	/**
	 * data yang dikirimkan
	 *
	 * array('name' => 'budiono', 'email' => 'budi@ono.com')
	 * 
	 * @var array
	 */
	protected $datas 	= array();

	/**
	 * where untuk update_bacth
	 *
	 * title
	 * 
	 * @var string
	 */
	protected $by 	= null;

	public function __construct()
	{
		parent::__construct();
		$this->db->query("SET time_zone='+07:00'");
	}

	/**
	 * memberikan inisial
	 * 
	 * @param  array
	 * @return object
	 */
	public function initialize(array $params = array())
	{
		$result = new M_global();

		foreach ($params as $key => $val) {
			if (property_exists($result, $key)) {
				$result->$key = $val;
			}
		}

		return $result;
	}

	/**
	 * menghitung jumlah data dari tabel
	 * 
	 * @param  array
	 * @return integer
	 */
	public function count(array $params = array())
	{
		$data = $this->initialize($params);

		$this->db->select("count(*) as jumlah")->from($data->table);

		if (!is_null($data->join)) {
			foreach ($data->join as $key => $value) {
				$tipe = (@$value[2] != '') ? $value[2] : 'INNER';
				$this->db->join($value[0], $value[1], $tipe);
			}
		}

		(!is_null($data->where)
			? $this->db->where($data->where)
			: '');

		(!is_null($data->like)
			? $this->db->like($data->like)
			: '');

		(!is_null($data->where_e)
			? $this->db->where($data->where_e, NULL, FALSE)
			: '');

		(!is_null($data->group)
			? $this->db->group_by($data->group, NULL, FALSE)
			: '');

		$query  = $this->db->get();
		$result = $query->row();

		return $result->jumlah;
	}

	/**
	 * mengambil data dari table
	 * 
	 * @param  array
	 * @return object / array -> tergantung dari parameter yang diberikan (array TRUE / FALSE)
	 */
	public function get(array $params = array())
	{
		$data = $this->initialize($params);

		if (is_array($data->select)) {
			$this->db->select($data->select[0], $data->select[1])->from($data->table);
		} else {
			$this->db->select($data->select)->from($data->table);
		}

		if (!is_null($data->join)) {
			foreach ($data->join as $key => $value) {
				$tipe = (@$value[2] != '') ? $value[2] : 'INNER';
				$this->db->join($value[0], $value[1], $tipe);
			}
		}

		(!is_null($data->order)
			? $this->db->order_by($data->order[0], $data->order[1])
			: '');
		(!is_null($data->show)
			? $this->db->limit($data->show, $data->start)
			: '');
		(!is_null($data->where)
			? $this->db->where($data->where)
			: '');
		(!is_null($data->like)
			? $this->db->like($data->like)
			: '');
		(!is_null($data->where_e)
			? $this->db->where($data->where_e, NULL, FALSE)
			: '');
		(!is_null($data->group)
			? $this->db->group_by($data->group, NULL, FALSE)
			: '');

		$query  = $this->db->get();

		(($data->array == true)
			? $result = $query->result_array()
			: $result = $query->result());

		return $result;
	}

	/**
	 * untuk insert data ke tabel
	 * 
	 * @param  array
	 * @return array
	 */
	public function insert(array $params = array())
	{
		$data = $this->initialize($params);

		$result    = $this->db->insert($data->table, $data->datas);

		if ($result == TRUE) {
			$result             = [];
			$result['status']   = TRUE;
			$result['id']       = $this->db->insert_id();
		} else {
			$result             = [];
			$result['status']   = FALSE;
		}

		return $result;
	}

	/**
	 * untuk insert batch data ke tabel
	 * 
	 * @param  array
	 * @return array
	 */
	public function insert_batch(array $params = array())
	{
		$data = $this->initialize($params);

		$result    = $this->db->insert_batch($data->table, $data->datas);

		if ($result == TRUE) {
			$result             = [];
			$result['status']   = TRUE;
		} else {
			$result             = [];
			$result['status']   = FALSE;
		}

		return $result;
	}

	/**
	 * untuk update data di tabel
	 * 
	 * @param  array
	 * @return boolean
	 */
	public function update(array $params = array())
	{
		$data = $this->initialize($params);

		(!is_null($data->where_e)
			? $this->db->where($data->where_e, NULL, FALSE)
			: '');

		$result    = $this->db->update($data->table, $data->datas, $data->where);

		if ($result) {
			$res = ['status' => TRUE, 'affected' => $this->db->affected_rows()];

			return $res;
		} else {
			$res = ['status' => FALSE];

			return $res;
		}
	}

	/**
	 * untuk update_batch data di tabel
	 * 
	 * @param  array
	 * @return boolean
	 */
	public function update_batch(array $params = array())
	{
		$data = $this->initialize($params);

		$result    = $this->db->update_batch($data->table, $data->datas, $data->by);

		if ($result) {
			$res = ['status' => TRUE, 'affected' => $this->db->affected_rows()];

			return $res;
		} else {
			$res = ['status' => FALSE];

			return $res;
		}
	}

	/**
	 * untuk menghapus data di tabel
	 * 
	 * @param  array
	 * @return boolean
	 */
	public function delete(array $params = array())
	{
		$data = $this->initialize($params);

		(!is_null($data->where_e)
			? $this->db->where($data->where_e, NULL, FALSE)
			: '');

		$result    = $this->db->delete($data->table, $data->where);

		return $result;
	}

	/**
	 * untuk memvalidasi data di tabel
	 * 
	 * @param  array
	 * @return boolean
	 */
	public function validation(array $params = array())
	{
		$this->db->select('*')->from($data->table);

		(!is_null($data->where)
			? $this->db->where($data->where)
			: '');
		(!is_null($data->where_e)
			? $this->db->where($data->where_e, NULL, FALSE)
			: '');

		$query  = $this->db->get();
		$result = $query->num_rows();

		if ($result > 0) {
			$result = FALSE;
		} else {
			$result = TRUE;
		}

		return $result;
	}

	/**
	 * untuk mengambil jumlah baris pada hasil query
	 * 
	 * @param  array
	 * @return integer
	 */
	public function get_num_rows(array $params = array())
	{
		$data = $this->initialize($params);

		$this->db->select("count(*) as jumlah")->from($data->table);

		if (!is_null($data->join)) {
			foreach ($data->join as $rows) {
				$tipe = (@$rows['tipe'] != '') ? $rows['tipe'] : 'INNER';
				$this->db->join($rows['table'], $rows['on'], $tipe);
			}
		}

		(!is_null($data->where)
			? $this->db->where($data->where)
			: '');
		(!is_null($data->where_e)
			? $this->db->where($data->where_e, NULL, FALSE)
			: '');
		(!is_null($data->group)
			? $this->db->group_by($data->group, NULL, FALSE)
			: '');

		$query  = $this->db->get();
		$result = $query->num_rows();

		return $result;
	}

	/**
	 * untuk insert beberapa data dan atau update beberapa data dalam waktu bersamaan
	 * 
	 * @param  array
	 * @return array
	 */
	public function insert_update_batch(array $params = array())
	{
		$data = $this->initialize($params);

		$count      = 0;
		$jumlah     = 0;

		foreach ($data->datas as $param) {
			$result     = $this->_insert_update($data->table, $param);
			if ($result == TRUE) {
				$count++;
			}
			$jumlah++;
		}

		if ($count == $jumlah) {
			$result             = [];
			$result['status']   = TRUE;
		} else {
			$result             = [];
			$result['status']   = FALSE;
			$result['message']  = ($jumlah - $count) . ' data gagal diproses';
		}

		return $result;
	}

	/**
	 * untuk insert data dan atau update data dalam waktu bersamaan
	 * 
	 * @param  array
	 * @return array
	 */
	public function insert_update(array $params = array())
	{
		$data = $this->initialize($params);

		$result     = $this->_insert_update($data->table, $data->datas);

		if ($result == TRUE) {
			$result             = [];
			$result['status']   = TRUE;
		} else {
			$result             = [];
			$result['status']   = FALSE;
		}

		return $result;
	}

	/**
	 * fungsi pendukung untuk insert_update dan insert_update_batch
	 * 
	 * @param  array
	 * @return boolean
	 */
	public function _insert_update($table, $data)
	{
		$key    = [];
		$value  = [];

		//generate duplicate
		$strDuplicate   = [];
		foreach ($data as $kolom => $nilai) {
			$key[]              = $kolom;
			$value[]            = $nilai;

			$nilai              = $this->db->escape($nilai);
			$strDuplicate[]     = "{$kolom} = {$nilai}";
		}
		$strDuplicate   = implode(",", $strDuplicate);

		// generate tanda tanya
		$tanya  = [];
		foreach ($value as $val) {
			$tanya[] = '?';
		}
		$tanya  = implode(", ", $tanya);

		$sKey   = implode(",", $key);

		$sql    = " INSERT INTO {$table}({$sKey}) VALUES ({$tanya})
					ON DUPLICATE KEY UPDATE
					{$strDuplicate}
				  ;";
		$query  = $this->db->query($sql, $value);

		return $query;
	}
}

/* End of file M_global.php */
/* Location: ./application/modules/global/models/M_global.php */