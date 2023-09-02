<?php

class Home extends SDF\Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->file("Session", SDF_APP_LIB);
        $this->load->file("Database", SDF_APP_LIB);
        $this->load->file("Flash", SDF_APP_LIB);
        $this->load->helper("Global");
        $this->load->helper("Database");
        $this->load->helper("Flash");
        $this->load->helper("Auth");
        $this->load->file("Types", SDF_APP_HELP);
        if (!isSignedIn()) {
            flash->add("Warning", "You must be signed in to view this page.");
            redirect("signin");
        }
    }

    public function index()
    {
        $view = new View("Dashboard", "dashboard", []);
        $this->load->view('partials/head', $view);
        $this->load->view('dashboard/home', $view);
        $this->load->view('partials/footer', $view);
    }
}
