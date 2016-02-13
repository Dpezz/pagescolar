
angular.module('apoderados',[])
.config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}')
})

.controller('apoderado', function($scope,$http){
	$scope.data = {};
	$scope.id = -1;
	$scope.id_user = -1;
	$scope.name = 'default';
	$scope.title = "default";

	$scope.parentescos = [];
	$scope.escolaridades = [];
	$scope.prioridades = [];
	$scope.binarios = [];
	$scope.regiones = [];
	$scope.comunas = [];

	loadData();	

	$scope.validate = function(){
		
		var fecha = angular.element('#rut');
		//if($scope.myForm.$valid && fecha.parent()[0].className != 'form-group has-feedback has-error')
		if($scope.myForm.$valid)
			$scope.flag = false;
		else $scope.flag = true;
	}

	$scope.change = function(){
		//console.log($scope.selected_person)
		$scope.comunas = [];
		$scope.data.comuna = null;
		loadComuna();
	}
	
	$scope.nuevo = function(id){
		$scope.id = id;
		$scope.id_user = -1;
		$scope.title = "Nuevo Apoderado";
		$scope.data = {};
		$scope.flag = true;
	}

	$scope.edit = function(id){

		$scope.title = "Editar Apoderado";
		$scope.id_user= id;
		$scope.flag = false;

		$http.get('../../get/apoderado/'+id)
		.success(function(result){
			$scope.data = result;
			
			$scope.parentesco = $scope.parentescos[getIndex($scope.data.parentesco,$scope.parentescos)];
			$scope.prioridad = $scope.prioridades[getIndex($scope.data.prioridad,$scope.prioridades)];
			$scope.escolaridad = $scope.escolaridades[getIndex($scope.data.escolaridad,$scope.escolaridades)];
			$scope.convive = $scope.binarios[getIndex($scope.data.convive,$scope.binarios)];

			if($scope.data.region != null){
				$scope.region = $scope.regiones[getIndex($scope.data.region,$scope.regiones)];
				loadComuna();
			}
		})
		.error(function(error){
			console.log(error)
		})
	}

	$scope.save = function(){

		if($scope.id_user == -1){
			$http.post('../../apoderado/create',{
				id: $scope.id,
				parentesco: $scope.parentesco.name,
				rut: $scope.data.rut,
				name: $scope.data.name,
				lastname: $scope.data.lastname,
				address: $scope.data.address,
				region: $scope.region.name,
				comuna: $scope.comuna.name,
				email: $scope.data.email,
				telefono: $scope.data.telefono,
				nivel: $scope.prioridad.name,
				convive: $scope.convive.id,
				escolaridad: $scope.escolaridad.name,
			})
			.success(function(result){
				console.log(result)
				window.location = "";
			})
			.error(function(error){
				console.log(error)
				window.location = "";
			})
		}else{
			$http.post('../../apoderado/edit',{
				id: $scope.id_user,
				parentesco: $scope.parentesco.name,
				rut: $scope.data.rut,
				name: $scope.data.name,
				lastname: $scope.data.lastname,
				address: $scope.data.address,
				region: $scope.region.name,
				comuna: $scope.comuna.name,
				email: $scope.data.email,
				telefono: $scope.data.telefono,
				nivel: $scope.prioridad.name,
				convive: $scope.convive.id,
				escolaridad: $scope.escolaridad.name,
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
	}

	$scope.delete = function(id,name){
		if(name != -1){
			$scope.title = "Eliminar Apoderado";
			$scope.id_user = id;
			$scope.name = name;
		}else{

			$http.post('../../apoderado/delete',{
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

	function getIndex(x,list){
		var index = 0;
		angular.forEach(list, function(value, key) {
			if(value.name == x)
		  		index = key;
		});
		return index;
	}

	function loadData(){
		$http.get('../../get/parentesco')
		.success(function(result){
			$scope.parentescos = result;
		})
		.error(function(error){
			console.log(error)
		});

		$http.get('../../get/prioridad')
		.success(function(result){
			$scope.prioridades = result;
		})
		.error(function(error){
			console.log(error)
		});

		$http.get('../../get/escolaridad')
		.success(function(result){
			$scope.escolaridades = result;
		})
		.error(function(error){
			console.log(error)
		});

		$scope.binarios = [
			{value : 'Si', id: 1, name: true},
			{value : 'No', id: 0, name: false},
		];

		$http.get('../../get/regiones')
		.success(function(result){
			$scope.regiones = result;
		})
		.error(function(error){
			console.log(error)
		});
	}

	function loadComuna(){
		$http.get('../../get/comunas/'+$scope.region.name)
		.success(function(result){
			$scope.comunas =  result;

			if($scope.data.comuna != null){
				$scope.comuna = $scope.comunas[getIndex($scope.data.comuna,$scope.comunas)];
			}
		})
		.error(function(error){
			console.log(error)
		});
	}

})