<?php

namespace App\Services;

use App\Filters\Blog\BlogFilter;
use App\Models\Blog;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class BlogService
{
    const DEFAULT_PATH_IMAGE = 'default/article.png';

    public function all($request)
    {
        $articles = Blog::filter($request)->with('doctor.user:id,first_name,last_name')->paginate(10);

        return $articles;
    }

    /**
     * @param array $data
     * @param int $doctorId
     *
     * @return void
     */
    public function create($data, $doctorId)
    {
        $filePath = $this->saveImage($data['preview_article'] ?? null);

        Blog::create([
            'doctor_id' => $doctorId,
            'title' => $data['title'],
            'body' => $data['body'],
            'background_path' => $filePath,
            'reading_time' => $data['reading_time'],
        ]);
    }

    /**
     * @param UploadedFile $file
     *
     * @return string
     */
    private function saveImage(UploadedFile $file = null)
    {
        if ($file === null) {
            return self::DEFAULT_PATH_IMAGE;
        }

        $folderPath = 'articles/' . date('Y-m-d');
        $filePath = $file->store($folderPath);

        return $filePath;
    }

    /**
     * @param string $path
     *
     * @return void
     */
    private function clearImage($path)
    {
        Storage::delete($path);
    }

    /**
     * @param array $data
     * @param int $id
     *
     * @return void
     */
    public function update($data, $id)
    {
        $article = Blog::findOrFail($id);

        $validData = [
            'title' => $data['title'],
            'body' => $data['body'],
            'reading_time' => $data['reading_time'],
        ];

        if (isset($data['preview_article'])) {
            if ($article->background_path !== self::DEFAULT_PATH_IMAGE) {
                $this->clearImage($article->background_path);
            }

            $validData = Arr::prepend(
                $validData,
                $this->saveImage($data['preview_article']),
                'background_path'
            );
        }
        $article->update($validData);
    }

    /**
     * @param Blog $blog
     *
     * @return void
     */
    public function delete(Blog $article)
    {
        if ($article->background_path !== self::DEFAULT_PATH_IMAGE) {
            $this->clearImage($article->background_path);
        }
        $article->delete();
    }

    /**
     * @param BlogFilter $request
     * @param int $doctorId
     *
     * @return [type]
     */
    public function getDoctorArticles($request, $doctorId)
    {
        $articles = Blog::filter($request)
            ->where('doctor_id', $doctorId)
            ->with('doctor.user:id,first_name,last_name')
            ->paginate(10);

        return $articles;
    }
}
