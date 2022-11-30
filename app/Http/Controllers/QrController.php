<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use \SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;

class QrController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

       QrCode::size('500')
           ->backgroundColor(255, 0, 0)
           ->color(0, 0, 255, 25)
           ->generate('testing QR', public_path('qr-codes-svg/qrcode132.svg') );

//        return view('index',$data);
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
        $validation = Validator::make($request->all(), [
            'qr_content'=>'required',
            'size'=>'required',
            'bg_color'=>'required',
            'fill_color'=>'required',
        ]);

        QrCode::size($request->size)
            ->backgroundColor($request->bg_color)
            ->color($request->fill_color)
            ->generate("$request->qr_content", public_path('qr-codes-svg/qrcode132.svg') );

        if($validation->fails()) {
            return response()->json(['errors'=> $validation->errors()], Response::HTTP_BAD_REQUEST);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
