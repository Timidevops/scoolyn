<?php


namespace App\Actions\Tenant\OnboardingTodo;


use App\Models\Tenant\OnboardingTodoList;

class UpdateTodoItemAction
{
    public function execute(array $input)
    {
        if ( OnboardingTodoList::isTodoListCompleted() ){
            return;
        }

        if ( OnboardingTodoList::isTodoItemCompleted($input['name']) ){
            return;
        }

        OnboardingTodoList::markTodoItemComplete($input['name']);
    }
}
