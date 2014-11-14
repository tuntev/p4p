/**
 * Created by tunte on 11/3/14.
 */

app.controller('HomeController',['$scope','TabService', function($scope, TabService){

    TabService.setTab(1);
}]);

app.controller('ProjectsController', ['$scope','ProjectsService','TabService','$rootScope','$timeout','dialogs',
    function($scope, ProjectsService, TabService, $rootScope, $timeout, dialogs){

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
            $scope.projects.unshift(projectData);
            $scope.data.title = '';
            $scope.data.student = '';
        }


    }
    // add new project

    // delete a project
    $scope.removeChecked = function() {
        $scope.projects = _.filter($scope.projects, function(item) {
            if(item.selected) {
                ProjectsService.delete(item.id);
            }
            return !item.selected;
        });
    };

    $scope.selected = function(){
        var count = 0;

        angular.forEach($scope.projects, function(project){
            count += project.selected ? 0 : 1;
        });
        return count;
    }

    // handle dialogs
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
                        if($scope.selected() !== $scope.projects.length){
                            var dlg = dialogs.confirm('Confirm','Are you sure that you want to delete the selected projects?');
                            dlg.result.then(function(btn){
                                $scope.removeChecked();
                            },function(btn){

                            });
                        }
                    }
                    if(type === 'close'){
                        var dlg = dialogs.confirm('Confirm','Are you sure that you want to finish the project?');
                        dlg.result.then(function(btn){
                            $scope.changeDone(pId,'1');
                        },function(btn){

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