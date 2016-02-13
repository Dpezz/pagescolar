angular.module('cuentas',[])
.config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}')
})

.controller('cuenta', function($scope,$http){
	$scope.id = -1;
	$scope.id_user = -1;
	$scope.name = 'default';
	$scope.title = "default";

	$scope.usuarios = [];
	$scope.roles = [];

	loadRoles();
	
	$scope.nuevo = function(id_user){
		$scope.id = -1;
		$scope.id_user = id_user;
		$scope.title = "Nuevo Curso";
		$scope.flag = true;
	}


	$scope.save = function(){
		$http.post('create',{
			id_user: $scope.id_user,
			username: $scope.usuario.id,
			rol: $scope.rol.name,
		})
		.success(function(result){
			//console.log(result)
			window.location = "";
		})
		.error(function(error){
			console.log(error)
			window.location = "";
		})
	}

	$scope.delete = function(id,name){
		if(name != -1){
			$scope.title = "Eliminar Cuenta";
			$scope.id = id;
			$scope.name = name;
		}else{

			$http.post('delete',{
				id: $scope.id
			})
			.success(function(result){
				//console.log(result)
				window.location = "";
			})
			.error(function(error){
				console.log(result)
				window.location = "";
			})
		}
	}

	$scope.change = function(){
		if(! angular.isUndefined($scope.rol)){
			if($scope.rol.id == 0){
				loadDocentes();
			}else{
				loadAlumnos();
			}
		}else{
			$scope.usuarios = [];
			$scope.flag = true;
		}
	}

	$scope.validate = function(){
		validate();
	}

	function validate(){
		if($scope.myForm.$valid)
			$scope.flag = false;
		else $scope.flag = true;
	}


	function loadAlumnos(){
		$http.get('../get/alumnos')
		.success(function(result){
			$scope.usuarios = result;
		})
		.error(function(error){
			console.log(error)
		});
		validate();
	}

	function loadDocentes(){
		$http.get('../get/docentes')
		.success(function(result){
			$scope.usuarios = result;
		})
		.error(function(error){
			console.log(error)
		});
		validate();
	}

	function loadRoles(){
		$scope.roles = [{id:0,name:'Docente'},{id:1,name:'Alumno'}];
	}


})