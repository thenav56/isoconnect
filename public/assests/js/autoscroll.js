$(document).ready(function(){
                      window.onbeforeunload = function(e){    
                        var pathname = window.location.href ;
                        window.name = ' ['+pathname+'[' + $(window).scrollTop().toString() + '[' + $(window).scrollLeft().toString();
                        };
                        
                      $.maintainscroll = function() {
                      if(window.name.indexOf('[') > 0)
                        {
                        var pathname = window.location.href ;
                        var parts = window.name.split('['); 
                        if(parts[1] == pathname){
                          window.name = $.trim(parts[0]);
                          window.scrollTo(parseInt(parts[parts.length - 1]), parseInt(parts[parts.length - 2]));
                          }
                        }   
                      };  
                      $.maintainscroll();
                      })(jQuery);