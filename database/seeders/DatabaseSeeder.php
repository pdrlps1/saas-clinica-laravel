<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\User;
use App\Models\Patient;
use App\Models\Appointment;
use App\Enums\AppointmentStatus;
use App\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $joao = User::create([
            'name' => 'João Silva',
            'email' => 'joao@example.com',
            'password' => Hash::make('password'),
        ]);

        $maria = User::create([
            'name' => 'Maria Santos',
            'email' => 'maria@example.com',
            'password' => Hash::make('password'),
        ]);

        $carlos = User::create([
            'name' => 'Carlos Oliveira',
            'email' => 'carlos@example.com',
            'password' => Hash::make('password'),
        ]);

        $ana = User::create([
            'name' => 'Ana Costa',
            'email' => 'ana@example.com',
            'password' => Hash::make('password'),
        ]);

        $clinicaSantaMaria = Organization::create([
            'name' => 'Clínica Santa Maria',
            'owner_id' => $joao->id,
        ]);

        $clinicaSaoLucas = Organization::create([
            'name' => 'Clínica São Lucas',
            'owner_id' => $carlos->id,
        ]);

        $clinicaSantaMaria->users()->attach($joao->id, [
            'role' => Role::Owner->value,
        ]);

        $clinicaSantaMaria->users()->attach($maria->id, [
            'role' => Role::Staff->value,
        ]);

        $clinicaSaoLucas->users()->attach($carlos->id, [
            'role' => Role::Owner->value,
        ]);

        $clinicaSaoLucas->users()->attach($ana->id, [
            'role' => Role::Staff->value,
        ]);

        $paciente1 = Patient::create([
            'organization_id' => $clinicaSantaMaria->id,
            'name' => 'Pedro Alves',
            'email' => 'pedro.alves@email.com',
            'phone' => '(16) 98765-4321',
            'birthdate' => '1985-03-15',
        ]);

        $paciente2 = Patient::create([
            'organization_id' => $clinicaSantaMaria->id,
            'name' => 'Juliana Ferreira',
            'email' => 'juliana.f@email.com',
            'phone' => '(16) 99876-5432',
            'birthdate' => '1992-07-22',
        ]);

        $paciente3 = Patient::create([
            'organization_id' => $clinicaSantaMaria->id,
            'name' => 'Roberto Mendes',
            'email' => null, // Paciente sem email
            'phone' => '(16) 97654-3210',
            'birthdate' => '1978-11-30',
        ]);

        // Pacientes da Clínica São Lucas
        $paciente4 = Patient::create([
            'organization_id' => $clinicaSaoLucas->id,
            'name' => 'Carla Souza',
            'email' => 'carla.souza@email.com',
            'phone' => '(16) 96543-2109',
            'birthdate' => '1990-05-08',
        ]);

        $paciente5 = Patient::create([
            'organization_id' => $clinicaSaoLucas->id,
            'name' => 'Fernando Lima',
            'email' => 'fernando.lima@email.com',
            'phone' => '(16) 95432-1098',
            'birthdate' => '1965-12-25',
        ]);

        $paciente6 = Patient::create([
            'organization_id' => $clinicaSaoLucas->id,
            'name' => 'Beatriz Rocha',
            'email' => 'beatriz.r@email.com',
            'phone' => null, // Paciente sem telefone
            'birthdate' => '2000-09-17',
        ]);

        Appointment::create([
            'organization_id' => $clinicaSantaMaria->id,
            'patient_id' => $paciente1->id,
            'responsible_user_id' => $joao->id, // Owner é responsável
            'starts_at' => now()->addDays(2)->setTime(9, 0),
            'duration_min' => 30,
            'status' => AppointmentStatus::Scheduled,
            'notes' => 'Consulta de rotina',
        ]);

        Appointment::create([
            'organization_id' => $clinicaSantaMaria->id,
            'patient_id' => $paciente2->id,
            'responsible_user_id' => $maria->id, // Staff é responsável
            'starts_at' => now()->addDays(3)->setTime(14, 30),
            'duration_min' => 60,
            'status' => AppointmentStatus::Scheduled,
            'notes' => 'Retorno pós-exame',
        ]);

        Appointment::create([
            'organization_id' => $clinicaSantaMaria->id,
            'patient_id' => $paciente3->id,
            'responsible_user_id' => $maria->id,
            'starts_at' => now()->subDays(5)->setTime(10, 0),
            'duration_min' => 45,
            'status' => AppointmentStatus::Done,
            'notes' => 'Consulta concluída com sucesso',
        ]);

        Appointment::create([
            'organization_id' => $clinicaSantaMaria->id,
            'patient_id' => $paciente1->id,
            'responsible_user_id' => $joao->id,
            'starts_at' => now()->subDays(10)->setTime(15, 0),
            'duration_min' => 30,
            'status' => AppointmentStatus::Canceled,
            'notes' => 'Paciente cancelou por motivos pessoais',
        ]);

        // Consultas da Clínica São Lucas
        Appointment::create([
            'organization_id' => $clinicaSaoLucas->id,
            'patient_id' => $paciente4->id,
            'responsible_user_id' => $carlos->id, // Owner é responsável
            'starts_at' => now()->addDays(1)->setTime(8, 0),
            'duration_min' => 45,
            'status' => AppointmentStatus::Scheduled,
            'notes' => 'Primeira consulta',
        ]);

        Appointment::create([
            'organization_id' => $clinicaSaoLucas->id,
            'patient_id' => $paciente5->id,
            'responsible_user_id' => $ana->id, // Staff é responsável
            'starts_at' => now()->addDays(4)->setTime(11, 0),
            'duration_min' => 30,
            'status' => AppointmentStatus::Scheduled,
            'notes' => 'Acompanhamento mensal',
        ]);

        Appointment::create([
            'organization_id' => $clinicaSaoLucas->id,
            'patient_id' => $paciente6->id,
            'responsible_user_id' => $ana->id,
            'starts_at' => now()->subDays(3)->setTime(16, 0),
            'duration_min' => 60,
            'status' => AppointmentStatus::Done,
            'notes' => 'Procedimento realizado',
        ]);

        Appointment::create([
            'organization_id' => $clinicaSaoLucas->id,
            'patient_id' => $paciente4->id,
            'responsible_user_id' => $carlos->id,
            'starts_at' => now()->subDays(7)->setTime(13, 30),
            'duration_min' => 30,
            'status' => AppointmentStatus::Canceled,
            'notes' => 'Reagendado para outra data',
        ]);

        $this->command->info('Seed concluído com sucesso!');
        $this->command->newLine();
        $this->command->info('DADOS CRIADOS:');
        $this->command->info('  • 4 usuários');
        $this->command->info('  • 2 clínicas');
        $this->command->info('  • 6 pacientes (3 por clínica)');
        $this->command->info('  • 8 consultas (4 por clínica)');
        $this->command->newLine();
        $this->command->info('CREDENCIAIS DE ACESSO:');
        $this->command->table(
            ['Nome', 'Email', 'Senha', 'Role', 'Clínica'],
            [
                ['João Silva', 'joao@example.com', 'password', 'Owner', 'Clínica Santa Maria'],
                ['Maria Santos', 'maria@example.com', 'password', 'Staff', 'Clínica Santa Maria'],
                ['Carlos Oliveira', 'carlos@example.com', 'password', 'Owner', 'Clínica São Lucas'],
                ['Ana Costa', 'ana@example.com', 'password', 'Staff', 'Clínica São Lucas'],
            ]
        );
    }
}
