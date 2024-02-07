<?php

class Encuesta
{
    private $id;
    private $created;
    private $respuestas;

    public function __construct()
    {}

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function setCreated($date)
    {
        $this->created = $date;
    }

    public function getRespuestas()
    {
        return $this->respuestas;
    }

    public function setRespuestas($respuestas)
    {
        $this->respuestas = $respuestas;
    }

}