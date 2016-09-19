<?
include "lesson.php";
function renderDay($day) {
    ?>
    <td class="col-xs-12 col-sm-6 col-md-4">
        <div class="day" id="day-<?= $w + 1 ?>-<?= $d + 1 ?>">
            <div class="day-name"><?= $day['name'] ?></div>
            <table>
        <?
        $maxLesson = 0;
        foreach ($lessons as $lesson) {
            foreach ($lesson as $lessonInGroup) {
                if ($lessonInGroup['event_index'] > $maxLesson) {
                    $maxLesson = $lessonInGroup['event_index'];
                }
            }   
        }
        if ($maxLesson) {
            for ($l = 1; $l <= $maxLesson; $l++) {
                renderLesson($lessons[$l],$w,$d,$l);
            }
        } else {
            echo "<tr class='emptyDay'></tr>";
        }?>
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
}