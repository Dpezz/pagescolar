angular.module('planificador',[])
.config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}')
})

.controller('planificacion', function($scope,$http){
	$scope.data = {};
	$scope.id = -1;
	$scope.name = 'default';
	$scope.title = "default";
	$scope.motivos = [];

	$scope.progress = 0;
	$scope.recurso = 0;
	loadData();

	$scope.validate = function(){
		//if($scope.myForm.$valid && fecha.parent()[0].className != 'form-group has-feedback has-error')
		if($scope.myForm.$valid)
			$scope.flag = false;
		else $scope.flag = true;
	}

	$scope.edit = function(id,progress,motivo,recurso){
		$scope.title = "Editar Objetivo";
		$scope.id= id;

		$http.get('../get/objetivo/'+ id)
		.success(function(result){
			//console.log(result)
			$scope.data = result;
			$scope.motivo = $scope.motivos[getIndex(motivo,$scope.motivos)];
			$scope.progress = progress;
			$scope.recurso = recurso;
		})
		.error(function(error){
			console.log(error)
		})
	}

	$scope.save = function(id_user,id_docente){
		$http.post('../objetivo/edit',{
			id: $scope.id,
			id_user: id_user,
			id_docente: id_docente,
			progress: $scope.progress,
			motivo: $scope.motivo.name,
			recurso: $scope.recurso,
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

	$scope.delete = function(id_user,id_docente){
		$http.post('../objetivo/delete',{
			id: $scope.id,
			id_user: id_user,
			id_docente: id_docente
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

	function getIndex(x,list){
		var index = -1;
		angular.forEach(list, function(value, key) {
			if(value.name == x)
		  		index = key;
		});
		return index;
	}

	function loadData(){
		$http.get('../get/motivos')
		.success(function(result){
			$scope.motivos = result;
		})
		.error(function(error){
			console.log(error)
		});
	}

})