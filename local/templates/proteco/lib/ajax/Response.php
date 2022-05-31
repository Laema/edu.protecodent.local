<?php
namespace Ajax;

class Response {
    const TYPE_JSON = 'json';
    const TYPE_HTML = 'html';
    public function shape($data = [], $message = '', $type = self::TYPE_JSON) {
        return [
            'result' => $data,
            'message' => $message,
            'type' => $type,
        ];
    }
    public function shapeOk($data = [], $message = '', $type = self::TYPE_JSON) {
        return array_merge($this->shape($data, $message, $type), ['isSuccess' => true]);
    }

    public function shapeError($data = [], $message = '', $type = self::TYPE_JSON) {
        return array_merge($this->shape($data, $message, $type), ['isSuccess' => false]);
    }
}
