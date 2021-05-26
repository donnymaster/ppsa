<?php

namespace App\Services;

use App\Models\Ration;
use App\Models\RationPartType;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class RationService
{
    public function create(array $data, int $userId)
    {
        // check data
        $ration = Ration::create([
            'title' => $data['title'],
            'start' => $data['start'],
            'end' => $data['end'],
            'user_id' => $userId,
        ]);

        $parts = $this->createRationPart($data['rations']);
        $ration->rationParts()->createMany($parts);

        return $ration;
    }

    private function createRationPart($rations)
    {
        $parts = [];

        foreach ($rations as $type => $recipeId) {
            if (!in_array($type, RationPartType::RATION_PART_TYPE)) {
                continue;
            }

            $typePart = RationPartType::where('key', $type)->firstOrFail();

            array_push($parts, [
                'ration_part_type_id' => $typePart->id,
                'recipe_id' => $recipeId,
            ]);
        }

        return $parts;
    }

    public function checkRangeDate(
        string $startVal,
        string $endVal,
        int $userId,
        string $title = null
    ) {
        $start = Carbon::parse($startVal)->format('Y-m-d') . ' 00:00:00';
        $end = Carbon::parse($endVal)->subDays(1)->format('Y-m-d') . ' 00:00:00';

        $result = DB::table('rations')
            ->where('start', '<=', $end)
            ->where(DB::raw('DATE_SUB(end, INTERVAL 1 DAY)'), '>=', $start)
            ->where('user_id', $userId)
            ->when($title, function ($query) use ($title) {
                return $query->where('title', '!=', $title);
            })
            ->get();

        return $result->count();
    }
}
