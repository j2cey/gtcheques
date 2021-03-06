<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class MimeType
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 *
 * @property string $name
 * @property string|null $mime
 * @property string|null $extension
 * @property integer|null $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class MimeType extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    #region Custom Functions - Create/Update

    public static function createNew($name, $mime, $extension, $description = null): MimeType {
        $mimetype = MimeType::create([
            'name' => $name,
            'mime' => $mime,
            'extension' => $extension,
            'description' => $description,
        ]);

        $mimetype->save();

        return $mimetype;
    }

    #endregion

    #region Custom Functions

    public static function defaultFileMimeTypes() : Collection {
        return MimeType::whereIn('extension', ['png','jpg','bmp','pdf'])->get()->pluck('id');
    }

    #endregion
}
