<?php

namespace PAGE\DemoBundle\Repository;


class Datos
{
	private function getJson(){
		$json = file_get_contents("../src/PAGE/DemoBundle/Repository/datos.json");
		$datos = json_decode($json, true);
		return $datos; 
	}

	public function getRegiones(){
		$datos = $this->getJson();
		return $datos["region"]; 
	}

	public function getComunas($region){
		$datos = $this->getJson();
		return $datos["comuna"][$region]; 
	}

	public function getPais(){
		$datos = $this->getJson();
		return $datos["pais"]; 
	}

	public function getSexo(){
		$datos = $this->getJson();
		return $datos["sexo"]; 
	}

	public function getJornada(){
		$datos = $this->getJson();
		return $datos["jornada"]; 
	}

	public function getModalidad(){
		$datos = $this->getJson();
		return $datos["modalidad"]; 
	}

	public function getRegimen(){
		$datos = $this->getJson();
		return $datos["regimen"]; 
	}

	public function getGrupo(){
		$datos = $this->getJson();
		return $datos["grupo"]; 
	}

	public function getFuncion(){
		$datos = $this->getJson();
		return $datos["funcion"]; 
	}

	public function getNivel(){
		$datos = $this->getJson();
		return $datos["nivel"]; 
	}

	public function getEtnia(){
		$datos = $this->getJson();
		return $datos["etnia"]; 
	}

	public function getDocumentos(){
		$datos = $this->getJson();
		return $datos["documentos"]; 
	}

	public function getProgramas(){
		$datos = $this->getJson();
		return $datos["programas"]; 
	}

	public function getParentesco(){
		$datos = $this->getJson();
		return $datos["parentesco"]; 
	}

	public function getPrioridad(){
		$datos = $this->getJson();
		return $datos["prioridad"]; 
	}

	public function getEscolaridad(){
		$datos = $this->getJson();
		return $datos["escolaridad"]; 
	}

	public function getBasico(){
		$datos = $this->getJson();
		return $datos["basico"]; 
	}

	public function getReforzamiento(){
		$datos = $this->getJson();
		return $datos["reforzamiento"]; 
	}

	public function getTaller(){
		$datos = $this->getJson();
		return $datos["taller"]; 
	}

	public function getCursos(){
		$datos = $this->getJson();
		return $datos["cursos"]; 
	}

	public function getIndices(){
		$datos = $this->getJson();
		return $datos["indices"]; 
	}

	public function getAsignaturas(){
		$datos = $this->getJson();
		return $datos["asignaturas"]; 
	}

	public function getSistema(){
		$datos = $this->getJson();
		return $datos["sistema"]; 
	}

	public function getMomento(){
		$datos = $this->getJson();
		return $datos["momento"]; 
	}

	public function getEvaluador(){
		$datos = $this->getJson();
		return $datos["evaluador"]; 
	}

	public function getEvalua(){
		$datos = $this->getJson();
		return $datos["evalua"]; 
	}

	public function getEvaluacionD(){
		$datos = $this->getJson();
		return $datos["evaluacionD"]; 
	}

	public function getFinalidad(){
		$datos = $this->getJson();
		return $datos["finalidad"]; 
	}

	public function getInstrumento(){
		$datos = $this->getJson();
		return $datos["instrumento"]; 
	}

	public function getAprendizaje(){
		$datos = $this->getJson();
		return $datos["aprendizaje"]; 
	}

	public function getMotivos(){
		$datos = $this->getJson();
		return $datos["motivos"]; 
	}

	public function getUnidades(){
		$datos = $this->getJson();
		return $datos["unidades"]; 
	}

	public function getObjetivos(){
		$datos = $this->getJson();
		return $datos["objetivos"]; 
	}
}