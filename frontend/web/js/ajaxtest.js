 $(document).ready(function(){
   
     $("button#load").click(function(){
        var params = {
          'id': $(this).attr('data-id')  
        };
        $.post('/site/test',params, function(data){
          
            console.log(data);
            if (data.success === true){
                var flag = 0;
                var txt6 = "<div class='post-meta' id='users'>\n\
                              <div class='post-title'>\n\
                                 <img  width='50' height='50' class='author-image' style='margin-right: 1px' />\n\
                                 <div class='author-name'>\n\
                                    <a class=''></a>\n\
                                    <span class=''></span>\n\
                                </div>\n\
                              </div>\n\
                            </div>\n\
                            <hr class='finish' style='margin-top: 1px; margin-bottom: 3px'>";
       
                $("#ajaxtest").html(data.users.length);
                $("div#allusers").empty();
                
                data.users.forEach(function (item, index, array) {
                    if (item['picture']){
                        var txt3 = '/uploads/resized/'+item['picture'];
                    }else {
                        var txt3 = '/default/default.jpg';
                    }
                    
                    if (data.isCurrentUser[index]['authorName'] === 'bg-success'){
                        var txt5 = "bg-success";
                    }else {
                        var txt5 = "";
                    }
                    
                    if (data.isUserOnline[index]){
                        var txt7 = "bg-success";
                        var txt8 = "Online";
                        
                    }else {
                        var txt7 = "bg-danger";
                        var txt8 = "Offline";
                    }
                    
                   var txt9 = data.hrefForUserPage[index]
                    
                    
                    if (!flag) {
                        $(txt6).prependTo( "div#allusers" );
                        flag +=1;
                    } else {
                        $("hr.finish:last").after(txt6);
                    }
                    
                 $("div#users:last img:last").attr("src",txt3);
                 $("div#users:last a:last").text(item['username']);
                 $("div#users:last a:last").attr("href",txt9);
                 
                 $("div#users:last a:last").addClass(txt5);
                 
                 $("div#users:last span:last").addClass(txt7);
                 $("div#users:last span:last").text(txt8);
                 
                 
                });
                
            }
        });
        return false;
    });
   
    $("button#loadPosts").click(function(){
       var params = {
          'targetUserId': $(this).attr('target-user-id')  
        };
        $.post('/user/profile/add-posts',params, function(data){
            var flag = 0;
            if (data.success === true){
            
            var txtCommon = "<div class='col-md-4 profile-post'>\n\
                                <a><img id='post-picture' class='author-image'></a>\n\
                             </div>\n\
                             <div class='last1'></div>";
                
             $("#postsShown").text(data.limitPosts);
             $("#numberOfPosts").text(data.numberOfAllPosts);
             var leftPosts =  data.numberOfAllPosts - data.limitPosts;
             $("#leftPosts").text(leftPosts);
             $("#left").text(" left");
             
             $("div#allposts").empty();
             data.posts.forEach(function (post, index, array) {
                    var txtHref = '/comments/'+post['id'];
                    var txtSrc = '/uploads/resized/'+post['photo'];
                    if (flag == 0) {
                        $(txtCommon).prependTo( "div#allposts" );
                        flag = flag + 1;
                    } else {
                        $(txtCommon).insertAfter(".last1:last");
                    }
                    $("div.profile-post:last a:last").attr("href",txtHref);
                    $("div.profile-post:last img:last").attr("src",txtSrc);
                });
               
            }
        });
        return false;
    });
   
  
});


