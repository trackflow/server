<?php

return (new PhpCsFixer\Config())
    //->setRules([])
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->exclude(['docker/', 'vendor/', 'public/'])
            ->in(__DIR__)
    )
;
