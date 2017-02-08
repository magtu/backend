<!DOCTYPE html>
<html>
<head>
    <?include_once("templates/meta.php");?>
</head>
<body>
<main>
    <h1>Мы нашли несколько результатов по вашему запросу</h1>
    <div class="search-results">
        <? foreach ($data as $data_item) {?>
        <a class="search-result" href="/<?=$data_item["url"]?>">
            <div class="result-name"><?=$data_item["name"]?></div>
            <div class="result-type"><?=($data_item["type"] == 'teacher')? 'Преподаватель': 'Группа'?></div>
        </a>
        <?}?>
    </div>
</main>
<footer></footer>
<script src="js/jquery.min.js"></script>
<script src="js/select2.min.js"></script>
<script src="js/jquery.scrollTo.min.js"></script>
<script src="js/Global.js"></script>
<script src="js/Main.js"></script>
</body>
</html>