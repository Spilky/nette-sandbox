<?php

namespace App\Components\DataGrids\UsersDataGrid\Factories;

use App\AdminModule\DataGrids\UsersDataGrid;

interface IUsersDataGridFactory
{
    /**
     * @return UsersDataGrid
     */
    public function create();
}
