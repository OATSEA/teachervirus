<!DOCTYPE HTML>
<html lang="en-US">
    <head>
        <meta charset="UTF-8">
        <?php   

            $url=getcwd();
            $constant = explode('/play',$url);
            header('location:/tv/play');
        ?> 
  
        <title>Page Redirection</title>
    </head>
    <body>
    </body>
</html>