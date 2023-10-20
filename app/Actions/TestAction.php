<?php

namespace App\Actions;

use BytePlatform\Concerns\WithAction;

class TestAction
{
    use WithAction;
    public function DoAction()
    {
        return [
            'data-test' => 'hello test'
        ];
    }
}
