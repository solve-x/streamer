<?php

namespace App\Http\Controllers;

class StreamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }



    /**
     * Return a HLS stream fragment.
     *
     * @param string $streamPart
     * @return \Illuminate\Http\Response
     */
    public function live($streamPart)
    {
        $fragmentsDirectory = env('HLS_DIR');

        $fragmentPath = "$fragmentsDirectory/$streamPart";

        if (!file_exists($fragmentPath)) {
            return response("Not found.", 404);
        }

        return response()->file($fragmentPath);
    }
}
