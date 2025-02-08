<?php
/**
 * Этот файл является частью виджета веб-приложения GearMagic.
 * 
 * Файл конфигурации установки виджета.
 * 
 * @link https://gearmagic.ru
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

return [
    'use'         => FRONTEND,
    'id'          => 'gm.wd.tags',
    'category'    => 'list',
    'name'        => 'List of objects associated with the tag',
    'description' => 'List of objects associated with the specified tag',
    'namespace'   => 'Gm\Widget\Tags',
    'path'        => '/gm/gm.wd.tags',
    'locales'     => ['ru_RU', 'en_GB'],
    'events'      => [],
    'required'    => [
        ['php', 'version' => '8.2'],
        ['app', 'code' => 'GM CMS']
    ]
];
