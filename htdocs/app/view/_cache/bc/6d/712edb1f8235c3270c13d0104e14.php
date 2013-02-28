<?php

/* /common/content.twig */
class __TwigTemplate_bc6d712edb1f8235c3270c13d0104e14 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'head' => array($this, 'block_head'),
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html>
<head>
";
        // line 4
        $this->displayBlock('head', $context, $blocks);
        // line 36
        echo "</head>
<body>
    <div class=\"page\">
        <ul class=\"top-menu\">
            <li class=\"logo-element\"><a href=\"/\">BikeBook</a></li>
            <li><a href=\"/new-biker\">Стать постоянным участником</a></li>
            <li>";
        // line 42
        ob_start();
        // line 43
        echo "                ";
        if (($this->getAttribute((isset($context["user"]) ? $context["user"] : null), "who") == "robot")) {
            // line 44
            echo "                    <a href=\"/verification\">Авторизация</a>
                ";
        } elseif (($this->getAttribute((isset($context["user"]) ? $context["user"] : null), "who") == "user")) {
            // line 46
            echo "                    <a href=\"/verification/exit/?hash=";
            echo $this->getAttribute($this->getAttribute((isset($context["user"]) ? $context["user"] : null), "data"), "exitHash");
            echo "\">Выйти</a>
                ";
        }
        // line 48
        echo "            ";
        echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
        echo "</li>
            <li><a href=\"/sos\" class=\"sos\">Сигнал SOS</a></li>
        </ul>
        <div class=\"cl\"></div>

        <ul class=\"main-menu\">
            <li><a href=\"/our-bikers\">Наши люди</a></li>
            <li><a href=\"/motonovosti\">Новости МотоМира</a></li>
            <li><a href=\"/bikes-rating\">Рейтинг мотоциклов</a></li>
            <li><a href=\"/store\">BikeBook магазин</a></li>
            <li><a href=\"/bikes-rating\">BikeBook магазин</a></li>
        </ul>
        <div class=\"cl\"></div>





        ";
        // line 66
        $this->displayBlock('content', $context, $blocks);
        // line 67
        echo "    </div>
</body>
</html>";
    }

    // line 4
    public function block_head($context, array $blocks = array())
    {
        // line 5
        echo "
    <title>";
        // line 6
        ob_start();
        $this->displayBlock('title', $context, $blocks);
        echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
        echo "</title>

    <link href='http://fonts.googleapis.com/css?family=Jura:400,300,500,600&subset=latin,cyrillic,latin-ext' rel='stylesheet' type='text/css'>


    <link rel=\"stylesheet\" type=\"text/css\" href=\"/css/bikebook.css\"/>

    <script type=\"text/javascript\" src=\"http://yandex.st/jquery/1.9.1/jquery.min.js\"></script>
    <script type=\"text/javascript\" src=\"/js/jquery.autoGrowInput.min.js\"></script>

    ";
    }

    public function block_title($context, array $blocks = array())
    {
        echo "Bikebook.loc";
        echo (isset($context["title"]) ? $context["title"] : null);
    }

    // line 66
    public function block_content($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "/common/content.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  111 => 66,  88 => 6,  85 => 5,  82 => 4,  76 => 67,  74 => 66,  52 => 48,  46 => 46,  42 => 44,  39 => 43,  37 => 42,  29 => 36,  27 => 4,  22 => 1,);
    }
}
