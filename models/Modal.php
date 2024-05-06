<?php

class Modal
{
    private array $data = [
        'id' => '',
        'class' => '',
        'title' => '',
        'body' => ''
    ];

    public function __construct($data)
    {
        $this->set_value_of('data', $data);
    }

    public function set_value_of($attribut, $value)
    {
        $this->data[$attribut] = $value;
    }

    public function get_value_of($attribut)
    {
        return $this->data[$attribut];
    }


    public function modal_content()
    {
        $modal = "<div class='modal fade' id='";
        $modal .= $this->get_value_of('data')['id'];
        $modal .= "' tabindex='-1' aria-labelledby='Modal' aria-hidden='true'>";
        $modal .= "<div class='modal-dialog ";
        $modal .= $this->get_value_of('data')['class'];
        $modal .= "'>";
        $modal .= "<div class='modal-content'>";
        $modal .= "<div class='modal-header'>";
        $modal .= "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
        $modal .= "</div>";
        $modal .= "<div class='modal-body'>";
        $modal .= "<h5 class='modal-title'>";
        $modal .= $this->get_value_of('data')['title'];
        $modal .= "</h5>";
        $modal .= json_encode($this->get_value_of('data')['body']);
        $modal .= "</div>";
        $modal .= "</div>";
        $modal .= "</div>";
        $modal .= "</div>";
        return $modal;
    }

    public function modal_trigger()
    {
        $btn = "<button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#";
        $btn .= $this->get_value_of('data')['id'];
        $btn .= "'>";
        $btn .= $this->get_value_of('data')['title'];
        $btn .= "</button>";
        return $btn;
    }

    public function generate_modal()
    {
        echo $this->modal_trigger();
        echo $this->modal_content();
    }

    public function __toString()
    {
        return "Modal: " . $this->get_value_of('data')['id'] . " - " . $this->get_value_of('data')['title'] . "\n";
    }
}