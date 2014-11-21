/**
 * Created by tunte on 19-Nov-14.
 */
angular.module('app.directives',[])
    .directive('newMessage', function(){
        return {
            restrict: 'E',
            scope: {
                message: '=data'
            },
            templateUrl: 'templates/chat/message.html',
            controller: function($scope){

            }
        };
    })
    .directive('singleProject', function(){
        return {
            restrict: 'E',
            templateUrl: 'templates/projects/project.html',
            scope: {
                project: '=',
                access: '='
            }
        }
    })
    .directive('contactCard', function(){
        return {
            restrict: 'E',
            templateUrl: 'templates/contacts/contact.html',
            scope: {
                contactData: '='
            },
            link: function(scope, element, attr){
                scope.$watch('contactData', function(data) {

                })
            }
        }
    })
    ;
