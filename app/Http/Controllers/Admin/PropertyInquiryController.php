<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PropertyInquiry;

class PropertyInquiryController extends Controller
{
    public function index()
    {
        $inquiries = PropertyInquiry::with('property')
            ->latest()
            ->paginate(20);

        return view(
            'admin.property-inquiries.index',
            compact('inquiries')
        );
    }

    public function toggle(PropertyInquiry $inquiry)
    {
        $inquiry->update([
            'is_processed' => !$inquiry->is_processed
        ]);

        return back();
    }

    public function show(PropertyInquiry $propertyInquiry)
    {
        return view(
            'admin.property-inquiries.show',
            compact('propertyInquiry')
        );
    }
}