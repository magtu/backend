<!doctype html>
<head>
    <? include_once("templates/meta.php"); ?>
</head>
<body>

<section class="search-section" style="display: block;">
    <div class="group-search">
        <img src="images/logo.png" alt="" class="mgtu-start-logo">

        <h1>Расписание занятий</h1>

        <div class="search-form">
            <p>Группа или имя преподавателя:</p>
            <div class="ajax-select-wrap">
                <input type="text" class="ajax-select" placeholder="Поиск">
            </div>
        </div>
        <div class="last-used">
            <!--=========================-->
            <!--ЗАПОЛНЯЕТСЯ СКРИПТОМ НИЖЕ-->
            <!--=========================-->
        </div>
    </div>
</section>
<script src="js/jquery.min.js"></script>
<script src="js/myAjaxSelect.js"></script>
<script>
    myAjaxSelect($('.ajax-select'));

    if (localStorage.getItem("lastUsed") !== null) {
        var lastUsed = JSON.parse(localStorage.getItem("lastUsed"));
        $(".last-used").append("<p>Недавно смотрели:</p><div class='search-results'></div>");
        for (var i = 0; i < lastUsed.length; i++) {
            $(".search-results").append('<a class="search-result" href="/'+lastUsed[i]+'"><div class="result-name">'+lastUsed[i]+'</div></a>');
        }
    }
</script>
</body>
</html>