<!DOCTYPE HTML>
<html lang="en-US">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="refresh" content="1;url=infect/www/">
<?php   if (is_dir(getcwd()."/infect/www/"))   
        { 
            header('Location: /infect/www/');
        }
        else
        {
            header('Location: /tv/play/teacherbot/');
        }
        ?> 
            
  
        <title>Page Redirection</title>
    </head>
    <body>
        <!-- Note: don't tell people to `click` the link, just tell them that it is a link. -->
        If you are not redirected automatically <a href='infect/www/'>click here</a>
    </body>
</html>