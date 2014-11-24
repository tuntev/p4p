/**
 * Created by tunte on 19-Nov-14.
 */
app.controller('ProjectsController', ['$scope','ProjectsService','TabService','$rootScope','$timeout','dialogs',
    function($scope, ProjectsService, TabService, $rootScope, $timeout, dialogs){

        TabService.setTab(2);

        // get all current project
        ProjectsService.getProjects().then(function(data) {
            $scope.projects = data;
            var i;
            for(i = 0; i < $scope.projects.length; i++){
                $scope.projects[i].updated_at = $.format.prettyDate($scope.projects[i].updated_at);
            }
        });

        // change DONE
        $scope.changeDone = function(id, done){
            var pId;
            ProjectsService.updateDone(id, done).then(function(data){
                pId = data.data;
                $('#pID' + pId).find('.dateInfo').html($.format.prettyDate(new Date()));
                $('.cnfBtn_'+pId).hide();
            });

        };

        $scope.currentPage = 1;
        $scope.pageSize = 5;

        $scope.pageChangeHandler = function(num) {
            //console.log('page changed to ' + num);
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
                    projectData.updated_at = $.format.prettyDate(new Date());
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
