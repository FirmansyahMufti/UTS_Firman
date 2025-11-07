<?php

namespace App\Controllers;

use App\Models\SensusModel;
use CodeIgniter\API\ResponseTrait;

/**
 * SensusController
 * - GET    /api/sensus?keyword=...&page=1&per_page=10
 * - POST   /api/sensus
 * - PUT    /api/sensus/{id}
 * - DELETE /api/sensus/{id}
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
     * List sensus with join to cities, pagination and search by nama_penduduk
     */
    public function index()
    {
        $keyword = $this->request->getGet('keyword') ?? null;
        $page    = (int) ($this->request->getGet('page') ?? 1);
        $perPage = (int) ($this->request->getGet('per_page') ?? 10);

        // Build query with join
        $builder = $this->model->select('sensus.*, cities.nama_kota')
                               ->join('cities', 'cities.id = sensus.id_kota', 'left');

        if ($keyword) {
            $builder = $builder->like('sensus.nama_penduduk', $keyword);
        }

        $data  = $builder->paginate($perPage, 'default', $page);
        $pager = $builder->pager;

        return $this->respond([
            'status' => 'success',
            'data'   => $data,
            'meta'   => [
                'current_page' => $pager->getCurrentPage(),
                'per_page'     => $perPage,
                'total'        => $pager->getTotal(),
                'total_pages'  => $pager->getPageCount()
            ]
        ]);
    }

    /**
     * Create sensus record
     */
    public function create()
    {
        $raw = $this->request->getBody();
        $input = json_decode($raw, true);
        if (!is_array($input)) {
            $input = [
                'nama_penduduk' => $this->request->getVar('nama_penduduk'),
                'nik'           => $this->request->getVar('nik'),
                'alamat'        => $this->request->getVar('alamat'),
                'tanggal_lahir' => $this->request->getVar('tanggal_lahir'),
                'id_kota'       => $this->request->getVar('id_kota'),
            ];
        }

        if (empty($input['nama_penduduk']) || empty($input['id_kota'])) {
            return $this->failValidationErrors('nama_penduduk and id_kota are required');
        }

        $data = [
            'nama_penduduk' => $input['nama_penduduk'],
            'nik'           => $input['nik'] ?? null,
            'alamat'        => $input['alamat'] ?? null,
            'tanggal_lahir' => $input['tanggal_lahir'] ?? null,
            'id_kota'       => (int) $input['id_kota']
        ];

        $this->model->insert($data);

        return $this->respondCreated(['message' => 'Data sensus berhasil ditambahkan']);
    }

    /**
     * Update sensus record
     */
    public function update($id = null)
    {
        if (!$id) {
            return $this->failValidationErrors('ID is required');
        }

        $raw = $this->request->getBody();
        $input = json_decode($raw, true);
        if (!is_array($input)) {
            $input = $this->request->getRawInput(); // fallback to raw input
        }

        $exists = $this->model->find($id);
        if (!$exists) {
            return $this->failNotFound('Data sensus tidak ditemukan');
        }

        // Only update allowed fields
        $updateData = [];
        foreach (['nama_penduduk','nik','alamat','tanggal_lahir','id_kota'] as $f) {
            if (isset($input[$f])) $updateData[$f] = $input[$f];
        }

        if (empty($updateData)) {
            return $this->failValidationErrors('No data to update');
        }

        $this->model->update($id, $updateData);

        return $this->respond(['message' => 'Data sensus berhasil diperbarui']);
    }

    /**
     * Delete sensus record
     */
    public function delete($id = null)
    {
        if (!$id) {
            return $this->failValidationErrors('ID is required');
        }

        $exists = $this->model->find($id);
        if (!$exists) {
            return $this->failNotFound('Data sensus tidak ditemukan');
        }

        $this->model->delete($id);

        return $this->respondDeleted(['message' => 'Data sensus berhasil dihapus']);
    }
}
