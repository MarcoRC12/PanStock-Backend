<?php
namespace App\Controllers;
use App\Models\TiposProductosModel;
use CodeIgniter\Controller;
use App\Models\UsuariosModel;

class Tiposproductos extends Controller{
    public function index(){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new UsuariosModel();
        $usuarios = $model->where('usu_estado', 1)->findAll();
        foreach($usuarios as $key=>$value){
            if(array_key_exists('Authorization',$headers) && !empty($headers['Authorization'])){
                if($request->getHeader('Authorization')=='Authorization: Basic '.base64_encode($value['token_usuario'].':'.$value['token_contrasena'])){
                    $model = new TiposProductosModel();
                    $TipoProducto = $model->where('tpro_estado',1)->findAll();
                    if(!empty($TipoProducto)){
                        $data = array(
                            "Status"=>200,
                            "Total de registros"=>count($TipoProducto), 
                            "Detalle"=>$TipoProducto);
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
                    $model = new TiposProductosModel();
                    $TipoProducto = $model->where('tpro_estado', 1)->find($id);
                    if(!empty($TipoProducto)){
                        $data = array(  
                            "Status"=>200, "Detalle"=>$TipoProducto);
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
                        "tpro_nombre" => $request->getVar("tpro_nombre"),
                        "tpro_descripcion" => $request->getVar("tpro_descripcion")
                    );
                    
                    if(!empty($datos)){
                        $validation->setRules([
                            "tpro_nombre" => 'required',
                            "tpro_descripcion" => 'required'
                        ]);                         

                        $validation->withRequest($this->request)->run();
                        if($validation->getErrors()){
                            $errors = $validation->getErrors();
                            $data = array("Status"=>404, "Detalle"=>$errors);
                            return json_encode($data, true);
                        }
                        else{
                            $datos = array(
                                "tpro_nombre" => $datos["tpro_nombre"],
                                "tpro_descripcion" => $datos["tpro_descripcion"]
                            );   

                            $model = new TiposProductosModel();
                            $TipoProducto = $model->insert($datos);
                            $data = array(
                                "Status"=>201,
                                "Detalle"=>"Editar existoso"
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
                                "tpro_nombre" => 'required',
                                "tpro_descripcion" => 'required'
                            ]);
                            
                              
                            $validation->withRequest($this->request)->run();
                            if($validation->getErrors()){
                                $errors = $validation->getErrors();
                                $data = array("Status"=>404, "Detalle"=>$errors);
                                return json_encode($data, true);
                            }
                            else{
                                $model = new TiposProductosModel();
                                $TipoProducto = $model->find($id);
                                if(is_null($TipoProducto)){
                                    $data = array(
                                        "Status"=>404,
                                        "Detalles"=>"Registro no existe"
                                    );
                                    return json_encode($data, true);
                                }
                                else{
                                    $datos = array(
                                        "tpro_nombre" => $datos["tpro_nombre"],
                                        "tpro_descripcion" => $datos["tpro_descripcion"]
                                    );
                                    
                                    $model = new TiposProductosModel();
                                    $TipoProducto = $model->update($id, $datos);
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
                    $model = new TiposProductosModel();
                    $TipoProducto = $model->where('tpro_estado',1)->find($id);
                    if(!empty($TipoProducto)){
                        $datos = array("tpro_estado"=>0);
                        $TipoProducto = $model->update($id, $datos);
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