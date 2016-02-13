angular.module('loader',[])
.config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}')
})

.controller('load', function($scope,$http){

	$scope.ids = [];
	$scope.datos = [];
	$scope.cursos = [];
	$scope.asignaturas = [];
	$scope.unidades = [];
	$scope.objetivos = [{'id':'10','name':'Objetivo de Aprendizaje'},
	{'id':'10','name':'Objetivo de Aprendizaje de Habilidad'},
	{'id':'10','name':'Objetivo de Aprendizaje de Actitud'},
	{'id':'20','name':'Aprendizaje Esperado'},
	{'id':'20','name':'Objetivo Fundamental'},
	{'id':'20','name':'Contenido Mínimo Obligatorio'},];

	$scope.cargar = function(curso,asignatura,unidad){
		//Datos
		$http.get('../get/objetivos/'+curso+'_'+asignatura+'_'+unidad)
		.success(function(result){
			$scope.datos = result;
		})
		.error(function(error){
			console.log(error)
		})
	}

	$scope.loadId = function(id_docente,id_user){
		//idObjetivos
		$http.get('../get/objetivos_id/'+id_docente+'_'+id_user)
		.success(function(result){
			$scope.ids = result;
		})
		.error(function(error){
			console.log(error)
		})
	}

	$scope.check = function(id){
		
		exist = false;
		angular.forEach($scope.ids, function(value, key) {
		  	if(value.id == id)
		  		exist= true;
		});

		if(exist)
			return true
		else
			return false
	}
		
		//cursos
		$http.get('../get/cursos_lista')
		.success(function(result){
			$scope.cursos = result;
		})
		.error(function(error){
			console.log(error)
		})

		//asignaturas
		$http.get('../get/asignaturas_lista')
		.success(function(result){
			$scope.asignaturas = result;
		})
		.error(function(error){
			console.log(error)
		})

		//unidades
		$http.get('../get/unidades')
		.success(function(result){
			$scope.unidades = result;
		})
		.error(function(error){
			console.log(error)
		})

})