<?php

class Api extends SDF\Controller
{

  public function __construct()
  {
    die("Left for integration.");
    parent::__construct();
    $this->load->file("Session", SDF_APP_LIB);
    $this->load->file("Database", SDF_APP_LIB);
    $this->load->file("Flash", SDF_APP_LIB);
    $this->load->helper("Global");
    $this->load->helper("Database");
    $this->load->helper("Flash");
    $this->load->helper("Auth");
  }


}

