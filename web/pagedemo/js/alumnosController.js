angular.module('alumnos',[])
.config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}')
})

.controller('alumno', function($scope,$http){
	$scope.id = -1;
	$scope.name = 'default';
	$scope.title = 'default';
	
	
	$scope.delete = function(id,name){
		if(name != -1){
			$scope.title = "Eliminar Alumno";
			$scope.id = id;
			$scope.name = name;
		}else{

			$http.post('alumno/delete',{
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

})