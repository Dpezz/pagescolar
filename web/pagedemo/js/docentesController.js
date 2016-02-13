angular.module('docentes',[])
.config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}')
})

.controller('docentes', function($scope,$http){
	$scope.id = -1;
	$scope.name = 'default';
	$scope.title = 'default';
	
	
	$scope.delete = function(id,name){
		if(name != -1){
			$scope.title = "Eliminar Docente";
			$scope.id = id;
			$scope.name = name;
		}else{

			$http.post('docente/delete',{
				id: $scope.id
			})
			.success(function(){
				window.location = "";
			})
			.error(function(error){
				console.log(error)
				//window.location = "";
			})
		}
	}
})