<?php

/* default.html */
class __TwigTemplate_845d98a44e7798451ef18592d510a0a3 extends Twig_Template
{
    protected function doGetParent(array $context)
    {
        return false;
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"en\">
  <head>
    <meta charset=\"utf-8\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name=\"description\" content=\"Teacher Virus is an Open Source platform for the distribution and curation of Free Education - Infectious Education!\">
    <meta name=\"author\" content=\"Harry Longworth\">
    <link rel=\"icon\" href=\"";
        // line 10
        echo $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "root_path");
        echo "/public/favicon.ico\">
    <title>";
        // line 11
        echo $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "name");
        echo "</title>
    <link rel=\"alternate\" type=\"application/atom+xml\" href=\"";
        // line 12
        echo $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "root_path");
        echo "/?/feed/\">
          <!-- Bootstrap -->
    <link href=\"";
        // line 14
        echo $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "root_path");
        echo "/public/docs/css/bootstrap.min.css\" rel=\"stylesheet\">
    <link href=\"";
        // line 15
        echo $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "root_path");
        echo "/public/docs/css/bootstrap-theme.min.css\" rel=\"stylesheet\">
    <link href=\"";
        // line 16
        echo $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "root_path");
        echo "/public/docs/css/my-styles.css\" rel=\"stylesheet\">
      
      <link href='http://fonts.googleapis.com/css?family=Fredericka+the+Great' rel='stylesheet' type='text/css'>
      <link href='http://fonts.googleapis.com/css?family=Architects+Daughter' rel='stylesheet' type='text/css'>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src=\"";
        // line 24
        echo $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "root_path");
        echo "/public/docs/js/html5shiv.min.js\"></script>
      <script src=\"";
        // line 25
        echo $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "root_path");
        echo "/public/docs/js/respond.min.js\"></script>
    <![endif]-->
      
  </head>
  <body>
       <!-- Fixed navbar -->
    <nav class=\"navbar navbar-default navbar-fixed-top\">
      <div class=\"container\">  
          <div class=\"navbar-header\">
            <button type=\"button\" class=\"navbar-toggle collapsed\" data-toggle=\"collapse\" data-target=\"#navbar\" aria-expanded=\"false\" aria-controls=\"navbar\">
              <span class=\"sr-only\">Toggle navigation</span>
              <span class=\"icon-bar\"></span>
              <span class=\"icon-bar\"></span>
              <span class=\"icon-bar\"></span>
            </button>
            <a class=\"logo\" href=\"";
        // line 40
        echo $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "root_path");
        echo "\"><img class=\"logo\" src=\"";
        echo $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "root_path");
        echo "/public/images/logo.png\" alt=\"Teacher Virus\"><span class=\"navbar-brand logotext\"><b> Teacher Virus</b></span></a>
          </div>
          <div id=\"navbar\" class=\"navbar-collapse collapse\">
            ";
        // line 43
        $this->env->loadTemplate("partials/navigation/navigation.html")->display($context);
        echo "    
          </div>
          <!--/.nav-collapse -->
      </div>
    </nav>

    <div class=\"container\">
      <!-- Main Content -->          
           ";
        // line 51
        echo $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "content");
        echo "
    </div>
      <hr>
        <div><center><p>&copy; Copyright <a href=\"http://www.oatsea.org\" target=\"_blank\">OATSEA Foundation</a> ";
        // line 54
        echo $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "current_year");
        echo "</p></center>
        </div>  
        
    </div> <!-- /container -->
      
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->  
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src=\"";
        // line 63
        echo $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "root_path");
        echo "/public/docs/js/jquery-1.11.1.min.js\"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src=\"";
        // line 65
        echo $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "root_path");
        echo "/public/docs/js/bootstrap.min.js\"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src=\"";
        // line 67
        echo $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "root_path");
        echo "/public/docs/js/ie10-viewport-bug-workaround.js\"></script>
    
  </body>
</html>
";
    }

    public function getTemplateName()
    {
        return "default.html";
    }

    public function isTraitable()
    {
        return false;
    }
}
