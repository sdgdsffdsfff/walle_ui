/*
 frc = new FileReaderClient(web_socket_url,pid,filename);
 frc.on('message',function(evt){
 });
 frc.on('close',function(evt){
 });
 frc.on('open',function(evt){
 });
 frc.start();
 */

/*
 String.prototype.format = function(param) {
 var formatted = this;
 for(i in param ){
 var regexp = new RegExp('\\{'+i+'\\}', 'gi');
 formatted = formatted.replace(regexp, param[i]);
 }
 return formatted;
 };
 */

var FileReaderClient = function (socket_url, pid, filename, tail_line_count) {
    this.socket_url = socket_url;
    this.pid = pid;
    this.filename = filename;
    this.tail_line_count = tail_line_count.toString();


    var callback_for_events = {
        'open': function (evt) {
            console.log("open event");
        }
        , 'close': function (evt) {
            console.log("close event");
        }
        , 'message': function (evt) {
            console.log("message event");
        }
    }
    this.start = function () {
        var _self = this;
        var ws;
        if (window.WebSocket) {
            ws = new WebSocket(this.socket_url);
        } else if (window.MozWebSocket) {
            ws = MozWebSocket(this.socket_url);
        } else {
            alert('Your browser does not support web socket, please use Chrome or Firefox');
            return false;
        }
        ws.onopen = function (evt) {
            var s = '{"pid":' + _self.pid + ',"filename":"' + _self.filename + '","tail_line_count":' + _self.tail_line_count + '}';
            ws.send(s);
            callback_for_events['open'](evt);
        }
        ws.onmessage = callback_for_events['message'];
        ws.onclose = callback_for_events['close'];
        _self.ws = ws;
        return true;
    }
    this.on = function (event_name, callback) {
        callback_for_events[event_name] = callback;
    }
    this.close = function () {
        console.log("try to close websocket");
        this.ws.close();
    }
    console.log("FileReaderClient initialized");
}
FileReaderClient.checkWebsocketAvailability = function (socket_url, callback) {
    var available = false;
    var frc = new FileReaderClient(socket_url, -1, '/var/log/system.log', true);
    frc.on('close', function (evt) {
        console.log(evt);
        if (evt.code == 3002) {
            // 3002 means invalid pid,  websocket 正常
            callback(true);
        } else {
            callback(false);
        }
    });
    if (frc.start() === false) {
        callback(false);
    }
}

FileReaderClient.run = function (socket_url, pid, filename, div_id, tail_line_count) {
    FileReaderClient.checkWebsocketAvailability(socket_url, function (available) {
        if (available) {
            if (FileReaderClient._clients[div_id]) {
                FileReaderClient._clients[div_id].close();
            }
            var frc2 = new FileReaderClient(socket_url, pid, filename, tail_line_count);
            frc2.on('message', function (evt) {
                console.log(evt);
                var d = document.getElementById(div_id);
                d.textContent = d.textContent + evt.data;
            });
            frc2.on('close', function (evt) {
                console.log(evt);
                var d = document.getElementById(div_id);
                d.textContent = d.textContent + "\nwebsocket closed";
            });
            frc2.start();
            FileReaderClient._clients[div_id] = frc2;
        } else {
            alert('failed to connect ' + socket_url);
        }
    });
}
FileReaderClient.cat = function (socket_url, pid, filename, div_id) {
    FileReaderClient.run(socket_url, pid, filename, div_id, -1);
}
FileReaderClient.tail = function (socket_url, pid, filename, div_id) {
    FileReaderClient.run(socket_url, pid, filename, div_id, 10);
}
FileReaderClient._clients = {}
