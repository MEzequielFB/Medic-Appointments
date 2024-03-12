<?php
class Controller {
    protected $model;
    protected $view;

    protected function checkRequiredFields($requiredFields) {
        $emptyFields = [];

        foreach ($requiredFields as $field) {
            if (!isset($_POST[$field]) || empty($_POST[$field])) {
                array_push($emptyFields, $field);
            }
        }

        return $emptyFields;
    }

    protected function checkFileExtension($filename, $validExtensions) {
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        return in_array($ext, $validExtensions);
    }
}
?>