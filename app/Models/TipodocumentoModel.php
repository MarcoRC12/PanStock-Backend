<?php
namespace App\Models;
use CodeIgniter\Model;
class TipodocumentoModel extends Model{
    protected $table = 'tipo_documento';
    protected $primaryKey = 'td_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'td_nombre', 'td_estado'
    ];

}