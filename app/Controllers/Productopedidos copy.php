<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\ProductoPedidosModel;
use App\Models\UsuariosModel;

class Productopedidos extends Controller{
    public function index(){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new UsuariosModel();
        $usuarios = $model->where('usu_estado', 1)->findAll();
        foreach($usuarios as $key=>$value){
            if(array_key_exists('Authorization',$headers) && !empty($headers['Authorization'])){
                if($request->getHeader('Authorization')=='Authorization: Basic '.base64_encode($value['token_usuario'].':'.$value['token_contrasena'])){
                    $model = new ProductoPedidosModel();
                    $ProductoPedidos = $model->getProductoPedidos();
                    if(!empty($ProductoPedidos)){
                        $data = array(
                            "Status"=>200,
                            "Total de registros"=>count($ProductoPedidos), 
                            "Detalle"=>$ProductoPedidos);
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
                    $model = new ProductoPedidosModel();
                    $ProductoPedidos = $model->getId($id);
                    if(!empty($ProductoPedidos)){
                        $data = array(  
                            "Status"=>200, "Detalle"=>$ProductoPedidos);
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
                        "pe_id" => $request->getVar("pe_id"),
                        "prope_numorden" => $request->getVar("prope_numorden"),
                        "prope_descripcion" => $request->getVar("prope_descripcion"),
                        "prope_cantidad" => $request->getVar("prope_cantidad"),
                        "prope_entregado" => $request->getVar("prope_entregado")
                    );                                       
                    
                    if(!empty($datos)){
                        $validation->setRules([
                            "pro_id" => 'required',
                            "pe_id" => 'required',
                            "prope_numorden" => 'required',
                            "prope_descripcion" => 'required',
                            "prope_cantidad" => 'required',
                            "prope_entregado" => 'required'
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
                                "pe_id" => $datos["pe_id"],
                                "prope_numorden" => $datos["prope_numorden"],
                                "prope_descripcion" => $datos["prope_descripcion"],
                                "prope_cantidad" => $datos["prope_cantidad"],
                                "prope_entregado" => $datos["prope_entregado"]
                            );                            
                            
                            
                            $model = new ProductoPedidosModel();
                            $ProductoPedidos = $model->insert($datos);
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
                                "pe_id" => 'required',
                                "prope_numorden" => 'required',
                                "prope_descripcion" => 'required',
                                "prope_cantidad" => 'required',
                                "prope_entregado" => 'required'
                            ]);                            
                            
                            
                            $validation->withRequest($this->request)->run();
                            if($validation->getErrors()){
                                $errors = $validation->getErrors();
                                $data = array("Status"=>404, "Detalle"=>$errors);
                                return json_encode($data, true);
                            }
                            else{
                                $model = new ProductoPedidosModel();
                                $ProductoPedidos = $model->find($id);
                                if(is_null($ProductoPedidos)){
                                    $data = array(
                                        "Status"=>404,
                                        "Detalles"=>"Registro no existe"
                                    );
                                    return json_encode($data, true);
                                }
                                else{
                                    $datos = array(
                                        "pro_id" => $datos["pro_id"],
                                        "pe_id" => $datos["pe_id"],
                                        "prope_numorden" => $datos["prope_numorden"],
                                        "prope_descripcion" => $datos["prope_descripcion"],
                                        "prope_cantidad" => $datos["prope_cantidad"],
                                        "prope_entregado" => $datos["prope_entregado"]
                                    );                                    
                                    
                                    $model = new ProductoPedidosModel();
                                    $ProductoPedidos = $model->update($id, $datos);
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
                    $model = new ProductoPedidosModel();
                    $ProductoPedidos = $model->where('prope_estado',1)->find($id);
                    if(!empty($ProductoPedidos)){
                        $datos = array('prope_estado'=>0);
                        $ProductoPedidos = $model->update($id, $datos);
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