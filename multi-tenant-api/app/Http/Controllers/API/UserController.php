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

        $updated = $request->user()->update([
            'active_company_id' => $company->id,
        ]);

        if ($updated) {
            return response()->json([
                'message' => 'Active company switched',
                'company_id' => $company->id,
                'company_name' => $company->name,
            ]);
        } else {
            return response()->json([
                'message' => 'Failed to switch active company.',
            ], 500);
        }
    }


    public function me(Request $request)
    {
        return $request->user()->load('activeCompany');
    }
}
