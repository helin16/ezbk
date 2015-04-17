(function() {
	var app = angular.module('login-page', [])
		.controller('LoginController', ['$http', '$rootScope', function($http, $rootScope) {
			var ctrl = {};
			ctrl.user = {};
			ctrl.login = function(user) {
//				$http.post('/app/users/login', {'username': user.username, 'password': user.password})
//					.success(function(data){
//	//					$rootScope.globals.currentUser = data;
//					}).error(function(data){
//	//					$rootScope.globals.currentUser = {};
//					});
			};
			return ctrl;
		}]);
})();