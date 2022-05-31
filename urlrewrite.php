<?php
$arUrlRewrite=array (
  2 => 
  array (
    'CONDITION' => '#^/online/([\\.\\-0-9a-zA-Z]+)(/?)([^/]*)#',
    'RULE' => 'alias=$1',
    'ID' => NULL,
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  1 => 
  array (
    'CONDITION' => '#^/video([\\.\\-0-9a-zA-Z]+)(/?)([^/]*)#',
    'RULE' => 'alias=$1&videoconf',
    'ID' => NULL,
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  4 => 
  array (
    'CONDITION' => '#^\\/?\\/mobileapp/jn\\/(.*)\\/.*#',
    'RULE' => 'componentName=$1',
    'ID' => NULL,
    'PATH' => '/bitrix/services/mobileapp/jn.php',
    'SORT' => 100,
  ),
  6 => 
  array (
    'CONDITION' => '#^/bitrix/services/ymarket/#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/bitrix/services/ymarket/index.php',
    'SORT' => 100,
  ),
  0 => 
  array (
    'CONDITION' => '#^/stssync/calendar/#',
    'RULE' => '',
    'ID' => 'bitrix:stssync.server',
    'PATH' => '/bitrix/services/stssync/calendar/index.php',
    'SORT' => 100,
  ),
  15 => 
  array (
    'CONDITION' => '#^/speakers/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/speakers/index.php',
    'SORT' => 100,
  ),
  16 => 
  array (
    'CONDITION' => '#^/articles/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/articles/index.php',
    'SORT' => 100,
  ),
  14 => 
  array (
    'CONDITION' => '#^/centers/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/centers/index.php',
    'SORT' => 100,
  ),
  22 => 
  array (
    'CONDITION' => '#^/courses/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/courses/index.php',
    'SORT' => 100,
  ),
  19 => 
  array (
    'CONDITION' => '#^/galery/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/galery/index.php',
    'SORT' => 100,
  ),
  20 => 
  array (
    'CONDITION' => '#^/events/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog',
    'PATH' => '/events/index.php',
    'SORT' => 100,
  ),
  21 => 
  array (
    'CONDITION' => '#^/video/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/video/index.php',
    'SORT' => 100,
  ),
  5 => 
  array (
    'CONDITION' => '#^/rest/#',
    'RULE' => '',
    'ID' => NULL,
    'PATH' => '/bitrix/services/rest/index.php',
    'SORT' => 100,
  ),
);
