<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\ProductosModel;
use App\Models\UsuariosModel;

class Productos extends Controller{
    public function index(){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new UsuariosModel();
        $usuarios = $model->where('usu_estado', 1)->findAll();
        foreach($usuarios as $key=>$value){
            if(array_key_exists('Authorization',$headers) && !empty($headers['Authorization'])){
                if($request->getHeader('Authorization')=='Authorization: Basic '.base64_encode($value['token_usuario'].':'.$value['token_contrasena'])){
                    $model = new ProductosModel();
                    $Productos = $model->getProductos();
                    if(!empty($Productos)){
                        $data = array(
                            "Status"=>200,
                            "Total de registros"=>count($Productos), 
                            "Detalle"=>$Productos);
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
                    $model = new ProductosModel();
                    $Productos = $model->getId($id);
                    if(!empty($Productos)){
                        $data = array(  
                            "Status"=>200, "Detalle"=>$Productos);
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
                        "pro_nombre" => $request->getVar("pro_nombre"),
                        "pro_descripcion" => $request->getVar("pro_descripcion"),
                        "tpro_id" => $request->getVar("tpro_id"),
                        "pro_marca" => $request->getVar("pro_marca"),
                        "pro_imagen" => $request->getFile("pro_imagen")
                    );
                    $logo = $datos['pro_imagen'];
                    if (!empty($datos)) {
                        $validation->setRules([
                            "pro_nombre" => 'required',
                            "pro_descripcion" => 'required',
                            "tpro_id" => 'required',
                            "pro_marca" => 'required'
                        ]);

                        $validation->withRequest($this->request)->run();
                        if ($validation->getErrors()) {
                            $errors = $validation->getErrors();
                            $data = array("Status" => 404, "Detalle" => $errors);
                            return json_encode($data, true);
                        } else {
                            $newName = $logo->getRandomName();
                            $datos = array(
                                "pro_nombre" => $datos["pro_nombre"],
                                "pro_descripcion" => $datos["pro_descripcion"],
                                "tpro_id" => $datos["tpro_id"],
                                "pro_marca" => $datos["pro_marca"],
                                "pro_imagen" => $newName
                            );

                            $model = new ProductosModel();
                            $Productos = $model->insert($datos);
                            $data = array(
                                "Status" => 200,
                                "Detalle" => "Registro existoso"
                            );

                            if ($logo->isValid() && !$logo->hasMoved()) {
                                // Directorio de destino
                                $uploadPath = './public/'."productos";

                                // Generar un nombre de archivo único

                                // Mover el archivo al directorio de destino
                                $logo->move($uploadPath, $newName);

                                // Enviar una respuesta JSON con la ubicación del archivo
                                $response = [
                                        'status' => 'success',
                                        'message' => 'Archivo subido correctamente',
                                        'logo$logo_path' => base_url($uploadPath . "/" . $newName)
                                    ];

                                $up = $this->response->setJSON($response);
                            } else {
                                // Si hay un error en la carga del archivo
                                $response = [
                                        'status' => 'error',
                                        'message' => $logo->getErrorString()
                                    ];
                                $up =  $this->response->setJSON($response);
                            }
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
                                "pro_nombre" => 'required',
                                "pro_descripcion" => 'required',
                                "tpro_id" => 'required',
                                "pro_marca" => 'required',
                                "pro_imagen" => 'required'
                            ]);
                            
                            $validation->withRequest($this->request)->run();
                            if($validation->getErrors()){
                                $errors = $validation->getErrors();
                                $data = array("Status"=>404, "Detalle"=>$errors);
                                return json_encode($data, true);
                            }
                            else{
                                $model = new ProductosModel();
                                $Productos = $model->find($id);
                                if(is_null($Productos)){
                                    $data = array(
                                        "Status"=>404,
                                        "Detalles"=>"Registro no existe"
                                    );
                                    return json_encode($data, true);
                                }
                                else{
                                    $datos = array(
                                        "pro_nombre" => $datos["pro_nombre"],
                                        "pro_descripcion" => $datos["pro_descripcion"],
                                        "tpro_id" => $datos["tpro_id"],
                                        "pro_marca" => $datos["pro_marca"],
                                        "pro_imagen" => $datos["pro_imagen"]
                                    );
                                    
                                    $model = new ProductosModel();
                                    $Productos = $model->update($id, $datos);
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
                    $model = new ProductosModel();
                    $Productos = $model->where('pro_estado',1)->find($id);
                    if(!empty($Productos)){
                        $datos = array("pro_estado"=>0);
                        $Productos = $model->update($id, $datos);
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