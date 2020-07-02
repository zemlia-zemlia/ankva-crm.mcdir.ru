<?php
/**
 */
namespace execut\pages\plugin;
use execut\navigation\Page;
use execut\navigation\page\NotFound;
use execut\pages\models\FrontendPage;
use execut\pages\Plugin;
use execut\seo\models\Keyword;
use execut\seo\models\KeywordVsPage;
use yii\base\Module;
use yii\db\ActiveQuery;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

class Files implements Plugin
{
    public $keywordReplacePattern = '/(?!<([ab]|(h\d))[^>]*?>)(?<=[^a-z])({word})(?=[^a-z])(?!([^<]*?<\/([ab]|(h\d)))>)/i';
    public function getPageFieldsPlugins() {
        return [
            [
                'class' => \execut\files\crudFields\Plugin::class,
            ],
        ];
    }

    public function getCacheKeyQueries() {
        return [];
    }

    public function initCurrentNavigationPage(Page $navigationPage, \execut\pages\models\Page $pageModel) {
        $this->replaceText($navigationPage, $pageModel);
    }

    public function applyCurrentPageScopes(ActiveQuery $query) {
        $query->with([
            'filesFile' => function ($q) {
                $q->withoutData();
            }
        ]);
    }


    /**
     * @param Page $navigationPage
     * @param \execut\pages\models\Page $pageModel
     * @return mixed
     */
    protected function replaceText(Page $navigationPage, \execut\pages\models\Page $pageModel)
    {
        $text = $navigationPage->getText();
        if ($filesFile = $pageModel->filesFile) {
            $url = [
                '/files/frontend',
                'alias' => $filesFile->alias,
                'extension' => $filesFile->extension,
            ];

            $image = Html::a(Html::img([
                '/files/frontend',
                'alias' => $filesFile->alias,
                'extension' => $filesFile->extension,
                'dataAttribute' => 'size_m',
            ], [
                'alt' => $filesFile->alt,
            ]), $url, [
                'title' => $filesFile->title,
            ]);
            $text = $image . $text;
        }

        $navigationPage->setText($text);
    }
    public function configureErrorPage(NotFound $notFoundPage, \Exception $e) {
    }

    public function getPageAddressAdapters(): array
    {
        return [];
    }
}