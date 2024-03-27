<?php

return (new PhpCsFixer\Config())
    ->setRules([
        'function_declaration' => [
            'closure_function_spacing' => 'none',
            'closure_fn_spacing' => 'none'
        ]
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->exclude(['docker/', 'vendor/', 'public/'])
            ->in(__DIR__)
    )
;
