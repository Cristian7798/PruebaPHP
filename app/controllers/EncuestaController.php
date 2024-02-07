<?php

include_once "./app/models/DAO/EncuestaDAO.php";
include_once "./app/models/entities/Encuesta.php";

class EncuestaController
{
    private $encuestaDAO;

    public function __construct() 
    {
        $this->encuestaDAO = new EncuestaDAO();
    }

    public function default()
    {
        try {
            throw new Exception("Recurso no encontrado ...");
        } catch (Exception $ex) {
            echo json_encode([
                'error' => true,
                'message' => 'Error: ' . $ex->getMessage()
            ]);
        }
    }

    public function getEncuestas()
    {
        try {
            echo $this->encuestaDAO->getEncuestas();
        } catch (Exception $ex) {
            echo json_encode([
                'error' => true,
                'message' => 'Error: ' . $ex->getMessage()
            ]);
        }
    }

    public function getPreguntasByEncuesta()
    {
        try {
            $id = isset($_GET['id']) ? $_GET['id'] : '0';
            if ($id == '0') {
                throw new Exception("Ingrese un parametro válido ...");
            }
            echo $this->encuestaDAO->getPreguntasByEncuesta($id);
        } catch (Exception $ex) {
            echo json_encode([
                'error' => true,
                'message' => 'Error: ' . $ex->getMessage()
            ]);
        }
    }

    public function save()
    {
        try {
            $encuesta = new Encuesta();
            $encuesta->setId($_POST['id_formulario'] ?? 0);
            $encuesta->setRespuestas($_POST['preguntas'] ?? []);
            $encuesta->setCreated(date('y-m-d'));

            if ($encuesta->getId() == 0 || count($encuesta->getRespuestas()) == 0) {
                throw new Exception("Complete el formulario por favor ...");
            }

            $response = $this->encuestaDAO->saveEncuesta($encuesta);
            echo $response;
        } catch (Exception $ex) {
            echo json_encode([
                'error' => true,
                'message' => 'Error: ' . $ex->getMessage()
            ]);
        }
    }

    public function getEstadisticas()
    {
        try {
            $response = $this->encuestaDAO->getEstadisticas();
            return $response;
        } catch (Exception $ex) {
            return json_encode([
                'error' => true,
                'data' => [],
                'message' => 'Error: ' . $ex->getMessage()
            ]);
        }
    }

    public function getEstadisticasAjax()
    {
        try {
            $response = $this->encuestaDAO->getEstadisticas();
            echo $response;
        } catch (Exception $ex) {
            echo json_encode([
                'error' => true,
                'data' => [],
                'message' => 'Error: ' . $ex->getMessage()
            ]);
        }
    }
}