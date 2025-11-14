<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatientRequest;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class PatientController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Patient::class, 'patient');
    }

    public function index(Request $request)
    {
        $organizationId = $request->user()->organizations()->first()->id;

        $patients = Patient::where('organization_id', $organizationId)
            ->latest()
            ->paginate(15);

        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(PatientRequest $request)
    {
        $organizationId = $request->user()->organizations()->first()->id;

        $patient = Patient::create([
            ...$request->validated(),
            'organization_id' => $organizationId,
        ]);

        return redirect()
            ->route('patients.index')
            ->with('success', 'Paciente cadastrado com sucesso!');
    }

    public function show(Patient $patient)
    {
        // Carregar consultas do paciente
        $patient->load(['appointments' => function ($query) {
            $query->with('responsible')->latest('starts_at');
        }]);

        return view('patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    public function update(PatientRequest $request, Patient $patient)
    {
        $patient->update($request->validated());

        return redirect()
            ->route('patients.show', $patient)
            ->with('success', 'Paciente atualizado com sucesso!');
    }

    public function destroy(Patient $patient)
    {
        $name = $patient->name;

        try {
            $patient->delete();

            return redirect()
                ->route('patients.index')
                ->with('success', "Paciente '{$name}' deletado com sucesso!");
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Não é possível deletar paciente com consultas agendadas.');
        }
    }
}