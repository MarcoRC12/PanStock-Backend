<?php
namespace App\Models;
use CodeIgniter\Model;
class ProductoPedidosModel extends Model{
    protected $table = 'producto_pedidos';
    protected $primaryKey = 'prope_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'pro_id','pe_id', 'prope_numorden', 'prope_descripcion', 'prope_cantidad', 'prope_entregado', 'prope_estado'
    ];

    public function getProductoPedidos(){
        return $this->db->table('producto_pedidos prope')
        ->where('prope.prope_estado',1)
        ->join('productos pro','pro.pro_id = prope.pro_id')
        ->join('pedidos pe','pe.pe_id = prope.pe_id')
        ->get()->getResultArray();
    }

    public function getId($id){
        return $this->db->table('producto_pedidos prope')
        ->where('prope.prope_id',$id)
        ->where('prope.prope_estado',1)
        ->join('productos pro','pro.pro_id = prope.pro_id')
        ->join('pedidos pe','pe.pe_id = prope.pe_id')
        ->get()->getResultArray();
    }
}