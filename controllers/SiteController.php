<?php

namespace controllers;

use classes\Controller;
use models\Contacts;

class SiteController extends Controller
{
    public function actionMain()
    {
        return $this->view('Музей');
    }

    public function actionAbout()
    {
        return $this->view('Про нас');
    }
    public function actionContacts()
    {
        $contacts = Contacts::getContactsAssoc();
        return $this->view('Контакти', ['contacts' => $contacts]);
    }
    public function actionVisitors()
    {
        $visitorInfo = \models\VisitorInfo::findAll();
        return $this->view('Відвідувачам', ['visitorInfo' => $visitorInfo]);
    }
}
