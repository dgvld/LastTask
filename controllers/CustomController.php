<?php

namespace app\controllers;
use yii\web\Controller;

class CustomController extends Controller
{
    protected function setMeta ($title = null, $description = null, $keywords = null)
    {
        $this->view->title = $title;
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => $keywords]);
        $this->view->registerMetaTag(['name' => 'description', 'content' => $description]);
    }

    public static function dump($value)
    {
        echo "<pre>";
        print_r($value);
        echo "</pre>";
    }
}