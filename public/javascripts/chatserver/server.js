/**
 * Created by tunte on 8/29/14.
 */
//var mongo = require('mongodb').MongoClient;
var client = require('socket.io').listen(1133).sockets;

//mongo.connect('mongodb://127.0.0.1/chat', function(err, db){
//
//    if(err) throw err;


    client.on('connection', function(socket){

        // todo: save the message into db
        //var col = db.collection('messages');
        var sendStatus = function(s){
            socket.emit('status', s);
        };

        // todo: load messages from db
        // emit all messages
        //col.find().limit(100).sort({_id: 1}).toArray(function(error, res){
        //    if(error) throw error;
        //
        //    socket.emit('output', res);
        //});

        // connected
        socket.on('input', function(data){
            var email = data.email;
            var message = data.message,
                whitespacePattern = /^\s*$/;

            if(email === '' || message === ''){
                sendStatus('Message is required');
            }
            else{
                //col.insert({name: name, message: message}, function() {

                    // emit latest message to all clients
                    client.emit('output', [data]);
                    //sendStatus({
                    //    message: "Message sent",
                    //    clear: true
                    //});
                //});
            }



        });

    });
//});
