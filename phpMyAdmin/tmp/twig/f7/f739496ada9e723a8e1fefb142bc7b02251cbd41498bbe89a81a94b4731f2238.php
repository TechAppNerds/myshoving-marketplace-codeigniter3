<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* table/structure/partition_definition_form.twig */
class __TwigTemplate_b786e0d1c3c6d2937b3d6b1d15d076283ce2b4cdb59aa62932f5a79969b1e0bc extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 1
        echo "<form action=\"tbl_structure.php\" method=\"post\">
    ";
        // line 2
        echo PhpMyAdmin\Url::getHiddenInputs((isset($context["db"]) ? $context["db"] : null), (isset($context["table"]) ? $context["table"] : null));
        echo "
    <input type=\"hidden\" name=\"edit_partitioning\" value=\"true\" />

    <fieldset>
        <legend>";
        // line 6
        echo _gettext("Edit partitioning");
        echo "</legend>
        ";
        // line 7
        $this->loadTemplate("columns_definitions/partitions.twig", "table/structure/partition_definition_form.twig", 7)->display(twig_to_array(["partition_details" =>         // line 8
(isset($context["partition_details"]) ? $context["partition_details"] : null)]));
        // line 10
        echo "    </fieldset>
    <fieldset class=\"tblFooters\">
        <input type=\"submit\" name=\"save_partitioning\" value=\"";
        // line 12
        echo _gettext("Save");
        echo "\">
    </fieldset>
</form>
";
    }

    public function getTemplateName()
    {
        return "table/structure/partition_definition_form.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  51 => 12,  47 => 10,  45 => 8,  44 => 7,  40 => 6,  33 => 2,  30 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "table/structure/partition_definition_form.twig", "/home/myshovin/public_html/phpMyAdmin/templates/table/structure/partition_definition_form.twig");
    }
}
