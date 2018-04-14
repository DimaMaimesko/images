<?php
return [
    
    'user.passwordResetTokenExpire' => 3600,
    'maxFileSize' => 1024*1024*9, //9 мегабайт
    'storagePath' => '@frontend/web/uploads/', //папка в которой будут храниться загрузки
    'storagePathResized' => '@frontend/web/uploads/resized/', //папка в которой будут храниться загрузки
    'storageUri' => '/uploads/', //адресс ресурса, по которому будут доступны изображения из вне: http://imstagram.com/uploads/f1/d7/34243djhr233hj2.jpg
    'storageUriResized' => '/uploads/resized/', //адресс ресурса, по которому будут доступны изображения из вне: http://imstagram.com/uploads/f1/d7/34243djhr233hj2.jpg
 // Настройки могут быть вложенными
    'profilePicture' => [
        'maxWidth' => 1280,
        'maxHeight' => 1024,
    ],
    'feedPostLimit' => 10,
];
