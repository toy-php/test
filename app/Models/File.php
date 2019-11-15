<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\FilesystemAdapter;
use Storage;

/**
 * App\Models\File
 *
 * @property int $id
 * @property string $path Путь к файлу
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File wherePath($value)
 * @mixin \Eloquent
 */
class File extends Model
{

    /**
     * @inheritdoc
     */
    protected $table = 'files';

    /**
     * @inheritdoc
     */
    public $timestamps = false;

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'path',
    ];

    /**
     * Получить адаптер файловой системы
     * @return FilesystemAdapter
     */
    static public function getDisk(): FilesystemAdapter
    {
        return Storage::disk(config('filesystems.default'));
    }

    /**
     * Получить относительный путь к директории файла
     * @return string
     */
    static public function getDirectory()
    {
        return
            date('Y') .
            DIRECTORY_SEPARATOR .
            date('m') .
            DIRECTORY_SEPARATOR .
            date('d');
    }

}
