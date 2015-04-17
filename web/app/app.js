(function(){
	var app = angular.module('ezbk-app', ['ngRoute'])
		.constant('API_BASE', '/api/')
		.constant('APP_BASE', '/app/')
		.config(['APP_BASE', '$routeProvider', function (APP_BASE, $routeProvider) {
		    $routeProvider
		        .when('/login', {
		            templateUrl: APP_BASE + 'views/login.html'
		        })
		        .when('/', {
		            templateUrl: APP_BASE + 'views/home.html',
		        })
		        .otherwise({ redirectTo: '/login' });
		}])

		.run(['API_BASE', '$rootScope', '$location', '$http', function(API_BASE, $rootScope, $location, $http) {
			$rootScope.$on('$locationChangeStart', function (event, next, current) {
				$rootScope.globals = {};
				$rootScope.globals.currentUser = {};
				$http.get(API_BASE + 'users/current')
					.success(function(data){
						$rootScope.globals.currentUser = data;
					}).error(function(data){
						$rootScope.globals.currentUser = {};
					}).finally(function(data){
						// redirect to login page if not logged in
			            if ($location.path() !== '/login' && !($rootScope.globals.currentUser && $rootScope.globals.currentUser.id)) {
			                $location.path('/login');
			            }
					});
	        });
		}])
		
		.controller('LoginController', ['API_BASE', '$http', '$rootScope', '$location', function(API_BASE, $http, $rootScope, $location) {
			var ctrl = this;
			ctrl.user = {};
			ctrl.login = function(user){
				$http.post( API_BASE + 'users/login', user)
					.success(function(data){
						ctrl.errMsg = '';
					})
					.error(function(data){
						ctrl.errMsg = data.error.message;
					})
					.finally(function(data){
		                $location.path('/');
					});
			}
			return ctrl;
		}])
})();