function Hello($scope, $http) {
    $http.get('https://status.github.com/api/status.json?callback=apiStatus').
	//$http.get('http://rest-service.guides.spring.io/greeting').
        success(function(data) {
            $scope.dd = data;
        });
}