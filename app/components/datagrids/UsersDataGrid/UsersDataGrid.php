<?php

namespace App\AdminModule\DataGrids;

use App\Model\Entity\User;
use App\Model\Repository\UserRepository;
use Exception;
use Tracy\Debugger;
use Ublaboo\DataGrid\DataGrid;

class UsersDataGrid extends AbstractDataGrid
{
    /** @var UserRepository */
    private $userRepository;

    /**
     * @param UserRepository $UserRepository
     */
    public function __construct(UserRepository $UserRepository)
    {
        $this->userRepository = $UserRepository;
    }

    /**
     * @return DataGrid
     */
    public function createComponentDataGrid()
    {
        $grid = parent::create();

        $grid->addColumnText('email', 'E-mail')
            ->setSortable()
            ->setFilterText();

        $grid->addColumnText('name', 'Jméno a příjmení')
            ->setSortable()
            ->setFilterText();

        $grid->addColumnStatus('role', 'Status')
            ->addOption(User::ROLE_ADMIN, 'Administrátor')
            ->setClass('btn-default')
            ->endOption()
            ->setSortable()
            ->setFilterSelect(array(
                '' => '-',
                User::ROLE_ADMIN => 'Administrátor'
            ));
        $grid->getColumn('role')->onChange[] = [$this, 'changeRole'];

        $grid->addAction('settings', 'Editovat', 'User:edit');

        $grid->setDataSource($this->userRepository->getQB());

        return $grid;
    }

    /**
     * @param integer $id
     * @param string $newRole
     */
    public function changeRole($id, $newRole)
    {
        try {
            $this->userRepository->updateWhere(array('role' => $newRole), array('id' => $id));
            $this->flashMessage('Role úspěšně změněn.', 'success');
        } catch (Exception $e) {
            Debugger::log($e);
            return;
        }

        if ($this->presenter->isAjax()) {
            $this->redrawControl('flashes');
            $this['dataGrid']->redrawItem($id);
        } else {
            $this->redirect('this');
        }
    }
}