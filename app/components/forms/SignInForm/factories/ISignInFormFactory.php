<?php

namespace App\Components\Forms\SignInForm\Factories;

use App\Components\Forms\SignInForm\SignInForm;

interface ISignInFormFactory
{
    /**
     * @return SignInForm
     */
    public function create();
}
