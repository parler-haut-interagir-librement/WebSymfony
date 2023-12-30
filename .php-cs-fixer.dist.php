<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
        ->in(__DIR__)
        ->exclude('var')
        ->exclude('vendor')
;

return (
    new PhpCsFixer\Config())
        ->setRules(
            [
                '@Symfony'                => true,
                // https://cs.symfony.com/doc/ruleSets/Symfony.html
                'declare_strict_types'    => true,
                // https://cs.symfony.com/doc/rules/strict/declare_strict_types.html
                'yoda_style'              => true,
                // https://cs.symfony.com/doc/rules/control_structure/yoda_style.html
                // # Needed to avoid messing with @var annotations for PHPStan
                'phpdoc_to_comment'       => false,
                // https://cs.symfony.com/doc/rules/phpdoc/phpdoc_to_comment.html
                'global_namespace_import' => [
                    'import_classes'   => true,
                    'import_constants' => true,
                    'import_functions' => true,
                ],
                'concat_space'            => [
                    'spacing' => 'one',
                ],
                'method_argument_space'   => [
                    'on_multiline'                     => 'ensure_fully_multiline',
                    'attribute_placement'              => 'standalone',
                    'keep_multiple_spaces_after_comma' => false,
                ],
                'array_indentation'       => true,
        ])
        ->setFinder($finder)
;
