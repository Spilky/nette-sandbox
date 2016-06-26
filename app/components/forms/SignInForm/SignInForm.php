<?php

namespace App\Components\Forms\SignInForm;

use App\Components\Forms\AbstractForm;
use Nette\Application\UI\Form;
use Nette\Security\AuthenticationException;
use Nette\Security\User;
use Tracy\Debugger;

class SignInForm extends AbstractForm
{
    /** @var User */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return Form
     */
    public function createComponentForm()
    {
        $form = new Form;
        $form->addText('email', 'E-mail:')
            ->setRequired('Vložte prosím e-mail.')
            ->setAttribute('placeholder', 'E-mail');

        $form->addPassword('password', 'Heslo:')
            ->setRequired('Vložte prosím heslo.')
            ->setAttribute('placeholder', 'Heslo');

        $form->addCheckbox('remember', ' Zůstat přihlášen');

        $form->addSubmit('submit', 'Přihlásit se');

        $form->onSuccess[] = array($this, 'formSucceeded');
        return $form;
    }

    public function formSucceeded(Form $form, $values)
    {
        if ($values['remember']) {
            $this->user->setExpiration('14 days', FALSE);
        } else {
            $this->user->setExpiration('60 minutes', TRUE);
        }

        try {
            $this->user->login($values['email'], $values['password']);
        } catch (AuthenticationException $e) {
            $this->onError($this, 'Přihlášení se nezdařilo. Zkuste to prosím znovu.');
            Debugger::log($e);
            return;
        }

        $this->onSuccess($this, 'Přihlášení proběhlo úspěšně.');
    }
}
