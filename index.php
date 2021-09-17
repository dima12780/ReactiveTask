<?php
    require_once "DbConnect.php";
    require_once "Pages.php";
    require_once "Download.php";
?>
<html>
    <head>
        <meta http-equiv="Content-type" content="text/html;charset=UTF-8">
    </head>
    <body>
        <form method="post" enctype="multipart/form-data">
            Выберите файл: <input type="file" name="filename" size="10" /><br /><br />
            <input type="submit"  name="download" />
        </form>
        <?
            if(isset( $_POST['text'] ))
            {
                $_GET["page"] = 1;
                $loginSort = $_POST['text'];
            }elseif(isset( $_REQUEST["login"] ))
            {
                $loginSort = $_REQUEST["login"];
            } else   $loginSort = null; 

            $db = new DbConnect();
            $loading = new Download(); 
            $pages= new Pages();

            if( isset( $_POST['download'] ))
            {
                $res = $loading->Recording($db);
                echo "сколько записей обработано: ". $res[0]
                . "<br>сколько обновлено записей: ". $res[1]
                . "<br>сколько удалено: ". $res[2];
            }
        ?>
        <form method="post" enctype="multipart/form-data">
        <p>Поиск по Логину: <?echo $loginSort?></p>
            <input type="text" name="text" size="10" />
            <input type="submit" value="Искать"  name="sort" />
            <? echo "<a href=index.php?page=1>Сброс</a>"; ?>
        </form>
         <table border="1" class="ming">
            <caption><strong>Пользователи</strong></caption>
            <tr>
                <th>логин</th>
                <th>пароль</th>
                <th>имя</th>
                <th>е-мейл</th>
            </tr>
                <?   
                    $num= 25;
                    $start = $pages->pageStart($num);

                    $sort = isset($loginSort) ? "WHERE `login` LIKE '%".$loginSort."%'" : "";
                    $total = $pages->pagesDb($db, $num, $sort);
                    $result = $db->select("SELECT `login`,`password`,`name`,`email` FROM `users` $sort LIMIT $start, $num;" , false);
                    $table = $db->assoc($result);
                    if($table)
                    {
                        foreach($table as $key=>$value)
                        {
                            $login = "<td>".$value["login"]."</td>";
                            $password = "<td>".$value["password"]."</td>";
                            $name = "<td>". $value["login"] ."</td>";
                            $email = "<td>".$value["login"]."@example.com" ."</td>";
                            echo "<tr>". $login . $password . $name . $email . "</tr>";
                        };
                    };
                ?>
        </table>
        <?
            $pages->pagesUp($total, $loginSort);
        ?>
    </body>