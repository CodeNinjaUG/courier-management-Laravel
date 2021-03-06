<?php

namespace App\Http\Controllers;

use App\Model\Social;
use App\Model\GeneralSetting;
use App\Model\VisitorMessage;
use Illuminate\Http\Request;
use App\Model\GalleryImage;
use App\Model\CurrierInfo;
use Illuminate\Support\Facades\Session;
use App\Model\Service;
use App\Model\Testimonial;
use App\Model\Faq;

class FrontController extends Controller {

    public function index() {
        $testimonialList = Testimonial::all();
        $socialList = Social::get();
        $gs = GeneralSetting::first();
        $serviceList = Service::all();
        return view('frontend.index', compact('socialList', 'gs', 'serviceList', 'testimonialList'));
    }

    public function aboutus() {
        $socialList = Social::get();
        $gs = GeneralSetting::first();
        $testimonialList = Testimonial::all();
        return view('frontend.aboutus', compact('socialList', 'gs', 'testimonialList'));
    }

    public function contactus() {
        $socialList = Social::get();
        $gs = GeneralSetting::first();
        return view('frontend.contact', compact('socialList', 'gs'));
    }

    public function faq() {
        $socialList = Social::get();
        $gs = GeneralSetting::first();
        $faqList = Faq::all();
        $serviceList = Service::all();
        return view('frontend.faq', compact('socialList', 'gs', 'faqList', 'serviceList'));
    }

    public function visitorMessage(Request $request, VisitorMessage $visitorMessage) {
        $request->validate([
            'name' => 'required|max:50',
            'email' => 'max:100',
            'phone' => 'max:100',
        ]);
        $data = $request->all();
        $visitorMessage->create($data);

        return redirect()->route('front.contactus', ["#contactustest"])->withSuccess("Thanks for your message");
    }

    public function searchCurrier(Request $request) {

        $currier_invoice = $request->get('currier_invoice');
        $currierInfo = CurrierInfo::where('invoice_id', $currier_invoice)->orWhere('code',$currier_invoice)->first();
        return redirect()->route('front.index', ["#currier-search"])->with('currierInfo', $currierInfo);
        
    }

}
