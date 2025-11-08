<?php

namespace App\Controllers;

use App\Models\SensusModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\IncomingRequest;

/**
 * @property IncomingRequest $request
 */
class SensusController extends BaseController
{
    use ResponseTrait;

    protected $model;

    public function __construct()
    {
        $this->model = new SensusModel();
    }

    /**
     * List sensus with pagination and optional search by nama_penduduk
     */
    public function index()
    {
        $keyword = $this->request->getGet('keyword') ?? null;
        $page    = (int) ($this->request->getGet('page') ?? 1);
        $perPage = (int) ($this->request->getGet('per_page') ?? 10);

        $builder = $this->model->select('sensus.*, cities.nama_kota')
                               ->join('cities', 'cities.id = sensus.id_kota', 'left');

        if ($keyword) {
            $builder->like('sensus.nama_penduduk', $keyword);
        }

        $data = $builder->paginate($perPage, 'default', $page);
        $pager = $this->model->pager;

        return $this->respond([
            'status' => 'success',
            'data'   => $data,
            'meta'   => [
                'current_page' => $pager->getCurrentPage(),
                'per_page'     => $perPage,
                'total'        => $pager->getTotal(),
                'total_pages'  => $pager->getPageCount(),
            ]
        ]);
    }

    /**
     * Create new sensus record
     */
    public function create()
    {
        /** @var IncomingRequest $request */
        $request = $this->request;
        $input = $request->getJSON(true);

        if (!is_array($input)) {
            $input = [
                'nama_penduduk' => $request->getVar('nama_penduduk'),
                'nik'           => $request->getVar('nik'),
                'umur'          => $request->getVar('umur'),
                'jenis_kelamin' => $request->getVar('jenis_kelamin'),
                'alamat'        => $request->getVar('alamat'),
                'id_kota'       => $request->getVar('id_kota'),
            ];
        }

        if (empty($input['nama_penduduk']) || empty($input['id_kota'])) {
            return $this->failValidationErrors('nama_penduduk dan id_kota wajib diisi');
        }

        $this->model->insert($input);

        return $this->respondCreated(['message' => 'Data sensus berhasil ditambahkan']);
    }

    /**
     * Update sensus record
     */
    public function update($id = null)
    {
        if (!$id) {
            return $this->failValidationErrors('ID wajib diisi');
        }

        /** @var IncomingRequest $request */
        $request = $this->request;
        $input = $request->getJSON(true) ?? $request->getRawInput();

        $exists = $this->model->find($id);
        if (!$exists) {
            return $this->failNotFound('Data sensus tidak ditemukan');
        }

        $this->model->update($id, $input);
        return $this->respond(['message' => 'Data sensus berhasil diperbarui']);
    }

    /**
     * Delete sensus record
     */
    public function delete($id = null)
    {
        if (!$id) {
            return $this->failValidationErrors('ID wajib diisi');
        }

        $exists = $this->model->find($id);
        if (!$exists) {
            return $this->failNotFound('Data sensus tidak ditemukan');
        }

        $this->model->delete($id);

        return $this->respondDeleted(['message' => 'Data sensus berhasil dihapus']);
    }
}
