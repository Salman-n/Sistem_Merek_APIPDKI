<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Permohonan;
use App\Models\Pengumuman;
use Carbon\Carbon;
use Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    function index() {
        $pengguna = User::count();
        $pemohon = User::where("level","pemohon")->count();
        $belumverif = User::where("level","belumverifikasi")->count();
        $admin = User::where("level","admin")->count();
        $pmerek = Permohonan::count();
        $pmerekterima = Permohonan::where("status","Diterima")->count();
        $pmerekproses = Permohonan::where("status","Dalam Proses")->count();
        $pmerekperbaiki = Permohonan::where("status","Perbaiki")->count();
        return view('admin.index',compact("pengguna",'pmerek','pemohon','belumverif','admin','pmerekterima','pmerekproses','pmerekperbaiki'));
    }
    function verifikasi() {
        $users = User::where("level","belumverifikasi")->get();
        return view('admin.verifikasi',compact("users"));
    }
    function addAdmin(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            "level" => "admin"
        ]);

        return redirect()->back();

    }
    function permohonan() {
        $permohonans = Permohonan::where("status","Dalam Proses")->get();
        return view('admin.permohonan',compact("permohonans"));
    }
    function pemohon() {
        $users = User::where("level","pemohon")->get();
        return view('admin.pemohon',compact("users"));
    }
    function admin() {
        $users = User::where("level","admin")->get();
        return view('admin.admin',compact("users"));
    }
    function pengumuman() {
        $pengumumans = Pengumuman::all();
        return view('admin.pengumuman',compact("pengumumans"));
    }
    function tambahPengumuman() {
        return view('admin.tambah-pengumuman');
    }
    function handleTambahPengumuman(Request $request) {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);
        $pengumuman = new Pengumuman;
        $pengumuman->title = $validatedData['title'];
        $pengumuman->content = $validatedData['content'];
        $pengumuman->save();
        return redirect("/admin/pengumuman");
    }
    function hapusPengumuman($id) {
        $pengumuman = Pengumuman::where("id",$id)->first();
        $pengumuman->delete();
        return redirect()->back();
    }
    function infografis() {

        $permohonandata = Permohonan::select(DB::raw('DATE(created_at) as date_created'), DB::raw('COUNT(*) as total_permohonan'))
        ->where('created_at', '>=', now()->subDays(30))
        ->groupBy(DB::raw('DATE(created_at)'))
        ->orderBy(DB::raw('DATE(created_at)'), 'desc')
        ->get();
        $dates = [];
        $endDate = now();
        $startDate = $endDate->copy()->subDays(29); // Subtract 29 days to get a 30-day range

        while ($startDate->lte($endDate)) {
            $dateObject = (object)[];
            $dateObject->date =  $startDate->format('Y-m-d');
            $dateObject->count= 0;
            foreach ($permohonandata as $permohonan) {
                if (isset($permohonan->date_created) && $permohonan->date_created == $dateObject->date) {
                    $dateObject->count = $permohonan->total_permohonan;
                    break; // You can break out of the loop once you find the value
                }
            }
    
            array_push($dates,$dateObject);
            $startDate->addDay();
        }
        
        $permohonan_data_day = [];
        $permohonan_name_day = [];
        //split for frontend chart
        foreach ($dates as $date) {
            array_push($permohonan_data_day,$date->count);
            array_push($permohonan_name_day ,$date->date);
        }
    
        $permohonandata = Permohonan::select(
            DB::raw('YEAR(created_at) as month_year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total_permohonan')
        )
        ->where('created_at', '>=', now()->subMonths(12))
        ->groupBy('month_year', 'month')
        ->orderBy('month_year', 'desc')
        ->orderBy('month', 'desc')
        ->get();

        $months = [];
        $endDate = now();
        $startDate = $endDate->copy()->subMonths(11); // Subtract 11 months to get the last 12 months
        
        while ($startDate->lte($endDate)) {
            $monthObject = (object)[];
            $monthObject->month_year = $startDate->format('Y-m');
            $monthObject->count = 0;
            foreach ($permohonandata as $permohonan) {
                if (
                    isset($permohonan->month_year) &&
                    isset($permohonan->month) &&
                    $permohonan->month_year == $startDate->format('Y') &&
                    $permohonan->month == $startDate->format('n')
                ) {
                    $monthObject->count = $permohonan->total_permohonan;
                    break; // You can break out of the loop once you find the value
                }
            }
        
            array_push($months, $monthObject);
            $startDate->addMonth();
        }
        
        $permohonan_data_month = [];
        $permohonan_name_month = [];
        
        // Split for frontend chart
        foreach ($months as $month) {
            array_push($permohonan_data_month, $month->count);
            array_push($permohonan_name_month, $month->month_year);
        }

        $permohonandata = Permohonan::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('COUNT(*) as total_permohonan')
        )
        ->where('created_at', '>=', now()->subYears(5))
        ->groupBy('year')
        ->orderBy('year', 'desc')
        ->get();
        
        $years = [];
        $endYear = now()->year;
        $startYear = $endYear - 4; // Calculate the start year for the last 5 years
        
        while ($startYear <= $endYear) {
            $yearObject = (object)[];
            $yearObject->year = $startYear;
            $yearObject->count = 0;
            
            foreach ($permohonandata as $permohonan) {
                if (isset($permohonan->year) && $permohonan->year == $startYear) {
                    $yearObject->count = $permohonan->total_permohonan;
                    break; // You can break out of the loop once you find the value
                }
            }
        
            array_push($years, $yearObject);
            $startYear++;
        }
        
        $permohonan_data_year = [];
        $permohonan_name_year = [];
        
        // Split for frontend chart
        foreach ($years as $year) {
            array_push($permohonan_data_year, $year->count);
            array_push($permohonan_name_year, $year->year );
        }
        $penggunadata = User::select(
            DB::raw('DATE(created_at) as date_created'),
            DB::raw('COUNT(*) as total_pengguna')
        )
        ->where('created_at', '>=', now()->subDays(30))
        ->groupBy(DB::raw('DATE(created_at)'))
        ->orderBy(DB::raw('DATE(created_at)'), 'desc')
        ->get();
        
        $dates = [];
        $endDate = now();
        $startDate = $endDate->copy()->subDays(29); // Subtract 29 days to get a 30-day range
        
        while ($startDate->lte($endDate)) {
            $dateObject = (object)[];
            $dateObject->date =  $startDate->format('Y-m-d');
            $dateObject->count = 0;
            foreach ($penggunadata as $pengguna) {
                if (isset($pengguna->date_created) && $pengguna->date_created == $dateObject->date) {
                    $dateObject->count = $pengguna->total_pengguna;
                    break; // You can break out of the loop once you find the value
                }
            }
        
            array_push($dates, $dateObject);
            $startDate->addDay();
        }
        
        $pengguna_data_day = [];
        $pengguna_name_day = [];
        // Split for frontend chart
        foreach ($dates as $date) {
            array_push($pengguna_data_day, $date->count);
            array_push($pengguna_name_day, $date->date);
        }
        
        $penggunadata = User::select(
            DB::raw('YEAR(created_at) as month_year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total_pengguna')
        )
        ->where('created_at', '>=', now()->subMonths(12))
        ->groupBy('month_year', 'month')
        ->orderBy('month_year', 'desc')
        ->orderBy('month', 'desc')
        ->get();
        
        $months = [];
        $endDate = now();
        $startDate = $endDate->copy()->subMonths(11); // Subtract 11 months to get the last 12 months
        
        while ($startDate->lte($endDate)) {
            $monthObject = (object)[];
            $monthObject->month_year = $startDate->format('Y-m');
            $monthObject->count = 0;
            foreach ($penggunadata as $pengguna) {
                if (
                    isset($pengguna->month_year) &&
                    isset($pengguna->month) &&
                    $pengguna->month_year == $startDate->format('Y') &&
                    $pengguna->month == $startDate->format('n')
                ) {
                    $monthObject->count = $pengguna->total_pengguna;
                    break; // You can break out of the loop once you find the value
                }
            }
        
            array_push($months, $monthObject);
            $startDate->addMonth();
        }
        
        $pengguna_data_month = [];
        $pengguna_name_month = [];
        
        // Split for frontend chart
        foreach ($months as $month) {
            array_push($pengguna_data_month, $month->count);
            array_push($pengguna_name_month, 'month_' . $month->month_year);
        }
        
        $penggunadata = User::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('COUNT(*) as total_pengguna')
        )
        ->where('created_at', '>=', now()->subYears(5))
        ->groupBy('year')
        ->orderBy('year', 'desc')
        ->get();
        
        $years = [];
        $endYear = now()->year;
        $startYear = $endYear - 4; // Calculate the start year for the last 5 years
        
        while ($startYear <= $endYear) {
            $yearObject = (object)[];
            $yearObject->year = $startYear;
            $yearObject->count = 0;
        
            foreach ($penggunadata as $pengguna) {
                if (isset($pengguna->year) && $pengguna->year == $startYear) {
                    $yearObject->count = $pengguna->total_pengguna;
                    break; // You can break out of the loop once you find the value
                }
            }
        
            array_push($years, $yearObject);
            $startYear++;
        }
        
        $pengguna_data_year = [];
        $pengguna_name_year = [];
        
        // Split for frontend chart
        foreach ($years as $year) {
            array_push($pengguna_data_year, $year->count);
            array_push($pengguna_name_year, 'year_' . $year->year . '_year');
        }
        
        return view('admin.infografis',compact('permohonan_data_day','permohonan_name_day','permohonan_name_month','permohonan_data_month','permohonan_name_year','permohonan_data_year','pengguna_data_day','pengguna_name_day','pengguna_name_month','pengguna_data_month','pengguna_name_year','pengguna_data_year'));
    }
    function deletePemohon($id) {
        $users = User::where("id",$id)->first();
        $users->delete();
        return redirect()->back();
    }
    function terimaVerifikasi($id) {
        $user = User::where("id",$id)->first();
        $user->level ="pemohon";
        $user->save();
        return redirect()->back();
    }
    function tolakVerifikasi($id) {
        $user = User::where("id",$id)->first();
        $user->level ="ditolak";
        $user->save();
        return redirect()->back();
    }
    function terimaPermohonan($id) {
        $user = Permohonan::where("id",$id)->first();
        $user->status ="Diterima";
        $user->save();
        return redirect()->back();
    }
    function perbaikiPermohonan($id) {
        $user = Permohonan::where("id",$id)->first();
        $user->status ="Perbaiki";
        $user->save();
        return redirect()->back();
    }
    function tolakPermohonan($id) {
        $user = Permohonan::where("id",$id)->first();
        $user->status ="Ditolak";
        $user->save();
        return redirect()->back();
    }
    function logout(Request $request) {
        Auth::guard('admin')->logout();
        return redirect("/admin");
    }
    public function showLoginForm()
    {
        return view('adminlogin');
    }
    public function login(Request $request)
    {
        // Attempt to authenticate the user
        if (Auth::guard("admin")->attempt(['email' => $request->email, 'password' => $request->password])) {
            // The user has been authenticated, redirect to the intended page
            $user = Auth::guard("admin")->user(); // Get the authenticated user object
            if ($user->level =="admin") {
                return redirect("/admin");
            } else {
                Auth::guard('admin')->logout();
                return redirect("/admin/login");
            }
         }

    }

}
