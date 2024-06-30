<?php
namespace App\Models;
use CodeIgniter\Model;
class PedidosModel extends Model{
    protected $table = 'pedidos';
    protected $primaryKey = 'pe_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'cl_id','pe_numero', 'pe_direccion', 'pe_fechaentrega', 'pe_estado'
    ];

    public function getPedidos(){
        return $this->db->table('pedidos pe')
        ->where('pe.pe_estado',1)
        ->join('clientes cl','cl.cl_id = pe.cl_id')
        ->get()->getResultArray();
    }

    public function getId($id){
        return $this->db->table('pedidos pe')
        ->where('pe.pe_id',$id)
        ->where('pe.pe_estado',1)
        ->join('clientes cl','cl.cl_id = pe.cl_id')
        ->get()->getResultArray();
    }

}