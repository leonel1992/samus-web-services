<?php
function getScript(array|string $methods):string  {
    $scriptMethos = "";
    if(is_array($methods)) {
        foreach ($methods as $key => $value) {
            $scriptMethos += "$value;\n\t";
        }
    } else {
        $scriptMethos = "$methods;";
    }

    if ($GLOBALS['web-view']) {
        $scriptMethos = <<<JS
            $scriptMethos
        JS;
    } else { 
        $scriptMethos = <<<JS
        document.addEventListener("DOMContentLoaded", function () {
            $scriptMethos
        });
        JS;
    }

    return <<<HTML
    <script>
    $scriptMethos
    </script>
    HTML;
}