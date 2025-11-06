<?php

namespace App\Models;
use CodeIgniter\Model;

class SensusModel extends Model
{
    protected $table = 'sensus';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_penduduk', 'alamat', 'tanggal_lahir', 'id_kota'];
    protected $useTimestamps = true;

    // Ambil data sensus dengan relasi nama kota
    public function getSensus($keyword = null)
    {
        $builder = $this->select('sensus.*, cities.nama_kota')
                        ->join('cities', 'cities.id = sensus.id_kota');

        if ($keyword) {
            $builder->like('nama_penduduk', $keyword);
        }

        return $builder->paginate(10); // pagination 10 per halaman
    }
}
