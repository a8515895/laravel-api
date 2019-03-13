$(document).ready(function(){
    let audio = new Audio("/public/mess2.mp3");
    var socket = io.connect('https://sega-group.com:3000',{secure : true});
    socket.emit("init",{level : 'customer',ip : ip});
    var room = 0;
    socket.on("agent_send_message",(data)=>{
        let div;
        let avartar;
        let name;
        console.log(data);
        if(data.agent == null || data.agent == ""){
            avartar = "no-avartar.png";
            name = "SYSTEM";
        }
        else {
            avartar = data.agent.avartar;
            name = data.agent.name;
        }
        audio.play();
        if(data.status == true){
            div=`
            <div class="row msg_container base_receive">
                <div class="col-md-4 col-xs-4 avatar">
                    <img src="/public/img/avartar/${avartar}" class=" img-responsive ">
                </div>
                <div class="col-md-8 col-xs-8">
                    <div class="messages msg_receive">
                        <p>${data.data}</p>
                        <time datetime="2009-11-13T20:00">${name} • 51 min</time>
                    </div>
                </div>
            </div>
            `;
            room = data.room;
        }else{
            div=`
            <div class="row msg_container base_receive">
                <div class="col-md-4 col-xs-4 avatar">
                    <img src="/public/img/avartar/no-avartar.png" class=" img-responsive ">
                </div>
                <div class="col-md-8 col-xs-8">
                    <div class="messages msg_receive">
                        <p>Xin lỗi! Hiện các giao dịch viên đang bận</p>
                        <time datetime="2009-11-13T20:00">SYSTEM • 51 min</time>
                    </div>
                </div>
            </div>
            `;               
        }
        $("#chat_mess").append(div);
    })
    socket.on("agent_leave",function(data){
        div=`
            <div class="row msg_container base_receive">
                <div class="col-md-4 col-xs-4 avatar">
                    <img src="/public/img/avartar/no-avartar.png" class=" img-responsive ">
                </div>
                <div class="col-md-8 col-xs-8">
                    <div class="messages msg_receive">
                        <p>Giao dịch viên đã rời khởi cuộc trò chuyện</p>
                        <time datetime="2009-11-13T20:00">SYSTEM • 51 min</time>
                    </div>
                </div>
            </div>
        `; 
        $("#chat_mess").append(div);
    })
    socket.on("customer_rejoin",function(data){
        room = data.room;
        data.message.forEach((e)=>{
            if(e.target == "agent"){
                let div=`
                <div class="row msg_container base_receive">
                    <div class="col-md-4 col-xs-4 avatar">
                        <img src="/public/img/avartar/${data.agent.avartar}" class=" img-responsive ">
                    </div>
                    <div class="col-md-8 col-xs-8">
                        <div class="messages msg_receive">
                            <p>${e.message}</p>
                            <time datetime="2009-11-13T20:00">${data.agent.name} • 51 min</time>
                        </div>
                    </div>
                </div>
                `;
                $("#chat_mess").append(div);
            }else{
                let div = 
                `<div class="row msg_container base_sent">
                    <div class="col-md-8 col-xs-8">
                        <div class="messages msg_sent">
                            <p>${e.message}</p>
                            <time datetime="2009-11-13T20:00">Khách • 51 min</time>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-4 avatar">
                        <img src="/public/img/avartar/no-avartar.png" class=" img-responsive ">
                    </div>
                </div>
                `;   
                $("#chat_mess").append(div);            
            }
        })
    })
    socket.on("customer_send_message",function(data){
        if(data.data != null && data.data != ''){
            let div = 
            `<div class="row msg_container base_sent">
                <div class="col-md-8 col-xs-8">
                    <div class="messages msg_sent">
                        <p>${data.data}</p>
                        <time datetime="2009-11-13T20:00">Khách • 51 min</time>
                    </div>
                </div>
                <div class="col-md-4 col-xs-4 avatar">
                    <img src="/public/img/avartar/no-avartar.png" class=" img-responsive ">
                </div>
            </div>
            `;
            $("#chat_mess").append(div);
        }
    })
    socket.on("is_has_ban",function(data){
        if(data.status == true){
            hideChat();
            $("#chat_window_1").addClass("agent-ban");
            $("#chat-status").html("Disconect Server");
            $("#minim_chat_window").hide();
            $("#refresh-chat").show();
        }else{
            showChat()
            $("#minim_chat_window").show();
            $("#refresh-chat").hide();
            $("#chat_window_1").removeClass("agent-ban");
            $("#chat-status").html("");
        }
    })
    $("#btn-chat").on("click",()=>{
        if($("#btn-input").val() != null && $("#btn-input").val() != ''){
            socket.emit("customer_send_message",{room : room,data : $("#btn-input").val(),ip : ip})
            $("#btn-input").val('');
        }
    })
    $("#btn-input").on("keyup",(e)=>{
        if(e.keyCode == 13){
            $("#btn-chat").click();
        }
    })
    $("#close-chat").on("click",()=>{
        $(".msg_container_base").remove();
        socket.emit("customer_ban",{ip : ip,room : room});
    })
    $("#refresh-chat").on("click",()=>{
        socket.emit("init",{level : 'customer',ip : ip,refresh : true});
    })
})
$(document).on('click', '.panel-heading span.icon_minim', function (e) {
    if (!$("#minim_chat_window").hasClass('panel-collapsed')) {
        hideChat();
    } else {
        showChat();
    }
});
$(document).on('focus', '.panel-footer input.chat_input', function (e) {
    var $this = $(this);
    if ($('#minim_chat_window').hasClass('panel-collapsed')) {
        $this.parents('.panel').find('.panel-body').slideDown();
        $('#minim_chat_window').removeClass('panel-collapsed');
        $('#minim_chat_window').removeClass('glyphicon-plus').addClass('glyphicon-minus');
    }
});
$(document).on('click', '#new_chat', function (e) {
    var size = $( ".chat-window:last-child" ).css("margin-left");
    size_total = parseInt(size) + 400;
    alert(size_total);
    var clone = $( "#chat_window_1" ).clone().appendTo( ".container" );
    clone.css("margin-left", size_total);
});
function hideChat(){
    $("#chat_window_1").find('.panel-body').slideUp();
    $("#minim_chat_window").addClass('panel-collapsed');
    $("#minim_chat_window").removeClass('glyphicon-minus').addClass('glyphicon-plus');
}
function showChat(){
    $("#chat_window_1").find('.panel-body').slideDown();
    $("#minim_chat_window").removeClass('panel-collapsed');
    $("#minim_chat_window").removeClass('glyphicon-plus').addClass('glyphicon-minus');
}
