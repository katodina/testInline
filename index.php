<?php
require "tablecreate.php";

createTPosts();
createTComm();

if(!havePosts()) {
    $dataPosts = getData("https://jsonplaceholder.typicode.com/posts");
    setPost($dataPosts);
}
if(!haveComm()) {
    $dataComm = getData("https://jsonplaceholder.typicode.com/comments");
    setComm($dataComm);
}

function getData($url)
{
    $json_url = $url;
    $data = file_get_contents($json_url);
    $json = json_decode($data, true);

    return $json;
}

if(mb_strlen($_POST["search"]) >= 3) {
    search($_POST["search"]);
}
else if(mb_strlen($_POST["search"]) >= 1) {
    echo "Введено менее 3-х символов";
}
?>
<form method="post">
    <div style="display:flex; justify-content:center;">
        <input type="text" name="search">
        <input type="submit" value="Найти">
    </div>
</form>