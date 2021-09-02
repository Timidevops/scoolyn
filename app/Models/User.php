<?php

namespace App\Models;

use App\Models\Tenant\ScoolynTenant;

if ( ScoolynTenant::checkCurrent() ){
    class User extends \App\Models\Tenant\User {}
}
else{
    class User extends \App\Models\Landlord\User{}
}

