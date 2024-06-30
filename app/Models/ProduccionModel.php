<?php
namespace App\Models;
use CodeIgniter\Model;
class ProduccionModel extends Model{
    protected $table = 'produccion';
    protected $primaryKey = 'produ_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'pro_id','produ_horainicio', 'produ_horafin', 'produ_fecha', 'produ_terminado', 'produ_cantidadproducida', 'produ_estado'
    ];

    public function getProduccion(){
        return $this->db->table('produccion produ')
        ->where('produ.produ_estado',1)
        ->join('productos pro_id','tido.pro_id = produ.pro_id')
        ->get()->getResultArray();
    }

    public function getId($id){
        return $this->db->table('produccion produ')
        ->where('produ.produ_id',$id)
        ->where('produ.produ_estado',1)
        ->join('productos pro','pro.pro_id = produ.pro_id')
        ->get()->getResultArray();
    }
    
}