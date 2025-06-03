<?php

namespace controllers;

use classes\Controller;
use classes\Core;
use classes\Request;
use classes\Template;
use models\Contacts;
use models\ExhibitionImages;
use models\Exhibitions;
use models\ExhibitionTypes;
use models\News;
use models\Users;
use models\VisitorInfo;

class AdminController extends Controller
{
    public function actionDashboard()
    {
        if (!Users::isAdminLogin()) {
            $this->redirect('/admin/login');
        }
        Core::getInstance()->setLayout('layout/admin/index.php');

        return $this->view('Адмінка', []);
    }
    public function actionExhibitions($page = 0)
    {
        $limit = 10;
        if (!Users::isAdminLogin()) {
            $this->redirect('/admin/login');
        }
        $exhibitions = Exhibitions::getExhibitions(null, null, $page, $limit);

        $exhibitionCount = Exhibitions::countExhibitions();
        $pages = ceil($exhibitionCount / $limit);
        $baseUrl = '/admin/exhibitions?page=';
        foreach ($exhibitions as $key => $exhibition) {
            $exhibition['type'] = ExhibitionTypes::findById($exhibition['type_id'])['name'] ?? '';
            $exhibitions[$key] = $exhibition;
        }
        $pagination = new Template("views/shared/pagination.php");
        $pagination->addParams([
            'currentPage' => $page,
            'totalPages' => $pages,
            'baseUrl' => $baseUrl,
        ]);

        return $this->view('Виставки', [
            'exhibitions' => $exhibitions,
            'pagination' => $pagination->render(),
        ]);
    }
    public function actionExhibitionCreate()
    {
        if (!Users::isAdminLogin()) {
            $this->redirect('/admin/login');
        }

        if (Request::method() === 'POST') {
            $data = Request::only(['title', 'type_id', 'description', 'start_date', 'end_date']);

            $data['start_date'] = $data['start_date'] === '' ? null : $data['start_date'];
            $data['end_date'] = $data['end_date'] === '' ? null : $data['end_date'];
            if (empty($data['title']) || empty($data['type_id'])) {
                $this->addErrorMessage('Всі поля окрім дати є обов\'язковими');
                return $this->view('Створити виставку', ['types' => ExhibitionTypes::findAll()], "views/Exhibitions/exhibitionForm.php");
            }
            $exhibition = new Exhibitions();
            $exhibition->fill($data);
            $id = $exhibition->save();

            ExhibitionImages::uploadImages($id, $_FILES['images'] ?? []);

            $this->redirect('/admin/exhibitions');
        }

        $types = ExhibitionTypes::findAll();
        return $this->view('Створити виставку', ['types' => $types], "views/Exhibitions/exhibitionForm.php");
    }

    public function actionExhibitionEdit($id)
    {
        if (!Users::isAdminLogin()) {
            $this->redirect('/admin/login');
        }

        if (Request::method() === 'POST') {
            $data = Request::only(['title', 'type_id', 'description', 'start_date', 'end_date']);
            $data['start_date'] = $data['start_date'] === '' ? null : $data['start_date'];
            $data['end_date'] = $data['end_date'] === '' ? null : $data['end_date'];
            $id = Request::post('id');
            $exhibition = new Exhibitions();
            $exhibition->id = $id;
            if ($exhibition) {
                $exhibition->fill($data);
                $exhibition->save();
                ExhibitionImages::uploadImages($id, $_FILES['images'] ?? []);
            }

            $this->redirect('/admin/exhibitions');
        }

        $exhibition = Exhibitions::findById($id);
        if (!$exhibition) {
            $this->redirect('/admin/exhibitions');
        }

        $images = ExhibitionImages::findByExhibitionId($id);
        $additionalImages = array_map(fn($img) => [
            'filename' => $img['image_path'],
            'id' => $img['id'],
        ], $images);

        $types = ExhibitionTypes::findAll();
        return $this->view('Редагувати виставку', [
            'exhibition' => $exhibition,
            'types' => $types,
            'additionalImages' => $additionalImages,
        ], "views/Exhibitions/exhibitionForm.php");
    }
    public function actionDeleteExhibition()
    {
        if (!Users::isAdminLogin()) {
            $this->redirect('/admin/login');
        }

        if (Request::method() === 'POST') {
            $id = Request::get('id');
            Exhibitions::deleteWithImages($id);
            $this->redirect('/admin/exhibitions');
        }
    }

    public function actionDeleteImage()
    {
        if (!Users::isAdminLogin()) {
            http_response_code(403);
            exit;
        }

        if (Request::method() === 'POST') {
            $id = Request::post('id');
            ExhibitionImages::deleteWithFile($id);
            http_response_code(200);
            exit;
        }

        http_response_code(400);
        exit;
    }
    public function actionNews($page = 0)
    {
        if (!Users::isAdminLogin()) {
            $this->redirect('/admin/login');
        }

        $limit = 10;
        $news = News::getNews($page, $limit);
        $newsCount = News::countNews();

        $pages = ceil($newsCount / $limit);
        $baseUrl = '/admin/news?page=';

        $pagination = new Template("views/shared/pagination.php");
        $pagination->addParams([
            'currentPage' => $page,
            'totalPages' => $pages,
            'baseUrl' => $baseUrl,
        ]);

        return $this->view('Новини', ['news' => $news, 'pagination' => $pagination->render()]);
    }
    public function actionCreateNews()
    {
        if (!Users::isAdminLogin()) {
            $this->redirect('/admin/login');
        }

        if (Request::method() === 'POST') {
            $data = Request::only(['title', 'excerpt', 'content']);

            if (empty($data['title']) || empty($data['excerpt']) || empty($data['content'])) {
                $this->addErrorMessage('Всі поля є обов\'язковими');
                return $this->view('Створити новину', [], "views/News/newsForm.php");
            }

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../public/images/news/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $originalName = basename($_FILES['image']['name']);
                $extension = pathinfo($originalName, PATHINFO_EXTENSION);
                $filename = uniqid() . '.' . $extension;
                $targetPath = $uploadDir . $filename;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                    $data['image'] = '../public/images/news/' . $filename;
                } else {
                    $this->addErrorMessage('Помилка при завантаженні зображення');
                    return $this->view('Створити новину', [], "views/News/newsForm.php");
                }
            }

            $news = new News();
            $news->fill($data);
            $news->save();

            $this->redirect('/admin/news');
        }

        return $this->view('Створити новину', [], "views/News/newsForm.php");
    }
    public function actionEditNews($id)
    {
        if (!Users::isAdminLogin()) {
            $this->redirect('/admin/login');
        }

        if (Request::method() === 'POST') {
            $data = Request::only(['title', 'excerpt', 'content']);
            $id = Request::post('id');

            if (empty($data['title']) || empty($data['excerpt']) || empty($data['content'])) {
                $this->addErrorMessage('Всі поля є обов\'язковими');
                return $this->view('Редагувати новину', ['news' => News::findById($id)], "views/News/newsForm.php");
            }

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../public/images/news/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $news = News::findById($id);
                $imagePath = str_replace('../', '', $news['image']);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
                $originalName = basename($_FILES['image']['name']);
                $extension = pathinfo($originalName, PATHINFO_EXTENSION);
                $filename = uniqid() . '.' . $extension;
                $targetPath = $uploadDir . $filename;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                    $data['image'] = '../public/images/news/' . $filename;
                } else {
                    $this->addErrorMessage('Помилка при завантаженні зображення');
                    return $this->view('Редагувати новину', ['news' => News::findById($id)], "views/News/newsForm.php");
                }
            }

            $news = new News();
            $news->fill($data);
            $news->id = $id;
            $news->save();

            $this->redirect('/admin/news');
        }

        return $this->view('Редагувати новину', ['news' => News::findById($id)], "views/News/newsForm.php");
    }
    public function actionDeleteNews()
    {
        if (!Users::isAdminLogin()) {
            $this->redirect('/admin/login');
        }

        if (Request::method() === 'POST') {
            $id = Request::post('id');
            $news = News::findById($id);
            if ($news) {
                if (!empty($news['image'])) {
                    $imagePath = str_replace('../', '', $news['image']);
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
                News::deleteById($id);
            }
            $this->redirect('/admin/news');
        }
    }
    public function actionVisitorInfo()
    {
        if (!Users::isAdminLogin()) {
            $this->redirect('/admin/login');
        }

        $visitors = VisitorInfo::findAll();
        return $this->view('Відвідувачі', ['visitorInfos' => $visitors]);
    }
    public function actionCreateVisitorInfo()
    {
        if (!Users::isAdminLogin()) {
            $this->redirect('/admin/login');
        }

        if (Request::method() === 'POST') {
            $data = Request::only(['category', 'content']);
            if (empty($data['category']) || empty($data['content'])) {
                $this->addErrorMessage('Всі поля є обов\'язковими');
                return $this->view('Створити інформацію для відвідувачів', [], "views/VisitorInfo/visitorInfoForm.php");
            }
            $visitorInfo = new VisitorInfo();
            $visitorInfo->category = $data['category'];
            $visitorInfo->content = $data['content'];

            $visitorInfo->save();
            $this->redirect('/admin/visitorInfo');
        }

        return $this->view('Створити інформацію для відвідувачів', [], "views/VisitorInfo/visitorInfoForm.php");
    }
    public function actionEditVisitorInfo($id)
    {
        if (!Users::isAdminLogin()) {
            $this->redirect('/admin/login');
        }

        if (Request::method() === 'POST') {
            $data = Request::only(['category', 'content']);
            if (empty($data['category']) || empty($data['content'])) {
                $this->addErrorMessage('Всі поля є обов\'язковими');
                return $this->view('Редагувати інформацію для відвідувачів', ['visitorInfo' => VisitorInfo::findById($id)], "views/VisitorInfo/visitorInfoForm.php");
            }
            $visitorInfo = new VisitorInfo();
            $id = Request::post('id');
            $visitorInfo->id = $id;
            $visitorInfo->category = $data['category'];
            $visitorInfo->content = $data['content'];

            $visitorInfo->save();
            $this->redirect('/admin/visitorInfo');
        }

        return $this->view('Редагувати інформацію для відвідувачів', ['visitorInfo' => VisitorInfo::findById($id)], "views/VisitorInfo/visitorInfoForm.php");
    }
    public function actionDeleteVisitorInfo()
    {
        if (!Users::isAdminLogin()) {
            $this->redirect('/admin/login');
        }

        if (Request::method() === 'POST') {
            $id = Request::post('id');
            VisitorInfo::deleteById($id);
            $this->redirect('/admin/visitorInfo');
        }
    }

    public function actionContacts()
    {
        if (!Users::isAdminLogin()) {
            $this->redirect('/admin/login');
        }

        $contacts = Contacts::findAll();
        return $this->view('Контакти', ['contacts' => $contacts]);
    }
    public function actionCreateContact()
    {
        if (!Users::isAdminLogin()) {
            $this->redirect('/admin/login');
        }

        if (Request::method() === 'POST') {
            $data = Request::only(['name', 'value']);
            if (empty($data['name']) || empty($data['value'])) {
                $this->addErrorMessage('Всі поля є обов\'язковими');
                return $this->view('Створити контакт', [], "views/Contacts/contactForm.php");
            }
            $contact = new Contacts();
            $contact->name = $data['name'];
            $contact->value = $data['value'];

            $contact->save();
            $this->redirect('/admin/contacts');
        }

        return $this->view('Створити контакт', [], "views/Contacts/contactForm.php");
    }
    public function actionEditContact($id)
    {
        if (!Users::isAdminLogin()) {
            $this->redirect('/admin/login');
        }

        if (Request::method() === 'POST') {
            $data = Request::only(['name', 'value']);
            if (empty($data['name']) || empty($data['value'])) {
                $this->addErrorMessage('Всі поля є обов\'язковими');
                return $this->view('Редагувати контакт', ['contact' => Contacts::findById($id)], "views/Contacts/contactForm.php");
            }
            $contact = new Contacts();
            $id = Request::post('id');
            $contact->id = $id;
            $contact->name = $data['name'];
            $contact->value = $data['value'];

            $contact->save();
            $this->redirect('/admin/contacts');
        }

        return $this->view('Редагувати контакт', ['contact' => Contacts::findById($id)], "views/Contacts/contactForm.php");
    }
    public function actionDeleteContact()
    {
        if (!Users::isAdminLogin()) {
            $this->redirect('/admin/login');
        }

        if (Request::method() === 'POST') {
            $id = Request::post('id');
            Contacts::deleteById($id);
            $this->redirect('/admin/contacts');
        }
    }
    public function actionLogin()
    {
        if (Users::isAdminLogin()) {
            $this->redirect('/admin');
        }
        if (Request::method() === 'POST') {
            $data = Request::only(['username', 'password']);
            if (Users::login($data['username'], $data['password'])) {
                $this->redirect('/admin/dashboard');
            } else {
                $this->addErrorMessage('Неправильний логін або пароль');
            }
        }
        Core::getInstance()->setLayout('layout/admin/login.php');
        return $this->view('Вхід в адмінку');
    }

    public function actionLogout()
    {
        Core::getInstance()->session->destroy();
        $this->redirect('/');
    }
}
