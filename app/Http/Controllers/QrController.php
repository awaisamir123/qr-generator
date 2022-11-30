<?php

namespace App\Http\Controllers;

use App\Models\QrGenerator;
use App\Repository\QrRepositoryInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use \SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;

class QrController extends Controller
{
    private $qrRepository;

    public function __construct(QrRepositoryInterface $qrRepository)
    {
        $this->qrRepository = $qrRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['qrData'=>$this->qrRepository->all()], Response::HTTP_OK);
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

        if($validation->fails()) {
            return response()->json(['errors'=> $validation->errors()], Response::HTTP_BAD_REQUEST);
        }

        $qrName = self::characterGenerator(2).time().self::characterGenerator(3);

        list($bgR, $bgG, $bgB) = sscanf(isset($request->bg_color)?$request->bg_color:"#000000", '#%02x%02x%02x');
        list($fillR, $fillG, $fillB) = sscanf(isset($request->fill_color)?$request->fill_color:"#ffffff", '#%02x%02x%02x');

        QrCode::size($request->size)
            ->backgroundColor($bgR, $bgG, $bgB)
            ->color($fillR, $fillG, $fillB)
            ->generate("$request->qr_content", public_path("qr-codes-svg/$qrName.svg"));

        $request['bg_color'] = "$bgR, $bgG, $bgB";
        $request['fill_color'] = "$fillR, $fillG, $fillB";
        $request['svg_url'] = asset('qr-codes-svg/'.$qrName.'.svg');

        $this->qrRepository->create($request->all());

        return response()->json(['qrData'=>$this->qrRepository->create($request->all())], Response::HTTP_OK);
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

    public function characterGenerator($length=5) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
