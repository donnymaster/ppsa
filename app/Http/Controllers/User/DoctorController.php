<?php

namespace App\Http\Controllers\User;

use App\Filters\Doctor\DoctorFilter;
use App\Http\Requests\CreateDoctorRequest;
use App\Http\Resources\DoctorSearchResource;
use App\Models\Doctor;
use App\Models\DoctorMaterial;
use App\Models\User;
use App\Services\DoctorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class DoctorController extends Controller
{
    private $doctorService = null;

    public function __construct(DoctorService $service)
    {
        $this->doctorService = $service;
    }

    public function index(DoctorFilter $request)
    {
        $doctors = $this->doctorService->all($request);
        return view('pages.doctor.index', compact('doctors'));
    }

    public function create()
    {
        return view('pages.doctor.register');
    }

    public function store(CreateDoctorRequest $request)
    {
        $validated = $request->validated();
        $user = $this->doctorService->create($validated);

        Auth::login($user);

        return redirect()->route('doctor.verify');
    }

    public function suspend(Doctor $doctor)
    {
        $this->doctorService->verify($doctor, false);
        return redirect()->route('doctors.get');
    }

    public function activate(Doctor $doctor)
    {
        $this->doctorService->verify($doctor, true);
        return redirect()->route('doctors.get');
    }

    /**
     * @param int $doctor
     *
     * @return [type]
     */
    public function show($id)
    {
        $doctor = Doctor::where('id', $id)->with('user')->firstOrFail();
        $materials = DoctorMaterial::where('doctor_id', $id)->get();
        return view('pages.doctor.show', compact('doctor', 'materials'));
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $doctorTemplate = $request->get('doctor');

        $doctors =
            User::with('doctor')
            ->whereHas('doctor', function ($query) {
                return $query->select('id');
            })
            ->where('last_name', 'like', '%' . $doctorTemplate . '%')->limit(30)->get();

        return response()->json(DoctorSearchResource::collection($doctors));
    }

    public function getFile($id)
    {
        $material = DoctorMaterial::where('id', $id)->firstOrFail();
        return Storage::download($material->material_path);
    }

    public function verify()
    {
        $user = Auth::user();

        if (!$user || !$user->isDoctor()) {
            abort(403);
        }

        if ($user->doctor->is_active) {
            return redirect()->route('blog.index');
        }
        return view('pages.doctor.not-verify');
    }
}
