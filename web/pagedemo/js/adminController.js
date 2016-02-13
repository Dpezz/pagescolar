angular.module('admin',[])
.config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}')
})

.controller('superadmin', function($scope,$http){
	$scope.id = -1;
	$scope.name = 'default';
	$scope.title = "default";
	$scope.activar = -1;

	
	$scope.update = function(id,name,titulo,activar){
		$scope.id = id;
		$scope.name = name;
		$scope.title = titulo;
		$scope.activar = activar;
	}

	$scope.save = function(){
		$http.post('update',{
			id: $scope.id,
			activar: $scope.activar
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
			$scope.activar = -1;
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
})