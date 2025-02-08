<?php
/**
 * Виджет веб-приложения GearMagic.
 * 
 * @link https://gearmagic.ru
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Widget\Tags;

use Gm;
use Gm\Tagger\Tag;
use Gm\Db\Sql\Select;
use Gm\Db\Sql\Expression;
use Gm\View\WidgetResourceTrait;
use Gm\View\MarkupViewInterface;
use Gm\Site\View\Widget\ListArticles;

/**
 * Виджет "Список объектов связанных с меткой" предназначен для отображения материала сайта с указанными 
 * параметрами.
 * 
 * Пример использования с менеджером виджетов:
 * ```php
 * $tags = Gm::$app->widgets->get('gm.wd.tags', ['sort' => 'date', limit' => 10]);
 * $tags->run();
 * ```
 * 
 * Пример использования в шаблоне:
 * ```php
 * echo $this->widget('gm.wd.tags', [
 *     'mode'       => 'list',
 *     'sort'       => ['default' => 'date,a'],
 *     'pagination' => ['defaultLimit' => 20],
 *     'itemsView'  => '/blog/blog-items',
 *     'pager'      => [
 *         'itemTpl'       => '<li>{link}</li>',
 *         'activeItemTpl' => '<li class="active">{link}</li>',
 *         'options'       => ['class' => 'justify-content-center']
 *      ]
 * ]);
 * ```
 * 
 * Пример использования с namespace:
 * ```php
 * use Gm\Widget\Tags\Widget as List;
 * 
 * echo List::widget(['mode' => 'list', pagination' => ['limit' => 20]]);
 * ```
 * если namespace ранее не добавлен в PSR, необходимо выполнить:
 * ```php
 * Gm::$loader->addPsr4('Gm\Widget\Tags\\', Gm::$app->modulePath . '/gm/gm.wd.tags/src');
 * ```
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Widget\Tags
 * @since 1.0
 */
class Widget extends ListArticles implements MarkupViewInterface
{
    use WidgetResourceTrait;

    /**
     * @var Tag|null
     */
    public ?Tag $tag = null;

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        if ($this->tag === null) {
            $this->tag = Gm::tempGet('tag');
        }

        parent::init();

        $this->initTranslations();
    }

    /**
     * {@inheritdoc}
     */
    public function getMarkupOptions(array $options = []): array
    {
        /** @var array $pagination Параметры пагинации */
        $pagination = array_merge($this->defaultPagination, $this->pagination);
        /** @var array $sort Параметры сортировик */
        $sort = array_merge($this->defaultSort, $this->sort);

        // параметры передаваемые в форму настройки разметки
        $itemParams = [
            'id'         => $this->id,
            'calledFrom' => $this->calledFromViewFile,
            // вид интерфейса виджета
            'iv' => $this->itemsView, // шаблон элементов
            // пагинация
            'pp' => $pagination['pageParam'], // параметр страницы
            'lp' => $pagination['limitParam'], // параметр количества
            'dl' => $pagination['defaultLimit'], // элементов на странице
            'lf' => is_array($pagination['limitFilter']) ?  implode(',', $pagination['limitFilter']) :  $pagination['limitFilter'], // фильтр количества
            'ml' => $pagination['maxLimit'], // макс. количество элементов
            // сортировка
            'sp' => $sort['param'], // параметр сортировки
            'sd' => $sort['default'], // по умолчанию
        ];
        return [
            'component'  => 'widget',
            'uniqueId'   => $this->id,
            'dataId'     => 0,
            'registryId' => $this->registry['id'] ?? '',
            'title'      => $this->title ?: $this->t('{description}'),
            'control'    => [
                'text'   =>  $this->title ?: $this->t('{name}'), 
                'route'  => '@backend/site-markup/settings/view/' . ($this->registry['rowId'] ?? 0),
                'params' =>  $itemParams,
                'icon'   => $this->getAssetsUrl() . '/images/icon_small.svg'
            ],
            'menu' => [
                [
                    'text'    => $this->t('Markup settings'),
                    'route'   => '@backend/site-markup/settings/view/' . ($this->registry['rowId'] ?? 0),
                    'params'  => $itemParams,
                    'iconCls' => 'gm-markup__icon-markup-settings'
                ]
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function prepareQuery(): Select
    {
        return (new Select())
        ->from(['article' => '{{article}}'])
        ->join(
            ['tags' => '{{tag_terms}}'],
            new Expression(
                '? = ? AND ? = ?', 
                ['article.id', 'tags.id', 'tags.tag_id', $this->tag->id], 
                [Expression::TYPE_IDENTIFIER, Expression::TYPE_IDENTIFIER, Expression::TYPE_IDENTIFIER, Expression::TYPE_LITERAL]
            )
        )
        ->join(
            ['category' => '{{article_category}}'], 
            'article.category_id = category.id',
            ['slugPathCategory' => 'slug_path'],
            'left'
        )
        ->where($this->getDataFilter());
    }
}