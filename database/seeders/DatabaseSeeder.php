<?php

namespace Database\Seeders;

use App\Models\AcademicResource;
use App\Models\Department;
use App\Models\ExcoMember;
use App\Models\GalleryItem;
use App\Models\NewsPost;
use App\Models\Payment;
use App\Models\StaffDirectory;
use App\Models\StudentAlbum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Spatie Roles & Permissions
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $executiveRole = Role::firstOrCreate(['name' => 'executive']);
        $classRepRole = Role::firstOrCreate(['name' => 'class_rep']);
        $studentRole = Role::firstOrCreate(['name' => 'student']);

        $permissions = [
            'manage-students',
            'manage-payments',
            'manage-posts',
            'manage-gallery',
            'manage-vault',
            'send-notifications',
            'manage-settings',
            'manage-elections',
        ];

        foreach ($permissions as $permName) {
            \Spatie\Permission\Models\Permission::firstOrCreate(['name' => $permName]);
        }

        $adminRole->syncPermissions($permissions);
        $executiveRole->syncPermissions(['manage-posts', 'manage-gallery', 'manage-vault', 'send-notifications']);
        $classRepRole->syncPermissions(['manage-vault']);


        // 2. Seed Departments
        $deptsData = [
            ['name' => 'Civil & Water Resources Engineering', 'code' => 'CWE', 'slug' => 'civil-water-resources'],
            ['name' => 'Electrical & Electronics Engineering', 'code' => 'EEE', 'slug' => 'electrical-electronics'],
            ['name' => 'Mechanical Engineering', 'code' => 'MEE', 'slug' => 'mechanical-engineering'],
            ['name' => 'Computer Engineering', 'code' => 'CPE', 'slug' => 'computer-engineering'],
            ['name' => 'Agricultural & Env. Engineering', 'code' => 'AEE', 'slug' => 'agricultural-environmental'],
            ['name' => 'Chemical Engineering', 'code' => 'CHE', 'slug' => 'chemical-engineering'],
            ['name' => 'Food Science & Technology', 'code' => 'FST', 'slug' => 'food-science-technology'],
            ['name' => 'Petroleum & Gas Engineering', 'code' => 'PGE', 'slug' => 'petroleum-gas'],
        ];

        $deptModels = [];
        foreach ($deptsData as $d) {
            $deptModels[$d['code']] = Department::updateOrCreate(['code' => $d['code']], $d);
        }

        // 3. Seed Default Executive Admin
        $adminUser = User::updateOrCreate(
            ['email' => 'admin@nuesaunimaid.org.ng'],
            [
                'name' => 'Engr. Admin Yusuf',
                'role' => 'admin',
                'matric_number' => 'NUESA/ADMIN/001',
                'department_id' => $deptModels['CPE']->id,
                'academic_class' => 'Alumni',
                'phone' => '+234 800 000 0000',
                'state_of_origin' => 'Borno State',
                'dues_status' => 'paid',
                'clearance_status' => 'verified',
                'password' => Hash::make('password123'),
            ]
        );
        $adminUser->assignRole($adminRole);


        // 4. Seed Default Student User
        $studentUser = User::updateOrCreate(
            ['email' => 'ismail.yusuf@eng.unimaid.edu.ng'],
            [
                'name' => 'Comr. Ismail Isah Yusuf',
                'matric_number' => '18/04/01/0101',
                'department_id' => $deptModels['CWE']->id,
                'academic_class' => '500L',
                'phone' => '+234 803 456 7890',
                'state_of_origin' => 'Borno State',
                'dues_status' => 'paid',
                'clearance_status' => 'verified',
                'password' => Hash::make('password123'),
            ]
        );
        $studentUser->assignRole($studentRole);

        // 5. Seed Exco Members
        $excos = [
            ['name' => 'Comr. Ismail Isah Yusuf', 'office_position' => 'President', 'department_id' => $deptModels['CWE']->id, 'twitter_handle' => '@ismail_nuesa', 'linkedin_url' => 'https://linkedin.com', 'photo_path' => 'img/project-1.jpg', 'sort_order' => 1],
            ['name' => 'Comr. Fatima Ibrahim', 'office_position' => 'Vice President', 'department_id' => $deptModels['EEE']->id, 'twitter_handle' => '@fatima_nuesa', 'linkedin_url' => 'https://linkedin.com', 'photo_path' => 'img/project-4.jpg', 'sort_order' => 2],
            ['name' => 'Comr. Abubakar Ali', 'office_position' => 'Secretary General', 'department_id' => $deptModels['MEE']->id, 'twitter_handle' => '@abubakar_sec', 'linkedin_url' => 'https://linkedin.com', 'photo_path' => 'img/project-2.jpg', 'sort_order' => 3],
            ['name' => 'Comr. Zainab Hassan', 'office_position' => 'Financial Secretary', 'department_id' => $deptModels['CPE']->id, 'twitter_handle' => '@zainab_finsec', 'linkedin_url' => 'https://linkedin.com', 'photo_path' => 'img/team-2.jpg', 'sort_order' => 4],
        ];
        foreach ($excos as $e) {
            ExcoMember::updateOrCreate(['name' => $e['name']], $e);
        }

        // 6. Seed Staff Directory
        $staff = [
            ['name' => 'Prof. Engr. Baba Gana Umar', 'designation' => 'Dean, Faculty of Engineering', 'department_id' => $deptModels['AEE']->id, 'office_number' => 'Office Room 101 (Deanery)', 'email' => 'baba.umar@unimaid.edu.ng', 'photo_path' => 'img/team-1.jpg'],
            ['name' => 'Engr. Dr. Mohammed Ali', 'designation' => 'Head of Department (CWE)', 'department_id' => $deptModels['CWE']->id, 'office_number' => 'Office Room 204 (Civil Wing)', 'email' => 'm.ali@unimaid.edu.ng', 'photo_path' => 'img/team-1.jpg'],
            ['name' => 'Engr. Dr. Fatima Kyari', 'designation' => 'Head of Department (EEE)', 'department_id' => $deptModels['EEE']->id, 'office_number' => 'Office Room 112 (Electrical Wing)', 'email' => 'fatima.kyari@unimaid.edu.ng', 'photo_path' => 'img/team-2.jpg'],
            ['name' => 'Engr. Prof. Usman Abubakar', 'designation' => 'Senior Lecturer & SIWES Coordinator', 'department_id' => $deptModels['MEE']->id, 'office_number' => 'Office Room 305 (Mechanical Lab)', 'email' => 'usman.abubakar@unimaid.edu.ng', 'photo_path' => 'img/team-3.jpg'],
        ];
        foreach ($staff as $s) {
            StaffDirectory::updateOrCreate(['name' => $s['name']], $s);
        }

        // 7. Seed News Posts
        $newsPosts = [
            [
                'title' => 'NUESA Annual Engineering Week 2026 Kickoff & Innovation Expo',
                'slug' => 'nuesa-annual-engineering-week-2026-kickoff',
                'category' => 'Upcoming Event',
                'summary' => 'Get ready for the biggest faculty event of the year featuring hackathons, Spaghetti Bridge structural contests, and keynote industry speakers.',
                'body' => "The Executive Council of the Nigerian Universities Engineering Students Association (NUESA), University of Maiduguri Chapter, is thrilled to announce the official schedule for the 2026 Annual Engineering Week & Student Innovation Expo.\n\nThis flagship annual event brings together over 2,500 engineering undergraduates across 8 accredited departments for five days of intense technical competitions, paper presentations, cultural carnivals, and high-impact industrial networking sessions.\n\nEvent Key Highlights:\n- Hackathon & Software Pitch: AI, IoT & Embedded Systems Solutions.\n- Spaghetti Bridge Structural Contest: Load testing and civil engineering challenge.\n- Keynote Industry Lecture: Renewable Energy Transitions in Sub-Saharan Africa.\n- Grand Awards & Dinner Night: Honoring outstanding engineering scholars.\n\nRegistration for student project stalls, paper presentations, and dinner pass tickets is now open online via the student portal. All class representatives are advised to coordinate departmental participation with the Steering Committee.",
                'featured_image' => 'img/project-1.jpg',
                'is_published' => true,
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => '2025/2026 Session Dues & Clearance Portal Now Live',
                'slug' => '2025-2026-session-dues-clearance-portal-live',
                'category' => 'Announcement',
                'summary' => 'All engineering students across 8 departments can now generate payment receipts and verify clearance status directly on the e-portal.',
                'body' => "The Executive Council of NUESA UNIMAID hereby informs all engineering students that the official 2025/2026 session departmental dues payment and clearance verification portal is now fully active.\n\nStudents can log in to their student portal dashboard using their registered email or matriculation number to complete dues payment safely via debit card or online transfer.\n\nKey Steps for Clearance:\n1. Log into your NUESA Student Portal.\n2. Click on 'Pay Dues' and complete the transaction.\n3. Instantly download your official digitally signed PDF payment receipt.\n4. Present your receipt during departmental clearance or faculty registration.\n\nFor technical assistance or payment inquiries, visit the NUESA Secretariat or contact the Financial Secretary.",
                'featured_image' => 'img/project-4.jpg',
                'is_published' => true,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'NUESA Electoral Commission Releases Executive Election Timetable',
                'slug' => 'nuesa-electoral-commission-releases-election-timetable',
                'category' => 'Elections',
                'summary' => 'Voter accreditation and candidate screening for the upcoming chapter executive election will begin electronically next month.',
                'body' => "The NUESA Independent Electoral Commission (NUECO), University of Maiduguri Chapter, has officially released the guidelines and timetable for the 2026/2027 Executive Council elections.\n\nIn line with democratic standards and portal integration, voter accreditation and ballot casting will be conducted through the secure NUESA e-voting system.\n\nElection Schedule Overview:\n- Nomination Form Sales: Opens Monday, September 1st.\n- Candidate Screening: Friday, September 12th at Faculty Conference Room.\n- Presidential Debate: Wednesday, September 17th at Faculty Main Auditorium.\n- Electronic Voting Day: Friday, September 19th (8:00 AM - 4:00 PM).\n\nAll aspirants are urged to download nomination forms from the portal resources section and adhere strictly to election regulations.",
                'featured_image' => 'img/project-5.jpg',
                'is_published' => true,
                'published_at' => now()->subDays(10),
            ],
            [
                'title' => 'Faculty of Engineering Holds Annual SIWES Orientation Workshop',
                'slug' => 'faculty-of-engineering-holds-annual-siwes-orientation-workshop',
                'category' => 'Academic & SIWES',
                'summary' => 'Mandatory orientation briefing for 300L and 400L students proceeding on Students Industrial Work Experience Scheme.',
                'body' => "The Faculty of Engineering SIWES Coordination Committee, in collaboration with NUESA UNIMAID, invites all 300-level and 400-level students to the mandatory SIWES Orientation Workshop.\n\nThe workshop will provide critical guidance on logbook documentation, industrial safety standards, ITF supervision expectations, and placement letter processing.\n\nDate: Thursday, October 8th, 2026\nTime: 10:00 AM Prompt\nVenue: Faculty Main Auditorium\nGuest Speaker: Engr. Prof. Usman Abubakar (SIWES Coordinator)\n\nAttendance is mandatory for logbook issuance.",
                'featured_image' => 'img/project-2.jpg',
                'is_published' => true,
                'published_at' => now()->subDays(14),
            ],
        ];
        foreach ($newsPosts as $n) {
            NewsPost::updateOrCreate(['slug' => $n['slug']], $n);
        }

        // 8. Seed Academic Resources
        $resources = [
            ['title' => 'Fluid Mechanics Past Examination Question 2024', 'course_code' => 'MEE 311', 'category' => 'Past Question', 'department_id' => $deptModels['MEE']->id, 'file_path' => '#', 'file_size' => '2.4 MB'],
            ['title' => 'Structural Analysis II Lecture Slides & Notes', 'course_code' => 'CVE 401', 'category' => 'Lecture Note', 'department_id' => $deptModels['CWE']->id, 'file_path' => '#', 'file_size' => '4.8 MB'],
            ['title' => 'Control Systems Engineering Tutorial Guide', 'course_code' => 'EEE 403', 'category' => 'Tutorial Guide', 'department_id' => $deptModels['EEE']->id, 'file_path' => '#', 'file_size' => '1.9 MB'],
            ['title' => 'Digital Logic Design Past Examination Paper 2023', 'course_code' => 'CPE 201', 'category' => 'Past Question', 'department_id' => $deptModels['CPE']->id, 'file_path' => '#', 'file_size' => '3.1 MB'],
        ];
        foreach ($resources as $r) {
            AcademicResource::updateOrCreate(['title' => $r['title']], $r);
        }

        // 9. Seed Photo Gallery Items (Pure Event & Campus Photos)
        $galleryItems = [
            ['title' => 'Civil Engineering Structural Testing Lab', 'category' => 'civil', 'department_id' => $deptModels['CWE']->id, 'image_path' => 'img/project-1.jpg', 'verification_status' => 'verified'],
            ['title' => 'Electrical & Electronics Circuit Experiment', 'category' => 'electrical', 'department_id' => $deptModels['EEE']->id, 'image_path' => 'img/project-2.jpg', 'verification_status' => 'verified'],
            ['title' => 'Mechanical CAD Design Showcase', 'category' => 'mechanical', 'department_id' => $deptModels['MEE']->id, 'image_path' => 'img/project-3.jpg', 'verification_status' => 'verified'],
            ['title' => 'Computer Hardware & Microcontroller Exhibition', 'category' => 'computer', 'department_id' => $deptModels['CPE']->id, 'image_path' => 'img/project-4.jpg', 'verification_status' => 'verified'],
            ['title' => 'Engineering Week Cultural Carnival', 'category' => 'events', 'department_id' => null, 'image_path' => 'img/project-5.jpg', 'verification_status' => 'verified'],
            ['title' => 'Faculty of Engineering Complex Building', 'category' => 'campus', 'department_id' => null, 'image_path' => 'img/carousel-2.jpg', 'verification_status' => 'verified'],
        ];
        foreach ($galleryItems as $g) {
            GalleryItem::updateOrCreate(['title' => $g['title']], $g);
        }

        // 10. Seed Student Album Profiles
        $albums = [
            [
                'student_name' => 'Comr. Ismail Isah Yusuf',
                'student_id_number' => 'NUESA/UMD/2025/0101',
                'department_id' => $deptModels['CWE']->id,
                'academic_class' => 'Class of 2025 (500L)',
                'position_role' => 'NUESA President (Executive Council)',
                'phone' => '+234 803 456 7890',
                'email' => 'ismail.yusuf@eng.unimaid.edu.ng',
                'state_of_origin' => 'Borno State',
                'joined_date' => 'October 2020',
                'verification_status' => 'verified',
                'filter_tag' => 'civil class2025',
                'image_path' => 'img/project-1.jpg',
            ],
            [
                'student_name' => 'Comr. Fatima Ibrahim',
                'student_id_number' => 'NUESA/UMD/2025/0102',
                'department_id' => $deptModels['EEE']->id,
                'academic_class' => 'Class of 2025 (500L)',
                'position_role' => 'NUESA Vice President',
                'phone' => '+234 812 345 6789',
                'email' => 'fatima.ibrahim@eng.unimaid.edu.ng',
                'state_of_origin' => 'Yobe State',
                'joined_date' => 'November 2020',
                'verification_status' => 'verified',
                'filter_tag' => 'electrical class2025',
                'image_path' => 'img/project-4.jpg',
            ],
            [
                'student_name' => 'Comr. Abubakar Ali',
                'student_id_number' => 'NUESA/UMD/2025/0103',
                'department_id' => $deptModels['MEE']->id,
                'academic_class' => 'Class of 2025 (500L)',
                'position_role' => 'NUESA Secretary General',
                'phone' => '+234 806 789 0123',
                'email' => 'abubakar.ali@eng.unimaid.edu.ng',
                'state_of_origin' => 'Adamawa State',
                'joined_date' => 'January 2021',
                'verification_status' => 'to_be_verified',
                'filter_tag' => 'mechanical class2025',
                'image_path' => 'img/project-2.jpg',
            ],
            [
                'student_name' => 'Engr. Babagana Sheriff',
                'student_id_number' => 'NUESA/UMD/2024/0084',
                'department_id' => $deptModels['CPE']->id,
                'academic_class' => 'Class of 2024 (Alumni)',
                'position_role' => 'Former NUESA Tech Lead',
                'phone' => '+234 814 567 8901',
                'email' => 'babagana.sheriff@alumni.unimaid.edu.ng',
                'state_of_origin' => 'Borno State',
                'joined_date' => 'September 2019',
                'verification_status' => 'verified',
                'filter_tag' => 'computer class2024 archives',
                'image_path' => 'img/project-5.jpg',
            ],
            [
                'student_name' => 'Engr. Amina Usman',
                'student_id_number' => 'NUESA/UMD/2024/0085',
                'department_id' => $deptModels['CWE']->id,
                'academic_class' => 'Class of 2024 (Alumni)',
                'position_role' => 'Best Graduating Student (Civil)',
                'phone' => '+234 802 345 6789',
                'email' => 'amina.usman@alumni.unimaid.edu.ng',
                'state_of_origin' => 'Taraba State',
                'joined_date' => 'October 2019',
                'verification_status' => 'to_be_verified',
                'filter_tag' => 'civil class2024 archives',
                'image_path' => 'img/project-3.jpg',
            ],
            [
                'student_name' => 'Emmanuel Chidiebere',
                'student_id_number' => 'NUESA/UMD/2025/0106',
                'department_id' => $deptModels['EEE']->id,
                'academic_class' => 'Class of 2025 (500L)',
                'position_role' => 'IEEE UNIMAID Student Chair',
                'phone' => '+234 813 678 9012',
                'email' => 'emmanuel.c@eng.unimaid.edu.ng',
                'state_of_origin' => 'Enugu State',
                'joined_date' => 'February 2021',
                'verification_status' => 'verified',
                'filter_tag' => 'electrical class2025 archives',
                'image_path' => 'img/project-6.jpg',
            ],
            [
                'student_name' => 'Comr. Zainab Hassan',
                'student_id_number' => 'NUESA/UMD/2025/0107',
                'department_id' => $deptModels['CPE']->id,
                'academic_class' => 'Class of 2025 (500L)',
                'position_role' => 'NUESA Financial Secretary',
                'phone' => '+234 805 432 1098',
                'email' => 'zainab.hassan@eng.unimaid.edu.ng',
                'state_of_origin' => 'Bauchi State',
                'joined_date' => 'October 2020',
                'verification_status' => 'to_be_verified',
                'filter_tag' => 'computer class2025',
                'image_path' => 'img/team-2.jpg',
            ],
            [
                'student_name' => 'Engr. Usman Kyari',
                'student_id_number' => 'NUESA/UMD/2024/0088',
                'department_id' => $deptModels['AEE']->id,
                'academic_class' => 'Class of 2024 (Alumni)',
                'position_role' => 'PRO Executive',
                'phone' => '+234 816 789 0123',
                'email' => 'usman.kyari@alumni.unimaid.edu.ng',
                'state_of_origin' => 'Borno State',
                'joined_date' => 'November 2019',
                'verification_status' => 'verified',
                'filter_tag' => 'agricultural class2024 archives',
                'image_path' => 'img/team-1.jpg',
            ],
            [
                'student_name' => 'Comr. Idris Mohammed',
                'student_id_number' => 'NUESA/UMD/2025/0109',
                'department_id' => $deptModels['CHE']->id,
                'academic_class' => 'Class of 2025 (500L)',
                'position_role' => 'Social Director',
                'phone' => '+234 807 654 3210',
                'email' => 'idris.mohammed@eng.unimaid.edu.ng',
                'state_of_origin' => 'Gombe State',
                'joined_date' => 'March 2021',
                'verification_status' => 'to_be_verified',
                'filter_tag' => 'chemical class2025',
                'image_path' => 'img/team-3.jpg',
            ],
            [
                'student_name' => 'Engr. Maryam Bello',
                'student_id_number' => 'NUESA/UMD/2024/0090',
                'department_id' => $deptModels['FST']->id,
                'academic_class' => 'Class of 2024 (Alumni)',
                'position_role' => 'Sports Director',
                'phone' => '+234 818 901 2345',
                'email' => 'maryam.bello@alumni.unimaid.edu.ng',
                'state_of_origin' => 'Kano State',
                'joined_date' => 'December 2019',
                'verification_status' => 'verified',
                'filter_tag' => 'food class2024 archives',
                'image_path' => 'img/project-2.jpg',
            ],
        ];
        foreach ($albums as $a) {
            StudentAlbum::updateOrCreate(['student_name' => $a['student_name']], $a);
        }

        // 11. Seed Payment Record
        Payment::updateOrCreate(
            ['reference' => 'NUESA-2025-98401'],
            [
                'uuid' => 'NUESA-2025-98401',
                'user_id' => $studentUser->id,
                'amount' => 3500.00,
                'academic_session' => '2025/2026',
                'payment_type' => 'Departmental Dues',
                'payment_channel' => 'Debit Card',
                'status' => 'successful',
                'paid_at' => now(),
            ]
        );

        // 12. Seed Portal Notifications
        $notifications = [
            [
                'title' => 'NUESA Elections Live',
                'message' => 'Voting poll is open for 2025/2026 Executive Council.',
                'type' => 'info',
                'is_read' => false,
                'user_id' => $studentUser->id,
            ],
            [
                'title' => 'Dues Payment Received',
                'message' => 'Receipt NUESA-TXN-984211 ready for download.',
                'type' => 'success',
                'is_read' => false,
                'user_id' => $studentUser->id,
            ],
            [
                'title' => 'Course Vault Updated',
                'message' => 'New CPE 501 past questions uploaded to academic vault.',
                'type' => 'info',
                'is_read' => true,
                'user_id' => $studentUser->id,
            ],
        ];

        foreach ($notifications as $notif) {
            \App\Models\PortalNotification::updateOrCreate(
                ['title' => $notif['title'], 'user_id' => $notif['user_id']],
                $notif
            );
        }

        // 13. Seed Election Candidates
        $candidates = [
            [
                'name' => 'Comr. Ismail Isah Yusuf',
                'office' => 'PRESIDENT',
                'matric_number' => '22/05/04/0012',
                'department' => 'Computer Engineering',
                'level' => '500L',
                'photo' => 'img/team-1.jpg',
                'manifesto' => 'Fostering digital innovation, industrial internship placements, and enhanced student welfare across all 8 engineering departments.',
                'votes' => 0,
            ],
            [
                'name' => 'Comr. Mustapha Umar',
                'office' => 'VICE PRESIDENT',
                'matric_number' => '21/05/02/0014',
                'department' => 'Civil Engineering',
                'level' => '400L',
                'photo' => 'img/team-2.jpg',
                'manifesto' => 'Empowering students through workshops, mentorship schemes, and academic excellence awards.',
                'votes' => 0,
            ],
            [
                'name' => 'Comr. Fatima Aliyu',
                'office' => 'GENERAL SECRETARY',
                'matric_number' => '22/05/03/0089',
                'department' => 'Electrical Engineering',
                'level' => '300L',
                'photo' => 'img/team-3.jpg',
                'manifesto' => 'Transparent governance, digitizing chapter archives, and active communication via e-portal.',
                'votes' => 0,
            ],
        ];

        foreach ($candidates as $c) {
            \App\Models\ElectionCandidate::updateOrCreate(['matric_number' => $c['matric_number']], $c);
        }

        // 14. Seed Default Site Settings
        $siteSettings = [
            'about_president_name' => 'Comr. Ismail Isah Yusuf',
            'about_president_title' => 'NUESA President (2025/2026 Session)',
            'about_president_photo' => 'img/team-1.jpg',
            'about_president_quote' => 'Building world-class engineers through innovation, academic integrity, and dedicated student advocacy.',
            'about_president_speech' => 'On behalf of the Executive Council and the entire engineering student body of the University of Maiduguri, I warmly welcome you to our official web portal. Founded over 25 years ago, NUESA UNIMAID has grown into a vibrant umbrella body uniting over 2,500 students across 8 accredited engineering departments.',
            'about_overview' => 'The National Association of Engineering Students (NUESA), University of Maiduguri Chapter, represents over 3,000 undergraduate and postgraduate engineering scholars across 8 accredited departments. NUESA serves as the unified voice for student advocacy, professional development, and technological empowerment.',
            'about_mission' => 'Empower students through technical mentorship, academic past questions, and career placement support.',
            'about_vision' => 'To produce industry-ready engineering graduates capable of solving complex national challenges.',
        ];

        foreach ($siteSettings as $key => $val) {
            \App\Models\SiteSetting::updateOrCreate(['key' => $key], ['value' => $val]);
        }

        $this->call(ElectionDemoSeeder::class);
    }
}
