<?php 

class Form {
    public static $errors = [];
    public static $values = [];
    public static function Post(...$posts){
        self::$errors = [];
        self::$values = [];
        foreach($posts as $post){
            if(!isset($_POST[$post[0]])){
                self::$errors[$post[0]] = 'Kullanıcı bu inputu sayfadan kaldırmış!';
                continue;
            }
            if(!$_POST[$post[0]]){
                self::$errors[$post[0]] = 'Kullanıcı bu inputu doldurmamış!';
                continue;
            }
            $input = self::inputFiltering($post[0]);
            if(!$input){
                if(!isset($post[1]) || (isset($post[1]) && is_callable($post[1]))){
                    self::$errors[$post[0]] = 'Kullanıcı süzgeçlenmiş değerde sıkıntı yaşamış!';
                    continue;
                }
            }
            if(isset($post[1])){
                if(is_callable($post[1])){
                    $input = $post[1]($post[0]);
                } elseif($post[1] == 'OPTIONAL'){
                    $input = self::$values[$post[0]] = $post[0] ? $post[0] : 0;
                }
                if(!$input){
                    self::$errors[$post[0]] = 'Kullanıcı geçerli bir değer girmemiş';
                    continue;
                }
            }
            self::$values[$post[0]] = $input;
        }
        return ['values' => self::$values, 'errors' => self::$errors];
    }

    public static function inputFiltering($key){
        return htmlspecialchars(strip_tags(str_replace("\xc2\xa0", '', trim($_POST[$key]))));
    }
}

?>
