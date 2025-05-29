<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Model\Role;

class DetailMurid extends Model
{
    protected $table            = 'detail_murid';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['murid_id', 'nama_murid', 'nis', 'alamat', 'jurusan', 'kelas'];
    // Model configuration
    protected bool $useTimestamps = true;
    protected $dateFormat      = 'datetime';
    protected $createdField    = 'created_at';
    protected $updatedField    = 'updated_at';

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Buat agar detail murid itu isinya user yang memiliki role murid
    protected $allowedRoles = ['murid'];
    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
