<!DOCTYPE HTML>
<html lang="en-US">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="refresh" content="1;url=tv/admin/">
<?php   if (is_dir(getcwd()."/admin"))   
        { 
            header('Location: /tv/admin');
        }
        
        ?> 
            
  
        <title>Page Redirection</title>
    </head>
    <body>
        <!-- Note: don't tell people to `click` the link, just tell them that it is a link. -->
        If you are not redirected automatically <a href='tv/admin/'>click here</a>
    </body>
</html>