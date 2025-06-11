<?php

namespace App\Models;

use CodeIgniter\Model;

class BadgeModel extends Model
{
    protected $table = 'badge';
    protected $primaryKey = 'id';
    protected $allowedFields = ['murid_id', 'badge_name', 'badge_type', 'date_earned'];
    protected $useTimestamps = true;

    // Menambahkan fungsi untuk mendapatkan badge berdasarkan murid
    public function getBadgesByMurid($murid_id)
    {
        return $this->where('murid_id', $murid_id)->findAll();
    }

    // Menambahkan fungsi untuk menambah badge baru
    public function addBadge($data)
    {
        return $this->save($data);
    }
}
