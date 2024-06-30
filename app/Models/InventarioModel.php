<?php
namespace App\Models;
use CodeIgniter\Model;
class InventarioModel extends Model{
    protected $table = 'inventario';
    protected $primaryKey = 'inv_id ';
    protected $returnType = 'array';
    protected $allowedFields = [
        'pro_id ','inv_cantidad_total', 'inv_cantidad_disponible', 'inv_fecha_adquisicion', 'inv_estado'
    ];

    public function getInventario(){
        return $this->db->table('inventario inv')
        ->where('inv.inv_estado',1)
        ->join('productos pro','pro.pro_id = inv.pro_id')
        ->get()->getResultArray();
    }

    public function getId($id){
        return $this->db->table('inventario inv')
        ->where('inv.inv_id',$id)
        ->where('inv.inv_estado',1)
        ->join('productos pro','pro.pro_id = inv.pro_id')
        ->get()->getResultArray();
    }
}