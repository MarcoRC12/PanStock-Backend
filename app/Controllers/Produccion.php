<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\ProduccionModel;
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
                    $model = new ProduccionModel();
                    $Produccion = $model->getProduccion();
                    if(!empty($Produccion)){
                        $data = array(
                            "Status"=>200,
                            "Total de registros"=>count($Produccion), 
                            "Detalle"=>$Produccion);
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
                    $model = new ProduccionModel();
                    $Produccion = $model->getId($id);
                    if(!empty($Produccion)){
                        $data = array(  
                            "Status"=>200, "Detalle"=>$Produccion);
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
                        "produ_horainicio" => $request->getVar("produ_horainicio"),
                        "produ_horafin" => $request->getVar("produ_horafin"),
                        "produ_fecha" => $request->getVar("produ_fecha"),
                        "produ_terminado" => $request->getVar("produ_terminado"),
                        "produ_cantidadproducida" => $request->getVar("produ_cantidadproducida"),
                    );                    
                    
                    if(!empty($datos)){
                        $validation->setRules([
                            "pro_id" => 'required',
                            "produ_horainicio" => 'required',
                            "produ_horafin" => 'required',
                            "produ_fecha" => 'required',
                            "produ_terminado" => 'required',
                            "produ_cantidadproducida" => 'required'
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
                                "produ_horainicio" => $datos["produ_horainicio"],
                                "produ_horafin" => $datos["produ_horafin"],
                                "produ_fecha" => $datos["produ_fecha"],
                                "produ_terminado" => $datos["produ_terminado"],
                                "produ_cantidadproducida" => $datos["produ_cantidadproducida"]
                            );                                                        
                            
                            $model = new ProduccionModel();
                            $Produccion = $model->insert($datos);
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
                                "produ_horainicio" => 'required',
                                "produ_horafin" => 'required',
                                "produ_fecha" => 'required',
                                "produ_terminado" => 'required',
                                "produ_cantidadproducida" => 'required'
                            ]);  
                            
                            
                            $validation->withRequest($this->request)->run();
                            if($validation->getErrors()){
                                $errors = $validation->getErrors();
                                $data = array("Status"=>404, "Detalle"=>$errors);
                                return json_encode($data, true);
                            }
                            else{
                                $model = new ProduccionModel();
                                $Produccion = $model->find($id);
                                if(is_null($Produccion)){
                                    $data = array(
                                        "Status"=>404,
                                        "Detalles"=>"Registro no existe"
                                    );
                                    return json_encode($data, true);
                                }
                                else{
                                    $datos = array(
                                        "pro_id" => $datos["pro_id"],
                                        "produ_horainicio" => $datos["produ_horainicio"],
                                        "produ_horafin" => $datos["produ_horafin"],
                                        "produ_fecha" => $datos["produ_fecha"],
                                        "produ_terminado" => $datos["produ_terminado"],
                                        "produ_cantidadproducida" => $datos["produ_cantidadproducida"]
                                    ); 
                                    
                                    
                                    $model = new ProduccionModel();
                                    $Produccion = $model->update($id, $datos);
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
                    $model = new ProduccionModel();
                    $Produccion = $model->where('produ_estado',1)->find($id);
                    if(!empty($Produccion)){
                        $datos = array('produ_estado'=>0);
                        $Produccion = $model->update($id, $datos);
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