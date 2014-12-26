/**
 * Created by tunte on 19-Nov-14.
 */
app.controller('DemoController', ['TabService','$scope','$http', 'StudentService', function(TabService, $scope, $http, StudentService){

    TabService.setTab(4);

    $scope.students = [];

    //var students = new Bloodhound({
    //    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),
    //    queryTokenizer: Bloodhound.tokenizers.whitespace,
    //    remote: 'api/student/%QUERY'
    //});
    //
    //students.initialize();
    //
    //$('#textInput').typeahead({
    //        hint: true,
    //        highlight: true,
    //        minLength: 2
    //    },
    //    {
    //        name: 'students',
    //        displayKey: 'username',
    //        source: students.ttAdapter()
    //    }
    //);

    $scope.toggle = false;

    $scope.drawResult = function(text){
        if(text.length > 0){

            StudentService.getStudentByName(text).then(function(data) {
                $scope.students = data;
            });

            if(!$scope.toggle){
                $scope.toggle = true;
                $('.searchOut').toggle();
            }

        } else {
            $scope.students = {};
            $scope.visible = false;
            if($scope.toggle){
                $scope.toggle = false;
                $('.searchOut').toggle();
            }
        }
    };
    $scope.showContent = function(id){

        $('.searchOut').toggle();
        $scope.toggle = false;
        $scope.visible = true;

        StudentService.getStudentById(id).then(function(data) {
            $scope.student = data;
        });

    };

}]);
