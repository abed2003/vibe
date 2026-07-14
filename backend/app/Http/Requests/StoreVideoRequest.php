<?php

namespace App\Http\Requests;

use App\Enums\VideoVisibility;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreVideoRequest extends FormRequest
{
    /**
     * Authorization is handled entirely by the auth:sanctum route middleware
     * (any authenticated user may upload); there's no per-object policy check
     * for creation, unlike show/destroy.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'video' => [
                'required',
                'file',
                'mimetypes:'.implode(',', config('videos.allowed_mime_types')),
                'max:'.config('videos.max_upload_size_kb'),
            ],
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'visibility' => ['nullable', Rule::enum(VideoVisibility::class)],
        ];
    }
}
