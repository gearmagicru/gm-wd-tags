<?php
/**
 * Виджет веб-приложения GearMagic.
 * 
 * @link https://gearmagic.ru
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Widget\Tags\Model;

use Gm\Panel\Data\Model\WidgetMarkupSettingsModel;

/**
 * Настройка разметки виджета.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Widget\Tags\Model
 * @since 1.0
 */
class MarkupSettings extends WidgetMarkupSettingsModel
{
    /**
     * {@inheritdoc}
     */
    public function maskedAttributes(): array
    {
        return [
            'mode'       => 'mode', // режим работы
            'pagination' => 'pagination', // пагинация
            'sort'       => 'sort', // сортировка
            'itemsView'  => 'itemsView' // шаблон элементов
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function beforeUpdate(array &$params): void
    {
        // режим отображения {@see \Gm\Widget\Articles\Widget::$mode}
        $mode = $params['mode'] ?? '';
        if ($mode === 'full') {
            unset($params['mode']);
        }

        // если параметры пагинации имеют значения по умолчанию, тогда мы их 
        // убираем {@see \Gm\Widget\Articles\Widget::$defaultPagination}
        // фильтр количества
        $limitFilter = $params['pagination']['limitFilter'] ?? '';
        if ($limitFilter === '15,30,50,100') {
            unset($params['pagination']['limitFilter']);
        } else {
            if (is_string($limitFilter)) {
                $params['pagination']['limitFilter'] = explode(',', $limitFilter);
            }
        }
        // параметр страницы
        $pageParam = $params['pagination']['pageParam'] ?? '';
        if ($pageParam === 'page') {
            unset($params['pagination']['pageParam']);
        }
        // параметр количества
        $limitParam = $params['pagination']['limitParam'] ?? '';
        if ($limitParam === 'limit') {
            unset($params['pagination']['limitParam']);
        }
        // элементов на странице
        $defaultLimit = (int) ($params['pagination']['defaultLimit'] ?? 0);
        if ($defaultLimit === 15) {
            unset($params['pagination']['defaultLimit']);
        }
        // // макс. количество элементов
        $maxLimit = (int) ($params['pagination']['maxLimit'] ?? 0);
        if ($maxLimit === 100) {
            unset($params['pagination']['maxLimit']);
        }

        // если параметры сортировки имеют значения по умолчанию, тогда мы их 
        // убираем {@see \Gm\Widget\Articles\Widget::$defaultSort}
        // параметр сортировки
        $sortParam = $params['sort']['param'] ?? '';
        if ($sortParam === 'sort') {
            unset($params['sort']['param']);
        }
        // значение сортировки
        $sortDefault = $params['sort']['default'] ?? '';
        if ($sortDefault === 'date,a') {
            unset($params['sort']['default']);
        }
    }
}