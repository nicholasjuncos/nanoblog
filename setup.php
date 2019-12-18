<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Setting up database</title>
    </head>
    <body>
        
        <h3>Setting up...</h3>
        
        <?php
          require_once 'functions.php';
          
          createTable('members',
                      'user VARCHAR(16),' .
                      'pass VARCHAR(16),' .
                      'INDEX(user(6))');
          
          createTable('messages',
                      'id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,' .
                      'auth VARCHAR(16),' .
                      'recip VARCHAR(16),' .
                      'send_time DATETIME,' .
                      'pm CHAR(1),' .
                      'time INT UNSIGNED,' .
                      'message VARCHAR(4096),' .
                      'INDEX(auth(6)),' .
                      'INDEX(recip(6))');
          
          createTable('friends',
                      'user VARCHAR(16),' .
                      'friend VARCHAR(16),' .
                      'INDEX(user(6)),' .
                      'INDEX(friend(6))');
          
          createTable('profiles',
                      'user VARCHAR(16),' .
                      'text VARCHAR(4096),' .
                      'INDEX(user(6))');
          
          createTable('posts',
                      'id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,' .
                      'user VARCHAR(16) NOT NULL,' .
                      'title VARCHAR(50) NOT NULL,' .
                      'subtitle VARCHAR(50),' .
                      'heading_1 VARCHAR(50),' .
                      'text_1 VARCHAR(4096) NOT NULL,' .
                      'heading_2 VARCHAR(50),' .
                      'text_2 VARCHAR(4096),' .
                      'quote VARCHAR(500),' .
                      'quoter VARCHAR(50),' .
                      'publication_datetime DATETIME NOT NULL,' .
                      'published BOOLEAN NOT NULL DEFAULT 0,' .
                      'INDEX(user(6))');
          
          createTable('likes',
                      'user VARCHAR(16),' .
                      'post INT,' .
                      'INDEX(user(6)),' .
                      'INDEX(post)');
        ?>
        
        <br>...done.
    </body>
</html>
