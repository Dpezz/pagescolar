angular.module('evaluaciones',[])
.config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}')
})

.controller('evaluacion', function($scope,$http){
	
	$scope.id = -1;
	$scope.name = 'default';
	$scope.title = "default";
	                

	$scope.delete = function(id,name){
		if(name != -1){
			$scope.title = "Eliminar Evaluación";
			$scope.id_user = id;
			$scope.name = name;
		}else{
			$http.post('evaluacion/delete',{
				id: $scope.id_user
			})
			.success(function(result){
				console.log(result)
				window.location = "";
			})
			.error(function(error){
				console.log(result)
				window.location = "";
			})
		}
	}
})
