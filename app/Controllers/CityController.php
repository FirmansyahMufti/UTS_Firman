<?php

namespace App\Controllers;

use App\Models\CityModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class CityController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $model = new CityModel();
        $keyword = $this->request->getGet('keyword');
        $page = (int)($this->request->getGet('page') ?? 1);
        $perPage = 5;

        $builder = $model;
        if ($keyword) {
            $builder->like('nama_kota', $keyword);
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
        $model = new CityModel();
        $input = $this->request->getJSON(true);

        if (empty($input['nama_kota'])) {
            return $this->failValidationErrors('Nama kota wajib diisi');
        }

        $model->insert(['nama_kota' => $input['nama_kota']]);
        return $this->respondCreated(['message' => 'Kota berhasil ditambahkan']);
    }
}
