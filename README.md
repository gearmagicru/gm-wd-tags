# Виджет "Список объектов связанных с меткой"

Виджет предназначен для вывода списка объектов из базы данных по указанной метки (тегу) с параметрами.

## Пример применения
### с менеджером виджетов:
```
$list = Gm::$app->widgets->get('gm.wd.tags',  ['sort' => 'date', limit' => 10]);
$list->run();
```
### в шаблоне:
```
$this->widget('gm.wd.tags', [
    'mode'       => 'list',
    'sort'       => ['default' => 'date,a'],
    'pagination' => ['defaultLimit' => 20],
    'itemsView'  => '/partials/tag-items',
    'pager'      => [
        'itemTpl'       => '<li>{link}</li>',
        'activeItemTpl' => '<li class="active">{link}</li>',
        'options'       => ['class' => 'justify-content-center']
    ]
]);
```
### с namespace:
```
use Gm\Widget\Tags\Widget as List;
echo List::widget(['mode' => 'list', pagination' => ['limit' => 20]]);
```
если namespace ранее не добавлен в PSR, необходимо выполнить:
```
Gm::$loader->addPsr4('Gm\Widget\Tags\\', Gm::$app->modulePath . '/gm/gm.wd.tags/src');
```

## Установка

Для добавления виджета в ваш проект, вы можете просто выполнить команду ниже:

```
$ composer require gearmagicru/gm-wd-tags
```

или добавить в файл composer.json вашего проекта:
```
"require": {
    "gearmagicru/gm-wd-tags": "*"
}
```

После добавления виджета в проект, воспользуйтесь Панелью управления GM Panel для установки его в редакцию вашего веб-приложения.
