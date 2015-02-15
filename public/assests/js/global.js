


    

// //auto suggest search bar
//     $(document).ready(function(){
//       var users = new Bloodhound({
//         datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
//         queryTokenizer: Bloodhound.tokenizers.whitespace,
//         remote: <?php echo asset("'search/query?query=%QUERY'") ?>
//       });

//       users.initialize();

//       $('#users').typeahead({
//         hint: true,
//         highlight: true,
//         minLength: 2
//       }, {
//         name: 'users',
//         displayKey: 'name',
//         source: users.ttAdapter()
//        });
//     });

