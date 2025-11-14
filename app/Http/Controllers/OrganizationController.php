<?php

namespace App\Http\Controllers;

use App\Role;
use App\Http\Requests\OrganizationRequest;
use App\Models\Organization;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{

    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Organization::class, 'organization');
    }

    public function index(Request $request)
    {
        $user = $request->user();

        if ($user) {
            $organizations = $user->organizations()
                ->withPivot('role')
                ->latest()
                ->paginate(10);

            return view('organizations.index', compact('organizations'));
        }

        return view('organizations.index', compact('organizations'));
    }

    public function create()
    {
        return view('organizations.create');
    }

    public function store(OrganizationRequest $request)
    {
        $user = $request->user();

        $organization = Organization::create([
            'name' => $request->name,
            'owner_id' => $user->id,
        ]);

        $organization->users()->attach($user->id, [
            'role' => Role::Owner->value,
        ]);

        return redirect()
            ->route('organizations.index')
            ->with('success', 'Clínica criada com sucesso!');
    }

    public function show(Organization $organization)
    {
        // Carregar membros da clínica
        $organization->load(['users' => function ($query) {
            $query->withPivot('role')->orderBy('name');
        }]);

        return view('organizations.show', compact('organization'));
    }

    public function edit(Organization $organization)
    {
        return view('organizations.edit', compact('organization'));
    }

    public function update(OrganizationRequest $request, Organization $organization)
    {
        $organization->update($request->validated());

        return redirect()
            ->route('organizations.show', $organization)
            ->with('success', 'Clínica atualizada com sucesso!');
    }

    public function destroy(Organization $organization)
    {
        $name = $organization->name;
        
        $organization->delete();

        return redirect()
            ->route('organizations.index')
            ->with('success', "Clínica '{$name}' deletada com sucesso!");
    }
}