

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

 $(window).focus(function() {
                window_focus = true;
            }).blur(function() {
                window_focus = false;
            })

 $(document).ready(function(){ 

            window_focus = false ;
            fixtitle = document.title ;
             setInterval(function(){   
            
               this.value2 = $("#nav-mess").load('<?php echo asset('user/message/count'); ?>' ,
                function(responseTxt , statusTxt){
                if(statusTxt == "success"){
                //   console.info(
                // 'value1 = '+value1
                // +' responseTxt= '
                // +(responseTxt).match(/\d+/)+'  ---------'
                // );
                  if( (responseTxt).match(/\d+/) > value1 ){
                        $.playSound('<?php echo asset('assests/sound/notifiy') ; ?>'); 
                        document.title = 'Isoconnect ('+(responseTxt).match(/\d+/)+')';
                      }
                }
               });   
              
              this.value_2 = $("#nav-noti").load('<?php echo asset('user/notification/count') ; ?>' ,
                function(responseTxt , statusTxt){
                if(statusTxt == "success"){
                //   console.info(
                // 'value_1 = '+value_1
                // +' responseTxt= '
                // +(responseTxt).match(/\d+/)+'  ---------'
                // );
                  if( (responseTxt).match(/\d+/) > value_1 ){
                    $.playSound('<?php echo asset('assests/sound/notifiy') ; ?>'); 
                    document.title = 'Isoconnect ('+(responseTxt).match(/\d+/)+')';
                  }
               
                }
               });  
              
              this.value1 = (document.getElementById('nav-mess').innerHTML).match(/\d+/);
              this.value_1 = (document.getElementById('nav-noti').innerHTML).match(/\d+/);

              if(window_focus)
                  document.title = fixtitle ;   
               }, 6000);
            });

</script>

<script>
//auto suggest search bar
    $(document).ready(function(){
      
      var users = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: '<?php echo asset('search/query?query=%QUERY&type=users') ?>'
      });


       var groups = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: '<?php echo asset('search/query?query=%QUERY&type=groups') ?>'
      });


      users.initialize();
      groups.initialize();

      $('#users').typeahead({
        hint: true,
        highlight: true,
        minLength: 2
      }, [{
        name: 'users',
        displayKey: 'name',
        source: users.ttAdapter() ,
        templates: {
                        empty: [
                            '<div class="list-group">',
                            '<div class="list-group-item">',
                            'No Users Found',
                            '</div>',
                            '</div>'
                        ].join('\n'),
                         suggestion: Handlebars.compile(
                          "<a href='<?php echo asset('user/') ;?>/{{id}}' class='list-group-item' >"
                          +"<div class='row'>"
                          +"<div class='col-md-4'>"
                          +"<img class='img-circle img-responsive img-center' src='<?php echo asset('profile_pic/low/crop/') ;?>/{{profile_pic}}' >"
                          +"</div>"
                          +"<div class='col-md'>"
                          +"<strong>{{name}}</strong>"
                          +"<div class='row'>"
                          +"<div class='col-md'>"
                          +"<h6>{{company}}</h6>"
                          +"</div>" 
                          +"</div>"
                          +"</div>"
                          +"</div>"
                          +"</a>"
                          +"</div>"
                          ),
                         header: Handlebars.compile(
                          '<div class="list-group">'
                          +'<div class="list-group-item active">'
                          +'Users'
                          +'</div>')
                       
                    }
       } , {
        name: 'groups',
        displayKey: 'name',
        source: groups.ttAdapter() ,
        templates: {
                        empty: [
                            '<div class="list-group">',
                            '<div class="list-group-item">',
                            'No Groups found',
                            '</div>',
                            '</div>'
                        ].join('\n'),
                         suggestion: Handlebars.compile(
                          "<a href='<?php echo asset('group/') ;?>/{{id}}' class='list-group-item'>"
                          +"<div class='row'>"
                          +"<div class='col-md-4'>"
                          +"<img class='img-circle img-responsive img-center' src='<?php echo asset('profile_pic/low/crop/') ;?>/{{profile_pic}}' >"
                          +"</div>"
                          +"<div class='col-md'>"
                          +"<h6><strong>{{name}}</strong></h6>"
                          +"<div class='row'>"
                          +"<div class='col-md col-md-offset-4'>"
                          +"<h6>{{admin_id}}</h6>"
                          +"</div>" 
                          +"</div>"
                          +"</div>" 
                          +"</div>" 
                          +"</a>" 
                          +"</div>"
                          ),
                          header: Handlebars.compile(
                            '<div class="list-group">'
                          +'<div class="list-group-item active">'
                          +'Groups'
                          +'</div>')
                       
                    }
       }]);

       

       
    });
</script>

<script>
  
 //for post multiple image upload 
  $(document).on('change', '.btn-file :file', function() {
  var input = $(this),
      numFiles = input.get(0).files ? input.get(0).files.length : 1,
      label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
  input.trigger('fileselect', [numFiles, label]);
});

$(document).ready( function() {
    $('.btn-file :file').on('fileselect', function(event, numFiles, label) {
        
        var input = $(this).parents('.input-group').find(':text'),
            log = numFiles > 1 ? numFiles + ' files selected' : label;
        
        if( input.length ) {
            input.val(log);
        } else {
            //if( log ) alert(log);
        }
        
    });
});
</script>
