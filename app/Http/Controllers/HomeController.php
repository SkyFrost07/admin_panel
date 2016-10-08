<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Eloquents\TaxEloquent;
use App\Eloquents\MediaEloquent;
use App\Eloquents\PostTypeEloquent;
use Validator;
use Mail;
use Option;

class HomeController extends Controller {

    protected $tax;
    protected $slide;
    protected $post;

    public function __construct(
            TaxEloquent $tax,
            MediaEloquent $slide,
            PostTypeEloquent $post
    ) {
        $this->tax = $tax;
        $this->slide = $slide;
        $this->post = $post;
    }

    public function index() {
        $cats = $this->tax->all('cat', [
            'fields' => ['taxs.id', 'taxs.count', 'td.name', 'td.slug']
        ]);
        $tags = $this->tax->all('tag', [
            'fields' => ['taxs.id', 'taxs.count', 'td.name', 'td.slug']
        ]);

        $main_slider = Option::get('main_slider');
        $slides = $this->slide->all([
            'fields' => ['thumb_url', 'target', 'id'],
            'per_page' => -1,
            'slider_id' => $main_slider ? $main_slider : 73
        ]);
        
        $albums = $this->tax->all('album', [
            'per_page' => 8
        ]);
        
        $home_cat_id = Option::get('_home_cat');
        $home_cat_id = $home_cat_id ? $home_cat_id : 76;
        $home_cat = $this->tax->findByLang($home_cat_id, ['taxs.id', 'td.name', 'td.slug']);
        $posts = $this->post->all('post', [
            'per_page' => 6,
            'cats' => [$home_cat_id]
        ]);
        
        return view('front.index', compact('cats', 'tags', 'slides', 'posts', 'home_cat', 'albums'));
    }

    public function sendContact(Request $request) {
        $valid = Validator::make($request->all(), [
                    'name' => 'required',
                    'email' => 'required',
                    'content' => 'required'
        ]);
        if ($valid->fails()) {
            return redirect()->back()->withInput()->withErrors($valid->errors());
        }

        $mail_to = Option::get('_admin_email');
        $mail_to = $mail_to ? $mail_to : config('mail.contact_mail');
        
        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'content' => $request->input('content'),
            'phone' => $request->input('phone')
        ];

        Mail::send('mails.contact', $data, function($mail) use($mail_to, $request) {
            $mail->to($mail_to);
            $mail->subject(trans('contact.subject_content', ['host' => $request->getHost()]));
        });

        if (count(Mail::failures()) > 0) {
            return redirect()->back()->withInput()->with('error_mess', trans('front.na_errors'));
        }

        return redirect()->back()->with('succ_mess', trans('contact.contact_sent'));
    }

}
