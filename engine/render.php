<?php

function renderTemplate($template, $data = []) {
    ob_start();

    if (!empty($data)) {
        extract($data);
    }

    include TEMPLATES_DIR . "{$template}";

    return ob_get_clean();
}

function renderBlock($block, $data = []) {
    ob_start();

    if (!empty($data)) {
        extract($data);
    }

    include BLOCKS_DIR . "{$block}";

    return ob_get_clean();
}

function display($params = []) {
    if (!empty($params)) {
        extract($params);
    }

    $template = file_get_contents(LAYOUTS_DIR . 'main.tpl');

    echo str_replace(
        array_map(
            function ($a) {
                return "{{" . $a . "}}";
            },
            array_keys($params)
        ),
        $params,
        $template
    );
}