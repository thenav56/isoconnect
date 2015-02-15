

<script>
            (function($){

            $.extend({
              playSound: function(){
                return $("<embed src='"+arguments[0]+".mp3' hidden='true' autostart='true' loop='false' class='playSound'>" + "<audio autoplay='autoplay' style='display:none;' controls='controls'><source src='"+arguments[0]+".mp3' /><source src='"+arguments[0]+".ogg' /></audio>").appendTo('body');
              }
            });

          })(jQuery);

</script>

 <script>
 $(document).ready(function(){  
             value_1 = (document.getElementById('nav-noti').innerHTML).match(/\d+/);
             value1 = (document.getElementById('nav-mess').innerHTML).match(/\d+/);

             setInterval(function(){   
               $("#nav-mess").load('{{asset('user/message/count')}}'); 
              value2 = (document.getElementById('nav-mess').innerHTML).match(/\d+/);
              //  console.log(value1);
              // console.log(value2);
              // console.log(value2>value1);
               if(value2>value1)
                   $.playSound('{{asset('assests/sound/notifiy')}}');


              
               $("#nav-noti").load('{{asset('user/notification/count')}}'); 
              value_2 = (document.getElementById('nav-noti').innerHTML).match(/\d+/);
              //  console.log(value_1);
              //    console.log(value_2);
              // console.log(value_2>value_1);
               if(value_2>value_1)
                  $.playSound('{{asset('assests/sound/notifiy')}}');


             value1 = (document.getElementById('nav-mess').innerHTML).match(/\d+/);
             value_1 = (document.getElementById('nav-noti').innerHTML).match(/\d+/);
              }, 3000);
              })(jQuery);

</script>

<script>
//auto suggest search bar
    $(document).ready(function(){
      var users = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: '<?php echo asset('search/query?query=%QUERY') ?>'
      });

      users.initialize();

      $('#users').typeahead({
        hint: true,
        highlight: true,
        minLength: 2
      }, {
        name: 'users',
        displayKey: 'name',
        source: users.ttAdapter()
       });
    });
</script>

