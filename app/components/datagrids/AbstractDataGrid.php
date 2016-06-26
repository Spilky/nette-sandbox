<?php

namespace App\AdminModule\DataGrids;

use Nette\Application\UI\Control;
use ReflectionClass;
use Ublaboo\DataGrid\DataGrid;
use Ublaboo\DataGrid\Localization\SimpleTranslator;

abstract class AbstractDataGrid extends Control
{
    /**
     * @return DataGrid
     */
    public function create()
    {
        $grid = new DataGrid();

        $translator = new SimpleTranslator([
            'ublaboo_datagrid.no_item_found_reset' => 'Žádné položky nenalezeny. Filtr můžete vynulovat',
            'ublaboo_datagrid.no_item_found' => 'Žádné položky nenalezeny.',
            'ublaboo_datagrid.here' => 'zde',
            'ublaboo_datagrid.items' => 'Položky',
            'ublaboo_datagrid.all' => 'všechny',
            'ublaboo_datagrid.from' => 'z',
            'ublaboo_datagrid.reset_filter' => 'Resetovat filtr',
            'ublaboo_datagrid.group_actions' => 'Hromadné akce',
            'ublaboo_datagrid.show_all_columns' => 'Zobrazit všechny sloupce',
            'ublaboo_datagrid.hide_column' => 'Skrýt sloupec',
            'ublaboo_datagrid.action' => 'Akce',
            'ublaboo_datagrid.previous' => 'Předchozí',
            'ublaboo_datagrid.next' => 'Další',
            'ublaboo_datagrid.choose' => 'Vyberte',
            'ublaboo_datagrid.execute' => 'Provést',
            'ublaboo_datagrid.save' => 'Uložit',
            'ublaboo_datagrid.cancel' => 'Zrušit',

            'Name' => 'Jméno',
            'Inserted' => 'Vloženo'
        ]);

        $grid->setTranslator($translator);
        $grid->setRememberState(false);

        return $grid;
    }

    public function render()
    {
        $rc = new ReflectionClass($this);
        $template = $this->template;
        if (is_file(__DIR__ . '/' . $rc->getShortName() . '/templates/default.latte')) {
            $template->setFile(__DIR__ . '/' . $rc->getShortName() . 'templates/default.latte');
        } else {
            $template->setFile(__DIR__ . '/AbstractDataGrid.latte');
        }
        $template->render();
    }
}