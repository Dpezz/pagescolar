angular.module('documentos',[])
.config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}')
})

.controller('documento', function($scope,$http){
	$scope.id = -1;
	$scope.name = 'default';
	$scope.title = 'default';
	$scope.data = {};
	
	
	$scope.delete = function(id,name){
		if(name != -1){
			$scope.title = "Eliminar Documento";
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
				console.log(error)
				window.location = "";
			})
		}
	}

	$scope.edit = function(id){
		$scope.id = id
		$http.get('../get/documento/'+id)
		.success(function(result){
			$scope.data.title = result.title,
			$scope.data.description = result.description
		})
		.error(function(error){
			console.log(error)
		})
	}

	$scope.save = function(){
		$http.post('edit',{
			id: $scope.id,
			title: $scope.data.title,
			description: $scope.data.description
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

})