<?php

$this->load->view('include/header');
$this->load->view('include/sidebar');
$this->load->view($content);
if(!empty($modals)) { $this->load->view($modals); }
$this->load->view('include/view_modal');
$this->load->view('include/footer');

?>