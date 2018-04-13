$(document).ready(function(){
    
    
     $('.btn-report').click(function(){
         var button = $(this);
         var preloader = $(this).find('i.icon-preloader');
        var params = {
          'postId': $(this).attr('post-id')  
        };
        preloader.show();
        $.post('/post/comments/report',params, function(data){
            preloader.hide();
            console.log(data);
            if (data.success === true){
                  $(".btn-report").text('Already reported');
            }
        });
        return false;
    });
    
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



