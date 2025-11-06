<?php

namespace App\Models;
use CodeIgniter\Model;

class SensusModel extends Model
{
    protected $table = 'sensus';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_penduduk', 'alamat', 'tanggal_lahir', 'id_kota'];
    
    public function getSensusWithCity()
    {
        return $this->select('sensus.*, cities.nama_kota')
                    ->join('cities', 'cities.id = sensus.id_kota')
                    ->findAll();
    }
}
