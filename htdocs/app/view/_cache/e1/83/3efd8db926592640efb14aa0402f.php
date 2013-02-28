<?php

/* /common/content.twig */
class __TwigTemplate_e1833efd8db926592640efb14aa0402f extends Twig_Template
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
        echo "<html>
<head>
";
        // line 3
        $this->displayBlock('head', $context, $blocks);
        // line 28
        echo "</head>
<body>
    ";
        // line 30
        $this->displayBlock('content', $context, $blocks);
        // line 31
        echo "</body>
</html>";
    }

    // line 3
    public function block_head($context, array $blocks = array())
    {
        // line 4
        echo "
    <title>";
        // line 5
        ob_start();
        $this->displayBlock('title', $context, $blocks);
        echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
        echo "</title>

    ";
        // line 26
        echo "
";
    }

    // line 5
    public function block_title($context, array $blocks = array())
    {
        echo "Киношка";
        if (isset($context["title"])) { $_title_ = $context["title"]; } else { $_title_ = null; }
        echo $_title_;
    }

    // line 30
    public function block_content($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "/common/content.twig";
    }

    public function getDebugInfo()
    {
        return array (  65 => 30,  57 => 5,  52 => 26,  45 => 5,  42 => 4,  39 => 3,  34 => 31,  32 => 30,  28 => 28,  26 => 3,  22 => 1,  53 => 12,  50 => 11,  43 => 8,  40 => 7,  33 => 4,  30 => 3,);
    }
}
