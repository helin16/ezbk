(function(){
	var app = angular.module('ezbk-app', [])
		.constant('API_BASE', '/api/')
		.controller('appController', ['API_BASE', '$http', function(API_BASE, $http){
			var user = {};
			$http.get(API_BASE + 'users/current')
				.success(function(data){
					user = data;
				}).error(function(data){
					user = {};
				}).finally(function() {
					if(user && user.id) {
						//load template
					} else {
						//load login
					}
				});
		}]);
})();