<?php

namespace App\Services;

use App\Models\Doctor;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Contracts\FileStorageServiceContract as FileStorage;

class DoctorService
{
    private $fileService;

    public function __construct(FileStorage $service)
    {
        $this->fileService = $service;
    }

    public function all($request)
    {
        $doctors = Doctor::filter($request)->with('user:id,first_name,last_name')->paginate(10);

        return $doctors;
    }

    public function create(array $data)
    {
        $roleDoctor = Role::where('name', Role::DOCTOR)->firstOrFail();

        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'role_id' => $roleDoctor->id,
            'password' => Hash::make($data['password']),
        ]);

        $doctor = $user->doctor()->create([
            'biography' => $data['biography'],
            'work_experience' => $data['work_experience'],
            'is_active' => false,
        ]);

        if (isset($data['document'])) {
            $materials = [];

            foreach ($data['document'] as $doc) {
                $filePath = $this->fileService->saveFile('doctors', $doc);

                array_push($materials, [
                    'name' => $doc->getClientOriginalName(),
                    'material_path' => $filePath,
                ]);
            }

            $doctor->materials()->createmany($materials);
        }

        return $user;
    }

    public function verify(Doctor $doctor, bool $isVerify = false)
    {
        $doctor->is_active = $isVerify;
        $doctor->save();
    }

    public function checkIsEditArticle($doctorId)
    {
        if ($doctorId === Auth::user()->doctor->id) {
            return true;
        }

        abort(403);
    }
}
