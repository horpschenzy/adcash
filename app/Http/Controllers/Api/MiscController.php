<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\Misc\MiscService;
use App\Http\Controllers\Controller;

class MiscController extends Controller
{
    public $miscService;

    public function __construct(MiscService $miscService)
    {
        $this->miscService = $miscService;
    }

    public function index()
    {
        return $this->miscService->index();
    }
}
