<?php

namespace App\Http\Controllers;

use App\Services\StreamService;
use App\ViewModels\AddEditStreamViewModel;
use Auth;

class StreamController extends Controller
{
    /**
     * @var StreamService
     */
    private $streamService;

    public function __construct(StreamService $streamService)
    {
        $this->middleware('auth');
        $this->streamService = $streamService;
    }

    /**
     * Return all streams.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $streams = $this->streamService->getAllStreams();
        $streamTypes = $this->streamService->getAllStreamTypes();
        return view('streams/index', [
            'model' => $streams,
            'streamTypes' => $streamTypes
        ]);
    }

    public function addEdit(AddEditStreamViewModel $model)
    {
        if (!$model->isValid()) {
            return response(404);
        }

        $user = Auth::user();

        $streamId = $this->streamService->createNewStream(
            $model->name,
            $model->streamKey,
            $model->type,
            $user->getId()
        );

        return response($streamId);
    }

    /**
     * Return a HLS stream fragment.
     *
     * @param string $streamPart
     * @return \Illuminate\Http\Response
     */
    public function live(string $streamPart)
    {
        $streamExists = $this
            ->streamService
            ->existsByFragmentName($streamPart);

        if (!$streamExists) {
            return response('Stream not found!', 404);
        }

        $fragmentPath = $this
            ->streamService
            ->getHLSFragmentPath($streamPart);

        if (null === $fragmentPath) {
            return response('Stream fragment not found!', 404);
        }

        $accessGranted = $this
            ->streamService
            ->userHasAccess(Auth::user());

        if (!$accessGranted) {
            return response('You do not have permissions to view this stream!', 403);
        }

        return response()->file($fragmentPath);
    }
}
