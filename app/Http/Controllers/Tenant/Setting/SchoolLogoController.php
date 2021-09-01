<?php

namespace App\Http\Controllers\Tenant\Setting;

use App\Actions\Tenant\OnboardingTodo\UpdateTodoItemAction;
use App\Actions\Tenant\Setting\SchoolLogo\UpdateSchoolLogoAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\OnboardingTodoList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SchoolLogoController extends Controller
{
    public function update(Request $request)
    {
        $this->validate($request, [
            'schoolLogo' => ['required', 'file', 'image', 'max:10240'],
        ]);

        (new UpdateSchoolLogoAction())->execute([
            'file' => $request->file('schoolLogo'),
        ]);

        //set marker
        (new UpdateTodoItemAction())->execute([
            'name' => OnboardingTodoList::SET_SCHOOL_DETAIL_LOGO
        ]);

        Session::flash('successFlash', 'School logo updated successfully!!!');

        return back();
    }
}
