<?php

namespace App\Http\Controllers;

use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class InstitutionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:institution-show', ['only' => ['show']]);
        $this->middleware('permission:institution-edit', ['only' => ['edit', 'update']]);
    }

    public function show()
    {
        $institution = Institution::first();
        return view('institution.show', compact('institution'));
    }

    public function edit()
    {
        $institution = Institution::first();
        return view('institution.edit', compact('institution'));
    }

    public function update(Request $request)
    {
        Validator::make($request->all(), [
            'name'               => ['required', 'string', 'max:255'],
            'phone'              => ['required', 'string', 'max:255'],
            'email'              => ['required', 'string', 'max:255'],
            'address'            => ['required', 'string', 'max:255'],
            'logo'               => ['sometimes', 'image'],
            'director_signature' => ['sometimes', 'image'],
            'rector_signature'   => ['sometimes', 'image']
        ])->validate();

        $logo = Institution::where('code', $request->code)->exists() ?
            Institution::where('code', $request->code)->first()->logo :
            "";

        $directorSignature = Institution::where('code', $request->code)->exists() ?
            Institution::where('code', $request->code)->first()->director_signature :
            "";

        $rectorSignature = Institution::where('code', $request->code)->exists() ?
            Institution::where('code', $request->code)->first()->rector_signature :
            "";

        if ($request->hasFile('logo'))
        {
            $file = $request->file('logo');
            $imageName = 'logo.'.$file->getClientOriginalExtension();
            $request->logo->move(public_path('images/institutions'), $imageName);
            $logo = 'images/institutions/'.$imageName;
        }

        if ($request->hasFile('director_signature'))
        {
            $file = $request->file('director_signature');
            $imageName = 'director.'.$file->getClientOriginalExtension();
            $request->director_signature->move(public_path('images/institutions'), $imageName);
            $directorSignature = 'images/institutions/'.$imageName;
        }

        if ($request->hasFile('rector_signature'))
        {
            $file = $request->file('rector_signature');
            $imageName = 'rector.'.$file->getClientOriginalExtension();
            $request->rector_signature->move(public_path('images/institutions'), $imageName);
            $rectorSignature = 'images/institutions/'.$imageName;
        }

        if (Institution::where('code', $request->code)->exists())
        {
            Institution::where('code', $request->code)->update([
                'name'               => $request->name,
                'phone'              => $request->phone,
                'email'              => strtolower($request->email),
                'address'            => $request->address,
                'logo'               => $logo,
                'director_signature' => $directorSignature,
                'rector_signature'   => $rectorSignature,
                'director_name'      => $request->director_name,
                'rector_name'        => $request->rector_name
            ]);
        }
        else
        {
            Institution::create([
                'name'               => $request->name,
                'phone'              => $request->phone,
                'email'              => strtolower($request->email),
                'code'               => $this->generateCode(6),
                'address'            => $request->address,
                'logo'               => $logo,
                'director_signature' => $directorSignature,
                'rector_signature'   => $rectorSignature,
                'director_name'      => $request->director_name,
                'rector_name'        => $request->rector_name
            ]);
        }

        return redirect(route('institution.edit'))->with('success', trans('messages.institutionUpdated'));
    }

    private function generateCode($length = 20)
    {
        $characters = '1234567890abcdefghijklmnpqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
