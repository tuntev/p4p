/**
 * Created by tunte on 11/3/14.
 */

app.controller('ProjectsController', ['$scope','$rootScope','ProjectsService','TabService','dialogs','$timeout',
    function($scope, $rootScope, ProjectsService, TabService, dialogs, $timeout){

    TabService.setTab(2);

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

            ProjectsService.addNew(projectData).then(function(data){
                projectData.id = data;
            });
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

    // handle dialogs
    var _progress = 33;
    $scope.launch = function(which, type, pId){
        switch(which){
            case 'error':
                dialogs.error();
                break;
            case 'wait':
                var dlg = dialogs.wait(undefined,undefined,_progress);
                _fakeWaitProgress();
                break;
            case 'customwait':
                var dlg = dialogs.wait('Custom Wait Header','Custom Wait Message',_progress);
                _fakeWaitProgress();
                break;
            case 'notify':
                dialogs.notify();
                break;
            case 'confirm':
                if(type === 'delete'){
                    var dlg = dialogs.confirm('Confirm','Do you want to delete the selected projects?');
                    dlg.result.then(function(btn){
                        $scope.removeChecked();
                    },function(btn){
//                    $scope.confirmed = 'You confirmed "No."';
                    });
                }
                if(type === 'complete'){
                    var dlg = dialogs.confirm('Confirm','Do you want to close the project?');
                    dlg.result.then(function(btn){
                        $scope.changeDone(pId, '1')
                    },function(btn){
//                    $scope.confirmed = 'You confirmed "No."';
                    });
                }
                break;
            case 'custom':
                var dlg = dialogs.create('/dialogs/custom.html','customDialogCtrl',{},{size:'lg',keyboard: true,backdrop: false,windowClass: 'my-class'});
                dlg.result.then(function(name){
                    $scope.name = name;
                },function(){
                    if(angular.equals($scope.name,''))
                        $scope.name = 'You did not enter in your name!';
                });
                break;
            case 'custom2':
                var dlg = dialogs.create('/dialogs/custom2.html','customDialogCtrl2',$scope.custom,{size:'lg'});
                break;
        }
    }; // end launch

    var _fakeWaitProgress = function(){
        $timeout(function(){
            if(_progress < 100){
                _progress += 33;
                $rootScope.$broadcast('dialogs.wait.progress',{'progress' : _progress});
                _fakeWaitProgress();
            }else{
                $rootScope.$broadcast('dialogs.wait.complete');
                _progress = 33;
            }
        },1000);
    }; // end _fakeWaitProgress
}]);

app.controller('ProjectDetailsController',['$routeParams','$scope','ProjectsService','TabService','$location',
    function($routeParams, $scope, ProjectsService, TabService, $location){

    TabService.setTab(2);

    var pId = $routeParams.projectId;
    $scope.pId = pId;
    ProjectsService.getProjectById(pId).then(function(data) {
        if(data.message){
            $location.path('/projects');
            // TODO: flash service for notifying the user that that project does not exist
            return;
        } else {
            $scope.project = data;
        }

    });

}]);

app.controller('TodoController', ['$http', '$scope', 'GetTodos','TabService', function($http, $scope, GetTodos, TabService){

    TabService.setTab(3);

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

    TabService.setTab(4);

}]);

app.controller('HomeController', ['TabService', function(TabService){

    TabService.setTab(1);

}]);