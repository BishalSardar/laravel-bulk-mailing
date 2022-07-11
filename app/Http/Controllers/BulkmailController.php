<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use App\Models\Bulkmail;
use App\Models\Email;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Psy\Readline\Hoa\Console;

class BulkmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    function getItem(Request $request)
    {
        try {
            $email = Bulkmail::all();
            return response([
                'email' => $email,

            ]);
        } catch (Exception $exception) {
            return response([
                'message' => 'error' . $exception,
            ]);
        }
    }

    // adding data to database
    function mailSubmit(Request $request)
    {
        try {
            $bulkmail = new Bulkmail();
            $bulkmail->name = $request->name;
            $bulkmail->emails = $request->emails;
            $bulkmail->save();
        } catch (Exception $exception) {
            dd($exception);
            return redirect()->back()->with('error', 'This is the error' . $exception);
        }
        return redirect()->back();
    }

    function sendEmail(Request $request)
    {
        $subject = $request->subject;
        $message = $request->message;
        $bulkmail = Bulkmail::all();
        $email_arr = array();
        for ($i = 0; $i < count($bulkmail); $i++) {
            $mail_name = $bulkmail[$i]['name'];
            $email = $bulkmail[$i]['emails'];
            array_push($email_arr, $email);
        }
        Mail::to($email)->cc($email_arr)->send(new WelcomeMail($mail_name, $message, $subject));
        return redirect()->back();
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bulkmail  $bulkmail
     * @return \Illuminate\Http\Response
     */
    public function show(Bulkmail $bulkmail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bulkmail  $bulkmail
     * @return \Illuminate\Http\Response
     */
    public function edit(Bulkmail $bulkmail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bulkmail  $bulkmail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bulkmail $bulkmail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bulkmail  $bulkmail
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bulkmail $bulkmail)
    {
        //
    }
}
