/**
 * Created by tunte on 19-Nov-14.
 */
app.controller('ChatController', ['TabService','$scope','UserService','$sanitize', function(TabService, $scope, UserService, $sanitize){

    TabService.setTab(5);

    var $textArea = $('.chat textarea');
    var $status = $('.chat-status span');
    var statusDefault = $status.text();
    var $chatMessages = $('.chat-messages');

    var setStatus = function(s){
        $status.text(s);

        if(s !== statusDefault){
            var delay = setTimeout(function(){
                setStatus(statusDefault);
                clearInterval(delay);
            }, 3000);
        }
    };

    UserService.getUser($scope.id_user).then(function(data){

        $scope.nickname = data.email;// + ' ' + data.lastName[0] + '';

    });

    try{
        var socket = io.connect('http://localhost:1133');
    }catch(e) {
        // set status to wan the user
    }



    if(socket !== undefined){

        $scope.sendMsg = function(){

            if($scope.message){
                socket.emit('input', {
                    nickname: $sanitize($scope.nickname),
                    message: $sanitize($scope.message)
                });
            }
        };

        socket.emit('userConnected');

        socket.on('output',function(data){
            if(data.length){

                data[0].created_at = $scope.prettyDate(data[0].created_at);
                $scope.messages.push(data[0]);
                $scope.$apply();
                $chatMessages.animate({scrollTop: '3000px'});
            }
        });

        socket.on('status', function(data){
            setStatus((typeof data === 'object') ? data.message : data);

            if(data.clear === true){
                $scope.message = '';
                $scope.$apply();
            }
        });

        socket.on('loaded_msgs', function(data){
            var i;
            $scope.messages = data;
            for(i=0;i<$scope.messages.length;i++){
                $scope.messages[i].created_at = $scope.prettyDate($scope.messages[i].created_at);
            }
            $scope.$apply();
        });
    }
    else {
        $('.theMessage').attr("disabled","disabled");
        $('.theMessage').attr('placeholder','Chat unavailable');
    }

    // most important: remove the listeners
    $scope.$on('$destroy', function (event) {
        socket.removeAllListeners();
        // or something like
        // socket.removeListener(this);
    });

    $scope.prettyDate = function(date){
        return $.format.date(date, "dd/MM/yyyy HH:mm:ss")
    }

}]);