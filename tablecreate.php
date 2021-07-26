<?php
require "databaseconnect.php";

function createTPosts()
{
    $stmt = dbConn()->prepare("
                                        create table posts
                                        (
                                             id integer not null auto_increment primary key,
                                             user_id integer,
                                             title varchar(127),
                                             body varchar(255)
                                        );
                                    ");
    $stmt->execute();

}

function createTComm()
{
    $stmt = dbConn()->prepare("
                                        create table comments
                                        (
                                             id integer not null auto_increment primary key,
                                             post_id int references posts(id),
                                             name varchar(127),
                                             email varchar(127),
                                             body varchar(255)
                                        );
                                    ");
    $stmt->execute();
}

function setPost($data)
{
    foreach ($data as $post)
    {
        $stmt = dbConn()->prepare("INSERT INTO posts(user_id, title, body) VALUES(:user_id, :title, :body)");
        $stmt->execute([
            "user_id" => $post["userId"],
            "title" => $post["title"],
            "body" => $post["body"]
        ]);
    }
    print "Загружено " . count($data) . " записей<br>";
}

function setComm($data)
{
    foreach ($data as $post)
    {
        $stmt = dbConn()->prepare("INSERT INTO comments(post_id, name, email, body) VALUES(:post_id, :name, :email, :body)");
        $stmt->execute([
            "post_id" => $post["postId"],
            "name" => $post["name"],
            "email" => $post["email"],
            "body" => $post["body"]
        ]);
    }
    print "Загружено " . count($data) . " комментариев<br>";
}

function havePosts()
{
    $stmt = dbConn()->prepare("SELECT * FROM posts");
    $stmt->execute();
    $result = $stmt->fetchAll();
    if (!$result) {
        return false;
    }


    echo "Данные уже были загружены заранее<br>";
    return true;
}

function haveComm()
{
    $stmt = dbConn()->prepare("SELECT * FROM comments");
    $stmt->execute();
    $result = $stmt->fetchAll();
    if (!$result) {
        return false;
    }

    return true;
}

function search($query)
{
    $stmt = dbConn()->prepare("SELECT * FROM comments WHERE body LIKE ?");
    $stmt->execute([
        "%". $query. "%",
    ]);
    $result = $stmt->fetchAll();

    if(!$result)
        echo "Ничего не найдено<br>";
    foreach ($result as $res)
    {
        $stmt = dbConn()->prepare("SELECT * FROM posts WHERE id = ?");
        $stmt->execute([
            $res["post_id"]
        ]);
        $res_stmt = $stmt->fetch();
        echo " ". $res_stmt["title"] ."<br>";
        echo " ". $res["body"] ."<br><br>";
    }
}