<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ProduccionInventarioModel;
use App\Models\UsuariosModel;

class Produccioninventario extends Controller
{
    public function index()
    {
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new UsuariosModel();
        $usuarios = $model->where('usu_estado', 1)->findAll();
        foreach ($usuarios as $key => $value) {
            if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
                if ($request->getHeader('Authorization') == 'Authorization: Basic ' . base64_encode($value['token_usuario'] . ':' . $value['token_contrasena'])) {
                    $model = new ProduccionInventarioModel();
                    $ProduInv = $model->getProduInven();
                    if (!empty($ProduInv)) {
                        $data = array(
                            "Status" => 200,
                            "Total de registros" => count($ProduInv),
                            "Detalle" => $ProduInv
                        );
                    } else {
                        $data = array(
                            "Status" => 404,
                            "Total de registros" => 0,
                            "Detalle" => "No hay registros"
                        );
                    }
                    return json_encode($data, true);
                } else {
                    $data = array(
                        "Status" => 404,
                        "Detalles" => "El token es incorrecto"
                    );
                }
            } else {
                $data = array(
                    "Status" => 404,
                    "Detalles" => "No posee autorización"
                );
            }
        }
        return json_encode($data, true);
    }
    public function show($id)
    {
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new UsuariosModel();
        $Usuario = $model->where('usu_estado', 1)->findAll();
        foreach ($Usuario as $key => $value) {
            if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
                if ($request->getHeader('Authorization') == 'Authorization: Basic ' . base64_encode($value['token_usuario'] . ':' . $value['token_contrasena'])) {
                    $model = new ProduccionInventarioModel();
                    $ProduInv = $model->getId($id);
                    if (!empty($ProduInv)) {
                        $data = array(
                            "Status" => 200, "Detalle" => $ProduInv
                        );
                    } else {
                        $data = array(
                            "Status" => 404, "Detalle" => "No hay registros"
                        );
                    }
                    return json_encode($data, true);
                } else {
                    $data = array(
                        "Status" => 404,
                        "Detalles" => "El token es incorrecto"
                    );
                }
            } else {
                $data = array(
                    "Status" => 404,
                    "Detalles" => "No posee autorización"
                );
            }
        }
        return json_encode($data, true);
    }
    public function create()
    {
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new UsuariosModel();
        $Usuario = $model->where('usu_estado', 1)->findAll();
        //var_dump($Usuario); die; 
        foreach ($Usuario as $key => $value) {
            if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
                if ($request->getHeader('Authorization') == 'Authorization: Basic ' . base64_encode($value['token_usuario'] . ':' . $value['token_contrasena'])) {
                    $datos = array(
                        "inv_id" => $request->getVar("inv_id"),
                        "produ_id" => $request->getVar("produ_id"),
                        "produinv_cantidad" => $request->getVar("produinv_cantidad")
                    );

                    if (!empty($datos)) {
                        $validation->setRules([
                            "inv_id" => 'required',
                            "produ_id" => 'required',
                            "produinv_cantidad" => 'required'
                        ]);

                        $validation->withRequest($this->request)->run();
                        if ($validation->getErrors()) {
                            $errors = $validation->getErrors();
                            $data = array("Status" => 404, "Detalle" => $errors);
                            return json_encode($data, true);
                        } else {
                            $datos = array(
                                "inv_id" => $datos["inv_id"],
                                "produ_id" => $datos["produ_id"],
                                "produinv_cantidad" => $datos["produinv_cantidad"]
                            );


                            $model = new ProduccionInventarioModel();
                            $ProduInv = $model->insert($datos);
                            $data = array(
                                "Status" => 200,
                                "Detalle" => "Registro existoso"
                            );
                            return json_encode($data, true);
                        }
                    } else {
                        $data = array(
                            "Status" => 404,
                            "Detalle" => "Registro con errores"
                        );
                        return json_encode($data, true);
                    }
                } else {
                    $data = array(
                        "Status" => 404,
                        "Detalles" => "El token es incorrecto"
                    );
                }
            } else {
                $data = array(
                    "Status" => 404,
                    "Detalles" => "No posee autorización"
                );
            }
        }
        return json_encode($data, true);
    }
    public function update($id)
    {
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new UsuariosModel();
        $Usuario = $model->where('usu_estado', 1)->findAll();
        foreach ($Usuario as $key => $value) {
            if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
                if ($request->getHeader('Authorization') == 'Authorization: Basic ' . base64_encode($value['token_usuario'] . ':' . $value['token_contrasena'])) {

                    $datos = $this->request->getRawInput();

                    if (!empty($datos)) {
                        $validation->setRules([
                            "inv_id" => 'required',
                            "produ_id" => 'required',
                            "produinv_cantidad" => 'required'
                        ]);


                        $validation->withRequest($this->request)->run();
                        if ($validation->getErrors()) {
                            $errors = $validation->getErrors();
                            $data = array("Status" => 404, "Detalle" => $errors);
                            return json_encode($data, true);
                        } else {
                            $model = new ProduccionInventarioModel();
                            $ProduInv = $model->find($id);
                            if (is_null($ProduInv)) {
                                $data = array(
                                    "Status" => 404,
                                    "Detalles" => "Registro no existe"
                                );
                                return json_encode($data, true);
                            } else {
                                $datos = array(
                                    "inv_id" => $datos["inv_id"],
                                    "produ_id" => $datos["produ_id"],
                                    "produinv_cantidad" => $datos["produinv_cantidad"]
                                );

                                $model = new ProduccionInventarioModel();
                                $ProduInv = $model->update($id, $datos);
                                $data = array(
                                    "Status" => 200,
                                    "Detalles" => "Datos actualizados"
                                );
                                return json_encode($data, true);
                            }
                        }
                    } else {
                        $data = array(
                            "Status" => 404,
                            "Detalle" => "Registro con errores"
                        );
                        return json_encode($data, true);
                    }
                } else {
                    $data = array(
                        "Status" => 404,
                        "Detalles" => "El token es incorrecto"
                    );
                }
            } else {
                $data = array(
                    "Status" => 404,
                    "Detalles" => "No posee autorización"
                );
            }
        }
        return json_encode($data, true);
    }
    public function delete($id)
    {
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new UsuariosModel();
        $Usuario = $model->where('usu_estado', 1)->findAll();

        foreach ($Usuario as $key => $value) {
            if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
                if ($request->getHeader('Authorization') == 'Authorization: Basic ' . base64_encode($value['token_usuario'] . ':' . $value['token_contrasena'])) {
                    $model = new ProduccionInventarioModel();
                    $ProduInv = $model->where('produinv_estado', 1)->find($id);
                    if (!empty($ProduInv)) {
                        $datos = array('produinv_estado' => 0);
                        $ProduInv = $model->update($id, $datos);
                        $data = array(
                            "Status" => 200,
                            "Detalle" => "Se ha eliminado el registro"
                        );
                    } else {
                        $data = array(
                            "Status" => 404,
                            "Detalle" => "No hay registros"
                        );
                    }
                    return json_encode($data, true);
                } else {
                    $data = array(
                        "Status" => 404,
                        "Detalles" => "El token es incorrecto"
                    );
                }
            } else {
                $data = array(
                    "Status" => 404,
                    "Detalles" => "No posee autorización"
                );
            }
        }
        return json_encode($data, true);
    }
}
