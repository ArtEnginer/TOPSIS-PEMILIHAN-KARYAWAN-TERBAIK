<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Manage extends BaseController
{
    use ResponseTrait;
    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger,
    ) {
        parent::initController($request, $response, $logger);
        $this->view->setData([
            // "user" => TeamSession::user()
        ]);
    }
    public function index(): string
    {
        $this->view->setData([
            "page" => "dashboard",
        ]);
        return $this->view->render("pages/panel/index");
    }
    public function alternatif(): string
    {
        $this->view->setData([
            "page" => "alternatif",
        ]);
        return $this->view->render("pages/panel/alternatif");
    }
    public function kriteria(): string
    {
        $this->view->setData([
            "page" => "kriteria",
        ]);
        return $this->view->render("pages/panel/kriteria");
    }
    public function penilaian(): string
    {
        $this->view->setData([
            "page" => "penilaian",
        ]);
        return $this->view->render("pages/panel/penilaian");
    }

    // subkriteria
    public function subkriteria(): string
    {
        $this->view->setData([
            "page" => "subkriteria",
        ]);
        return $this->view->render("pages/panel/subkriteria");
    }

    public function implementasi(): string
    {
        $this->view->setData([
            "page" => "implementasi",
        ]);
        return $this->view->render("pages/panel/implementasi");
    }
    public function hasil(): string
    {
        $this->view->setData([
            "page" => "hasil",
        ]);
        return $this->view->render("pages/panel/hasil");
    }
    public function user(): string
    {
        $this->view->setData([
            "page" => "user",
        ]);
        return $this->view->render("pages/panel/user");
    }
}
