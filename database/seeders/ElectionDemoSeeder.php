<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\ElectionCandidate;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

/**
 * Demo data: students, an executive account and extra election candidates.
 * Every demo account uses the password "password123".
 */
class ElectionDemoSeeder extends Seeder
{
    public function run(): void
    {
        $studentRole = Role::firstOrCreate(['name' => 'student']);
        $executiveRole = Role::firstOrCreate(['name' => 'executive']);
        $depts = Department::pluck('id', 'code');

        $students = [
            ['Aisha Bello', 'aisha.bello@student.nuesa.test', '21/04/01/0201', 'CWE', '400L'],
            ['Usman Garba', 'usman.garba@student.nuesa.test', '21/04/02/0202', 'EEE', '400L'],
            ['Halima Musa', 'halima.musa@student.nuesa.test', '22/04/03/0203', 'MEE', '300L'],
            ['Ibrahim Kolo', 'ibrahim.kolo@student.nuesa.test', '22/04/04/0204', 'CPE', '300L'],
            ['Maryam Sani', 'maryam.sani@student.nuesa.test', '23/04/05/0205', 'CHE', '200L'],
            ['Yusuf Abdullahi', 'yusuf.abdullahi@student.nuesa.test', '23/04/06/0206', 'PGE', '200L'],
        ];

        foreach ($students as [$name, $email, $matric, $dept, $level]) {
            $user = User::updateOrCreate(['email' => $email], [
                'name' => $name,
                'role' => 'student',
                'matric_number' => $matric,
                'department_id' => $depts[$dept] ?? null,
                'academic_class' => $level,
                'phone' => '+234 80' . random_int(10000000, 99999999),
                'state_of_origin' => 'Borno State',
                'dues_status' => 'paid',
                'clearance_status' => 'verified',
                'password' => 'password123',
            ]);
            $user->syncRoles([$studentRole]);
        }

        $exec = User::updateOrCreate(['email' => 'exec@nuesaunimaid.org.ng'], [
            'name' => 'Comr. Executive Demo',
            'role' => 'executive',
            'matric_number' => 'NUESA/EXEC/001',
            'department_id' => $depts['EEE'] ?? null,
            'academic_class' => '500L',
            'dues_status' => 'paid',
            'clearance_status' => 'verified',
            'password' => 'password123',
        ]);
        $exec->syncRoles([$executiveRole]);

        $candidates = [
            ['Comr. Abdul Karim', 'PRESIDENT', '20/04/01/0301', 'Mechanical Engineering', '500L', 'img/team-2.jpg', 'Industry partnerships and paid internships for every department.'],
            ['Comr. Khadija Lawan', 'VICE PRESIDENT', '21/04/02/0302', 'Chemical Engineering', '400L', 'img/team-3.jpg', 'Welfare, mentorship and a stronger voice for female engineers.'],
            ['Comr. Bashir Adamu', 'GENERAL SECRETARY', '21/04/03/0303', 'Computer Engineering', '400L', 'img/team-1.jpg', 'Digital record keeping and open, timely communication.'],
        ];
        foreach ($candidates as [$name, $office, $matric, $dept, $level, $photo, $manifesto]) {
            ElectionCandidate::updateOrCreate(['matric_number' => $matric], compact('name', 'office') + [
                'department' => $dept, 'level' => $level, 'photo' => $photo, 'manifesto' => $manifesto, 'votes' => 0,
            ]);
        }

        SiteSetting::set('election_status', 'LIVE');
    }
}
