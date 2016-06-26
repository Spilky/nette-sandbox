<?php

namespace App\AdminModule\Presenters;

use App\Components\Forms\SignInForm\Factories\ISignInFormFactory;
use App\Components\Forms\SignInForm\SignInForm;

class SignPresenter extends BasePresenter
{
    /** @var ISignInFormFactory @inject */
    public $signInFormFactory;
    
    public function actionOut()
    {
        $this->getUser()->logout();
        if (!is_null($this->getParameter('backlink'))) {
            $this->redirectUrl($this->getParameter('backlink'));
        } else {
            $this->redirect('Homepage:');
        }
    }

    /**
     * @return SignInForm
     */
    protected function createComponentSignInForm()
    {
        $form = $this->signInFormFactory->create();
        $form->onSuccess[] = function ($control, $message) {
            $this->flashMessage($message, 'success');
            $this->redirect('Homepage:');
        };
        $form->onError[] = function ($control, $message) {
            $this->flashMessage($message, 'danger');
        };
        return $form;
    }
}
