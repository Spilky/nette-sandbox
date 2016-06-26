<?php

namespace App\AdminModule\Presenters;

use App\Presenters\BasePresenter as SuperBasePresenter;
use Nette\Application\ForbiddenRequestException;

abstract class BasePresenter extends SuperBasePresenter
{
    public function startup()
    {
        parent::startup();
        if (!$this->user->isLoggedIn()) {
            if ($this->getName() == 'Admin:Sign' &&
                in_array($this->getAction(), array('in', 'out', 'forgottenPassword'))) {
                return;
            } else {
                $this->redirect('Sign:in');
                return;
            }
        }

        if (!$this->user->isAllowed($this->getName(), $this->getAction())) {
            throw new ForbiddenRequestException;
        }
    }
}
