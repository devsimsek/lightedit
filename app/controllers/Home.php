<?php

class Home extends SDF\Controller
{
    /**
     * Not necessary to add, but
     * it feels kinda nice to
     * control all variables
     * flowing through
     * controller.
     */
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
    }

    /**
     * Index view
     * @return void
     */
    public function index()
    {
        if (isSignedIn())
            redirect("dashboard");
        redirect("signin");
    }
}
