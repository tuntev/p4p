/**
 * Created by tunte on 8/29/14.
 */

var q = require('q');
var config = require('./config/app');
var port = config.chat.port;
var client = require('socket.io').listen(port).sockets;

var nbrMessages = 20;

var db = require('./helpers/db.js');

client.on('connection', function(socket){

    var sendStatus = function(s){
        socket.emit('status', s);
    };

    socket.on('userConnected', function(){
        var dbCalls = [];
        dbCalls.push(db.query('SELECT id, nickname, message, created_at FROM chat_messages ORDER BY id asc LIMIT ' + nbrMessages));
        q.all(dbCalls).then(
            function(results) {
                socket.emit('loaded_msgs', results[0]);
            },
            function(e) {
                console.log(e);
                socket.emit('error_msg', 'Грешка при вчитувањето на податоци од база');
                return;
            }
        );
    });

    // connected
    socket.on('input', function(data){
        var nickname = data.nickname;
        var message = data.message,
            whitespacePattern = /^\s*$/;

        if(nickname === '' || message === ''){
            sendStatus('Message is required');
        }
        else{
            _storeNewMessage(data);

            sendStatus({
                message: "Message sent",
                clear: true
            });

        }
    });

    socket.on('delete_msg_req', function(id){

        var dbPromise = db.query('DELETE FROM chat_messages WHERE id='+id);
        dbPromise.then(
            function(result) {
                client.emit('delete_msg_resp',id);
            },
            function() {
                // TODO: log errors in file
                socket.emit('error_msg', 'Грешка при праќањето на пораката');
                return;
            }
        );


        // remove the message form the db.
        // emit event for delete the message form the clients
    });
});

function _storeNewMessage(data, socket) {

    var msgDate = new Date();

    var dbPromise = db.query('INSERT INTO chat_messages ' +
        '(id, nickname, message, created_at, updated_at) VALUES (?, ?, ?, ?, ?)',
        [null, data.nickname, data.message, msgDate, msgDate]);
    dbPromise.then(
        function(result) {
            if (result.insertId >= 0) {
                data.id = result.insertId;
                data.created_at = msgDate;
                client.emit('output', [data]);
            }
        },
        function() {
            // TODO: log errors in file
            socket.emit('error_msg', 'Грешка при праќањето на пораката');
            return;
        }
    );
}
