<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\Permohonan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class DashboardController extends Controller
{
    function logout(Request $request) {
        Auth::guard('web')->logout();
        return redirect("/");
    }
    //
    function index() {
        
        $permohonans = Permohonan::where("status","Diterima")->orderBy('id','desc')->get();

        return view('dasbor',compact("permohonans"));

    }
    function permohonan() {
        $uid = Auth::user()->id;
        $permohonans = Permohonan::where("user_id",$uid)->orderBy('id','desc')->get();

        return view('permohonan',compact("permohonans"));

    }
    
    function showTambahForm() {
        return view('tambah');
    }
    function showProfileEditForm() {
        $user = Auth::user();
        return view('editprofil',compact("user"));
    }
    function showForm($id) {
        $permohonan = Permohonan::where("id",$id)->first();
        return view('lihat',compact('permohonan'));
    }
    function showEditForm($id) {
        $permohonan = Permohonan::where("id",$id)->first();
        return view('edit',compact('permohonan'));
    }
    function editprofil(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'gender' => 'string',
            'address' => 'string',
        ]);
        $uid = Auth::user()->id;
        $user = User::where("id",$uid)->first();
        $user->name = $validatedData['name'];
        $user->gender = $validatedData['gender'];
        $user->address = $validatedData['address'];
        $user->save();
        return redirect()->back();
        
    }
    function tambah(Request $request) {
        $validatedData = $request->validate([
            'nama_usaha' => 'required|string',
            'alamat_usaha' => 'required|string',
            'pemilik_usaha' => 'required|string',
            'logo' => 'required|image', // Define a custom validation rule
            'umk' => 'nullable',
            'ttd' => 'required|image',
        ]);

        $data = $validatedData;
        $key = $data['nama_usaha'];

        // Awalan LINK sebelum di restrict $PDKI_URL = "https://pdki-indonesia-api.dgip.go.id/api/trademark/search?keyword=$key&page=1&type=trademark&order_state=asc";
        $PDKI_URL = "https://pdki-indonesia-api.dgip.go.id/api/trademark/search2?keyword=" . urlencode($key) . "&page=1&type=trademark&order_state=asc";
        $currentTime = now();
        $formattedDate = $currentTime->format('Ymd');
        $inputString = $formattedDate . urlencode($key) . "arhoBkmdhcHsWSJPyLhLVqGNhAEontUgedqsNAAWjRkXkKDnrnNwolYRnEwGkaYaC";
        $hashString = hash('sha256', $inputString);
        $jsonData = json_encode(["key" => $hashString]);
        $client = new Client();
        $response = $client->post($PDKI_URL, [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => $jsonData
        ]);
        // Get the response body as a string
        $body = $response->getBody()->getContents();

        $obj = json_decode($body);

        $out = $obj->hits->hits;
        $found = false;
        $similarity = [];
        $mereks = [];
        foreach($out as $hit) {
        $key2 = strtolower($hit->_source->nama_merek);
            if (strtolower($key) == $key2) {
            $found = true;
            $similarity[] = 100;
            $mereks[] = $key2;
        }
        $max_length = max(strlen($key), strlen($key2));
        $similarity[] = ((($max_length) - (levenshtein($key,$key2))) / $max_length) * 100;
        $mereks[] = $key2;
        
        }
        // dd($out,$found);   
        $output = (object)[];
        $output->kata  = $key;
        $output->tersedia = !$found;
        $output->kesamaan = 0;
        $mereklist = "";
        $merekobject = [];
        if (count($similarity) > 0) {
            $maxsim = 0;
            foreach ($similarity as $key => $sim) {
                if ($sim > $maxsim) {
                    $maxsim = $sim;
                }
                //create new object
                $mObject = (object)[];
                $mObject->sim = $sim;
                $mObject->merek = $mereks[$key];
                $merekobject[] = $mObject;
            }
            $output->kesamaan = $maxsim ;
            //sort merekObject based on object inside the sim field
            usort($merekobject, function($a, $b) {
                return $b->sim - $a->sim;
            });
            $limit = 3;
            $cur = 0;
      
            foreach ($merekobject as $merek) {
                if($cur == $limit) {
                    break;
                }
                if ($mereklist == "") {
                    $mereklist =$merek->merek . " (" . $merek->sim . "%)";
                } else {
                    $mereklist = $mereklist . " , " . $merek->merek . " (" . $merek->sim . "%)";
                }
                $cur++;
            }
        }




        if (!$output->tersedia) {
            return redirect("/permohonan")->with([ 'alerttype' => 'danger' , 'alert' => "Maaf. nama ini sudah dipakai dan tidak tersedia" ]);
  
            die("Maaf. Nama ini sudah dipakai dan tidak tersedia");
        }

        $data['logo'] = $this->convertImage("logo",$request);
        $data['ttd'] = $this->convertImage("ttd",$request);
        if (empty($request->umk)) {
            $data['umk'] = null;
        } else {
            $data['umk'] = $this->convertImage("umk",$request);
        }
        $data['user_id'] = Auth::user()->id;

        $data['similaritas'] =  $output->kesamaan ;
        $data['similaritas_merek'] = $mereklist;

        if ( $output->kesamaan >= 65) {
        Permohonan::create($data);
           
            return redirect("/permohonan")->with([ 'alert' => "Sukses menambahkan permohonan merek namun perlu perbaikan karena terlalu mirip. Similaritas Nama : " . $output->kesamaan . "%" ]);;
  
        }

        Permohonan::create($data);
        
        return redirect("/permohonan")->with([ 'alert' => "Sukses menambahkan permohonan merek. Similaritas Nama : " . $output->kesamaan . "%" ]);;
  
    }

    function edit(Request $request) {
        $validatedData = $request->validate([
            "permohonan_id" => 'required|integer',
            'alamat_usaha' => 'required|string',
            'pemilik_usaha' => 'required|string',
            'logo' => 'nullable', // Define a custom validation rule
            'umk' => 'nullable',
            'ttd' => 'nullable',
        ]);

        $data = $validatedData;
        $permohonan = Permohonan::where("id",$data['permohonan_id'])->first();
    
        if ($request->file('logo')!=null) {
            $permohonan->logo = $this->convertImage("logo",$request);
        }
        if ($request->file('ttd')!=null) {
            $permohonan->ttd = $this->convertImage("ttd",$request);
        }
        if ($request->file('umk')!=null) {
            $permohonan->umk = $this->convertImage("umk",$request);
        }
        $permohonan->status ="Dalam Proses";
        // $data['user_id'] = Auth::user()->id;

        $permohonan->save();

        return redirect("/permohonan")->with([ 'alert' => "Sukses merubah permohonan merek"]);;
  
    }


    function convertImage($reqname,$request) {
        $image = $request->file($reqname);
        $extension = $image->getClientOriginalExtension();
        $mime = $image->getMimeType();
        $base64Image = base64_encode(file_get_contents($image->getPathname()));

        $dataUri = "data:$mime;base64,$base64Image";
        return $dataUri;
    }
}
