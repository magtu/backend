<?
function renderLesson($lessons,$w,$d,$l) {
    $haveLessInGroup = false;
    foreach ($lessons as $lesson) {
        $haveLessInGroup = true;
    }
    if ($haveLessInGroup) {?>
    <tr>
        <td class="less-<?= $l ?> haveLess" id="less-<?= $w . "-" . $d . "-" . $l ?>">
            <div class="less-wrap">
    <?
    foreach ($lessons as $lesson) {
    ?>
                <div class="less group-<?= $lesson['subgroup'] ?>">
                    <div class="title"><?= $lesson['course'] ?></div>
                    <div class="ad clearfix">
                        <?= $lesson['type'] ?>
                        <div class="teacher"><?= $lesson['teacher'] ?></div>
                    </div>
                    <div class="aud"><?= $lesson['location'] ?></div>
                </div>

    <?}?>
            </div>
        </td>
    </tr>
    <?} else {
       echo "<tr class='empty'></tr>";
    }
}