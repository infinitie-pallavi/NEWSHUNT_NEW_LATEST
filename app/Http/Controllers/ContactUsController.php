<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Yajra\DataTables\Facades\DataTables;

class ContactUsController extends Controller
{
    public function index()
    {
        $theme = getTheme();
        $title = "Contact us";
        return view('front_end.' . $theme . '.pages.contact-us',compact('theme','title'));

    }

    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:30',
            'message' => 'required|string',
        ]);
        
        $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        try {
            $phoneNumber = $phoneUtil->parse($validated['phone']);
            $countryCode = '+' . $phoneNumber->getCountryCode();
            $nationalNumber = $phoneNumber->getNationalNumber();
        } catch (\libphonenumber\NumberParseException $e) {
            return response()->json([
                'success' => false,
                'errors' => [
                    'phone' => 'Invalid phone number format'
                ]
            ], 422);
        }
    
        // Create a new contact record in the database
        Contact::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'country_code' => $countryCode,
            'phone_number' => $nationalNumber,
            'message' => $validated['message'],
        ]);
    
        // Return a JSON response for success
        return response()->json([
            'success' => true,
            'message' => 'Thank you for contact us.',
        ]);
    }
    
    public function view()
    {
        $title = trans('CONTACT_US');
        
        return view('admin.contact_us.contact-us',compact('title'));
    }
    
    public function show()
    {
        $getData = Contact::select('*')->get();

        $getData->each(function ($contactData) {
            $contactData->name = $contactData->first_name .' '. $contactData->last_name;
            $contactData->phone = $contactData->country_code .' '. $contactData->phone_number;
        });
        return DataTables::of($getData)
         ->addColumn('action', function ($getData) {
            return "<a href='" . route('channels.edit', $getData->id) . "' class='btn text-primary btn-sm edit_btn' data-bs-toggle='modal' data-bs-target='#contact-us-modal' title='contact-us'> <i class='fa fa-eye'></i></a> &nbsp; ";
        })->make(true);
    }
    

}
