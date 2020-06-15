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
            'director_signature' => ['sometimes', 'image']
        ])->validate();

        $image = Institution::where('code', $request->code)->exists() ?
            Institution::where('code', $request->code)->first()->image :
            "";

        if ($request->hasFile('image'))
        {
            $file = $request->file('image');
            $imageName = 'logo.'.$file->getClientOriginalExtension();
            $request->image->move(public_path('images/institutions'), $imageName);
            $image = 'images/institutions/'.$imageName;
        }

        if (Institution::where('code', $request->code)->exists())
        {
            Institution::where('code', $request->code)->update([
                'name'    => $request->name,
                'phone'   => $request->phone,
                'email'   => strtolower($request->email),
                'address' => $request->address,
                'image'   => $image
            ]);
        }
        else
        {
            Institution::create([
                'name'    => $request->name,
                'phone'   => $request->phone,
                'email'   => strtolower($request->email),
                'code'    => $this->generateCode(6),
                'address' => $request->address,
                'image'   => $image
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
