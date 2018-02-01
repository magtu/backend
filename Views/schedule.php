<!DOCTYPE html>
<html lang="ru">
<head>
    <? include_once("templates/meta.php"); ?>
</head>
<body>
<main>
    <div class="page-wrap">
        <div class="content clearfix">
            <? include_once("templates/header.php"); ?>
            <?php
            for ($w = 0; $w < count($data['schedule']); $w++) {
                $week = $data['schedule'][$w];
                ?>
                <div class="week" id="week-<?= $w + 1; ?>">
                    <div class="week-name"><?= $week['week']; ?></div>
                    <div class="main-table">
                        <table>
                            <tr>
                                <?
                                for ($d = 0; $d < 6; $d++) {
                                    $day = $week['days'][$d];
                                    ?>
                                    <td class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="day" id="day-<?= $w + 1 ?>-<?= $d + 1 ?>">
                                            <div class="day-name"><?= $day['day'] ?></div>
                                            <table>
                                                <?
                                                $events = $day['events'];
                                                $haveLesson = array();
                                                $maxLesson = 0;
                                                foreach ($events as $event) {
                                                    if ($event['event_index'] > $maxLesson) {
                                                        $maxLesson = $event['event_index'];;
                                                    }
                                                    $haveLesson[$event['event_index']] = true;
                                                }
                                                if ($maxLesson > 0) {
                                                    for ($l = 1; $l <= $maxLesson; $l++) {

                                                        if (!empty($haveLesson[$l])) { ?>
                                                            <tr>
                                                                <td class="less-<?= $l ?> haveLess"
                                                                    id="less-<?= $w . "-" . $d . "-" . $l ?>">
                                                                    <div class="less-wrap">
                                                                        <?
                                                                        foreach ($events as $event) {
                                                                            if ($event['event_index'] != $l) {
                                                                                continue;
                                                                            }
                                                                            ?>
                                                                            <div
                                                                                class="less group-<?= $event['subgroup'] ?>">
                                                                                <div
                                                                                    class="title"><?= $event['course'] ?></div>
                                                                                <div class="ad clearfix">
                                                                                    <?= $event['type'] ?>
                                                                                    <div class="teacher">
                                                                                        <a href="/<?= $event['reverse'] ?>"><?= $event['reverse'] ?></a>
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="aud"><?= $event['location'] ?></div>
                                                                            </div>
                                                                        <? } ?>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        <? } else {
                                                            echo '<tr class="empty"></tr>';
                                                        }
                                                    }
                                                } else {
                                                    echo '<tr class="emptyDay"></tr>';
                                                } ?>
                                            </table>
                                        </div>
                                    </td>
                                    <?
                                    if ($d == 1 || $d == 3) {
                                        ?>
                                        <td class="col-sm-12 visible-sm separator"></td>
                                        <?
                                    }
                                    if ($d == 2) {
                                        ?>
                                        <td class="col-md-12 visible-md visible-lg separator"></td>
                                        <?
                                    }
                                } ?>
                            </tr>
                        </table>
                    </div>
                </div>
                <?
            }
            ?>
            <div id="vk_community_messages"></div>
            <script type="text/javascript">
                function vkMessages() {
                    VK.Widgets.CommunityMessages("vk_community_messages", 114684821, {
                        disableButtonTooltip: "1"
                    });
                }
            </script>
        </div>
    </div>
</main>
<footer>
    <br><b>Внимание!</b> Возможны ошибки в расписании. Напишите, если обнаружили неточности: <a href="https://vk.com/topic-114684821_33345488" target="_blank" rel="noopener">Официальная группа Вконтакте</a>
    <div id="vkshare"><script type="text/javascript">
            function vkShare () {
                document.write(VK.Share.button(false,{type: "round", text: "Поделиться расписанием"}));
            }
    </script></div>
</footer>
</body>
<script type="text/javascript">(window.Image ? (new Image()) : document.createElement('img')).src = location.protocol + '//vk.com/rtrg?r=Z*fXNNj0X4TqohkrxTFdMSN*l8z6tO1igT9UrB2oo2t9mu4GumjXVQMkLzNzHI6tjaD/UjmFsD*lttKCdAGZ5EZiAAg18NIPxYWqlnI0IEclP4KJ3YltgDBhv7r*iyEGWcsmPqPm8BRPxwnndHsHWceOVi*CJewJvYL24*2BtBc-&pixel_id=1000076630';</script>
<script type="text/javascript" onload="vkMessages" src="//vk.com/js/api/openapi.js?139"></script>
<script type="text/javascript" onload="vkShare" src="https://vk.com/js/api/share.js?94" charset="windows-1251"></script>

<script src="js/jquery.min.js"></script>
<script src="js/myAjaxSelect.js"></script>
<script src="js/jquery.scrollTo.min.js"></script>
<script src="js/Global.js"></script>
<script src="js/Main.js"></script>
<script>
    myAjaxSelect($('.ajax-select'));

    //==============================
    //   LAST SCHEDULES VIEWER
    //==============================
    var has_ads = false;
    localStorage.setItem("ad_removed", 1);
    if (localStorage.getItem("lastUsed") !== null || has_ads) {
        var lastUsed = JSON.parse(localStorage.getItem("lastUsed"));
        if (lastUsed[0] != "<?=$data['name']?>" || lastUsed[1] !== null) { //Не является ли текущая страница единственной в закладках
            $(".last-used").append("<div class='header-lastused'></div>");
            for (var i = 0; i < lastUsed.length; i++) {
                if (lastUsed[i] != "<?=$data['name']?>")
                    $(".header-lastused").append('<div class="lu-item clearfix"><a href="/' + lastUsed[i] + '">' + lastUsed[i] + '</a><div class="close-btn" onclick="removeLastUsed($(this))"></div></div>');
            }
        }
        var ad_href = 'https://vk.com/drama_mgn?w=wall-8293739_9299';

        if (localStorage.getItem("ad_removed") != 1) {
            $(".header-lastused").append('<div id="item007" class="lu-item clearfix"><a href="' + ad_href + '" target="_blank">11 декабря 18:30</a><div class="close-btn" onclick="removeAd()"></div></div>')
        }
    }
    function removeLastUsed(btnEl){
        var ulItem = btnEl.parents(".lu-item");
        var name = ulItem.find("a").text();
        var lastUsedData = JSON.parse(localStorage.getItem("lastUsed"));
        lastUsedData.splice(lastUsedData.indexOf(name), 1);
        localStorage.setItem("lastUsed", JSON.stringify(lastUsedData));
        ulItem.detach();
    }
    function removeAd(){
        var ulItem = $("#item007");
        localStorage.setItem("ad_removed", 1);
        ulItem.detach();
    }


    //==============================
    //   LAST SCHEDULES ADDER
    //==============================
    if (localStorage.getItem("lastUsed") === null) {
        var lastUsed = [];
    } else {
        var lastUsed = JSON.parse(localStorage.getItem("lastUsed"));
    }
    if (lastUsed.indexOf("<?=$data['name']?>") == -1) {
        lastUsed = lastUsed.slice(0, 9);
        lastUsed.unshift("<?=$data['name']?>");
        localStorage.setItem("lastUsed", JSON.stringify(lastUsed));
    } else {
        lastUsed.splice(lastUsed.indexOf("<?=$data['name']?>"), 1);
        lastUsed.unshift("<?=$data['name']?>");
        localStorage.setItem("lastUsed", JSON.stringify(lastUsed));
    }
</script>

</html>
