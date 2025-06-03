<?php

namespace classes;

class Controller
{
    protected Template $template;
    protected $errorMessages = [];
    protected $successMessages = [];
    public function __construct()
    {
        $action = Core::getInstance()->action;
        $controller = Core::getInstance()->controller;
        $this->template = new Template("views/{$controller}/{$action}.php");
    }

    public function view(string $title, ?array $params = null, ?string $templatePath = null): array
    {
        if (!empty($templatePath)) {
            $this->template->setTemplatePath($templatePath);
        }
        if (!empty($params)) {
            $this->template->addParams($params);
        }
        return [
            'title' => $title,
            'content' => $this->template->render(),
        ];
    }

    public function redirect(string $url): void
    {
        header("Location: $url");
        die;
    }

    public function addErrorMessage(?string $message = null): void
    {
        $this->errorMessages[] = "• " . $message;
        $this->template->addParam('errorMessage', implode('<br>', $this->errorMessages));
    }
    public function addSuccessMessage(?string $message = null): void
    {
        $this->successMessages[] = "• " . $message;
        $this->template->addParam('successMessage', implode('<br>', $this->successMessages));
    }
    public function clearErrorMessage(): void
    {
        $this->errorMessages = [];
        $this->template->addParam('errorMessage', null);
    }
    public function clearSuccessMessage(): void
    {
        $this->successMessages = [];
        $this->template->addParam('successMessage', null);
    }
    public function isErrorMessagesExists(): bool
    {
        return !empty($this->errorMessages);
    }
    public function isSuccessMessagesExists(): bool
    {
        return !empty($this->successMessages);
    }
    protected function json($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
