<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
   public function index()
    {
        // Fetch active FAQs ordered by sort_order and created_at
        $faqs = Faq::active()->ordered()->get();

        return view('page.faq.index', compact('faqs'));
    }
}
