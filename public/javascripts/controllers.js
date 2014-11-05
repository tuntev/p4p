/**
 * Created by tunte on 11/3/14.
 */

app.controller('ProjectsController', ['$scope','ProjectsService','TabService', function($scope, ProjectsService, TabService){

    TabService.setTab(1);

    // get all current project
    ProjectsService.getProjects().then(function(data) {
        $scope.projects = data;
    });

    // change DONE
    $scope.changeDone = function(id, done){
        var pId;
        ProjectsService.updateDone(id, done).then(function(data){
            pId = data.data;
            $('.cnfBtn_'+pId).hide();
        });

    };

    $scope.data = {
        title : "",
        student : ""
    };

    $scope.addNew = function(input){

        if($scope.data.title !== "" && $scope.data.student !== ""){
            var projectData = ProjectsService.sanitizeInput($scope.data);

            ProjectsService.addNew(projectData);
            $scope.projects.push(projectData);
            $scope.data.title = '';
            $scope.data.student = '';
        }


    }
    // add new project

    // delete a project
    $scope.removeChecked = function() {
        $scope.projects = _.filter($scope.projects, function(item) {
            if(item.done) {
                ProjectsService.delete(item.id);
            }
            return !item.done;
        });
    };
}]);


app.controller('TodoController', ['$http', '$scope', 'GetTodos','TabService', function($http, $scope, GetTodos, TabService){

    TabService.setTab(2);

    GetTodos.getData().then(function(data) {
        $scope.todos = data;
    });

    $scope.remaining = function(){
        var count = 0;

        angular.forEach($scope.todos, function(todo){
            count += todo.done ? 0 : 1;
        });

        return count;
    }

    $scope.addNew = function(){
        var todo = {
            text: $scope.todotxt,
            done: false,
            csrf_token: $('meta[name="csrf-token"]').attr('content')
        };

        $scope.todos.push(todo);
        $scope.todotxt = "";

        $http.post('todos', todo);
    };

    $scope.removeChecked = function() {
        $scope.todos = _.filter($scope.todos, function(item) {
            if(item.done) {
                $http.delete('todos/delete/' + item.id).error(function(data, status) {
                    console.log(status);
                });
            }
            return !item.done;
        });
    };

    $scope.toggleDone = function(id, done) {
        $http.put('todos/update/' + id, { done: done } ).success(function(data, status) {
            if(data) {
                console.log($scope.todos);
            } else {
                console.log('There was a problem. Status: ' + status + '; Data: ' + data);
            }
        }).error(function(data, status) {
                console.log('status: ' + status);
            });
    }
}]);

app.controller('DemoController', ['TabService', function(TabService){

    TabService.setTab(3);

}]);