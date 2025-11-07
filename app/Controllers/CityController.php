<?php

namespace App\Controllers;

use App\Models\CityModel;
use CodeIgniter\API\ResponseTrait;

class CityController extends BaseController
{
    use ResponseTrait;
    protected $model;

    public function __construct()
    {
        $this->model = new CityModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword') ?? null;
        $page    = max(1, (int) ($this->request->getGet('page') ?? 1));
        $perPage = max(1, (int) ($this->request->getGet('per_page') ?? 10));
        $offset  = ($page - 1) * $perPage;

        $builder = $this->model->builder();
        if ($keyword) {
            $builder->like('nama_kota', $keyword);
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
        if (empty($input['nama_kota'])) {
            return $this->failValidationErrors('nama_kota is required');
        }

        $this->model->insert(['nama_kota' => $input['nama_kota']]);
        return $this->respondCreated(['message' => 'Kota berhasil ditambahkan']);
    }
}
