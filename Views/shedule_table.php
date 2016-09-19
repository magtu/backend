<?
$days = array('Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота');
for ($w = 0; $w < 2; $w++) {
    if ($w == 0) { ?>
        <div class="week" id="week-1">
        <div class="week-name">Нечётная</div>
    <? } else { ?>
        <div class="week hide" id="week-2">
        <div class="week-name">Чётная</div>
    <? } ?>
    <div class="main-table">
        <table>
            <tr>
                <? for ($d = 0; $d < 6; $d++) { ?>
                    <td class="col-xs-12 col-sm-6 col-md-4">
                        <div class="day" id="day-<?= $w + 1 ?>-<?= $d + 1 ?>">
                            <div class="day-name"><?= $days[$d] ?></div>
                            <table>
                                <? for ($l = 0; $l < 8; $l++) { ?>
                                    <tr class="empty">
                                        <td class="less-<?= $l + 1 ?>"
                                            id="less-<?= $w + 1 ?>-<?= $d + 1 ?>-<?= $l + 1 ?>"></td>
                                    </tr>
                                <? } ?>
                            </table>
                        </div>
                    </td>
                    <? if ($d == 1 || $d == 3) { ?>
                        <td class="col-sm-12 visible-sm separator"></td>
                    <? } ?>
                    <? if ($d == 2) { ?>
                        <td class="col-md-12 visible-md visible-lg separator"></td>
                        <?
                    }
                } ?>
            </tr>
        </table>
    </div>
    </div>
<? } ?>