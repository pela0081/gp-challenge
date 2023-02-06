<?php

namespace App\Models;

class Torneo extends BaseModel {

    public function getOne($id = null)
    {
        if(!$id) {
            return null;
        }

        $stmt = $this->db->prepare('SELECT * FROM torneos WHERE id = :id');
        $stmt->execute(['id' => $id]);

        return $stmt->fetch();
    }

    public function getAll()
    {
        $stmt = $this->db->prepare('SELECT * FROM torneos');
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function insertTorneo($values)
    {
        $torneo = false;

        $stmt = $this->db->prepare('INSERT INTO torneos (nombre, tipo, fecha_creacion) VALUES (:nombre, :tipo, :fecha_creacion)');

        try {
            $this->db->beginTransaction();
            $stmt->execute([
                ':nombre' => $values['nombre'],
                ':tipo' => $values['tipo'],
                ':fecha_creacion' => date('Y-m-d H:i:s'),
            ]);
            $id = $this->db->lastInsertId();
            $this->db->commit();
            if($id) {
                $torneo = $this->getOne($id);
            }
        }catch (\Exception $e){
            $this->db->rollback();
            //throw $e;
        }

        return $torneo;
    }

    public function updateTorneo($torneo)
    {
        if(!$torneo->id) {
            return null;
        }

        $stmt = $this->db->prepare('UPDATE torneos SET nombre=:nombre, tipo=:tipo, ganador_id=:ganador_id, fecha_fin=:fecha_fin WHERE id=:id');

        try {
            $stmt->execute([
                ':nombre' => $torneo->nombre,
                ':tipo' => $torneo->tipo,
                ':ganador_id' => $torneo->ganador_id,
                ':fecha_fin' => $torneo->fecha_fin,
                ':id' => $torneo->id,
            ]);
        }catch (\Exception $e){
            throw $e;
        }

        return $torneo;
    }

    public function insertPartido($torneo_id, $jugador1_id, $jugador2_id, $ganador_id)
    {
        $partido = false;

        $stmt = $this->db->prepare('INSERT INTO partidos (torneo_id, jugador1_id, jugador2_id, ganador_id) VALUES (:torneo_id, :jugador1_id, :jugador2_id, :ganador_id)');

        try {
            $this->db->beginTransaction();
            $stmt->execute([
                ':torneo_id' => $torneo_id,
                ':jugador1_id' => $jugador1_id,
                ':jugador2_id' => $jugador2_id,
                ':ganador_id' => $ganador_id,
            ]);
            $id = $this->db->lastInsertId();
            $this->db->commit();
            if($id) {
                $partido = $this->getOne($id);
            }
        }catch (\Exception $e){
            $this->db->rollback();
            //throw $e;
        }

        return $partido;
    }

    public function comenzarTorneo($torneo_id, $jugadores)
    {
        $en_carrera = $jugadores;
        while(count($en_carrera) > 1) {
            $en_carrera = $this->generarRonda($torneo_id, $en_carrera);
        }

        $this->terminarTorneo($torneo_id, $en_carrera[0]);
        return $en_carrera[0];
    }

    public function generarRonda($torneo_id, $jugadores)
    {
        $en_carrera = [];
        shuffle($jugadores);
        while(count($jugadores) > 0) {
            $jugador1 = array_shift($jugadores);
            $jugador2 = array_shift($jugadores);
            $en_carrera[] = $this->crearPartido($torneo_id, $jugador1, $jugador2);
        }

        return $en_carrera;
    }

    public function crearPartido($torneo_id, $jugador1, $jugador2)
    {
        $torneo = $this->getOne($torneo_id);
        $ganador = $this->getGanadorPartido($jugador1, $jugador2, $torneo->tipo);

        $this->insertPartido($torneo_id, $jugador1, $jugador2, $ganador);

        return $ganador;
    }

    public function getGanadorPartido($jugador1_id, $jugador2_id, $tipo)
    {
        $player_model = $this->getModel('Player');
        $jugador1 = $player_model->getOne($jugador1_id);
        $jugador2 = $player_model->getOne($jugador2_id);

        $pts1 = $jugador1->habilidad * (rand(60,100)/100);
        $pts2 = $jugador2->habilidad * (rand(60,100)/100);

        if($tipo === 0) {
            $pts1 += $jugador1->fuerza * (rand(40,100)/100) + $jugador1->velocidad * (rand(40,100)/100);
            $pts2 += $jugador2->fuerza * (rand(40,100)/100) + $jugador2->velocidad * (rand(40,100)/100);
        } else {
            $pts1 += $jugador1->reaccion * (rand(40,100)/100);
            $pts2 += $jugador2->reaccion * (rand(40,100)/100);
        }

        if($pts1 > $pts2) {
            $ganador = $jugador1_id;
        } else if($pts2 > $pts1) {
            $ganador = $jugador2_id;
        } else {
            $ganador = (rand(0,100) % 2 > 0) ? $jugador1_id : $jugador2_id; // ganador aleatorio en caso de empate en pts
        }
        
        return $ganador;
    }

    public function terminarTorneo($torneo_id, $ganador_id)
    {
        $torneo = $this->getOne($torneo_id);
        $torneo->ganador_id = $ganador_id;
        $torneo->fecha_fin = date('Y-m-d H:i:s');
        $torneo = $this->updateTorneo($torneo);
    }
}