<?php

class Form
{
    private array $data = [
        'header' => [],
        'inputs' => [],
        'footer' => [],
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

    private function generate_header()
    {
        if (isset($this->get_value_of('data')['header'])) {
            foreach ($this->get_value_of('data')['header'] as $item) {
                $header = '<' . $item['type'] . '>' . $item['line'] . '</' . $item['type'] . '>';
                $headers[] = $header;
            }
            if (isset($headers)) {
                return implode("\n", $headers);
            }
        }
    }

    private function generate_alert()
    {
        if (isset($this->get_value_of('data')['id'])) {
            $id= 'alert_message_' . ($this->get_value_of('data')['id'] ?? '');
            $alert = "<div id='$id' class='d-none alert'>";
            $alert .= "</div>";
            return $alert;
        }
    }

    private function generate_footer()
    {
        if (isset($this->get_value_of('data')['footer'])) {
            foreach ($this->get_value_of('data')['footer'] as $item) {
                $footer = '<' . $item['type'] . '>' . $item['line'] . '</' . $item['type'] . '>';
                $footers[] = $footer;
            }
            if (isset($footers)) {
                return implode("\n", $footers);
            }
        } else {
            return '';
        }
    }




    // A Améliorer //
    private function generate_inputs()
    {
        $inputs = [];
        if (isset($this->get_value_of('data')['inputs'])) {
            foreach ($this->get_value_of('data')['inputs'] as $item) {
                $input = "<div class='form__body__form-group' id='input_" . $item['name'] . "'>";
                    if (isset($item['label'])){
                    $input = "<label for='" . $item['name'] . "'>" . $item['label'] . "</label>";
                    }
                    switch($item['type']){

                        case 'select':
                            $input .= "<select 
                                        name='$item[name]' 
                                        " . ($item['required'] ? 'required' : '') . "
                                    > 
                                        <option value=''>-- Choisir --</option>";
                                foreach ($item['options'] as $option) {
                                    $input .= "<option value='" . $option->get_value_of('id') . "'>
                                                " . $option->get_value_of('nom') . "
                                            </option>";
                                }
                            $input .= "</select>";
                            break;

                        case 'file':
                            $input .= "<input type='file' 
                                        name='" . $item['name'] . "' " . " accept='" . $item['accept'] . " " . 
                                        ($item['required'] ? 'required' : '') . ">";
                            break;
                        case 'password':
                            $input .= "<input 
                                        type='password' 
                                        name='" . $item['name'] . "' 
                                        placeholder='" . $item['placeholder'] . "' 
                                        " . ($item['required'] ? 'required' : '') . ">";
                            break;
                        case 'hidden':
                            $input .= "<input 
                                        type='hidden' 
                                        name='" . $item['name'] . "' 
                                        value='" . $item['value'] . "'>";
                            break;
                        default:
                            $input .= "<input
                                        type='$item[type]'
                                        name='$item[name]'
                                        placeholder='$item[placeholder]'
                                        " . ($item['required'] ? 'required' : '') . ">";
                            break;
                    }
                $input .= "</div>";

                array_push($inputs, $input);
            }
            if (isset($inputs)) {
                return implode("\n", $inputs);
            }
        }
    }
    // A Améliorer //

    public function generate_form()
    {
        $form = "<form 
                    method='" . ($this->get_value_of('data')['method'] ?? 'POST') . "'
                    action='" . ($this->get_value_of('data')['action'] ?? '') . "'
                    enctype='" . ($this->get_value_of('data')['enctype'] ?? 'application/x-www-form-urlencoded') . "'
                    class='form " . ($this->get_value_of('data')['class'] ?? '') . "' 
                    id='" . ($this->get_value_of('data')['id'] ?? '') . "'>";
                    
            $form .= "<div class='form__header'>";
                $form .=$this->generate_header();
                $form .=$this->generate_alert();
            $form .= "</div>";

            $form .= "<div class='form__body'>";
                $form .=$this->generate_inputs();
            $form .= "</div>";

            $form .= "<div class='form__footer'>";
                $form .=$this->generate_footer();
            $form .= "</div>";

            $form .= "<div class='form__button'>";
       
                $form .= "<button type='submit' 
                    id='submit_" . ($this->get_value_of('data')['id'] ?? '') . "'>" . ($this->get_value_of('data')['submit'] ?? 'Envoyer') . "</button>";

            $form .= "</div>";

        $form .= "</form>";
        return $form;
    }
}