// server.js

// var express = require('express');
// var app = express();
// var http = require('http').Server(app); //1
// var io = require('socket.io')(http);    //1

var fs = require( 'fs' );
var app = require('express')();
var https = require('https');
var server = https.createServer({
    key: fs.readFileSync('/etc/letsencrypt/live/www.samdisamdi.com/privkey.pem'),
    cert: fs.readFileSync('/etc/letsencrypt/live/www.samdisamdi.com/cert.pem'),
    ca: fs.readFileSync('/etc/letsencrypt/live/www.samdisamdi.com/chain.pem'),
    requestCert: false,
    rejectUnauthorized: false
},app);
server.listen(6848);

var io = require('socket.io').listen(server);

app.get('/',function(req, res){  //2
    res.sendFile(__dirname + '/client.html');
});

var count=1;

io.on('connection', function(socket){ //3
    console.log('user connected: ', socket.id);  //3-1
    var name = "user" + count++;                 //3-1
    var helloMSG = name + ' has entered'
    var goodbyeMSG = name + ' has left'

    //새로운 사람 입장 시 입장 알림
    io.emit('receive message', helloMSG);

    io.to(socket.id).emit('change name',name);   //3-1

    socket.on('disconnect', function(){ //3-2
        console.log('user disconnected: ', socket.id);
        //퇴장 시 퇴장 알림
        io.emit('receive message', goodbyeMSG);
    });

    socket.on('send message', function(name,text){ //3-3
        var msg = name + ' : ' + text;
        console.log(msg);
        io.emit('receive message', msg);
    });
});

server.listen(6848, function(){ //4
    console.log('server on!');
});