$(document).ready(function(){
    
    $('.btn-like').click(function(){
        var params = {
          'id': $(this).attr('data-id')  
        };
        $.post('/post/default/like',params, function(data){
            console.log(data);
            if (data.success === true){
                $(".btn-like[data-id='"+data.id+"']").hide();
                $(".btn-dislike[data-id='"+data.id+"']").show();
                
                $(".btn-like[data-id='"+data.id+"'] span.count-like").html(data.countLikes);
                $(".btn-dislike[data-id='"+data.id+"'] span.count-dislike").html(data.countLikes);
                
            }
        });
        return false;
    });
    
    $('.btn-dislike').click(function(){
        var params = {
          'id': $(this).attr('data-id')  
        };
        $.post('/post/default/dis-like',params, function(data){
            console.log(data);
            if (data.success === true){
                $(".btn-like[data-id='"+data.id+"']").show();
                $(".btn-dislike[data-id='"+data.id+"']").hide();
                
                $(".btn-dislike[data-id='"+data.id+"'] span.count-dislike").html(data.countLikes);
                $(".btn-like[data-id='"+data.id+"'] span.count-like").html(data.countLikes);
            }
        });
        return false;
    });
});

