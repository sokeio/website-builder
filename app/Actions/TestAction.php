<?php

namespace App\Actions;

use Sokeio\Concerns\WithAction;

class TestAction
{
    use WithAction;
    public function doAction()
    {
        return [
            'data-test' => 'hello test'
        ];
    }
}
