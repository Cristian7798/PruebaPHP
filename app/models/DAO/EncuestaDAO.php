<?php

include_once "./config/Conection.php";
include_once "./app/models/entities/Encuesta.php";

class EncuestaDAO
{
    private $conection;

    public function __construct() 
    {
        $this->conection = Conection::getConexion();
    }

    public function getEncuestas()
    {
        try {
            $sql = $this->conection->prepare("select * from encuestas");
            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
            return json_encode([
                'error' => false,
                'data' => $result
            ]);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function getPreguntasByEncuesta($id)
    {
        try {
            $sql = $this->conection->prepare("select * from preguntas_encuesta where codigo_encuesta = ? order by num_pregunta asc");
            $sql->execute([$id]);
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
            return json_encode([
                'error' => false,
                'data' => $result
            ]);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function saveEncuesta(Encuesta $encuesta)
    {
        try {
            // Insert Headers
            $insert_header = $this->conection->prepare("insert into respuesta_encuesta (codigo_encuesta, fecha_respuesta) values (?, ?)");
            $parametros = [
                $encuesta->getId(),
                $encuesta->getCreated()
            ];
            $insert_header->execute($parametros);
            $insert_header->rowCount();
            $id_header = $this->conection->lastInsertId();

            // Insert Details
            foreach ($encuesta->getRespuestas() as $respuesta) {
                $arr_respuesta = explode('-', $respuesta);
                $num_pregunta = $arr_respuesta[0];
                $valor_pregunta = intval($arr_respuesta[1]) * 4;
                $insert_details = $this->conection->prepare("insert into respuesta_pregunta (num_pregunta, codigo_encuesta, califica, codigo_respuesta) values (?, ?, ?, ?)");
                $params_detail = [
                    $num_pregunta,
                    $encuesta->getId(),
                    $valor_pregunta,
                    $id_header
                ];
                $insert_details->execute($params_detail);
                $insert_details->rowCount();
            }
            return json_encode([
                'error' => false,
                'message' => 'Guardado con exito ...'
            ]);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function getEstadisticas()
    {
        try {
            $encuestas = json_decode($this->getEncuestas());
            $encuestas = $encuestas->data;
            foreach ($encuestas as $encuesta) {
                $sql_count = $this->conection->prepare("select count(*) as cantidad from encuestas e inner join respuesta_encuesta r on r.codigo_encuesta = e.codigo_encuesta where e.codigo_encuesta = ? GROUP BY e.codigo_encuesta");
                $sql_promedio = $this->conection->prepare("select AVG(rp.califica) as promedio from respuesta_pregunta rp where rp.codigo_encuesta = ? group by rp.codigo_encuesta");
                $params = [$encuesta->codigo_encuesta];
                $sql_count->execute($params);
                $sql_promedio->execute($params);
                $count = $sql_count->fetchAll(PDO::FETCH_ASSOC);
                $promedio = $sql_promedio->fetchAll(PDO::FETCH_ASSOC);
                $encuesta->count = count($count) > 0 ? $count[0]['cantidad'] : 0;
                $encuesta->promedio = count($promedio) > 0 ? floatval($promedio[0]['promedio']) : 0;
            }

            return json_encode([
                'error' => false,
                'data' => $encuestas
            ]);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}