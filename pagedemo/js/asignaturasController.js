angular.module('asignaturas',[])
.config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}')
})

.controller('asignatura', function($scope,$http){
	$scope.data = {};
	$scope.id = -1;
	$scope.id_apoderado = -1;
	$scope.name = 'default';
	$scope.title = "default";

	$scope.asignaturas = [];
	loadData();
	
	$scope.nuevo = function(id){
		$scope.id = id;
		$scope.id_apoderado = -1;
		$scope.title = "Nueva Asignatura";
		$scope.data = {name : ''};
	}

	$scope.edit = function(id){

		$scope.title = "Editar Asignatura";
		$scope.id_apoderado= id;

		$http.get('../get/asignatura/'+id)
		.success(function(result){
			$scope.data = result;
			if($scope.data.active == 0){
				$scope.asignatura = $scope.asignaturas[getIndex($scope.data.name,$scope.asignaturas)];
			}else{
				$scope.name = $scope.data.name;
			}
			
		})
		.error(function(error){
			console.log(error)
		})
	}

	$scope.save = function(){
		var active = getIsActive();
		var nombre = '';

		if(active == 1){
			
			if(!angular.isUndefined($scope.name))
				nombre = $scope.name;
			$scope.asignatura = $scope.asignaturas[0];
		}else{
			if(!angular.isUndefined($scope.asignatura))
				nombre = $scope.asignatura.name;
			
			$scope.name = "default";
		}

		if(nombre != ''){
			if($scope.id_apoderado == -1){
				$http.post('create',{
					id: $scope.id,
					name: nombre,
					active: active,
				})
				.success(function(result){
					window.location = "";
				})
				.error(function(error){
					console.log(error)
					window.location = "";
				});
			}else{
				$http.post('edit',{
					id: $scope.id_apoderado,
					name: nombre,
					active: active,
				})
				.success(function(result){
					window.location = "";
				})
				.error(function(error){
					console.log(error)
					window.location = "";
				});
			}
		}
	}

	$scope.delete = function(id,name){
		if(name != -1){
			$scope.title = "Eliminar Asignatura";
			$scope.id_apoderado = id;
			$scope.name = name;
		}else{

			$http.post('delete',{
				id: $scope.id_apoderado
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

	$scope.change = function(){
		$scope.asignatura = {name : ''};
		$scope.name = '';
	}

	function getIndex(x,list){
		var index = 0;
		angular.forEach(list, function(value, key) {
			if(value.name == x)
		  		index = key;
		});
		console.log(index)
		return index;
	}

	function loadData(){
		$http.get('../get/asignaturas_lista')
		.success(function(result){
			$scope.asignaturas = result;
		})
		.error(function(error){
			console.log(error)
		});
	}

	function getIsActive(){
		var active = 0;
		if($scope.data.active == 1){
			active = 1;
		}
		return active;
	}

})