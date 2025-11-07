<?php

namespace App\Controllers;

use App\Models\SensusModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class SensusController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $model = new SensusModel();
        $keyword = $this->request->getGet('keyword');
        $page = (int)($this->request->getGet('page') ?? 1);
        $perPage = 5;

        $builder = $model->select('sensus.*, cities.nama_kota')
                         ->join('cities', 'cities.id = sensus.id_kota', 'left');

        if ($keyword) {
            $builder->like('sensus.nama_penduduk', $keyword);
        }

        $data = $builder->paginate($perPage, 'default', $page);
        $pager = $builder->pager;

        return $this->respond([
            'status' => 'success',
            'data' => $data,
            'pager' => [
                'currentPage' => $pager->getCurrentPage(),
                'totalPages' => $pager->getPageCount()
            ]
        ], ResponseInterface::HTTP_OK);
    }

    public function create()
    {
        $model = new SensusModel();
        $input = $this->request->getJSON(true);

        if (empty($input['nama_penduduk']) || empty($input['id_kota'])) {
            return $this->failValidationErrors('Nama penduduk dan kota wajib diisi');
        }

        $model->insert([
            'nama_penduduk' => $input['nama_penduduk'],
            'alamat' => $input['alamat'] ?? '',
            'tanggal_lahir' => $input['tanggal_lahir'] ?? null,
            'id_kota' => $input['id_kota']
        ]);

        return $this->respondCreated(['message' => 'Data sensus berhasil ditambahkan']);
    }

    public function update($id)
    {
        $model = new SensusModel();
        $input = $this->request->getJSON(true);

        if (!$model->find($id)) {
            return $this->failNotFound('Data tidak ditemukan');
        }

        $model->update($id, $input);
        return $this->respond(['message' => 'Data sensus berhasil diperbarui'], 200);
    }

    public function delete($id)
    {
        $model = new SensusModel();

        if (!$model->find($id)) {
            return $this->failNotFound('Data tidak ditemukan');
        }

        $model->delete($id);
        return $this->respondDeleted(['message' => 'Data sensus berhasil dihapus']);
    }
}
