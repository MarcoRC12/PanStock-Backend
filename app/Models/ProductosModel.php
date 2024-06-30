<?php
namespace App\Models;
use CodeIgniter\Model;
class ProductosModel extends Model{
    protected $table = 'productos';
    protected $primaryKey = 'pro_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'pro_nombre','pro_descripcion', 'tpro_id', 'pro_marca', 'pro_imagen', 'pro_estado'
    ];

    public function getProductos(){
        return $this->db->table('productos pro')
        ->where('pro.pro_estado',1)
        ->join('tipos_productos tpro','tpro.tpro_id = pro.tpro_id')
        ->get()->getResultArray();
    }

    public function getId($id){
        return $this->db->table('productos pro')
        ->where('pro.pro_id',$id)
        ->where('pro.pro_estado',1)
        ->join('tipos_productos tpro','tpro.tpro_id = pro.tpro_id')
        ->get()->getResultArray();
    }

}