<?php

/* partials/navigation/navigation.html */
class __TwigTemplate_3df0d24dc2b37acb071de9b7c3a5304f extends Twig_Template
{
    protected function doGetParent(array $context)
    {
        return false;
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<ul class=\"nav navbar-nav navbar-right\">
  ";
        // line 2
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "root"));
        $context['loop'] = array(
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        );
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["_key"] => $context["child"]) {
            // line 3
            echo "    ";
            if ($this->getAttribute((isset($context["child"]) ? $context["child"] : null), "children")) {
                // line 4
                echo "        <li class=\"dropdown\">
            <a href=\"";
                // line 5
                echo $this->getAttribute((isset($context["child"]) ? $context["child"] : null), "url");
                echo "\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-expanded=\"false\">";
                echo $this->getAttribute((isset($context["child"]) ? $context["child"] : null), "title");
                echo "<span class=\"caret\"></span></a>
        ";
                // line 6
                $this->env->loadTemplate("partials/navigation/children.html")->display(array_merge($context, array("page" => (isset($context["child"]) ? $context["child"] : null))));
                // line 7
                echo "             </li>
    ";
            } else {
                // line 9
                echo "        <li>
      <a href=\"";
                // line 10
                echo $this->getAttribute((isset($context["child"]) ? $context["child"] : null), "url");
                echo "\">";
                echo $this->getAttribute((isset($context["child"]) ? $context["child"] : null), "title");
                echo "</a>
    </li>
    
    ";
            }
            // line 14
            echo "  ";
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['child'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 15
        echo "</ul>
               
               ";
    }

    public function getTemplateName()
    {
        return "partials/navigation/navigation.html";
    }

    public function isTraitable()
    {
        return false;
    }
}
