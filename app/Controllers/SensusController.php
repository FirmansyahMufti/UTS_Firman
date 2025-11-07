<?php

namespace App\Controllers;

use App\Models\SensusModel;
use CodeIgniter\API\ResponseTrait;
use Config\Database;

class SensusController extends BaseController
{
    use ResponseTrait;
    protected $model;

    public function __construct()
    {
        $this->model = new SensusModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword') ?? null;
        $page    = max(1, (int) ($this->request->getGet('page') ?? 1));
        $perPage = max(1, (int) ($this->request->getGet('per_page') ?? 10));
        $offset  = ($page - 1) * $perPage;

        $db = Database::connect();
        $builder = $db->table('sensus')
                      ->select('sensus.*, cities.nama_kota')
                      ->join('cities', 'cities.id = sensus.id_kota', 'left');

        if ($keyword) {
            $builder->like('sensus.nama_penduduk', $keyword);
        }

        $total = (int) $builder->countAllResults(false);
        $rows  = $builder->limit($perPage, $offset)->get()->getResultArray();

        return $this->respond([
            'status' => 'success',
            'data'   => $rows,
            'meta' => [
                'current_page' => $page,
                'per_page'     => $perPage,
                'total'        => $total,
                'total_pages'  => (int) ceil($total / $perPage)
            ]
        ]);
    }

    public function create()
    {
        $input = $this->request->getJSON(true);
        if (empty($input['nama_penduduk']) || empty($input['id_kota'])) {
            return $this->failValidationErrors('nama_penduduk and id_kota are required');
        }

        $this->model->insert($input);
        return $this->respondCreated(['message' => 'Data sensus berhasil ditambahkan']);
    }

    public function update($id = null)
    {
        if (!$id) return $this->failValidationErrors('ID is required');
        $input = $this->request->getJSON(true);

        $exists = $this->model->find($id);
        if (!$exists) return $this->failNotFound('Data sensus tidak ditemukan');

        $this->model->update($id, $input);
        return $this->respond(['message' => 'Data sensus berhasil diperbarui']);
    }

    public function delete($id = null)
    {
        if (!$id) return $this->failValidationErrors('ID is required');
        $exists = $this->model->find($id);
        if (!$exists) return $this->failNotFound('Data sensus tidak ditemukan');

        $this->model->delete($id);
        return $this->respondDeleted(['message' => 'Data sensus berhasil dihapus']);
    }
}
