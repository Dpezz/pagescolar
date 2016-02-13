angular.module('cursos',[])
.config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}')
})

.controller('curso', function($scope,$http){
	$scope.data = {};
	$scope.id = -1;
	$scope.id_apoderado = -1;
	$scope.name = 'default';
	$scope.index = '';
	$scope.title = "default";

	$scope.cursos = [];
	$scope.indices = [];

	loadData();
	
	$scope.nuevo = function(id){
		$scope.id = id;
		$scope.id_apoderado = -1;
		$scope.title = "Nuevo Curso";
		$scope.data = {};
		$scope.curso = {name : ''};
		$scope.indice = {name : ''};
	}

	$scope.edit = function(id){
		$scope.curso = $scope.cursos[1]; 
		$scope.title = "Editar Curso";
		$scope.id_apoderado= id;

		$http.get('../get/curso/'+id)
		.success(function(result){
			$scope.data = result;
			if($scope.data.active == 0){
				$scope.curso = $scope.cursos[getIndex($scope.data.name,$scope.cursos)];
				if($scope.data.indice != ''){
					$scope.indice = $scope.indices[getIndex($scope.data.indice,$scope.indices)];
				}
			}else{
				$scope.curso = {};
				$scope.indice = {};
				$scope.name = $scope.data.name;
				$scope.index = $scope.data.indice;
			}
		})
		.error(function(error){
			console.log(error)
		})
	}

	$scope.save = function(){
		var active = getIsActive();
		var nombre = '';
		var indice = '';

		if(active == 1){
			if(!angular.isUndefined($scope.name))
				nombre = $scope.name;
			if(!angular.isUndefined($scope.index))
				indice = $scope.index;
			$scope.curso = $scope.cursos[0];;
			$scope.indice = $scope.indices[0];
		}else{
			if(!angular.isUndefined($scope.curso))
				nombre = $scope.curso.name;
			if($scope.indice != null)
				indice = $scope.indice.name;
			$scope.name = "default";
			$scope.index = "";
		}
		
		if(nombre != ''){
			if($scope.id_apoderado == -1){
				$http.post('create',{
					id: $scope.id,
					name: nombre,
					indice: indice,
					active: active,
				})
				.success(function(result){
					window.location = "";
				})
				.error(function(error){
					console.log(error)
					window.location = "";
				})
			}else{
				$http.post('edit',{
					id: $scope.id_apoderado,
					name: nombre,
					indice: indice,
					active: active,
				})
				.success(function(result){
					window.location = "";
				})
				.error(function(error){
					console.log(error)
					window.location = "";
				})
			}
		}
	}

	$scope.delete = function(id,name){
		if(name != -1){
			$scope.title = "Eliminar Curso";
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
		$scope.curso = {name : ''};
		$scope.indice = {name : ''};
		$scope.index = '';
		$scope.name = '';
	}

	function getIndex(x,list){
		var index = 0;
		angular.forEach(list, function(value, key) {
			if(value.name == x)
		  		index = key;
		});
		return index;
	}

	function loadData(){
		$http.get('../get/cursos_lista')
		.success(function(result){
			$scope.cursos = result;
		})
		.error(function(error){
			console.log(error)
		});

		$http.get('../get/indices')
		.success(function(result){
			$scope.indices = result;
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