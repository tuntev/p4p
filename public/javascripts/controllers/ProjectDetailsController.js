/**
 * Created by tunte on 19-Nov-14.
 */
app.controller('ProjectDetailsController',['$scope','$routeParams','TabService','ProjectsService','$location',
    function($scope, $routeParams,TabService, ProjectsService, $location){

        TabService.setTab(2);
        var pId = $routeParams.projectId;
        ProjectsService.getProjectById(pId).then(function(data){
            if(data.message){
                $location.path('/projects');
                return;
            }
            else{
                $scope.project = data;
            }
        });

    }]);