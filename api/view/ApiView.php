<?php
class ApiView {

    public function response($data, $statusCode) {
        header("Content-Type: application/json");
        header("HTTP/1.1 $statusCode " . $this->requestStatus($statusCode));

        echo json_encode($data);
    }

    private function requestStatus($statusCode) {
        $status = [
            200 => "OK",
            400 => "Bad Request",
            404 => "Not Found",
            500 => "Internal Server Error"
        ];

        return isset($status[$statusCode]) ? $status[$statusCode] : $status[500];
    }
}
?>