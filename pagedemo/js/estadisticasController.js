angular.module("estadisticas", ["chart.js"])

.controller("bar_docentes", function ($scope,$http) {
  	loadAsignatura();
  	function loadAsignatura(){
	  	$http.get('asignaturas_docentes')
	  	.success(function(result){
	  		
	  		$scope.labels = new Array(result.length);
	  		$scope.data = [];
	  		$scope.num = new Array(result.length);

	  		for (var i = result.length - 1; i >= 0; i--) {
	  			$scope.labels[i] = result[i].name;
	  			$scope.num[i] = result[i].data;
	  		};
	  		$scope.data[0] = $scope.num;
	  	})
	  	.error(function(error){
	  		console.log(error)
	  	})
  	};
})
.controller("donuts_docentes", function ($scope,$http) {
	loadSexo();
  	loadFuncion();
  	loadNivel();

  	function loadSexo(){
	  	$http.get('sexo_docentes')
	  	.success(function(result){
	  		$scope.sexlabels = new Array(result.length);
	  		$scope.sexdata = new Array(result.length);

	  		for (var i = result.length - 1; i >= 0; i--) {
	  			$scope.sexlabels[i] = result[i].name;
	  			$scope.sexdata[i] = result[i].data;
	  		};
	  	})
	  	.error(function(error){
	  		console.log(error)
	  	})
  	};
  	function loadFuncion(){
	  	$http.get('funcion_docentes')
	  	.success(function(result){
	  		
	  		$scope.funlabels = new Array(result.length);
	  		$scope.fundata = new Array(result.length);

	  		for (var i = result.length - 1; i >= 0; i--) {
	  			$scope.funlabels[i] = result[i].name;
	  			$scope.fundata[i] = result[i].data;
	  		};
	  	})
	  	.error(function(error){
	  		console.log(error)
	  	})
  	};
  	function loadNivel(){
	  	$http.get('nivel_docentes')
	  	.success(function(result){
	  		
	  		$scope.nivlabels = new Array(result.length);
	  		$scope.nivdata = new Array(result.length);

	  		for (var i = result.length - 1; i >= 0; i--) {
	  			$scope.nivlabels[i] = result[i].name;
	  			$scope.nivdata[i] = result[i].data;
	  		};
	  	})
	  	.error(function(error){
	  		console.log(error)
	  	})
  	};
})
.controller("line_docentes", function ($scope,$http) {
  	$scope.series = ['Año Ingreso'];
  	loadAsignatura();
  	function loadAsignatura(){
	  	$http.get('ingreso_docentes')
	  	.success(function(result){
	  		
	  		$scope.labels = new Array(result.length);
	  		$scope.data = [];

	  		$scope.num = new Array(result.length);

	  		for (var i = result.length - 1; i >= 0; i--) {
	  			$scope.labels[i] = result[i].name;
	  			$scope.num[i] = result[i].data;
	  		};
	  		$scope.data[0] = $scope.num;
	  	})
	  	.error(function(error){
	  		console.log(error)
	  	})
  	};

  	$scope.onClick = function (points, evt) {
    	console.log(points, evt);
  	};
})

.controller("bar_alumnos", function ($scope,$http) {
  	loadItem();
  	function loadItem(){
	  	$http.get('cursos_alumnos')
	  	.success(function(result){
	  	
	  		$scope.labels = new Array(result.length);
	  		$scope.data = [];
	  		$scope.num = new Array(result.length);

	  		for (var i = result.length - 1; i >= 0; i--) {
	  			$scope.labels[i] = result[i].name;
	  			$scope.num[i] = result[i].data;
	  		};
	  		$scope.data[0] = $scope.num;
	  	})
	  	.error(function(error){
	  		console.log(error)
	  	})
  	};
})
.controller("line_alumnos", function ($scope,$http) {
  	$scope.series = ['Año Ingreso'];
  	loadAsignatura();
  	function loadAsignatura(){
	  	$http.get('ingreso_alumnos')
	  	.success(function(result){
	  		
	  		$scope.labels = new Array(result.length);
	  		$scope.data = [];

	  		$scope.num = new Array(result.length);

	  		for (var i = result.length - 1; i >= 0; i--) {
	  			$scope.labels[i] = result[i].name;
	  			$scope.num[i] = result[i].data;
	  		};
	  		$scope.data[0] = $scope.num;
	  	})
	  	.error(function(error){
	  		console.log(error)
	  	})
  	};

  	$scope.onClick = function (points, evt) {
    	console.log(points, evt);
  	};
})
.controller("donuts_alumnos", function ($scope,$http) {
	loadSexo();
  	loadEtnia();
  	loadProgramas();

  	function loadSexo(){
	  	$http.get('sexo_alumnos')
	  	.success(function(result){
	  		
	  		$scope.sexlabels = new Array(result.length);
	  		$scope.sexdata = new Array(result.length);

	  		for (var i = result.length - 1; i >= 0; i--) {
	  			$scope.sexlabels[i] = result[i].name;
	  			$scope.sexdata[i] = result[i].data;
	  		};
	  	})
	  	.error(function(error){
	  		console.log(error)
	  	})
  	};
  	function loadEtnia(){
	  	$http.get('etnia_alumnos')
	  	.success(function(result){
	  		$scope.funlabels = new Array(result.length);
	  		$scope.fundata = new Array(result.length);

	  		for (var i = result.length - 1; i >= 0; i--) {
	  			$scope.funlabels[i] = result[i].name;
	  			$scope.fundata[i] = result[i].data;
	  		};
	  	})
	  	.error(function(error){
	  		console.log(error)
	  	})
  	};
  	function loadProgramas(){
	  	$http.get('programas_alumnos')
	  	.success(function(result){
	  		$scope.nivlabels = new Array(result.length);
	  		$scope.nivdata = new Array(result.length);

	  		for (var i = result.length - 1; i >= 0; i--) {
	  			$scope.nivlabels[i] = result[i].name;
	  			$scope.nivdata[i] = result[i].data;
	  		};
	  	})
	  	.error(function(error){
	  		console.log(error)
	  	})
  	};
})
.controller("pie_alumnos", function ($scope,$http) {
	loadBasica();
  	loadReforzamiento();
  	loadTaller();

  	function loadBasica(){
	  	$http.get('basico_alumnos')
	  	.success(function(result){
	  		
	  		$scope.baslabels = new Array(result.length);
	  		$scope.basdata = new Array(result.length);

	  		for (var i = result.length - 1; i >= 0; i--) {
	  			$scope.baslabels[i] = result[i].name;
	  			$scope.basdata[i] = result[i].data;
	  		};
	  	})
	  	.error(function(error){
	  		console.log(error)
	  	})
  	};
  	function loadReforzamiento(){
	  	$http.get('reforzamiento_alumnos')
	  	.success(function(result){
	  		$scope.reflabels = new Array(result.length);
	  		$scope.refdata = new Array(result.length);

	  		for (var i = result.length - 1; i >= 0; i--) {
	  			$scope.reflabels[i] = result[i].name;
	  			$scope.refdata[i] = result[i].data;
	  		};
	  	})
	  	.error(function(error){
	  		console.log(error)
	  	})
  	};
  	function loadTaller(){
	  	$http.get('taller_alumnos')
	  	.success(function(result){
	  		$scope.tallabels = new Array(result.length);
	  		$scope.taldata = new Array(result.length);

	  		for (var i = result.length - 1; i >= 0; i--) {
	  			$scope.tallabels[i] = result[i].name;
	  			$scope.taldata[i] = result[i].data;
	  		};
	  	})
	  	.error(function(error){
	  		console.log(error)
	  	})
  	};
})

.controller("bar_apoderados", function ($scope,$http) {
  	loadItem();
  	function loadItem(){
	  	$http.get('cursos_apoderados')
	  	.success(function(result){
	  		
	  		$scope.labels = new Array(result.length);
	  		$scope.data = [];
	  		$scope.num = new Array(result.length);

	  		for (var i = result.length - 1; i >= 0; i--) {
	  			$scope.labels[i] = result[i].name;
	  			$scope.num[i] = result[i].data;
	  		};
	  		$scope.data[0] = $scope.num;
	  	})
	  	.error(function(error){
	  		console.log(error)
	  	})
  	};
})
.controller("donuts_apoderados", function ($scope,$http) {
	loadParentesco();
  	loadConvive();
  	loadEscolaridad();

  	function loadParentesco(){
	  	$http.get('parentesco_apoderados')
	  	.success(function(result){
	  		console.log(result)
	  		$scope.parlabels = new Array(result.length);
	  		$scope.pardata = new Array(result.length);

	  		for (var i = result.length - 1; i >= 0; i--) {
	  			$scope.parlabels[i] = result[i].name;
	  			$scope.pardata[i] = result[i].data;
	  		};
	  	})
	  	.error(function(error){
	  		console.log(error)
	  	})
  	};
  	function loadConvive(){
	  	$http.get('convive_apoderados')
	  	.success(function(result){
	  		$scope.conlabels = new Array(result.length);
	  		$scope.condata = new Array(result.length);

	  		for (var i = result.length - 1; i >= 0; i--) {
	  			$scope.conlabels[i] = result[i].name;
	  			$scope.condata[i] = result[i].data;
	  		};
	  	})
	  	.error(function(error){
	  		console.log(error)
	  	})
  	};
  	function loadEscolaridad(){
	  	$http.get('escolaridad_apoderados')
	  	.success(function(result){
	  		$scope.esclabels = new Array(result.length);
	  		$scope.escdata = new Array(result.length);

	  		for (var i = result.length - 1; i >= 0; i--) {
	  			$scope.esclabels[i] = result[i].name;
	  			$scope.escdata[i] = result[i].data;
	  		};
	  	})
	  	.error(function(error){
	  		console.log(error)
	  	})
  	};
})

.controller("bar_evaluacion", function ($scope,$http) {
  	$scope.series =[];
  	loadRegimen();
  	
  	function loadRegimen(){
	  	$http.get('regimen_institucion')
	  	.success(function(result){
	  		
	  		if(!angular.isUndefined(result))
	  			$scope.series = result.split(',');

	  		loadItem();
	  	})
	  	.error(function(error){
	  		console.log(error)
	  	})
  	};
  	
  	function loadItem(){
	  	$http.get('evaluaciones_asignaturas')
	  	.success(function(result){
	  		$scope.result = result;
	  		$scope.labels = [];

	  		var index = 0;
	  		for(var i=0; i<$scope.result.length; i++){
	  			if($scope.labels.indexOf($scope.result[i].name) == -1){
  					$scope.labels[index] = $scope.result[i].name;
  					index ++;
  				}
	  		}

	  		$scope.data = new Array($scope.series.length);
	  		for(var i=0; i<$scope.series.length; i++){
	  			var item = new Array($scope.labels.length);
	  			var index = 0;
	  			for(var j=0; j<$scope.labels.length; j++){
	  				var cont = 0;
	  				for(var z=0; z<$scope.result.length; z++){
	  					if($scope.series[i] == $scope.result[z].semestre && $scope.labels[j] == $scope.result[z].name){
	  						item[index] =$scope.result[z].data;
	  						index++;
	  					}else{
	  						cont++;
	  					}
	  					if(cont == $scope.result.length){
	  						item[index] =0;
	  						index++;
		  				}
	  				}
	  			}
	  			$scope.data[i] = item;
	  		}
	  	})
	  	.error(function(error){
	  		console.log(error)
	  	})
  	};
})
.controller("donuts_evaluacion", function ($scope,$http) {
	loadSistema();
  	loadMomento();	
	loadTipo();
  	loadEvalua();
  	
  	function loadSistema(){
	  	$http.get('sistema_evaluaciones')
	  	.success(function(result){
	  		
	  		$scope.alabels = new Array(result.length);
	  		$scope.adata = new Array(result.length);

	  		for (var i = result.length - 1; i >= 0; i--) {
	  			$scope.alabels[i] = result[i].name;
	  			$scope.adata[i] = result[i].data;
	  		};
	  	})
	  	.error(function(error){
	  		console.log(error)
	  	})
  	};
  	function loadMomento(){
	  	$http.get('momento_evaluaciones')
	  	.success(function(result){
	  		
	  		$scope.blabels = new Array(result.length);
	  		$scope.bdata = new Array(result.length);

	  		for (var i = result.length - 1; i >= 0; i--) {
	  			$scope.blabels[i] = result[i].name;
	  			$scope.bdata[i] = result[i].data;
	  		};
	  	})
	  	.error(function(error){
	  		console.log(error)
	  	})
  	};


  	function loadTipo(){
	  	$http.get('tipo_evaluaciones')
	  	.success(function(result){
	  		
	  		$scope.clabels = new Array(result.length);
	  		$scope.cdata = new Array(result.length);

	  		for (var i = result.length - 1; i >= 0; i--) {
	  			$scope.clabels[i] = result[i].name;
	  			$scope.cdata[i] = result[i].data;
	  		};
	  	})
	  	.error(function(error){
	  		console.log(error)
	  	})
  	};
  	function loadEvalua(){
	  	$http.get('evalua_evaluaciones')
	  	.success(function(result){
	  		
	  		$scope.dlabels = new Array(result.length);
	  		$scope.ddata = new Array(result.length);

	  		for (var i = result.length - 1; i >= 0; i--) {
	  			$scope.dlabels[i] = result[i].name;
	  			$scope.ddata[i] = result[i].data;
	  		};
	  	})
	  	.error(function(error){
	  		console.log(error)
	  	})
  	};
})
.controller("pie_evaluacion", function ($scope,$http) {
	loadEvaluacionD();
  	loadFinalidad();
  	loadInstrumentos();
  	loadaprendizaje();

  	function loadEvaluacionD(){
	  	$http.get('evaluacion_docente')
	  	.success(function(result){
	  		
	  		$scope.alabels = new Array(result.length);
	  		$scope.adata = new Array(result.length);

	  		for (var i = result.length - 1; i >= 0; i--) {
	  			$scope.alabels[i] = result[i].name;
	  			$scope.adata[i] = result[i].data;
	  		};
	  	})
	  	.error(function(error){
	  		console.log(error)
	  	})
  	};
  	
  	function loadFinalidad(){
	  	$http.get('finalidad_evaluaciones')
	  	.success(function(result){
	  		
	  		$scope.blabels = new Array(result.length);
	  		$scope.bdata = new Array(result.length);

	  		for (var i = result.length - 1; i >= 0; i--) {
	  			$scope.blabels[i] = result[i].name;
	  			$scope.bdata[i] = result[i].data;
	  		};
	  	})
	  	.error(function(error){
	  		console.log(error)
	  	})
  	};
  	function loadInstrumentos(){
	  	$http.get('instrumentos_evaluaciones')
	  	.success(function(result){
	  		
	  		$scope.clabels = new Array(result.length);
	  		$scope.cdata = new Array(result.length);

	  		for (var i = result.length - 1; i >= 0; i--) {
	  			$scope.clabels[i] = result[i].name;
	  			$scope.cdata[i] = result[i].data;
	  		};
	  	})
	  	.error(function(error){
	  		console.log(error)
	  	})
  	};
  	function loadaprendizaje(){
	  	$http.get('aprendizaje_evaluaciones')
	  	.success(function(result){
	  		
	  		$scope.dlabels = new Array(result.length);
	  		$scope.ddata = new Array(result.length);

	  		for (var i = result.length - 1; i >= 0; i--) {
	  			$scope.dlabels[i] = result[i].name;
	  			$scope.ddata[i] = result[i].data;
	  		};
	  	})
	  	.error(function(error){
	  		console.log(error)
	  	})
  	};
})