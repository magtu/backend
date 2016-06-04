<?
include "day.php";
function renderWeek($week) {
    ?>
    <div class="main-table">
        <table>
            <tr>
    <?for ($d = 0; $d < 6; $d++) {
        renderDay($week['days'][$d]);
    }?>
            </tr>
        </table>
    </div>
    </div>
<?}?>