var redisApp = angular.module('redis', ['ui.bootstrap']);

/**
 * Constructor
 */
function RedisController() {}

RedisController.prototype.onRedis = function() {
    if (!this.scope_.value || this.scope_.value.length == 0) {
        this.http_.get("/index.php?cmd=get&key=" + this.scope_.key)
            .success(angular.bind(this, function(data) {
                this.scope_.redisResponse = data.data;
            }));
    } else {
        this.http_.get("/index.php?cmd=set&key=" + this.scope_.key + "&value=" + this.scope_.value) 
            .success(angular.bind(this, function(data) {
                this.scope_.redisResponse = "Updated.";
            }));
    }
};

redisApp.controller('RedisCtrl', function ($scope, $http, $location) {
        $scope.controller = new RedisController();
        $scope.controller.scope_ = $scope;
        $scope.controller.location_ = $location;
        $scope.controller.http_ = $http;
});
