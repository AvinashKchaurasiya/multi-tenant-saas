<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $companies = $request->user()->companies()->paginate(10);
        return response()->json([
            'companies' => $companies,
            'active_company_id' => $request->user()->active_company_id,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'industry' => 'required|string',
        ]);

        $company = $request->user()->companies()->create($validated);

        return response()->json($company);
    }

    public function show(Request $request, Company $company)
    {
        if ($company->user_id !== $request->user()->id) {
            abort(403);
        }

        return response()->json($company);
    }

    public function update(Request $request, Company $company)
    {
        if ($company->user_id !== $request->user()->id) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'industry' => 'required|string',
        ]);

        $company->update($validated);

        return response()->json($company);
    }

    public function destroy(Request $request, Company $company)
    {
        if ($company->user_id !== $request->user()->id) {
            abort(403);
        }

        $company->delete();

        return response()->json(['message' => 'Company deleted']);
    }


    public function summary(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'active_company_name' => optional($user->activeCompany)->name,
            'total_companies' => $user->companies()->count(),
        ]);
    }
}
