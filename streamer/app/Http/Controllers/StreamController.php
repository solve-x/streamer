<?php

namespace App\Http\Controllers;

use App\Entities\Stream;
use App\Services\StreamService;
use App\ViewModels\AddEditStreamViewModel;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

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
     * @return View
     */
    public function index(): View
    {
        $streams = $this->streamService->getAllStreams();
        return view('streams/index', [
            'model' => $streams
        ]);
    }

    /**
     * Returns the view for creating a new stream or editing an existing one.
     *
     * @param null|int $id
     * @return View
     */
    public function createEdit($id = null): View
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

    /**
     * Creates or updates a stream.
     *
     * @param AddEditStreamViewModel $model
     * @return RedirectResponse|Response
     */
    public function postCreateEdit(AddEditStreamViewModel $model)
    {
        if (!$model->isValid()) {
            return response('Invalid model!', 400);
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

    /**
     * Deletes a stream.
     *
     * @param $id
     * @return JsonResponse|Response
     */
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

    /**
     * Check if a stream is live or not and return in JSON format.
     *
     * @param string $streamKey
     * @return ResponseFactory|Response
     */
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
     * Returns the view on which the player is displayed.
     *
     * @param string $streamKey
     * @return View
     */
    public function live(string $streamKey): View
    {
        $stream = $this
            ->streamService
            ->getStreamByKey($streamKey);

        if (null === $stream) {
            return view('error/404');
        }

        return view('streams/live', [
            'model' => $stream
        ]);
    }

    /**
     * Return a HLS stream fragment.
     *
     * @param string $streamPart
     * @return \Illuminate\Http\Response
     */
    public function liveParts(string $streamPart): Response
    {
        // Check if stream exists and is live
        $streamKey = $this
            ->streamService
            ->getKeyFromFragmentName($streamPart);

        $stream = $this
            ->streamService
            ->getStreamByKey($streamKey);

        if (null === $stream) {
            return response('Stream not found!', 404);
        }

        if (!$stream->isLive()) {
            return response('Stream is not live!', 400);
        }

        // Check if user can access the stream
        $accessGranted = $this
            ->streamService
            ->userHasAccess(Auth::user());

        if (!$accessGranted) {
            return response('You do not have permissions to view this stream!', 403);
        }

        // Get the fragment disk path
        $fragmentPath = $this
            ->streamService
            ->getHLSFragmentPath($streamPart);

        if (null === $fragmentPath) {
            return response('Stream fragment not found!', 404);
        }


        return response()->file($fragmentPath);
    }
}
