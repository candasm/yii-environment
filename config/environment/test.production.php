<?php
echo 'Tests are not supported for production!';
exit;
return CMap::mergeArray(
	require(dirname(__FILE__).'/main-production.php'),
	array(
		'components'=>array(
			'fixture'=>array(
				'class'=>'system.test.CDbFixtureManager',
			),
		),
	)
);
