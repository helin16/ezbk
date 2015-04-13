/**
 *
 */
(function(){
	var app = angular.module('ezbk-app', ['routeResolverServices'])
		.config(['$routeProvider', 'routeResolverProvider', '$controllerProvider', '$compileProvider', '$filterProvider', '$provide',
		    function ($routeProvider, routeResolverProvider, $controllerProvider, $compileProvider, $filterProvider, $provide) {
				//Change default views and controllers directory using the following:
	            routeResolverProvider.routeConfig.setBaseDirectories('/app/views', '/app/controllers');

	            app.register = {
	                controller: $controllerProvider.register,
	                directive: $compileProvider.directive,
	                filter: $filterProvider.register,
	                factory: $provide.factory,
	                service: $provide.service
	            };
	            //Define routes - controllers will be loaded dynamically
	            var route = routeResolverProvider.route;
				$routeProvider.when('/', {
					templateUrl : '/login.html',
					resolve : route.resolve('Users')
				});

				// configure html5 to get links working on jsfiddle
				$locationProvider.html5Mode(true);
			}
		]);
})();