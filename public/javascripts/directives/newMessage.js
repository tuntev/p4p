/**
 * Created by tunte on 19-Nov-14.
 */
angular.module('app.directives.newMessage',[]).directive('newMessage', function(){
    return {
        restrict: 'E',
        scope: {
            message: '=data'
        },
        templateUrl: 'templates/chat/message.html',
        controller: function($scope){

        }
    };
});
