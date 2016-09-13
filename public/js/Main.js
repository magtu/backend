$(function () {

    var Main = {

        run: function () {
            this.footerMove();
            this.select2init();
            this.viewSearch();
            this.viewTable();
            this.date();
            this.changeWeek();
            this.select2init();
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
        viewTable: function () {
            $('.search-section').fadeOut();
            setTimeout(function () {
                $('main').fadeIn();
            }, 500);
        },
        viewSearch: function () {
            $('.search-section').fadeIn();
        },
        select2init: function () {
            $('#group-select, #head-group-select').select2({
                multiple: true,
                maximumSelectionLength: 1,
                minimumInputLength: 1,
                placeholder: "Найди группу...",
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
            $('#teacher-select,#head-teacher-select').select2({
                multiple: true,
                maximumSelectionLength: 1,
                minimumInputLength: 1,
                placeholder: "Найди преподавателя...",
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
                    url: '/api/v1/teachers/',
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
        openHomework: function () {
            $(".less").on('click', function () {
                $(".info").not($(this).next(".info")).slideUp();
                $(this).next(".info").slideToggle();
            });
        },
        date: function () {
            var days = ['Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'];
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
})
