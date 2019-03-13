<!DOCTYPE html>
<html lang="vi" style="height : auto;width : auto">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="/public/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="/public/jquery-3.3.1.min.js"></script>
    <link href="/public/css/chat.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Sega-Group</title>
</head>
<body style="max-height : 400px">
    <div class="row chat-window col-xs-5 col-md-3" id="chat_window_1" style="width: 500px;margin:0px;position: fixed;z-index : 1000;right: 0;padding : 0">
        <div class="col-xs-12 col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading top-bar">
                    <div class="col-md-8 col-xs-8">
                        <h3 class="panel-title"><span class="glyphicon glyphicon-comment"></span> Chat - Miguel</h3>
                    </div>
                    <div class="col-md-4 col-xs-4" style="text-align: right;">
                        <a href="#"><span id="minim_chat_window" class="glyphicon glyphicon-minus icon_minim"></span></a>
                        <a href="#"><span class="glyphicon glyphicon-remove icon_close" data-id="chat_window_1"></span></a>
                    </div>
                </div>
                <div id="chat_mess" class="panel-body msg_container_base">                
            </div>
                <div class="panel-footer">
                    <div class="input-group">
                        <input id="btn-input" type="text" class="form-control input-sm chat_input" placeholder="Write your message here...">
                        <span class="input-group-btn">
                        <button class="btn btn-primary btn-sm" id="btn-chat">Send</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="/public/bootstrap.min.js"></script>
<script src="https://sega-group.com:3000/socket.io/socket.io.js"></script>
<script src="/public/js/node.js"></script>
<script>


</script>
</html>