<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

use Laravel\Scout\Searchable;
use App\Traits\ActivityLogTrait;

class PageItem extends Model
{
 	use Searchable, ActivityLogTrait;
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    const TEXT = 0;
    const CONTENT = 1;
    const FILE = 2;

    /**
     * @TNT Search
     */
    public $asYouType = true;
    
    public function toSearchableArray() {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
        ];
    }

    /**
     * @Relationships
     */
    public function page() {
        return $this->belongsTo(Page::class, 'page_id');
    }

    /**
     * @Getters
     */
    public static function getTypes() {
        return [
            ['value' => static::TEXT, 'label' => 'Text/Link/Label', 'class' => 'bg-green'],
            ['value' => static::CONTENT, 'label' => 'Content/Editor', 'class' => 'bg-blue'],
            ['value' => static::FILE, 'label' => 'Image/File', 'class' => 'bg-orange'],
        ];
    }

    /**
     * @Methods
     */
    public static function store($request, $item = null) {
        $vars = $request->only(['page_id', 'content', 'type']);
        $vars['slug'] = Helpers::slugify($request->input('slug'));
        switch ($request->input('type')) {
            case static::FILE:
                    if($request->hasFile('content')) {
                        if($item && $item->content) {
                            Storage::delete('public/' . $item->content);
                        }

                        $vars['content'] = $request->file('content')->store('page-items-files', 'public');
                    }
                break;
            
            default:
                # code...
                break;
        }

        if (!$item) {
            $item = static::create($vars);
        } else {
            $item->update($vars);
        }
        return $item;
    }

    /**
     * @Helpers
     */
    public function renderConstants($array, $value, $column = null) {

        /* Loop through the array */
        foreach ($array as $obj) {
            
            if($obj['value'] == $value) {

                /* Fetch columm if specified */
                if($column && isset($obj[$column]))
                    return $obj[$column];

                return $obj;
            }
        }
    }

    /*
     * Renders
     */

    public function renderName() {
        return $this->slug;
    }

    public function renderRelationshipName($column = 'slug', $relationship = 'page') {
        $name = null;

        if ($this->page) {
            $name = $this->page->$column;
        }

        return $name;
    }

    public function renderFilePath($column = 'content') {
        $path = null;
        if ($this[$column]) { $path = asset('storage/' . $this[$column]); }
        return $path;
    }

    public function renderTypeLabel() {
        return $this->renderConstants(static::getTypes(), $this->type, 'label');
    }

    public function renderTypeClass() {
        return $this->renderConstants(static::getTypes(), $this->type, 'class');
    }

    public function renderView() {
        return route('page-items.edit', $this->id);
    }

    public function renderDelete() {
        return route('page-items.destroy', $this->id);
    }

    public function renderRestore() {
        return route('page-items.restore', $this->id);
    }
}
