/**
 * 
 */
(function() {
	var app = angular.module('transactionPanelJs', [])
		.directive('transactionPanel', ['$http', function($http){
			return {
				restrict 'E', //<transaction-panel></transaction-panel>
				templateUrl: '/app/views/TransactionPanel.html',
				controller: function() {
					return {
						load: funciton(data) {
							this.transaction = data;
						}
						saveTransation: function() {
							//do somthing here to record
							$http.post('/api/transtions/', {})
								.success(function(data){
									
								})
								.failed(function(data) {
									
								})
								.finally(function(data){
									
								})
						}
					}
				}
			}
		}])
})();