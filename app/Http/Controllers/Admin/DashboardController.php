<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicResource;
use App\Models\Department;
use App\Models\ExcoMember;
use App\Models\GalleryItem;
use App\Models\NewsPost;
use App\Models\Payment;
use App\Models\SiteSetting;
use App\Models\StaffDirectory;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = User::where('role', 'student')->count();
        $verifiedStudentsCount = User::where('clearance_status', 'verified')->count();
        $verifiedPaidCount = User::where('dues_status', 'paid')->count();
        $totalRevenue = Payment::where('status', 'successful')->sum('amount');
        $resourcesCount = AcademicResource::count();
        $departmentsCount = Department::count();

        $recentPayments = Payment::with('user')->latest()->take(5)->get();
        $recentUsers = User::with('department')->latest()->take(5)->get();

        return view('admin.index', compact(
            'totalStudents',
            'verifiedStudentsCount',
            'verifiedPaidCount',
            'totalRevenue',
            'resourcesCount',
            'departmentsCount',
            'recentPayments',
            'recentUsers'
        ));

    }

    public function users()
    {
        $users = User::with('department')->latest()->get();
        $departments = Department::all();

        return view('admin.users', compact('users', 'departments'));
    }

    public function toggleVerification($id)
    {
        $user = User::findOrFail($id);
        $user->clearance_status = $user->clearance_status === 'verified' ? 'pending' : 'verified';
        $user->dues_status = $user->clearance_status === 'verified' ? 'paid' : 'unpaid';
        $user->save();

        return back()->with('success', 'Student verification status updated successfully.');
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'Student record deleted successfully.');
    }

    public function payments()
    {
        $payments = Payment::with('user.department')->latest()->get();

        return view('admin.payments', compact('payments'));
    }

    public function posts()
    {
        $posts = NewsPost::latest()->get();

        return view('admin.posts', compact('posts'));
    }

    public function about()
    {
        $excos = ExcoMember::with('department')->ordered()->get();
        $departments = Department::all();
        $settings = SiteSetting::all()->pluck('value', 'key');
        $president = $excos->first(function ($e) {
            $pos = strtolower($e->office_position);
            return str_contains($pos, 'president') && !str_contains($pos, 'vice');
        }) ?? $excos->first();

        return view('admin.about', compact('excos', 'departments', 'settings', 'president'));
    }

    public function updateAboutSettings(Request $request)
    {
        $presidentPhotoPath = null;

        // 1. President photo upload
        if ($request->hasFile('about_president_photo')) {
            $file = $request->file('about_president_photo');
            $fileName = 'president_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('about', $fileName, 'public');
            $presidentPhotoPath = 'storage/about/' . $fileName;
            SiteSetting::set('about_president_photo', $presidentPhotoPath);
        }

        // 2. Text settings update
        $settingKeys = [
            'about_president_name',
            'about_president_title',
            'about_president_quote',
            'about_president_speech',
            'about_overview',
            'about_mission',
            'about_vision',
        ];

        foreach ($settingKeys as $key) {
            if ($request->has($key)) {
                SiteSetting::set($key, $request->input($key));
            }
        }

        // Sync President Exco card if present
        $presidentName = $request->input('about_president_name');
        $presidentExco = ExcoMember::whereRaw("LOWER(office_position) LIKE '%president%' AND LOWER(office_position) NOT LIKE '%vice%'")->first();
        if ($presidentExco) {
            $syncData = [];
            if ($presidentName) $syncData['name'] = $presidentName;
            if ($presidentPhotoPath) $syncData['photo_path'] = $presidentPhotoPath;
            if (!empty($syncData)) $presidentExco->update($syncData);
        }

        // 3. Batch updates for Excos
        if ($request->has('excos') && is_array($request->input('excos'))) {
            foreach ($request->input('excos') as $excoId => $excoData) {
                $exco = ExcoMember::find($excoId);
                if ($exco) {
                    $exco->update([
                        'name' => $excoData['name'] ?? $exco->name,
                        'office_position' => $excoData['office_position'] ?? $exco->office_position,
                        'department_id' => $excoData['department_id'] ?? $exco->department_id,
                        'twitter_handle' => $excoData['twitter_handle'] ?? $exco->twitter_handle,
                        'linkedin_url' => $excoData['linkedin_url'] ?? $exco->linkedin_url,
                    ]);

                    if ($request->hasFile("exco_photo_{$excoId}")) {
                        $file = $request->file("exco_photo_{$excoId}");
                        $fileName = 'exco_' . $excoId . '_' . time() . '.' . $file->getClientOriginalExtension();
                        $file->storeAs('excos', $fileName, 'public');
                        $exco->update(['photo_path' => 'storage/excos/' . $fileName]);
                    }
                }
            }
        }

        return redirect()->back()->with('success', 'Home & About Us content saved successfully! Live portal and main website are synchronized.');
    }

    public function gallery()
    {
        $items = GalleryItem::with('department')->latest()->get();
        $departments = Department::all();

        return view('admin.gallery', compact('items', 'departments'));
    }

    public function resources()
    {
        $resources = AcademicResource::with('department')->latest()->get();
        $departments = Department::all();

        return view('admin.resources', compact('resources', 'departments'));
    }

    public function staff()
    {
        $staff = StaffDirectory::with('department')->latest()->get();
        $departments = Department::all();

        return view('admin.staff', compact('staff', 'departments'));
    }

    public function settings()
    {
        $settings = SiteSetting::all()->pluck('setting_value', 'setting_key');

        return view('admin.settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        foreach ($request->except('_token') as $key => $value) {
            SiteSetting::updateOrCreate(
                ['setting_key' => $key],
                ['setting_value' => $value]
            );
        }

        return back()->with('success', 'Portal settings updated successfully.');
    }
}
