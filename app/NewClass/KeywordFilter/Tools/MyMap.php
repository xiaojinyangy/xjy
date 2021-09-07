<?php
namespace app\NewClass\KeywordFilter\Tools;

/**
 * 敏感词map数据结构
 */
class MyMap {

    public function get($key) {
        return isset($this->$key) ? $this->$key : null;
    }

    public function put($key, $value) {
        $this->$key = $value;
    }

}
