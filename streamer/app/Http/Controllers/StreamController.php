<?php

namespace App\Http\Controllers;

use App\Services\StreamService;
use Illuminate\Http\Request;

class StreamController extends Controller
{
    /**
     * @var StreamService
     */
    private $streamService = null;

    public function __construct(StreamService $streamService)
    {
        $this->middleware('auth');
        $this->streamService = $streamService;
    }

    /**
     * Return a HLS stream fragment.
     *
     * @param Request $request
     * @param string $streamPart
     * @return \Illuminate\Http\Response
     */
    public function live(Request $request, string $streamPart)
    {
        /*$this->streamService->getHLSFragmentPath(
            $streamPart,
            $request->user()
        );*/

        $s = $request->user()->getStreams();
        var_dump($request->user());

        /*$fragmentsDirectory = env('HLS_DIR');

        $fragmentPath = "$fragmentsDirectory/$streamPart";

        if (!file_exists($fragmentPath)) {
            return response("Not found.", 404);
        }

        return response()->file($fragmentPath);*/
    }
}
