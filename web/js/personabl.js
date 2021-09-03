function swapvideo(data){
    var window;
    window = $('#window'+data.id).empty();

    window.append("<camera id='Personabl"+data.id+"' data-app-id='"+data.appid+"' data-video-data='{\"user_id\": \""+data.userid+"\", \"user_name\":\""+data.username+"\", \"ujob_id\":\""+data.jobid+"\"}' data-sources='record' style='width:267px; height:200px;'></camera>");
    CameraTag.setup();
}