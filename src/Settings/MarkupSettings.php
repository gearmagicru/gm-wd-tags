<?php
/**
 * Виджет веб-приложения GearMagic.
 * 
 * @link https://gearmagic.ru
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Widget\Tags\Settings;

use Gm;
use Gm\Panel\Helper\ExtCombo;
use Gm\Panel\Widget\MarkupSettingsWindow;

/**
 * Интерфейс окна настроек разметки виджета.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Widget\Tags\Settings
 * @since 1.0
 */
class MarkupSettings extends MarkupSettingsWindow
{
    /**
     * {@inheritdoc}
     */
    protected function init(): void
    {
        parent::init();

        /** @var \Gm\Http\Request $request */
        $request = Gm::$app->request;

        $this->width = 500;
        $this->form->autoScroll = true;
        $this->form->defaults = [
            'labelWidth' => 160,
            'labelAlign' => 'right'
        ];
        $this->form->items = [
            [
                'xtype'      => 'hidden',
                'name'       => 'id',
                'value'      => $request->post('id')
            ],
            [
                'xtype'      => 'textfield',
                'fieldLabel' => '#The markup is done in the template',
                'tooltip'    => '#In the specified template, the widget parameters are changed. You can make changes manually by opening the template for editing.',
                'name'       => 'calledFrom',
                'value'      => $request->post('calledFrom'),
                'maxLength'  => 50,
                'width'      => '100%',
                'readOnly'   => true,
                'allowBlank' => true
            ],
            ExtCombo::local(
                $this->creator->t('Work mode'), 'mode', 
                [
                    'fields' => ['id', 'name'],
                    'data'   => [
                        ['items', '#Items'],  ['list', '#List'],  ['full', '#Full']
                    ]
                ],
                [
                    'tooltip'   => '#The operating mode determines whether list control parameters will be accepted from the request',
                    'value'     => $request->post('mode', 'full'),
                    'style'     => 'margin:10px 0 10px 0'
                ],
                [
                    'width' => 200
                ]
            ),
            [
                'xtype'      => 'textfield',
                'fieldLabel' => '#Шаблон элементов',
                'tooltip'    => '#В указанном шаблоне выводится список элементов - материалы',
                'name'       => 'itemsView',
                'value'      => $request->post('iv', ''),
                'width'      => '100%'
            ],
            [
                'xtype'    => 'fieldset',
                'title'    => '#Pagination',
                'defaults' => [
                    'xtype'      => 'textfield',
                    'labelWidth' => 195,
                    'labelAlign' => 'right',
                    'width'      => 300
                ],
                'items' => [
                    [
                        'fieldLabel' => '#Page parameter',
                        'tooltip'    => '#Parameter indicating transition to page',
                        'name'       => 'pagination[pageParam]',
                        'value'      => $request->post('pp', 'page'),
                        'width'      => 350
                    ],
                    [
                        'fieldLabel' => '#Limit parameter',
                        'tooltip'    => '#Parameter indicating the number of elements on the page',
                        'name'       => 'pagination[limitParam]',
                        'value'      => $request->post('lp', 'limit'),
                        'width'      => 350
                    ],
                    [
                        'xtype'      => 'numberfield',
                        'fieldLabel' => '#Elements per page',
                        'tooltip'    => '#Number of elements displayed on the page',
                        'name'       => 'pagination[defaultLimit]',
                        'minValue'   => 1,
                        'value'      => $request->post('dl', 15),
                    ],
                    [
                        'xtype'      => 'numberfield',
                        'fieldLabel' => '#Max. elements per page',
                        'tooltip'    => '#Maximum number of elements displayed on the page',
                        'name'       => 'pagination[maxLimit]',
                        'minValue'   => 1,
                        'value'      => $request->post('ml', 100),
                    ],
                    [
                        'fieldLabel' => '#Limit filter',
                        'tooltip'    => '#The number of elements on the page that can be specified is listed through ","',
                        'name'       => 'pagination[limitFilter]',
                        'value'      => $request->post('lf', '15,30,50,100'),
                        'width'      => 350
                    ],
                ]
            ],
            [
                'xtype'    => 'fieldset',
                'title'    => '#Sorting',
                'defaults' => [
                    'xtype'      => 'textfield',
                    'labelWidth' => 195,
                    'labelAlign' => 'right',
                    'width'      => 350
                ],
                'items' => [
                    [
                        'fieldLabel' => '#Sort parameter',
                        'name'       => 'sort[param]',
                        'value'      => $request->post('sp', 'sort'),
                    ],
                    [
                        'fieldLabel' => '#By default',
                        'tooltip'    => '#Default list sorting',
                        'name'       => 'sort[default]',
                        'value'      => $request->post('sd', 'date,a'),
                    ],
                ]
            ]
        ];
    }

}