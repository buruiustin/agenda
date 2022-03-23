<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\CheckCNP;
use App\Models\Contact;
use App\Models\Phone;


class ContactsController extends Controller
{

    public function index()
    {
        $contacts = Contact::all();

        return view('contacts.index', [
            'contacts' => $contacts,
        ]);
    }


    public function create()
    {
        return view('contacts.create');
    }

    public function store(Request $request)
    {
        $checkCNP = new CheckCNP();

        $validation = [
            'nume' => ['required'],
            'prenume' => ['required'],
            'sex' => ['required'],
            'email' => [
                'required',
                'regex:/(.+)@(.+)\.(.+)/i',
            ],
            'cnp' => [
                $checkCNP,
                'nullable',
            ],
            'data_nastere' => [
                'date', 
                'nullable',
            ],
        ];

        if($request->telefon) {
            foreach ($request->telefon as $key => $value) {
                $validation['telefon.'.$key] = [
                    'nullable',
                    'regex:/^0?[237]\d{8}$/',
                    'unique:phones,number'
                ];
            }
        }

        if($request->cnp && $request->data_nastere) {
            $validation['data_nastere'] = [
                function ($attribute, $value, $fail) use ($checkCNP) {
                    if( $value == $checkCNP->getDataNastere() ) {
                        return true;
                    } else {
                        $fail('Data nasterii nu corespunde cu CNP-ul introdus.');
                    }
                },
            ];
        }

        $msg_err = [
            '*.required' => 'Acest camp este obligatoriu.',
            'email.regex' => 'Adresa de e-mail nu este valida.',
            'data_nastere.date' => 'Acest camp trebuie sa contina o data valida!',
            'telefon.*.regex' => 'Numarul de telefon nu este valid.',
            'telefon.*.unique' => 'Numarul de telefon este deja folosit pentru un alt contact.',
        ];

        $this->validate($request, $validation, $msg_err);
        
        $contact = Contact::create([
            'nume' => $request->nume,
            'prenume' => $request->prenume,
            'sex' => $request->sex,
            'email' => $request->email,
            'cnp' => $request->cnp ?? null,
            'data_nastere' => $request->data_nastere ?? null,
        ]);

        if($request->telefon) {
            foreach ($request->telefon as $key => $value) {
                if($value) {
                    Phone::create([
                        'number' => $value,
                        'contact_id' => $contact->id,
                    ]);
                }
            }
        }

        return redirect()->back()->with('message', 'Contactul a fost adaugat cu success.');

    }


    public function edit(Contact $contact)
    {
        return view('contacts.edit', [
            "contact" => $contact,
        ]);
    }


    public function update(Request $request, Contact $contact)
    {
        $checkCNP = new CheckCNP();

        $validation = [
            'nume' => ['required'],
            'prenume' => ['required'],
            'sex' => ['required'],
            'email' => [
                'required',
                'regex:/(.+)@(.+)\.(.+)/i',
            ],
            'cnp' => [
                $checkCNP,
                'nullable',
            ],
            'data_nastere' => [
                'date', 
                'nullable',
            ],
        ];

        if($request->telefon) {
            $numbers_array = $contact->phones->pluck('id', 'number')->toArray();

            foreach ($request->telefon as $key => $value) {
                $phone_key = (int) $value;
                $phone_id = array_key_exists($phone_key, $numbers_array) ? $numbers_array[$phone_key] : null;

                $validation['telefon.'.$key] = [
                    'nullable',
                    'regex:/^0?[237]\d{8}$/',
                    'unique:phones,number,' . "{$phone_id}"
                ];
                

            }
        }

        if($request->cnp && $request->data_nastere) {
            $validation['data_nastere'] = [
                function ($attribute, $value, $fail) use ($checkCNP) {
                    if( $value == $checkCNP->getDataNastere() ) {
                        return true;
                    } else {
                        $fail('Data nasterii nu corespunde cu CNP-ul introdus.');
                    }
                },
            ];
        }

        $msg_err = [
            '*.required' => 'Acest camp este obligatoriu.',
            'email.regex' => 'Adresa de e-mail nu este valida.',
            'data_nastere.date' => 'Acest camp trebuie sa contina o data valida!',
            'telefon.*.regex' => 'Numarul de telefon nu este valid.',
            'telefon.*.unique' => 'Numarul de telefon este deja folosit pentru un alt contact.',
        ];

        $this->validate($request, $validation, $msg_err);

        
        $contact->update([
            'nume' => $request->nume,
            'prenume' => $request->prenume,
            'sex' => $request->sex,
            'email' => $request->email,
            'cnp' => $request->cnp ?? null,
            'data_nastere' => $request->data_nastere ?? null,
        ]);

        $contact->phones()->delete();

        if($request->telefon) {
            foreach ($request->telefon as $key => $value) {
                if($value) {
                    Phone::create([
                        'number' => $value,
                        'contact_id' => $contact->id,
                    ]);
                }
            }
        }

        return redirect()->back()->with('message', 'Contactul a fost editat cu succes.');
    }


    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->back()->with('message', 'A fost sters un contact.');
    }
}
