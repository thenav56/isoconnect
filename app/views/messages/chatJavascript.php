


<script>

function chat () {
	instanse = false ;
    last_message = 1;
    messenger_id_forAuto_scroll = 1 ;

    this.update = updateChat;
    this.send = sendChat;
    this.getState = getStateOfChat;
}

// $.maintainscrollMessanger = function() {
//                      if(window.messenger.indexOf('[') > 0)
//                         {
//                         var pathname = window.location.href ;
//                         var parts = window.messenger.split('['); 
//                         if(parts[1] == pathname){
//                           window.messenger = $.trim(parts[0]);
//                           window.scrollTo(parseInt(parts[parts.length - 1]), parseInt(parts[parts.length - 2])- 50);
//                           window.messenger = ' ['+pathname+'[' + $(window).scrollTop().toString() + '[' + $(window).scrollLeft().toString();
//                           }
//                         }   
//                       }; 

//gets the state of the chat
function getStateOfChat() {
	if(!instanse){
		instanse = true;
		$.ajax({
			type: "POST",
			url: "<?php echo asset('messenger') ;?>",
			data: {'function': 'getState', 'conversation' : <?php echo $conversation_id ; ?>, 'otherUser':<?php echo $otherUser->id ;?>},
			dataType: "json",	
			success: function(data) {
				last_message = data.last_message ;
				instanse = false;
				console.info(data.seen);
			}
		});
	}	
}

//Updates the chat
function updateChat() {
	if(!instanse){		
		instanse = true;
		$.ajax({
			type: "POST",
			url: "<?php echo asset('messenger') ;?>",
			data: { 'last_message': last_message , 'function': 'update','conversation' : <?php echo $conversation_id ; ?>,'otherUser': <?php echo $otherUser->id ;?>  },
			dataType: "json",
			success: function(data) {
				if(data.text){
					 $('#chat-area').append(
					 	 "<div class='row' id='"
    					+messenger_id_forAuto_scroll
					 	+"' >"
					 	+"<div class='bg-success new_message col-md-6 col-md-offset-2'>"
           	 			+"<div class='text-left'>"
           	     		+"<div class='alert alert-block'>"
           	     		+"<a class='btn btn-success' href='"
           	     		+data.user_link
           	     		+"'>"
           	     		+data.user
           	     		+"</a>"
           	     		+data.text
				 		+"<span class='text-muted pull-right '>"
				 		+data.date
				 		+"</span>"
				 		+"</div>"
       					+"</div>"
       		 			+"</div>"
       		 			+"</div>"
					 	+"<br>"
					 	);
				var el = document.getElementById(messenger_id_forAuto_scroll) ;
				el.scrollIntoView(true);
				messenger_id_forAuto_scroll++ ;
				// $.maintainscrollMessanger();
				}
				document.getElementById('chat-area').scrollTop = document.getElementById('chat-area').scrollHeight;
				instanse = false;
				last_message = data.last_message;
			}
		});
	}
	else {
		setTimeout(updateChat, 1500);
	}
}

//send the message
function sendChat(message, nickname) { 
	updateChat();
	$.ajax({
		type: "POST",
		url: "<?php echo asset('messenger') ;?>",
		data: {'function': 'send','message': message,'nickname': nickname,'last_message':last_message ,'otherUser':<?php echo $otherUser->id ;?>},
		dataType: "json",
		success: function(data){
			updateChat();
		}
	});
}
 	
	
</script>

<script>

  // kick off chat
  var chat =  new chat();

  $(function() {
  
     chat.getState(); 
     
     // watch textarea for key presses
     $("#sendie").keydown(function(event) {  
     
         var key = event.which;  
   
         //all keys including return.  
         if (key >= 33) {
           
             var maxLength = $(this).attr("maxlength");  
             var length = this.value.length;  
             
             // don't allow new content if length is maxed out
             if (length >= maxLength) {  
                 event.preventDefault();  
             }  
         }  
                                                                                                     });
     // watch textarea for release of key press
     $('#sendie').keyup(function(e) {  
                
        if (e.keyCode == 13) { 
        
              var text = $(this).val();
              var maxLength = $(this).attr("maxlength");  
              var length = text.length; 
               
              // send 
              if (length <= maxLength + 1) { 
                chat.send(text, name);  
                $(this).val("");
              } else {
                $(this).val(text.substring(0, maxLength));
              }  
        }
     });
  });
</script>


<body onload="setInterval('chat.update()', 1000)">