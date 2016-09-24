<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, user-scalable=no">

    <link rel="apple-touch-icon" sizes="57x57" href="/icons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/icons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/icons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/icons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/icons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/icons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/icons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/icons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/icons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/icons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/icons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/icons/favicon-16x16.png">
    <link rel="manifest" href="/icons/manifest.json">
    <meta name="msapplication-TileColor" content="#1A5573">
    <meta name="msapplication-TileImage" content="/icons/ms-icon-144x144.png">

    <meta name="description"
          content="Расписание занятий для студентов МГТУ им. Носова. Удобный просмотр с любых устройств!">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=latin,cyrillic'
          rel='stylesheet' type='text/css'>
    <link href="css/template_styles.css" type="text/css" rel="stylesheet"/>
    <title>Расписание МГТУ им. Носова</title>
    <meta name="theme-color" content="#1A5573">
</head>
<body>

<header>
    <div class="top-menu clearfix">

    </div>
</header>
<div class="error-block">
    <section class="search-section">
        <h1 class="error-code">404</h1>
        <h2>Страница не найдена</h2>
        <h3>Попробуйте воспользоваться поиском</h3>
        <div class="group-search">
            <div class="ajax-select-wrap">
                <input type="text" class="ajax-select" placeholder="Найди группу">
            </div>
        </div>
    </section>
</div>

<footer></footer>
<script src="js/jquery.min.js"></script>
<script src="js/myAjaxSelect.js"></script>
<script>
    myAjaxSelect($('.ajax-select'));
</script>
</body>
</html>
