(function(){
	var app = angular.module('ezbk-app', [])
		.constant('API_BASE', '/api/')
		.controller('appController', ['API_BASE', '$http', function(API_BASE, $http){
			this.user = {};
			$http.post(API_BASE + 'users/login', {'username': 'helin16@gmail.com', 'password': 'test'})
				.success(function(data){
					this.user = data;
				}).error(function(data){
					this.user = {};
				});
		}]);
})();