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
<main>
   <div class="page-wrap">
      <div class="content clearfix">
         <div class="head clearfix">
            <div class="logo"></div>
            <div class="date-wrap">
               <div class="time">
                  <div class="hours"></div>
                  <span>:</span>
                  <div class="minutes"></div>
               </div>
               <div class="weekday"></div>
               <div class="date"></div>
            </div>
            <div class="group-name">
               <?=$data['name']?>
            </div>
            <div class="ajax-select-wrap head-select">
               <input type="text" class="ajax-select" placeholder="Найди группу">
            </div>
         </div>
         <div class="head-min clearfix">
            <div class="date-wrap">
               <div class="time">
                  <div class="hours"></div>
                  <span>:</span>
                  <div class="minutes"></div>
               </div>
               <div class="weekday"></div>
               <div class="date"></div>
            </div>
            <div class="group-name"></div>
         </div>
         <div class="main-table-wrap">
            <?php
            for ($w = 0; $w < count($data['schedule']); $w++) {
               $week = $data['schedule'][$w];
               ?>
               <div class="week" id="week-<?=$w+1;?>">
                  <div class="week-name"><?=$week['week'];?></div>
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

                                             if (!empty($haveLesson[$l])) {?>
                                                <tr>
                                                   <td class="less-<?= $l ?> haveLess" id="less-<?= $w . "-" . $d . "-" . $l ?>">
                                                      <div class="less-wrap">
                                                         <?
                                                         foreach ($events as $event) {
                                                            if ($event['event_index'] != $l) { continue; }
                                                            ?>
                                                            <div class="less group-<?= $event['subgroup'] ?>">
                                                               <div class="title"><?= $event['course'] ?></div>
                                                               <div class="ad clearfix">
                                                                  <?= $event['type'] ?>
                                                                  <div class="teacher">
                                                                     <a target="_blank" href="/<?= $event['reverse'] ?>"><?= $event['reverse'] ?></a>
                                                                  </div>
                                                               </div>
                                                               <div class="aud"><?= $event['location'] ?></div>
                                                            </div>
                                                         <?}?>
                                                      </div>
                                                   </td>
                                                </tr>
                                             <?} else {
                                                echo '<tr class="empty"></tr>';
                                             }
                                          }
                                       } else {
                                          echo '<tr class="emptyDay"></tr>';
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
                           }?>
                        </tr>
                     </table>
                  </div>
               </div>
               <?
            }
            ?>

            <div class="warning-msg">
               <span class="msg-h">Внимание!</span> Сайт находится на стадии разработки, поэтому возможны ошибки в
               расписании. Напишите, если обнаружили неточности: <a href="https://vk.com/topic-114684821_33345488" target="_blank">ССЫЛКА</a>
            </div>
         </div>
      </div>
</main>
<footer></footer>
<script src="js/jquery.min.js"></script>
<script src="js/select2.min.js"></script>
<script src="js/jquery.scrollTo.min.js"></script>
<script src="js/Global.js"></script>
<script src="js/Main.js"></script>
<script src="js/myAjaxSelect.js"></script>
<script>
   myAjaxSelect($('.ajax-select'));
</script>
</body>
</html>
