/**
 * Created by tunte on 19-Nov-14.
 */
app.controller('DemoController', ['TabService','$scope','$http', function(TabService, $scope, $http){

    TabService.setTab(4);

    $scope.toggle = false;

    $scope.drawResult = function(text){
        if(text.length > 0){
            $http.get('javascripts/data.json').success(function(data){
                $scope.data = data;
            });

            if(!$scope.toggle){
                $scope.toggle = true;
                $('.searchOut').slideToggle();
            }

        } else {
            $scope.data = {};
            $scope.visible = false;
            if($scope.toggle){
                $scope.toggle = false;
                $('.searchOut').slideToggle();
            }
        }
    };
    $scope.showContent = function(id){

        $('.searchOut').slideToggle();
        $scope.toggle = false;
        $scope.visible = true;
        // get full data for that id
        // $scope.contactData = data;
        $scope.contactData = {
            id: id,
            name: 'Ime Prezime',
            info: ''
        };
    };

}]);
