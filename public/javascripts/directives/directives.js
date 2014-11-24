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
    .directive('singleProject', function($compile){
        return {
            restrict: 'E',
            templateUrl: 'templates/projects/project.html',
            scope: {
                project: '=',
                access: '=',
                onClick: '&'

            },
            link: function(scope, element, attrs) {
                //$compile(element.contents())(scope.$new());
            }
        }
    })
    .directive('contactCard', function(){
        return {
            restrict: 'E',
            templateUrl: 'templates/contacts/contact.html',
            scope: {
                contactData: '='
            }
        }
    })
    ;
