<?php
namespace App\Models;
use CodeIgniter\Model;
class UsuariosModel extends Model{
    protected $table = 'usuarios';
    protected $primaryKey = 'usu_id ';
    protected $returnType = 'array';
    protected $allowedFields = [
        'usu_nombre', 'usu_usuario', 'usu_contrasena', 'token_usuario', 'token_contrasena', 'usu_estado'
    ];

}