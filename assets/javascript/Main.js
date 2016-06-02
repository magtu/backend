$(function () {

    var Main = {

        run: function () {
            this.footerMove();
            this.select2init();
            this.date();
            this.hideGroupsComponent();
            this.changeWeek();
            this.setToCurrent();
        },
        resizeFunctions: function () {
            if ($(window).outerWidth() > 560) {
                $('.head-search-form').show();
            } else {
                //$('.head-search-form').hide();
            }
        },
        scrollFunctions: function () {
            this.headMinification();
        },
        hideSearch: function () {
            $('.group-name').on('click', function () {
                if ($(window).outerWidth() <= 560) {
                    $('.head-search-form').toggle()
                } else {
                    $('.head-search-form').show()
                }
            });
            $(document).on('click', function (event) {
                if ($(window).outerWidth() <= 560) {
                    if ($(event.target).closest(".group-name, .head-search-form").length)
                        return;
                    $(".head-search-form").hide();
                    console.log(2);
                    event.stopPropagation();
                } else {
                    $('.head-search-form').show()
                }
            });
        },

        setToCurrent: function () {
            scrollToCurrentDay();
            accentCurrentLess();
            setInterval(accentCurrentLess(), 10000);
            function scrollToCurrentDay() {
                var date = new Date();
                var week = (date.getWeek() + 1) % 2;
                var day = date.getDay();
                var canScroll = true;
                $(document).on('click scroll mousedown touchstart', function () {
                    canScroll = false
                });
                if (week == 1) {
                    $('#week-2').removeClass('hide');
                    $('#week-1').addClass('hide');
                } else {
                    $('#week-1').removeClass('hide');
                    $('#week-2').addClass('hide');
                }
                setTimeout(function () {
                    var day_selector = '#day-' + (week + 1) + '-' + day;
                    if (canScroll && $(day_selector).offset().top + +$(day_selector).outerHeight() > window.pageYOffset + window.innerHeight) {
                        $.scrollTo(day_selector, 1600, {queue: true, offset: -47});
                    }
                }, 2500);
            }

            function accentCurrentLess() {
                var date = new Date();
                var week = (date.getWeek() + 1) % 2;
                var day = date.getDay();
                var time = date.getHours() * 60 + date.getMinutes();
                var lessNum = 0;
                switch (true) {
                    case (8 * 60 + 00 < time && time < 9 * 60 + 30):
                        lessNum = 1;
                        break;
                    case (9 * 60 + 40 < time && time < 11 * 60 + 20):
                        lessNum = 2;
                        break;
                    case (11 * 60 + 20 < time && time < 12 * 60 + 50):
                        lessNum = 3;
                        break;
                    case (13 * 60 + 30 < time && time < 15 * 60 + 00):
                        lessNum = 4;
                        break;
                    case (15 * 60 + 10 < time && time < 16 * 60 + 40):
                        lessNum = 5;
                        break;
                    case (16 * 60 + 50 < time && time < 18 * 60 + 20):
                        lessNum = 6;
                        break;
                    case (18 * 60 + 30 < time && time < 20 * 60 + 00):
                        lessNum = 7;
                        break;
                    case (20 * 60 + 10 < time && time < 21 * 60 + 40):
                        lessNum = 8;
                        break;
                    default:
                        break;
                }
                var less_selector = '#less-' + (week + 1) + '-' + day + '-' + lessNum;
                $(less_selector).parent().addClass('currentLess');
            }

        },
        headMinification: function () {
            if (window.pageYOffset > $('.head').outerHeight()) {
                $('.head-min').slideDown('min');
            } else {
                $('.head-min').slideUp('min');
            }
        },
        select2init: function () {
            $('.head-select,.head-group-select').select2({
                multiple: true,
                maximumSelectionLength: 1,
                minimumInputLength: 1,
                placeholder: "Найди свою группу...",
                language: {
                    inputTooShort: function () {
                        return 'Введите хотя бы 1 букву';
                    },
                    maximumSelected: function () {
                        return 'Ошибка. Попробуёте ещё раз';
                    },
                    searching: function () {
                        return 'Поиск…';
                    },
                    noResults: function () {
                        return 'Совпадений не найдено';
                    },
                    loadingMore: function () {
                        return 'Загрузка данных…';
                    },
                    errorLoading: function () {
                        return 'Невозможно загрузить результаты';
                    }
                },
                ajax: {
                    url: '/api/v1/groups/',
                    dataType: "json",
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page
                        };
                    },
                    results: function (data) {
                        return {results: data, text: 'name'};
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.name,
                                    id: item.id
                                }
                            })
                        };
                    },
                    formatSelection: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.name,
                                    id: item.id
                                }
                            })
                        };
                    }
                }
            });
        },
        changeWeek: function () {
            $('.week-name').on('click', function () {
                $('.week').toggleClass('hide');
            });
        },
        hideGroupsComponent: function () {
            var btn1 = $('.subgroup-btn-1');
            var btn2 = $('.subgroup-btn-2');
            var btn3 = $('.subgroup-btn-3');
            var group1 = $('.group-1');
            var group2 = $('.group-2');
            var group3 = $('.group-3');
            var div = $('div');
            btn1.show();
            btn2.show();
            btn3.show();
            if (!div.is('.group-1')) {
                btn1.hide();
            }
            if (!div.is('.group-2')) {
                btn2.hide();
            }
            if (!div.is('.group-3')) {
                btn3.hide();
            }
            function showG(group) {
                group.parent().slideDown().removeClass('folded');
                group.parent().parent().addClass('haveLess');
                group.parent().parent().parent().removeClass('empty');
            }

            function hideG(group) {
                group.parent().slideUp().addClass('folded');
                group.each(function () {
                    var _this = $(this);
                    var f = _this.parent().parent().parent().find('.less-wrap').is(':not(".folded")');
                    if (!f) {
                        _this.parent().parent().removeClass('haveLess');
                        _this.parent().parent().parent().addClass('empty');
                    }
                });
            }

            btn1.on('click', function () {
                $(":not('.group-1') + .info").slideUp();
                showG(group1);
                hideG(group2);
                hideG(group3);
            });
            btn2.on('click', function () {
                $(":not('.group-2') + .info").slideUp();
                showG(group2);
                hideG(group1);
                hideG(group3);
            });
            btn3.on('click', function () {
                $(":not('.group-3') + .info").slideUp();
                showG(group3);
                hideG(group1);
                hideG(group2);
            });
            $('.subgroup-btn-0').on('click', function () {
                showG(group1);
                showG(group2);
                showG(group3);
            });
        },
        date: function () {
            var days = ['Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота', 'Воскресенье'];
            var months = ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря',];

            function date() {
                var date = new Date();
                $('.date').text(date.getDate() + ' ' + months[date.getMonth()]);
                $('.hours').text(date.getHours());
                $('.minutes').text(date.getMinutes());
                $('.weekday').text(days[date.getDay() - 1]);
            }

            date();
            setInterval(date, 30000);
        },

        
            // function allocateLessons(data) {
            //     for (var w = 0; w < data.length; w++) {
            //         var week = data[w];
            //         for (var d = 0; d < week['days'].length; d++) {
            //             var day = week['days'][d];
            //             for (var l = 0; l < day['events'].length; l++) {
            //                 var event = day['events'][l];
            //                 var lessonHtml = '' +
            //                     '<div class="less-wrap">' +
            //                     '<div class="less group-' + event['subgroup'] + '">' +
            //                     '<div class="title">' + event['course'] + '</div>' +
            //                     '<div class="ad clearfix">' + event['type'] + '' +
            //                     '<div class="teacher">' + event['teacher'] + '</div>' +
            //                     '</div>' +
            //                     '<div class="aud">' + event['location'] + '</div>' +
            //                     '</div>';
            //                 var lessonCell = $('#less-' + week['week_id'] + '-' + day['day_id'] + '-' + event['event_index']);
            //                 var dayCell = $('#day-' + week['week_id'] + '-' + day['day_id']);
            //                 lessonCell.addClass('haveLess');
            //                 dayCell.addClass('haveLess');
            //                 lessonCell.parent().removeClass('empty');
            //                 lessonCell.append(lessonHtml);
            //             }
            //         }
            //     }
            //     $.each($('.day'), function(){
            //         var _this = $(this);
            //         _this.find('table tr:not(.empty)').last().nextAll('.empty').detach();
            //     })
            // }

        footerMove: function () {
            var ua = navigator.userAgent.toLowerCase();
            var isOpera = (ua.indexOf('opera') > -1);
            var isIE = (!isOpera && ua.indexOf('msie') > -1);
            var viewportHeight = getViewportHeight();
            var wrapper = $("main");
            var footer = $("footer");

            function getViewportHeight() {
                return ((document.compatMode || isIE) && !isOpera)
                    ? (document.compatMode == 'CSS1Compat') ? document.documentElement.clientHeight : document.body.clientHeight : (document.parentWindow || document.defaultView).innerHeight;
            }

            wrapper.css("min-height", viewportHeight - footer.outerHeight(true));
        }
    };
    window.Application.addComponent("Main", Main);
});
