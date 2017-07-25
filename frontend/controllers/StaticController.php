<?php

namespace frontend\controllers;

use yii\web\Controller;
use MatthiasMullie\Minify;

class StaticController extends Controller {

    public $layout = false;
    public $minifyJs = true;
    public $enableCache = false;
    public $indexJqueryUrl = "https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js";
    public $iframeJqueryUrl = "https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js";

    public function actionIndex() {
        return $this->render('index');
    }

    public function renderScript($view, $data = []) {
        $content = $this->render($view, $data);
        //Remove scrip tag
        $content = substr($content, 8, -9);
        return $content;
    }

    public function printJavascript($view, $data = []) {
        header('Content-Type: text/javascript');
        $content = $this->renderScript($view, $data);
        if ($this->minifyJs) {
            $minifier = new Minify\JS();
            $minifier->add($content);
            $content = $minifier->minify();
        }
        echo $content;
        return $content;
    }

    public function getRandomImages() {
        $images = scandir("img/popup");
        return array_slice($images, 2);
    }

    public function actionPopup() {
        $iframeContent = json_encode($this->render("popup/iframe", [
                    'jqueryUrl' => $this->iframeJqueryUrl,
                    'randomImages' => json_encode($this->getRandomImages()),
        ]));
        $content = $this->printJavascript("popup/index.php", [
            'iframeContent' => $iframeContent,
            'jqueryUrl' => $this->indexJqueryUrl
        ]);
        if ($this->enableCache)
            file_put_contents("static/popup.js", $content);
    }

}
