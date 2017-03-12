<!DOCTYPE html>
<html>
<head>
    <? include_once("templates/meta.php"); ?>
    <script src="js/jquery.min.js"></script>
    <script src="js/myAjaxSelect.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/Global.js"></script>
    <script src="js/Main.js"></script>
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
                VK.Widgets.CommunityMessages("vk_community_messages", 114684821, {expanded: "1",tooltipButtonText: "Свяжитесь с нами!"});
            </script>
        </div>
    </div>
</main>
<footer>
    <b>Внимание!</b> Возможны ошибки в расписании. Напишите, если обнаружили неточности: <a href="https://vk.com/topic-114684821_33345488" target="_blank">Официальная группа Вконтакте</a>
</footer>
<script>
    myAjaxSelect($('.ajax-select'));

    //==============================
    //   LAST SCHEDULES VIEWER
    //==============================

    if (localStorage.getItem("lastUsed") !== null) {
        var lastUsed = JSON.parse(localStorage.getItem("lastUsed"));
        if (lastUsed[0] != "<?=$data['name']?>" || lastUsed[1] !== null) { //Не является ли текущая страница единственной в закладках
            $(".last-used").append("<div class='header-lastused'></div>");
            for (var i = 0; i < lastUsed.length; i++) {
                if (lastUsed[i] != "<?=$data['name']?>")
                    $(".header-lastused").append('<div class="lu-item clearfix"><a href="/' + lastUsed[i] + '">' + lastUsed[i] + '</a><div class="close-btn" onclick="removeLastUsed($(this))"></div></div>');
            }
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

</body>
</html>
