<?php

namespace App\Controllers;

use App\Models\CityModel;
use CodeIgniter\API\ResponseTrait;

/**
 * CityController
 * - GET  /api/cities?keyword=...&page=1&per_page=10
 * - POST /api/cities
 */
class CityController extends BaseController
{
    use ResponseTrait;

    protected $model;

    public function __construct()
    {
        $this->model = new CityModel();
    }

    /**
     * List cities with pagination and optional search by nama_kota
     */
    public function index()
    {
        $keyword = $this->request->getGet('keyword') ?? null;
        $page    = (int) ($this->request->getGet('page') ?? 1);
        $perPage = (int) ($this->request->getGet('per_page') ?? 10);

        $builder = $this->model;

        if ($keyword) {
            $builder = $builder->like('nama_kota', $keyword);
        }

        // paginate() returns array of results
        $data = $builder->paginate($perPage, 'default', $page);
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
     * Create new city
     */
    public function create()
    {
        // Accept JSON body or form-data
        $raw = $this->request->getBody();
        $input = json_decode($raw, true);
        if (!is_array($input)) {
            // fallback to getVar
            $input = [
                'nama_kota' => $this->request->getVar('nama_kota')
            ];
        }

        if (empty($input['nama_kota'])) {
            return $this->failValidationErrors('nama_kota is required');
        }

        $this->model->insert(['nama_kota' => $input['nama_kota']]);

        return $this->respondCreated(['message' => 'Kota berhasil ditambahkan']);
    }

    // (Optional) you can add update / delete for cities if needed
}
