// server.js

//json을 받아서 json의 키와 밸류를 바꾸는 함수
//key - socket.id 와 value - nickname 바꿀 때 사용됨
function swap(json) {
    var ret = {};
    for (var key in json){
        ret[json[key]] = key;
    }
    return ret
}

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

//채팅방 설정
let room = ['room1', 'room2'];
//사용자의 socket.id와 nickaname을 저장하기 위한 json
let clients = {};

//연결 시
io.on('connection', function (socket) {
    //닉네임 생성 이벤트
    socket.on('create nick name', function (nickname) {
        //닉네임 중복 유무 저장 변수
        let isNameOverlap = false;
        //clients 배열에 중복 되는 닉네임 있는지 체크
        for (let i in clients) {
            //중복 되는 경우 클라이언트에게 닉네임 변경 강제
            if(clients[i] == nickname) {
                isNameOverlap = true;
                io.to(socket.id).emit('force change name');
                console.log('닉네임 중복 발생');
                break;
            }
        }
        //중복 되지 않은 경우 clients에 정보 저장
        if (!isNameOverlap) {
            clients[socket.id] = nickname;
            //클라이언트가 name confirm을 수신하면
            //클라이언트에서 1번 방에 입장 요청하는 emit 발송
            io.to(socket.id).emit('name confirm');
        }
    })


    //사용자 입장시 콘솔 출력
    console.log('user connected', socket.id);
    //사용자 페이지 이탈 시
    socket.on('disconnect', function () {
        //콘솔 출력
        console.log('user disconnected ', socket.id);

        //연결 해제 시
        io.emit('user disconnect', clients[socket.id]);
        if(clients[socket.id]) {
            //clients에서 socket.id에 해당하는 키/밸류 데이터 삭제제
           delete clients[socket.id];
        }
    });

    //룸 이탈 이벤트
    socket.on('leaveRoom' , function (roomNum, name) {
        //룸 이동
        socket.leave(room[roomNum], function () {
            console.log(name + ' left ' + room[roomNum]);
            //나간 룸에게 유저가 나갔다는 사실 emit
            io.to(room[roomNum]).emit('leaveRoom', roomNum, name);
        });
    });

    //룸 조인 이벤트
    socket.on('joinRoom', function (roomNum, name) {
        //룸 조인
        socket.join(room[roomNum], function () {
           console.log(name + ' joined ' + room[roomNum]);
           //조인 한 룸에게 유저가 조인 했다는 사실 emit
           io.to(room[roomNum]).emit('joinRoom', roomNum, name);
        });
    });

    //클라이언트에게 채팅을 받은 경우
    socket.on('chat message', function (roomNum, name, msg) {
        //메시지가  '/w '로 시작하는지 체크하여 귓속말인지 아닌지 구분
        if(msg.startsWith('/w ')) {
            //귓속말 보내는 사용자
            const fromUser = name;
            //귓속말 받는 사용자
            const toUser = msg.split(' ')[1];
            const swapClient = swap(clients);

            //귓속말로 보낼 메시지
            const msgArray = msg.split(' ');
            //'/w' 와 '수신자' 값 삭제
            msgArray.shift();
            msgArray.shift();
            msg = msgArray.join(" ");

            //귓속말 전송자에게 귓속말 내용 보내기
            io.to(socket.id).emit('hidden message', '(to ' + toUser + ') : ' + msg);
            //귓속말 수신자에게 귓속말 내용 보내기
            io.to(swapClient[toUser]).emit('hidden message', '(from ' + fromUser + ') : ' + msg);
        }
        else {
            console.log(roomNum, name, msg);
            io.to(room[roomNum]).emit('chat message', name, msg);
        }
    });
});

server.listen(6848, function(){ //4
    console.log('server on!');
});