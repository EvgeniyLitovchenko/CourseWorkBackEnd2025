<?php

namespace controllers;

use classes\Controller;
use classes\Template;
use models\Exhibitions;
use models\ExhibitionTypes;
use models\ExhibitionImages;

class ExhibitionsController extends Controller
{
    public function actionShow($type_id = null, $search = null, $page = 0, $from_date = null, $to_date = null)
    {
        $limit = 6;
        $queryParams = [
            'type_id' => $type_id,
            'search' => $search,
            'from_date' => $from_date,
            'to_date' => $to_date,
        ];

        $total = Exhibitions::countExhibitions($type_id, $search, $from_date, $to_date);

        $exhibitions = Exhibitions::getExhibitions($type_id, $search, $page, $limit, $from_date, $to_date);
        $pages = ceil($total / $limit);

        $types = ExhibitionTypes::findAll();
        $baseUrl = '/exhibitions/show?';

        $queryString = http_build_query(array_filter($queryParams));
        $baseUrl = '/exhibitions/show?' . $queryString . '&page=';

        $pagination = new Template("views/shared/pagination.php");
        $pagination->addParams([
            'currentPage' => $page,
            'totalPages' => $pages,
            'baseUrl' => $baseUrl,
        ]);


        return $this->view('Виставки', [
            'exhibitions' => $exhibitions,
            'types' => $types,
            'currentType' => $type_id,
            'pagination' => $pagination->render(),
        ]);
    }

    public function actionView($id)
    {
        $exhibition = Exhibitions::findById($id);
        if (!$exhibition) {
            $this->redirect('/exhibitions/show');
        }

        $images = ExhibitionImages::findByExhibitionId($id);

        return $this->view('Виставка', [
            'exhibition' => $exhibition,
            'images' => $images,
        ]);
    }
}
