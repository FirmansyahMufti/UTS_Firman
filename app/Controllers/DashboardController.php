<?php

namespace App\Controllers;

use App\Models\SensusModel;
use App\Models\CityModel;
use CodeIgniter\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $sensusModel = new SensusModel();
        $cityModel = new CityModel();

        $totalSensus = $sensusModel->countAllResults();
        $totalCity = $cityModel->countAllResults();

        $recentSensus = $sensusModel
            ->select('sensus.*, cities.nama_kota')
            ->join('cities', 'cities.id = sensus.id_kota', 'left')
            ->orderBy('sensus.created_at', 'DESC')
            ->limit(5)
            ->find();

        return view('dashboard/index', [
            'totalSensus' => $totalSensus,
            'totalCity' => $totalCity,
            'recentSensus' => $recentSensus
        ]);
    }
}
