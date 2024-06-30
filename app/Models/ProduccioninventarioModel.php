<?php
namespace App\Models;
use CodeIgniter\Model;
class ProduccionInventarioModel extends Model{
    protected $table = 'produccion_inventario';
    protected $primaryKey = 'produinv_id ';
    protected $returnType = 'array';
    protected $allowedFields = [
        'inv_id','produ_id', 'produinv_cantidad', 'produinv_estado'
    ];


    public function getProduInven(){
        return $this->db->table('produccion_inventario produinv')
        ->where('produinv.produinv_estado',1)
        ->join('inventario inv','inv.inv_id = produinv.inv_id')
        ->join('produccion produ','produ.produ_id = produinv.produ_id')
        ->get()->getResultArray();
    }
    public function getId($id){
        return $this->db->table('produccion_inventario produinv')
        ->where('produinv.produinv_id',$id)
        ->where('produinv.produinv_estado',1)
        ->join('inventario inv','inv.inv_id = produinv.inv_id')
        ->join('produccion produ','produ.produ_id = produinv.produ_id')
        ->get()->getResultArray();
    }
}