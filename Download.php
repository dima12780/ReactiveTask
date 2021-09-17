<?php

class Download{

    public $filePaht;
    public $login;
    public $password;
    public $name;
    public $email;

    function __construct(){
        if ($_FILES && $_FILES["filename"]["error"]== UPLOAD_ERR_OK)
        {
            $this->filePaht = "file/users.xml";
            move_uploaded_file($_FILES["filename"]["tmp_name"], $this->filePaht);
            echo "<br><h3>Файл загружен</h3><br>";
        }
    }

    function building($xmlUser)
    {
        $this->login = $xmlUser->login;
        $this->password = $xmlUser->password;
        $this->name = isset($xmlUser->name) ? $xmlUser->name : $xmlUser->login;
        $this->email = isset($xmlUser->email) ? $xmlUser->name : $xmlUser->login."@example.com";
    }

    function Recording($db)
    {
        $kit = [];
        $processed = 0;
        $updated = 0;
        $deleted = $db->select("SELECT COUNT(*) FROM `users`;")[0] ?: 0 ;

        $xml = simplexml_load_file($this->filePaht);

        foreach ($xml as $user)
        {
            $this->building($user);
            $result = $db->select("SELECT `login` FROM `users` WHERE `login`='$this->login';");
            if ($result) $updated++;
        };
        $db->delete("DELETE FROM `users`");
        foreach ($xml as $user)
        {
            $processed++;
            $this->building($user);
            $this->Insert($db);
        };
        $deleted = $deleted - $updated;
        $processed = $processed + $deleted;
        $kit = [$processed, $updated, $deleted];
        return $kit;
    }

    function Insert($db)
    {
        $db->insert("INSERT INTO `users` (
                            `login`,
                            `password`,
                            `name`,
                            `email`
                        ) VALUES (
                            '$this->login',
                            '$this->password',
                            '$this->name',
                            '$this->email' ) ;"
                        );
    }
}
