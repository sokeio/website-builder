<?php

namespace Sokeio\Builder;

use Sokeio\Facades\Module;
use Sokeio\Facades\Plugin;
use Sokeio\Facades\Theme;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\File;
use Sokeio\Builder\Models\BuilderTemplate;

class TemplateBuilder implements Arrayable
{
    public $path = '';
    public $template_name = '';
    public $template_type = '';
    public $author = '';
    public $category = '';
    public $topic = '';
    public $email = '';
    public $thumbnail = '';
    public $description = '';
    public $content = '';
    private function __construct($value, $is_path = true)
    {
        if ($is_path) {
            $this->makeByPath($value);
        } else {
            $this->makeByModel($value);
        }
    }
    private function makeByPath($path)
    {
        $this->path = $path;
        $this->content = file_get_contents($this->path);

        $pattern = '/<!--\s*(.*?)\s*-->/s';
        preg_match($pattern, $this->content, $matches);
        if (isset($matches[1])) {
            $metadata = $matches[1];
            $metadataPairs = preg_split("/[\r\n]+/", $metadata);
            $metadataArray = array();

            foreach ($metadataPairs as $pair) {
                if (strpos($pair, ':') !== false) {
                    list($key, $value) = explode(':', $pair, 2);
                    $metadataArray[trim($key)] = trim($value);
                }
            }
            $this->template_name = isset($metadataArray['template name']) ? $metadataArray['template name'] : '';
            $this->template_type = isset($metadataArray['template type']) ? $metadataArray['template type'] : 'free';
            $this->author =  isset($metadataArray['anthor']) ? $metadataArray['anthor'] : '';
            $this->category =  isset($metadataArray['category']) ? $metadataArray['category'] : '';
            $this->email =  isset($metadataArray['email']) ? $metadataArray['email'] : '';
            $this->topic =  isset($metadataArray['topic']) ? $metadataArray['topic'] : '';
            $this->thumbnail = isset($metadataArray['thumbnail']) ? $metadataArray['thumbnail'] : '';
            $this->description = isset($metadataArray['description']) ? $metadataArray['description'] : '';
            if ($this->thumbnail && !str_starts_with($this->thumbnail, 'http')) {
                $this->thumbnail = url($this->thumbnail);
            }
        }
        $pattern = '/<!--(.*?)-->/s';
        $this->content = preg_replace($pattern, '', $this->content);
    }
    private function makeByModel($model)
    {
        //'name', 'description', 'content', 'author_id', 'status', 'js', 'css', 'topic', 'category', 'only_me', 'thumbnail', 'email'
        $this->template_name = $model->name;
        $this->template_type = 'database';
        $this->author = $model->author->id;
        $this->category = $model->category;
        $this->email = $model->email;
        $this->topic = $model->topic;
        $this->thumbnail = $model->thumbnail;
        $this->description = $model->description;
        $this->content = $model->content;
    }
    public function toArray()
    {
        return [
            'path' => $this->path,
            'template_name' => $this->template_name,
            'template_type' => $this->template_type,
            'author' => $this->author,
            'category' => $this->category,
            'topic' => $this->topic,
            'email' => $this->email,
            'thumbnail' => $this->thumbnail,
            'description' => $this->description,
            'content' => $this->content,
        ];
    }
    public static function create($path, $is_path = true)
    {
        return new TemplateBuilder($path, $is_path);
    }
    public static function getTemplates()
    {
        $arr = [];
        foreach (Theme::getAll() as $item) {
            if ($item->isActive()) {
                $arr = [...$arr, ...collect($item->getTemplateBuilder())->map(function ($path) {
                    return TemplateBuilder::create($path);
                })];
            }
        }
        foreach (Module::getAll() as $item) {
            if ($item->isActive() || $item->isVendor()) {
                $arr = [...$arr, ...collect($item->getTemplateBuilder())->map(function ($path) {
                    return TemplateBuilder::create($path);
                })];
            }
        }
        foreach (Plugin::getAll() as $item) {
            if ($item->isActive() || $item->isVendor()) {
                $arr = [...$arr, ...collect($item->getTemplateBuilder())->map(function ($path) {
                    return TemplateBuilder::create($path);
                })];
            }
        }
        $templatePath = base_path('resources/template-builders');
        if (File::exists($templatePath)) {
            $files =  collect(File::allFiles($templatePath))->map(function ($item) {
                return TemplateBuilder::create($item->getPathname());
            });
            $arr = [...$arr, ...$files];
        }
        $arr = [...$arr, ...BuilderTemplate::query()->where('status', 'published')->get()->map(function ($item) {
            return TemplateBuilder::create($item, false);
        })];
        return $arr;
    }
}
