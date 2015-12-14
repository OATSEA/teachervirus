<!DOCTYPE HTML>
<html lang="en-US">
    <head>
        <meta charset="UTF-8">
        <?php   

            $url=getcwd();
            $constant = explode('/admin',$url);
            header('location:/tv/admin');
        ?> 
    <title>Page Redirection</title>
    </head>
    <body>
        <!-- Note: don't tell people to `click` the link, just tell them that it is a link. -->
       
    </body>
</html>