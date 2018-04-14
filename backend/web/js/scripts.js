$(document).ready(function(){
    
    //
   
    
//    $("tr td input[type='checkbox']").click(function(){
//        var keys = $('#w0').yiiGridView('getSelectedRows'); 
//        $("#test").text(keys);
//        $("#test").toggleClass('bg-success');
//        $("#w0").toggleClass('bg-success');
//        //$("#test2").text(checkBox.val() );
////        for(var i = 0; i < keys.length; i++ ){
////           var tmp = keys[i];
////        var checkBox = $('input[value="tmp"]');    
////            if (checkBox.checked === true){
////                alert("checked!");
////            }else{
////                alert("unchecked!");
////            }
////        }
//    });
//    
//    
//    $('.btn-like').click(function(){
//        var params = {
//          'id': $(this).attr('data-id')  
//        };
//        $.post('/post/default/like',params, function(data){
//            console.log(data);
//            if (data.success === true){
//                $(".btn-like[data-id='"+data.id+"']").hide();
//                $(".btn-dislike[data-id='"+data.id+"']").show();
//                
//                $(".btn-like[data-id='"+data.id+"'] span.count-like").html(data.countLikes);
//                $(".btn-dislike[data-id='"+data.id+"'] span.count-dislike").html(data.countLikes);
//                
//            }
//        });
//        return false;
//    });
//    
//    $('.btn-dislike').click(function(){
//        var params = {
//          'id': $(this).attr('data-id')  
//        };
//        $.post('/post/default/dis-like',params, function(data){
//            console.log(data);
//            if (data.success === true){
//                $(".btn-like[data-id='"+data.id+"']").show();
//                $(".btn-dislike[data-id='"+data.id+"']").hide();
//                
//                $(".btn-dislike[data-id='"+data.id+"'] span.count-dislike").html(data.countLikes);
//                $(".btn-like[data-id='"+data.id+"'] span.count-like").html(data.countLikes);
//            }
//        });
//        return false;
//    });
//    
    
    
//    $('#modalEditComment').on('show.bs.modal', function (event) {
//        var button = $(event.relatedTarget); // Button that triggered the modal
//        
//        var dataPostId = button.data('postid'); // Extract info from data-* attributes
//        var dataCommentId = button.data('commentid'); // Extract info from data-* attributes
//        var dataCommentcontent = button.data('commentcontent'); // Extract info from data-* attributes
//        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
//        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
//        var modal = $(this);
//        modal.find('.modal-title').text(dataCommentId);
//        modal.find('.content').text(dataCommentcontent);
//        //$(this).hide;
//        $('#saveBtn'+dataCommentId).on('click', function () {
//            //event.preventDefault();
//            var params = {
//                'postId': dataPostId,
//                'commentId': dataCommentId,
//            };
//            $.post('/post/comments/edit', params, function (data) {
//                console.log(data);
//                if (data.success === true) {
//                    modal.find('.modal-title').text(data.CommentId);
//                    modal.find('.content').text(data.postId);
//                    //$(this).hide;return false;
//                }return false;
//            });
//            return false;
//        });
//       //
//            
//    });
    
});

