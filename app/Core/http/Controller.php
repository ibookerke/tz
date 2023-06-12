<?php

namespace Core\http;

/**
 * The Controller class serves as the base class for all controllers in the application.
 */
class Controller
{
    /**
     * The HTTP request object.
     *
     * @var Request
     */
    public Request $request;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->request = new Request();
    }

    /**
     * Renders a view with optional data.
     *
     * @param string $view The name of the view to render.
     * @param array $data An optional array of data to pass to the view.
     *
     * @return void
     */
    public function view(string $view, array $data = []): void
    {
        $view = str_replace('.', '/', $view);

        $filename = "../app/Views/" . $view . ".view.php";

        if (!file_exists($filename)) {
            $filename = "../app/Views/404.view.php";
        }

        if (!empty($data)) {
            extract($data);
        }

        require $filename;
    }
}
