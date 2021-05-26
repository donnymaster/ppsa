<div class="mb-3">
    <a href="{{route('doctor.get', ['id' => $doctor->id])}}" class="is-size-3">
        {{$doctor->user->full_name}}
        <span class="is-size-6">
            <i class="fa fa-briefcase" aria-hidden="true"></i>
            {{$doctor->work_experience}}
        </span>
        @if (Auth::user() && Auth::user()->isDoctor())
           @if ($doctor->is_active)
                <a class="pl-3" href="{{route('doctor.suspend', ['doctor' => $doctor->id])}}">
                    Призупинити обліковий запис <i class="fa fa-times has-text-danger" aria-hidden="true"></i>
                </a>
           @else
                <a class="pl-3" href="{{route('doctor.activate', ['doctor' => $doctor->id])}}">
                    Активувати обліковий запис <i class="fa fa-check has-text-success" aria-hidden="true"></i>
                </a>
           @endif
        @endif
    </a>
    <div>
        {{strip_tags(Str::limit($doctor->biography, 400))}} {{-- TODO: сделать дерективу --}}
    </div>
</div>
