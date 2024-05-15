<?php

namespace App\Http\Middleware;

use App\Models\Form;
use App\Providers\RouteServiceProvider;
use Closure;
use Hashids\Hashids;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class PasswordProtection
{
    public function handle($request, Closure $next, ...$guards)
    {
        $formValueParam =  Request::route()->parameters('id');
        $formValueId = isset($formValueParam['id'])
            ? $formValueParam['id']
            : null;

        $hashids                    = new Hashids('', 20);
        $id                         = $hashids->decodeHex($formValueId);
        $form                       = Form::find($id);

        if (!$request->session()->has('form_unlocked_' . $formValueId) && !empty($form)  && $form->password_enabled != 0 &&  $form->form_password != null ) {

           return redirect()->route('password.protection' , $formValueId);
        }
        return $next($request);
    }
}
