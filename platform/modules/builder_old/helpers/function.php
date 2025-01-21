<?php

use Sokeio\Facades\Assets;
use Sokeio\Seo\Facades\SEO;
use Sokeio\Seo\SchemaCollection;
use Sokeio\Seo\Schemas\ArticleSchema;
use Sokeio\Seo\Schemas\BreadcrumbListSchema;
use Sokeio\Seo\SEOData;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Sokeio\Cms\Facades\Shortcode;

if (!function_exists('pagebuilder_render')) {
    function pagebuilder_render(Model $data)
    {
        Shortcode::enable();
        Assets::Theme('tabler');
        Assets::AddCss('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css');
        doAction('SOKEIO_BUILDER_SLUG', $data);
        Assets::AddScript($data->js);
        Assets::AddStyle(trim($data->css));
        Assets::AddScript($data->custom_js);
        Assets::AddStyle(trim($data->custom_css));
        SEO::SEODataTransformer(function (SEOData $dataSeo) use ($data) {
            $dataSeo->title = page_title();
            $dataSeo->description = $data->ddescriptione;
            $dataSeo->image = $data->image ? url($data->image) : null;
            $dataSeo->datePublished = $data->published_at;
            $dataSeo->dateModified = $data->updated_at;
            if ($seo = $data->seo->first()) {
                $seo->fillForSeo($dataSeo);
            }
            $dataSeo->schema = SchemaCollection::initialize()->addArticle(function (ArticleSchema $articleSchema) use ($data) {
            })->addBreadcrumbs(function (BreadcrumbListSchema $breadcrumbListSchema) {
                $breadcrumbListSchema->appendBreadcrumbs([]);
            });
            return $dataSeo;
        });
        return $data->content;
    }
}
