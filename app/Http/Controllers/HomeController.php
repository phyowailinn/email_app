<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail,Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function sendingEmail(Request $request,$file_name='')
    {   
        foreach ($request['files'] as $key => $file) {
            list($type, $file) = explode(';', $file);
            list(, $file) = explode(',', $file);
            list(,$ext) = explode('/', $type);
            $path = "uploads/";

            if (!is_dir($path)) {
                mkdir($path, 0777, true);
                fopen($path . "index.php", "wp");
            }

            $name = $file_name.time(). '.' . $ext;
            $encodedData = base64_decode($file);
            file_put_contents($path.'/'.$name, $encodedData);
            $upload_data[] = $path.$name;
        }

        $multi_emails = ['nyilinaung97@gmail.com'];
        array_push($multi_emails, $request->email);

        $app_user = ['subject'=> $request->subject,'email'=>$multi_emails,'myfile'=>$upload_data,'body'=>$request->body];

        Mail::send('email.test', ['user' => $app_user], function ($message) use ($app_user)
        {  
            $route = public_path() . '/';
                
            for ($i=0; $i < count($app_user['myfile']); $i++) { 
                $message->attach($route.$app_user['myfile'][$i]);  
            }          
                   
            $message->to($app_user['email'], $app_user['subject'])->subject('Testing Email from MyApp');
        });

        return back();
    } 
}
