/**
 * Created by tunte on 19-Nov-14.
 */
app.controller('DemoController', ['TabService','$scope','$http', function(TabService, $scope, $http){

    TabService.setTab(4);

    $scope.drawResult = function(text){
        if(text.length > 0){
            $http.get('javascripts/data.json').success(function(data){
                $scope.data = data;
                console.log('search');
            });
        } else {
            $scope.data = {};
        }
    };
    $scope.showContent = function(id){
        $scope.id = id;
    }

}]);
