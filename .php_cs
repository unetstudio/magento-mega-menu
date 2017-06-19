<?php
$header = <<<'EOF'
This file is part of PHP CS Fixer.
EOF;

Symfony\CS\Fixer\Contrib\HeaderCommentFixer::setHeader($header);

return Symfony\CS\Config::create()
    ->level(\Symfony\CS\FixerInterface::NONE_LEVEL)
    ->fixers(array(
        'header_comment',
        'encoding',
        'short_tag',
        'braces',
        'class_definition',
        'function_call_space',
        'function_declaration',
        'indentation',
        'method_argument_space',
        'parenthesis',
        'trailing_spaces',
        'visibility',
        'concat_with_spaces',
        'php_closing_tag',
        'linefeed',
        'return'
    ))
    ->finder(
        Symfony\CS\Finder::create()
            ->in(__DIR__.DIRECTORY_SEPARATOR.'app/code/')
    );