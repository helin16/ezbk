(function() {
	var app = angular.module('HomePage', []).controller('HomeController', ['$http', '$rootScope', function($http, $rootScope) {
		var ctrl = {};
		console.debug($rootScope);
		return ctrl;
	}]);
})();