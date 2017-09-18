<?php

namespace App\Http\Controllers;

use App\Services\StreamService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * @var StreamService
     */
    private $streamService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(StreamService $streamService)
    {
        $this->middleware('auth');
        $this->streamService = $streamService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $streams = $this->streamService->getAllStreams();

        return view('home', ['model' => $streams]);
    }
}
