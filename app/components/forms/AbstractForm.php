<?php

namespace App\Components\Forms;

use Nette;
use Nette\Application\UI\Control;
use ReflectionClass;

abstract class AbstractForm extends Control
{
    /** @var array */
    public $onSuccess;
    /** @var array */
    public $onError;

    public function render()
    {
        $rc = new ReflectionClass($this);
        $template = $this->template;
        if (is_file(__DIR__ . '/' . $rc->getShortName() . '/templates/default.latte')) {
            $template->setFile(__DIR__ . '/' . $rc->getShortName() . '/templates/default.latte');
        } else {
            $template->setFile(__DIR__ . '/AbstractForm.latte');
        }
        $template->render();
    }

    /**
     * @param array $defaults
     */
    public function setDefaults($defaults)
    {
        $rc = new ReflectionClass($this);
        if (isset($this['form'])) {
            $this['form']->setDefaults($defaults);
        } elseif (isset($this[lcfirst($rc->getShortName())])) {
            $this[lcfirst($rc->getShortName())]->setDefaults();
        }
    }
}