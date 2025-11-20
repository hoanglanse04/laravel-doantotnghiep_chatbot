<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;

class OverviewController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     */
    public function overview()
    {
        return view('admin::overview');
    }
}
