<?php

namespace App\AdminModule\Presenters;

use App\Components\DataGrids\UsersDataGrid\Factories\IUsersDataGridFactory;

class UserPresenter extends BasePresenter
{
    /** @var IUsersDataGridFactory @inject */
    public $usersDataGridFactory;
    
    public function renderDefault()
    {
        $this->template->anyVariable = 'any value';
    }
    
    protected function createComponentUsersDataGrid()
    {
        $control = $this->usersDataGridFactory->create();
        return $control;
    }
}
