<?php
namespace App\Models;
use CodeIgniter\Model;
class ClientesModel extends Model{
    protected $table = 'clientes';
    protected $primaryKey = 'cl_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'cl_nombre', 'cl_apellido', 'cl_documento', 'td_id', 'cl_telefono', 'cl_email', 'cl_estado'
    ];

    public function getClientes(){
        return $this->db->table('clientes cl')
        ->where('cl.cl_estado',1)
        ->join('tipo_documento tido','tido.td_id = cl.td_id')
        ->get()->getResultArray();
    }

    public function getId($id){
        return $this->db->table('clientes cl')
        ->where('cl.cl_id', $id)
        ->where('cl.cl_estado',1)
        ->join('tipo_documento tido','tido.td_id = cl.td_id')
        ->get()->getResultArray();
    }


}