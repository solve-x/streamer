<?php

namespace App\Http\Controllers;

use App\Entities\Stream;
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
        return view('streams/index', [
            'model' => $streams
        ]);
    }

    public function createEdit($id = null)
    {
        $stream = Stream::empty();
        if (null !== $id) {
            $stream = $this->streamService->getStreamById($id);
        }

        $streamTypes = $this->streamService->getAllStreamTypes();

        return view('streams/createEdit', [
            'model' => $stream,
            'streamTypes' => $streamTypes
        ]);
    }

    public function postCreateEdit(AddEditStreamViewModel $model)
    {
        if (!$model->isValid()) {
            return response(400);
        }

        $user = Auth::user();

        $this->streamService->createUpdateStream(
            $model->id,
            $model->name,
            $model->streamKey,
            $model->type,
            $user->getId(),
            $model->isLive
        );

        return response()->redirectToRoute('streams');
    }

    public function deleteStream($id)
    {
        $removed = $this
            ->streamService
            ->deleteStream($id);

        if ($removed) {
            return response()->json([
                'redirect' => route('streams')
            ]);
        }

        return response('Could not remove stream!', 500);
    }

    public function isLive(string $streamKey)
    {
        $stream = $this
            ->streamService
            ->getStreamByKey($streamKey);

        if (null === $stream) {
            return response('Stream not found!', 404);
        }

        return response()->json(
            $stream->isLive()
        );
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
