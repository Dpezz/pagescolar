angular.module('calendarios_docente',[])
.config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}')
})

.controller('calendario_docente', function($scope,$http){
	$scope.data = {};

	$scope.cursos = [];
	$scope.asignaturas = [];

	$scope.dias = [];
	$scope.bloques = [];

	$scope.id = -1;
	$scope.id_user = -1;
	$scope.name = 'default';
	$scope.title = "default";
	                
	loadData();

	$scope.nuevo = function(id,id_user){
		$scope.id = id;
		$scope.id_user = id_user;
		$scope.title = "Nueva Hora";
		$scope.data = {};
	}

	$scope.save = function(){

		$http.post('../create_horario_docente',{
			id: $scope.id,
			id_user: $scope.id_user,
			id_asignatura: $scope.asignatura.id,
			id_curso: $scope.curso.id,
			dia: $scope.dia.name,
			bloque: $scope.bloque.name,
		})
		.success(function(result){
			console.log(result)
			window.location = "";
		})
		.error(function(error){
			console.log(error)
			window.location = "";
		})
	}

	$scope.delete = function(id,name){
		if(name != -1){
			$scope.title = "Eliminar Hora";
			$scope.id = id;
			$scope.name = name;
		}else{

			$http.post('../delete_horario_docente',{
				id: $scope.id
			})
			.success(function(result){
				window.location = "";
			})
			.error(function(error){
				console.log(result)
				window.location = "";
			})
		}
	}

	function getIndex(x,list){
		var index = 0;
		angular.forEach(list, function(value, key) {
			if(value.id == x)
		  		index = key;
		});
		return index;
	}

	function loadData(){
		$http.get('../../get/cursos')
		.success(function(result){
			$scope.cursos = result;
		})
		.error(function(error){
			console.log(error)
		});

		$http.get('../../get/asignaturas')
		.success(function(result){
			$scope.asignaturas = result;
		})
		.error(function(error){
			console.log(error)
		});

		$scope.dias = [
		{name:'Lunes'},
		{name:'Martes'},
		{name:'Miércoles'},
		{name:'Jueves'},
		{name:'Viernes'},
		{name:'Sábado'}];

		$scope.bloques = [
		{name:'1'},
		{name:'2'},
		{name:'3'},
		{name:'4'},
		{name:'5'},
		{name:'6'},
		{name:'7'},
		{name:'8'},
		{name:'9'},
		{name:'10'},
		{name:'11'},
		{name:'12'},
		{name:'13'},
		{name:'14'},
		{name:'15'},
		{name:'16'},
		{name:'17'},
		{name:'18'},
		{name:'19'},
		{name:'20'}];
	}
})
