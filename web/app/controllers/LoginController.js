(function() {
	var app = angular.controller('LoginController', ['API_BASE', '$http', '$rootScope', function(API_BASE, $http, $rootScope) {
		var ctrl = {};
		ctrl.user = {};
		ctrl.login = function(user) {
			$http.post(API_BASE + 'users/login', {'username': user.username, 'password': user.password})
				.success(function(data){
					$rootScope.globals.currentUser = data;
				}).error(function(data){
					$rootScope.globals.currentUser = {};
				});
		};
		return ctrl;
	}]);
})();