<?php

namespace App\Http\Controllers;

use App\Http\Requests\Calendar\CreateRationEventRequest;
use App\Http\Requests\Calendar\UpdateRationEventRequest;
use App\Http\Requests\Ration\DoctorCreateRationRequest;
use App\Models\Ration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Calendar\Event as EventResource;
use App\Http\Resources\Calendar\RationSearch as RationSearchResource;
use App\Services\RationService;
use Illuminate\Support\Arr;

class RationController extends Controller
{
    private $rationService;

    public function __construct(RationService $service)
    {
        $this->rationService = $service;
    }

    public function events()
    {
        $user = Auth::user();
        $events = Ration::where('user_id', $user->id)
            ->with(['rationParts.rationPartType', 'rationParts.recipe'])
            ->get();

        return response()->json(EventResource::collection($events));
    }

    public function update(Ration $ration, UpdateRationEventRequest $request)
    {
        $validated = $request->validated();
        $userId = Auth::user()->id;

        $count = $this
            ->rationService
            ->checkRangeDate($validated['start'], $validated['end'], $userId, $ration->title);

        if ($count >= 1) {
            return response()->json([
                'msg' => 'Ви не можете додати раціон, так як на цей проміжок часу вже призначений раціон!',
            ], 403);
        }

        if (isset($validated['rations'])) {
            $ration->update(
                Arr::except($validated, 'rations')
            );
        }

        $ration->update($validated);

        return response()->json([
            'result' => $ration,
        ]);
    }

    public function search(Request $request)
    {
        $search = $request->input('search') ?? '';
        $rations = Ration::where('title', 'like', '%' . $search . '%')->limit(30)->get();

        return response()->json(RationSearchResource::collection($rations));
    }

    public function store(CreateRationEventRequest $request)
    {
        $user = Auth::user();
        $data = $request->validated();

        $count = $this->rationService->checkRangeDate($data['start'], $data['end'], $user->id);

        if ($count >= 1) {
            return response()->json([
                'msg' => 'Ви не можете додати раціон, так як на цей проміжок часу вже призначений раціон!',
                'count' => $count,
            ], 403);
        }

        $ration = $this->rationService->create($data, $user->id);

        return response()->json(new EventResource($ration));
    }

    public function delete(Ration $ration)
    {
        $user = Auth::user();

        if ($ration->user_id !== $user->id) {
            return response()->json([
                'data' => 'You do not have permission to delete!',
            ], 403);
        }

        $ration->delete();

        return response()->json(new EventResource($ration));
    }

    public function doctorCreateRation(DoctorCreateRationRequest $request)
    {
        $user = Auth::user();
        $data = $request->validated();
        $data['title'] = $user->full_name . ':' . $data['title'];

        $count = $this->rationService->checkRangeDate($data['start'], $data['end'], $data['user_id']);

        if ($count >= 1) {
            return response()->json([
                'msg' => 'Ви не можете додати раціон, так як на цей проміжок часу вже призначений раціон!',
            ], 403);
        }

        $ration = $this->rationService->create($data, $data['user_id']);

        return response()->json(new EventResource($ration));
    }
}
