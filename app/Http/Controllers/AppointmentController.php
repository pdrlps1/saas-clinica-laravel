<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Enums\AppointmentStatus;
use App\Http\Requests\AppointmentRequest;
use App\Models\Patient;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AppointmentController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Appointment::class, 'appointment');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $organizationId = $user->organizations()->first()->id;

        $appointments = Appointment::where('organization_id', $organizationId)
            ->with(['patient', 'responsible'])
            ->latest('starts_at')
            ->paginate(15);

        return view('appointments.index', compact('appointments'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $user = $request->user();
        $organizationId = $user->organizations()->first()->id;

        $patients = Patient::where('organization_id', $organizationId)
            ->orderBy('name')
            ->get();
        
        $organization = $user->organizations()->first();
        $responsibles = $organization->users()->orderBy('name')->get();

        return view('appointments.create', compact('patients', 'responsibles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AppointmentRequest $request)
    {
        $user = $request->user();
        $organizationId = $user->organizations()->first()->id;

        $appointment = Appointment::create([
            'organization_id' => $organizationId,
            'patient_id' => $request->patient_id,
            'responsible_user_id' => $request->responsible_user_id,
            'starts_at' => $request->starts_at,
            'duration_min' => $request->duration_min,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return redirect()
            ->route('appointments.index')
            ->with('success', 'Consulta agendada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        $appointment->load(['patient', 'responsible', 'organization']);

        return view ('appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Appointment $appointment)
    {
        $user = $request->user();
        $organizationId = $appointment->organization_id;

        $patients = Patient::where('organization_id', $organizationId)
            ->orderBy('name')
            ->get();
        
        $organization = $user->organizations()
            ->where('organizations.id', $organizationId)
            ->first();
        
        $responsibles = $organization->users()->orderBy('name')->get();

        return view('appointments.edit', compact('appointment', 'patients', 'responsibles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AppointmentRequest $request, Appointment $appointment)
    {
        $appointment->update($request->validated());

        return redirect()
            ->route('appointments.show', $appointment)
            ->with('success', 'Consulta atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $appointment -> delete();

        return redirect()->route('appointment.index')->with('success', 'Consulta deletada com sucesso!');
    }

    public function complete(Appointment $appointment)
    {
        $this->authorize('complete', $appointment);

        $appointment->update([
            'status' => AppointmentStatus::Done,
        ]);

        return redirect()->route('appointments.show', $appointment)->with('success', 'Consulta marcada como concluída!');
    }

    public function cancel(Appointment $appointment)
    {
        $this->authorize('cancel', $appointment);

        $appointment->update([
            'status' => AppointmentStatus::Canceled,
        ]);

        return redirect()->route('appointments.show', $appointment)->with('success', 'Consulta cancelada!');
    }
}
