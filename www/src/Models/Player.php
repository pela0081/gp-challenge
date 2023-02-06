<?php

namespace App\Models;

class Player extends BaseModel {

    public function getOne($id = null)
    {
        if(!$id) {
            return null;
        }

        $stmt = $this->db->prepare('SELECT * FROM jugadores WHERE id = :id');
        $stmt->execute(['id' => $id]);

        return $stmt->fetch();
    }

    public function getAll()
    {
        $stmt = $this->db->prepare('SELECT * FROM jugadores');
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function insert($values)
    {
        $player = false;

        $stmt = $this->db->prepare('INSERT INTO jugadores (nombre, tipo, habilidad, fuerza, velocidad, reaccion) VALUES (:nombre, :tipo, :habilidad, :fuerza, :velocidad, :reaccion)');

        try {
            $this->db->beginTransaction();
            $stmt->execute([
                ':nombre' => $values['nombre'],
                ':tipo' => $values['tipo'],
                ':habilidad' => $values['habilidad'],
                ':fuerza' => $values['fuerza'],
                ':velocidad' => $values['velocidad'],
                ':reaccion' => $values['reaccion'],
            ]);
            $id = $this->db->lastInsertId();
            $this->db->commit();
            if($id) {
                $player = $this->getOne($id);
            }
        }catch (\Exception $e){
            $this->db->rollback();
            //throw $e;
        }

        return $player;
    }
}