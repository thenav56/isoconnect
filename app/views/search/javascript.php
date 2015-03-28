<script>
//auto suggest search bar
    $(document).ready(function(){
      
      var user = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: '<?php echo asset('search/query?query=%QUERY&type=users') ?>'
      });


       var group = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: '<?php echo asset('search/query?query=%QUERY&type=groups') ?>'
      });


      user.initialize();
      group.initialize();

        $('#group').typeahead({
        hint: true,
        highlight: true,
        minLength: 2
      },{
        name: 'group',
        displayKey: 'name',
        source: group.ttAdapter() ,
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
       });

      $('#user').typeahead({
        hint: true,
        highlight: true,
        minLength: 2
      },{
        name: 'user',
        displayKey: 'name',
        source: user.ttAdapter() ,
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
       });

       

       
    });
</script>

