<?php

namespace controllers;

use classes\Controller;
use models\News;
use classes\Template;

class NewsController extends Controller
{
    public function actionShow($page = 0)
    {
        $limit = 6;

        $news = News::getNews($page, $limit,);
        $total = News::countNews();
        $pages = ceil($total / $limit);

        $query_params = [
            'page' => $page,
        ];

        $baseUrl = '/news/show?' . http_build_query($query_params);

        $pagination = new Template("views/shared/pagination.php");
        $pagination->addParams([
            'currentPage' => $page,
            'totalPages' => $pages,
            'baseUrl' => $baseUrl,
        ]);

        return $this->view('Новини', [
            'news' => $news,
            'pagination' => $pagination->render(),
        ]);
    }

    public function actionView($id)
    {
        $newsItem = News::findById($id);
        if (!$newsItem) {
            $this->redirect('/news/show');
        }

        return $this->view('Новина', [
            'newsItem' => $newsItem,
        ]);
    }
}
