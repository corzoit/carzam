

var app = angular.module("myApp", []);

	app.config(function ($interpolateProvider) {
	    $interpolateProvider.startSymbol('[[');
	    $interpolateProvider.endSymbol(']]');
	});

	app.controller('AppCtrl', function($scope, $http) {

		$scope.$watch('search', function() {
		  fetchData();
		});

		function fetchData(){
			if($scope.search != undefined && $scope.search != "")
			{
				$http.get("http://localhost:8000/api/v1/cars?k=" + $scope.search)
					.then(function(response){
						$scope.items = response.data.output;
					});
			}
			else
			{
				$scope.items = [];
			}
		}			
	});