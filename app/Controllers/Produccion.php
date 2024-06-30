<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\InventarioModel;
use App\Models\UsuariosModel;

class Produccion extends Controller{
    public function index(){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new UsuariosModel();
        $usuarios = $model->where('usu_estado', 1)->findAll();
        foreach($usuarios as $key=>$value){
            if(array_key_exists('Authorization',$headers) && !empty($headers['Authorization'])){
                if($request->getHeader('Authorization')=='Authorization: Basic '.base64_encode($value['token_usuario'].':'.$value['token_contrasena'])){
                    $model = new InventarioModel();
                    $Pedidos = $model->getInventario();
                    if(!empty($Pedidos)){
                        $data = array(
                            "Status"=>200,
                            "Total de registros"=>count($Pedidos), 
                            "Detalle"=>$Pedidos);
                    }
                    else{
                        $data = array(
                            "Status"=>404,
                            "Total de registros"=>0, 
                            "Detalle"=>"No hay registros");
                    }
                    return json_encode($data, true);
                }
                else{
                    $data = array(
                        "Status"=>404,
                        "Detalles"=>"El token es incorrecto"
                    );
                }
           }
            else{
                $data = array(
                    "Status"=>404,
                    "Detalles"=>"No posee autorización"
                );
            }
      }
        return json_encode($data, true);        
    }
    public function show($id){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new UsuariosModel();
        $Usuario = $model->where('usu_estado', 1)->findAll();
        foreach($Usuario as $key=>$value){
            if(array_key_exists('Authorization',$headers) && !empty($headers['Authorization'])){
                if($request->getHeader('Authorization')=='Authorization: Basic '.base64_encode($value['token_usuario'].':'.$value['token_contrasena'])){
                    $model = new InventarioModel();
                    $Pedidos = $model->getId($id);
                    if(!empty($Pedidos)){
                        $data = array(  
                            "Status"=>200, "Detalle"=>$Pedidos);
                    }
                    else{
                        $data = array(
                            "Status"=>404, "Detalle"=>"No hay registros");
                    }
                    return json_encode($data, true);
                }
                else{
                    $data = array(
                        "Status"=>404,
                        "Detalles"=>"El token es incorrecto"
                    );
                }
            }
            else{
                $data = array(
                    "Status"=>404,
                    "Detalles"=>"No posee autorización"
                );
            }
        }
        return json_encode($data, true);
    }
    public function create(){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new UsuariosModel();
        $Usuario = $model->where('usu_estado', 1)->findAll();
        //var_dump($Usuario); die; 
        foreach($Usuario as $key=>$value){
            if(array_key_exists('Authorization',$headers) && !empty($headers['Authorization'])){
                if($request->getHeader('Authorization')=='Authorization: Basic '.base64_encode($value['token_usuario'].':'.$value['token_contrasena'])){
                    $datos = array(
                        "pro_id" => $request->getVar("pro_id"),
                        "inv_cantidad_total" => $request->getVar("inv_cantidad_total"),
                        "inv_cantidad_disponible" => $request->getVar("inv_cantidad_disponible"),
                        "inv_fecha_adquisicion" => $request->getVar("inv_fecha_adquisicion")
                    );                    
                    
                    if(!empty($datos)){
                        $validation->setRules([
                            "pro_id" => 'required',
                            "inv_cantidad_total" => 'required',
                            "inv_cantidad_disponible" => 'required',
                            "inv_fecha_adquisicion" => 'required'
                        ]);                        
                        
                        $validation->withRequest($this->request)->run();
                        if($validation->getErrors()){
                            $errors = $validation->getErrors();
                            $data = array("Status"=>404, "Detalle"=>$errors);
                            return json_encode($data, true);
                        }
                        else{
                            $datos = array(
                                "pro_id" => $datos["pro_id"],
                                "inv_cantidad_total" => $datos["inv_cantidad_total"],
                                "inv_cantidad_disponible" => $datos["inv_cantidad_disponible"],
                                "inv_fecha_adquisicion" => $datos["inv_fecha_adquisicion"]
                            );                                                        
                            
                            $model = new InventarioModel();
                            $Pedidos = $model->insert($datos);
                            $data = array(
                                "Status"=>200,
                                "Detalle"=>"Registro existoso"
                            );
                            return json_encode($data, true);
                        }
                    }
                    else{
                        $data = array(
                            "Status"=>404,
                            "Detalle"=>"Registro con errores"
                        );
                        return json_encode($data, true);
                    }
                }
                else{
                    $data = array(
                        "Status"=>404,
                        "Detalles"=>"El token es incorrecto"
                    );
                }
            }
            else{
                $data = array(
                    "Status"=>404,
                    "Detalles"=>"No posee autorización"
                );
            }
        }
        return json_encode($data, true);
    }
    public function update($id){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new UsuariosModel();
        $Usuario = $model->where('usu_estado', 1)->findAll();
        foreach($Usuario as $key=>$value){
            if(array_key_exists('Authorization',$headers) && !empty($headers['Authorization'])){
                if($request->getHeader('Authorization')=='Authorization: Basic '.base64_encode($value['token_usuario'].':'.$value['token_contrasena'])){
                        
                        $datos = $this->request->getRawInput();
                        
                        if(!empty($datos)){
                            $validation->setRules([
                                "pro_id" => 'required',
                                "inv_cantidad_total" => 'required',
                                "inv_cantidad_disponible" => 'required',
                                "inv_fecha_adquisicion" => 'required'
                            ]);
                            
                            
                            $validation->withRequest($this->request)->run();
                            if($validation->getErrors()){
                                $errors = $validation->getErrors();
                                $data = array("Status"=>404, "Detalle"=>$errors);
                                return json_encode($data, true);
                            }
                            else{
                                $model = new InventarioModel();
                                $Pedidos = $model->find($id);
                                if(is_null($Pedidos)){
                                    $data = array(
                                        "Status"=>404,
                                        "Detalles"=>"Registro no existe"
                                    );
                                    return json_encode($data, true);
                                }
                                else{
                                    $datos = array(
                                        "pro_id" => $datos["pro_id"],
                                        "inv_cantidad_total" => $datos["inv_cantidad_total"],
                                        "inv_cantidad_disponible" => $datos["inv_cantidad_disponible"],
                                        "inv_fecha_adquisicion" => $datos["inv_fecha_adquisicion"]
                                    );
                                    
                                    
                                    $model = new InventarioModel();
                                    $Pedidos = $model->update($id, $datos);
                                    $data = array(
                                        "Status"=>200,
                                        "Detalles"=>"Datos actualizados"
                                    );
                                    return json_encode($data, true);
                                }
                            }
                        }
                        else{
                            $data = array(
                                "Status"=>404,
                                "Detalle"=>"Registro con errores"
                            );
                            return json_encode($data, true);
                        }
                }
                else{
                    $data = array(
                        "Status"=>404,
                        "Detalles"=>"El token es incorrecto"
                    );
                }
            }
            else{
                $data = array(
                    "Status"=>404,
                    "Detalles"=>"No posee autorización"
                );
            }
        }
        return json_encode($data, true);
    }
    public function delete($id){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new UsuariosModel();
        $Usuario = $model->where('usu_estado', 1)->findAll(); 
        foreach($Usuario as $key=>$value){
            if(array_key_exists('Authorization',$headers) && !empty($headers['Authorization'])){
                if($request->getHeader('Authorization')=='Authorization: Basic '.base64_encode($value['token_usuario'].':'.$value['token_contrasena'])){
                    $model = new InventarioModel();
                    $Pedidos = $model->where('inv_estado',1)->find($id);
                    if(!empty($Pedidos)){
                        $datos = array('inv_estado'=>0);
                        $Pedidos = $model->update($id, $datos);
                        $data = array(
                            "Status"=>200,
                            "Detalle"=>"Se ha eliminado el registro"
                        );
                    }
                    else{
                        $data = array(
                            "Status"=>404, 
                            "Detalle"=>"No hay registros");
                    }
                    return json_encode($data, true);
                }
                else{
                    $data = array(
                        "Status"=>404,
                        "Detalles"=>"El token es incorrecto"
                    );
                }
            }
            else{
                $data = array(
                    "Status"=>404,
                    "Detalles"=>"No posee autorización"
                );
            }
        }
        return json_encode($data, true);
    }
}