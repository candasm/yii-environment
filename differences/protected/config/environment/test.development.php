<?php

return Environment::mergeArray(
        require(__DIR__ . '/main.development.php'), array(
                'components' => array(
                    'fixture' => array(
                        'class' => 'system.test.CDbFixtureManager',
                    ),
                ),
        )
);
