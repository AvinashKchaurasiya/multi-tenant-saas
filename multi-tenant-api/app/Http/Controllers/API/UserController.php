<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function setActiveCompany(Request $request, Company $company)
    {
        if ($company->user_id !== $request->user()->id) {
            abort(403);
        }

        $request->user()->update([
            'active_company_id' => $company->id,
        ]);

        return response()->json(['message' => 'Active company switched']);
    }

    public function me(Request $request)
    {
        return $request->user()->load('activeCompany');
    }
}
