<?php

namespace App\Controllers;

use App\Models\SensusModel;
use App\Models\CityModel;
use CodeIgniter\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // --- MODEL SETUP ---
        $sensusModel = new SensusModel();
        $cityModel = new CityModel();

        // --- HITUNG DATA ---
        $totalSensus = $sensusModel->countAllResults();
        $totalCity   = $cityModel->countAllResults();

        // --- JOIN DATA ---
        $recentSensus = $sensusModel
            ->select('sensus.*, cities.nama_kota')
            ->join('cities', 'cities.id = sensus.id_kota', 'left')
            ->orderBy('sensus.created_at', 'DESC')
            ->limit(5)
            ->findAll();

        // --- KIRIM DATA KE VIEW ---
        return view('dashboard/index', [
            'totalSensus'   => $totalSensus,
            'totalCity'     => $totalCity,
            'recentSensus'  => $recentSensus,
        ]);
    }
}
