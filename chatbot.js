$(document).ready(function(){
  $('#chatbox').ready(function(){
  var chat;
  chat = $("#chatbox").contents().find("#chat");
  chat.append('<div class="message">'+
      '<div class="botMessage"> Bonjour, comment puis-je vous aider?'+
      '</div>' +
      '<div class="hour">' + gethour() + '</div>'+
      '</div>'
  );
  $("#post").click(function(e){
    sendMessage(e);
  });
  $(document).on('keypress',function(e) {
    if(e.which == 13) {
      sendMessage(e);
    }
});

  function gethour(){
    var date=new Date();
    var h=date.getHours();
    if (h<10) {h = "0" + h}
    var m=date.getMinutes();
    if (m<10) {m = "0" + m}
    var s=date.getSeconds();
    if (s<10) {s = "0" + s}
    return h+":"+m+":"+s
  }

  function searchFirstKey(mlemaudit, data){
    var found;
    message = $.trim(mlemaudit);
    message = message.toLowerCase();
    if(data[message]!=undefined) found = data[message];
    message = message.split(" ");
    var i = 0;
    while(data[message[i]]==undefined && i<message.length && found==undefined){
      i++;
    }
    if(i<message.length && found==undefined){
      console.log(data[message[i]]);
      found = data[message[i]];
    }
    return found;
  }



  function sendMessage(e){
    e.preventDefault();
    var message = $("#message").val();
    $("#message").val("");
    if(message=="nuit2linfo"){
      chat.append('<img class="fit-picture"' +
     'src="gif_nuit_info.gif"'+
     'alt="Grapefruit slice atop a pile of other slices">'
      );
    }else{
    chat = $("#chatbox").contents().find("#chat");
    chat.append('<div class="message"><div class="userMessage">' +
            message +
          '</div>' +
          '<div class="hour">' + gethour() + '</div>'+
          '</div>'
    );

    $("#chatbox").contents().find("#bubble_loading").toggleClass("hidden");

    setTimeout(function(){
    $.getJSON("texte.json", function(data){
      var response = searchFirstKey(message, data);
      $("#chatbox").contents().find("#bubble_loading").toggleClass("hidden");
      chat.append('<div class="message"> <div class="botMessage">' +
              (response!=undefined?response:'Je ne comprend pas votre question')+
              '</div>' +
              '<div class="hour">' + gethour() + '</div>'+
              '</div>'
      );
    });
  }, 2000);
}
    setTimeout(scrollDownFrame, 100);

  };
  function scrollDownFrame(){
    var bodyChat = $("#chatbox").contents().find("#containerChat");
    document.getElementById('chatbox').contentWindow.scrollBy(bodyChat.height(),bodyChat.height());
  }


});
});
