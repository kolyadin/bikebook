<?php

/* common/content.twig */
class __TwigTemplate_1280140d02dda9dbb96380e87fec6d8a extends Twig_Template
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
        // line 26
        echo "</head>
<body>
    ";
        // line 28
        $this->displayBlock('content', $context, $blocks);
        // line 29
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
        // line 7
        ob_start();
        // line 8
        echo "    ";
        echo call_user_func_array($this->env->getFunction('js')->getCallable(), array(array(0 => array(0 => "/js/jquery-1.8.3.min.js"), 1 => array(0 => "/js/jquery-ui-1.9.2.min.js"), 2 => array(0 => "/js/jquery.ui.datepicker-ru.js"), 3 => array(0 => "/js/jquery.fancybox.js"), 4 => array(0 => "/js/jquery.mousewheel.js"), 5 => array(0 => "/js/jquery.uploadify.min.js"), 6 => array(0 => "/js/jquery.filter_input.js"), 7 => array(0 => "/js/ckeditor/ckeditor.js"), 8 => array(0 => "/js/sprintf.js"), 9 => array(0 => "/js/admin.js"), 10 => array(0 => "/js/kaelement.js"))));
        // line 22
        echo "
    ";
        echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
        // line 24
        echo "
";
    }

    // line 5
    public function block_title($context, array $blocks = array())
    {
        if (isset($context["title"])) { $_title_ = $context["title"]; } else { $_title_ = null; }
        echo $_title_;
    }

    // line 28
    public function block_content($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "common/content.twig";
    }

    public function getDebugInfo()
    {
        return array (  73 => 28,  66 => 5,  61 => 24,  57 => 22,  54 => 8,  52 => 7,  45 => 5,  42 => 4,  39 => 3,  34 => 29,  32 => 28,  28 => 26,  26 => 3,  22 => 1,);
    }
}
