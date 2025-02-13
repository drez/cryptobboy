var isSelected_IarcAutoc = 0;
var isSelected_IarcAutoccShow = 0;
var CCautocSuccessIarc = '';
var CCautocChangeIarc = '';
var CCautocSearchIarc = '';
var CCautocFocusIarc = '';

var default_width = 0;
var default_height = 0;
var fullscreen_timer;
var fullscreen_click = false;

var act_confirm = '';
var alert_close = '';
var has_search = true;
var act_negatif = '';

window.confirm = function (obj, act_t) {
    act_confirm = act_t;
    $('#confirm_text').html(obj);
    $('#confirmDialog').dialog('open');
};

window.onload = function () {
    if (location.hash) { window.scrollTo(0, 0); }
};
function sleep(milliseconds) {
    var start = new Date().getTime();
    for (var i = 0; i < 1e7; i++) {
        if ((new Date().getTime() - start) > milliseconds) {
            break;
        }
    }
}

$(function() {
    $(window).focus(function () {
      checkAlive();
    });

  $(window).blur(function () {
      checkAlive();
    });
});

let checkedAlive = false;
checkAlive = () => {

  if (!checkedAlive) { 
      $.post(_SITE_URL + 'GuiManager', { a: 'alive' }, function (data) {
          if (data['status'] == 'success') { } else { 
              location.reload();
          }
    }, 'json') .fail(function(error) {  location.reload(); });;
  }
  checkedAlive = true;
  setTimeout(function(){ checkedAlive=false; }, 10000);
}

$(document).keypress(function (e) {
    /* Backspace */
    if (e.keyCode === 8 && !$(document.activeElement).is('input') && !$(document.activeElement).is('textarea')) {
        return false;
    };
});

$(document).ready(function () {

    $(document).bind('keydown', function (event) {
        if ($('.can-save').length) {
            if (event.ctrlKey || event.metaKey) {
                if (String.fromCharCode(event.which).toLowerCase() == 's') {
                    $('.can-save').trigger('click');
                    event.preventDefault();
                }
            }
        }
    });

    if (navigator.platform == 'iPad' || navigator.platform == 'iPhone' || navigator.platform == 'iPod') {
        $('.sw-header').css('position', 'absolute');
        $('.content-wrapper').css('top', '0px');
        $('.custom-controls-add').css({ 'display': 'inline-block', 'float': 'none' });
        $('.custom-controls').css({ 'display': 'inline-block', 'float': 'none' });
    }

    $('.center-panel').on({
        'touchmove': function (e) {
            $('.sw-header').css('position', 'fixed');
        }
    });
    $('.scroll-top').click(function () {
        $('.content-wrapper').scrollTop(0);
    });

    $('body').on('click', '.trigger-menu', function () {
        $('#body').toggleClass('toggle-left-panel');
        return false;
    });

    if ($('.trigger-search').css('display') !== 'none') {
        $('.msSearchCtnr').slideUp(500);
        $('.trigger-search span').text('Show search');
    }

    $('body').on('click', '.trigger-search', function () {
        if ($('.msSearchCtnr').css('display') == 'none') {
            $('.msSearchCtnr').slideDown(500);
            $('.trigger-search span').text('Hide search');
        } else {
            $('.msSearchCtnr').slideUp(500);
            $('.trigger-search span').text('Show search');
        }

        return false;
    });

    /*  overflow div content*/
    $(window).resize(function () {
        var w = $(window).width();
        if (w > 583) {
            $('.ac-header .right').removeAttr('style');
        }
        if (w > 1128) {
            $('.ac-list-form-header .msSearchCtnr').removeAttr('style');
        }
        setDivContent();
    });
    setDivContent();

    $('.ui-tabs .ui-tabs-nav').css('padding', '0');
    $('.ui-widget').css('font-size', '.8em');
    /* dialog*/
    $('#editDialog').dialog({
        collision: 'none', hide: 'fade', show: 'fade'
        , modal: true, autoOpen: false, width: 'auto', height: 'auto', autoResize: true, overlay: { backgroundColor: '#000', opacity: 0.5 }
        , open: function (event, ui) {
            dialogWidthClass($(this)); $('.ui-dialog-titlebar-close .ui-corner-all').focus(); try {
                return beforeDialogOpen();
            } catch (e) { }
        }
        , beforeClose: function (event, ui) {
            try { return onDialogBeforeClose(event, ui); } catch (e) { }
        }
        , focus: function (event, ui) {
            try {
                return onDialogFocus();
            } catch (e) { }
        }
        , resize: function (event, ui) {
            dialogWidthClass($(this));
        }
        , dragStart: function (event, ui) {
            $('.js-select-label.show').close();
        }
        , close: function (event, ui) {
            try {
                return onDialogClose();
            } catch (e) { }
        }
    });

    $('#loadingDialog').dialog({
        collision: 'none', hide: 'fade', show: 'fade'
        , resizable: false, closeText: 'hide', dialogClass: 'no-close', modal: true, autoOpen: false, width: '80', autoResize: false
        , overlay: { backgroundColor: '#000', opacity: 0.5 }
        , resize: function (event, ui) {
            dialogWidthClass($(this));
        }
        , dragStart: function (event, ui) {
            $('.js-select-label.show').close();
        }
        , open: function (event, ui) {
            dialogWidthClass($(this));
            $(this).parent().children('.ui-dialog-titlebar').hide();
        },
    });

    $('#editPopupDialog').dialog({
        collision: 'none', hide: 'fade', show: 'fade'
        , modal: true, autoOpen: false, width: 'auto', height: 'auto', autoResize: true
        , overlay: { backgroundColor: '#000', opacity: 0.5 }
        , open: function (event, ui) {
            dialogWidthClass($(this)); $('.ui-dialog-titlebar-close .ui-corner-all').focus(); try {
                return beforeDialogOpen();
            } catch (e) { }
        }
        , beforeClose: function (event, ui) {
            try {
                return onDialogBeforeClose(event, ui);
            } catch (e) { }
        }
        , focus: function (event, ui) {
            try {
                return onDialogFocus();
            } catch (e) { }
        }
        , resize: function (event, ui) {
            dialogWidthClass($(this));
        }
        , dragStart: function (event, ui) {
            $('.js-select-label.show').close();
        }
        , close: function (event, ui) {
            try {
                if ($(this).hasClass('ac-autocomplete')) {
                    $(body).removeClass('ac-no-overflow');
                    $('#editPopupDialog').removeClass('ac-autocomplete').height('auto');
                }
                return onDialogClose();
            } catch (e) { }
        }
    });


    $('#confirmDialog').dialog({
        collision: 'none', hide: 'fade', show: 'fade'
        , create: function (event, ui) {
            $('#confirmDialog').parents('.ui-dialog').find('.ui-dialog-title').attr('id', 'ui-dialog-title-confirmDialog');
        }
        , dialogClass: 'dialog-message', resizable: false, modal: true, autoOpen: false, width: '430', height: 'auto', autoResize: false, overlay: { backgroundColor: '#000', opacity: 0.5 },
        open: function (event, ui) {
            dialogWidthClass($(this));
            $('.ui-dialog-titlebar-close .ui-corner-all').focus();
            try { return beforeDialogOpen(); } catch (e) { }
        }
        , beforeClose: function (event, ui) {
            try {
                return onDialogBeforeClose(event, ui);
            } catch (e) { }
        }
        , focus: function (event, ui) {
            try { return onDialogFocus(); } catch (e) { }
        }
        , close: function (event, ui) {
            try { return onDialogClose(); } catch (e) { }
            $('[role=\"button\"][type=\"button\"]').show();
            $('#title_confirm').html('Message');
            $('#confirm_text').html('');
            $('#confirmDialog').dialog({ height: 'auto', width: 430 });
        }
        , resize: function (event, ui) {
            dialogWidthClass($(this));
        }
        , dragStart: function (event, ui) {
            $('.js-select-label.show').close();
        }
        , buttons: [{
            text: 'Yes', 'class': 'button-link-blue', click: function () {
                if ($.isFunction(act_confirm)) {
                    act_confirm();
                } else { eval(act_confirm); }

                $('#confirmDialog').dialog({ height: 'auto', width: 430 });
                setTimeout(function () {
                    $('#confirmDialog').dialog('close');
                }, 100);
            }
        },
        {
            text: 'No', 'class': 'button-link-gray', click: function () {
                if ($.isFunction(act_negatif)) {
                    act_negatif();
                } else {
                    eval(act_negatif);
                }

                $('#confirmDialog').dialog({ height: 'auto', width: 430 });
                setTimeout(function () {
                    $('#confirmDialog').dialog('close');
                }, 100);
            }
        }]
    });

    $('#alertDialog').dialog({
        collision: 'none', hide: 'fade', show: 'fade'
        , create: function (event, ui) {
            $('#alertDialog').parents('.ui-dialog').find('.ui-dialog-title').attr('id', 'ui-dialog-title-alertDialog');
        }
        , dialogClass: 'dialog-message', resizable: false, modal: true, autoOpen: false, width: '430', height: 'auto', autoResize: false, overlay: { backgroundColor: '#000', opacity: 0.5 },
        open: function (event, ui) {
            dialogWidthClass($(this)); $('.ui-dialog-titlebar-close .ui-corner-all').focus(); try { return beforeDialogOpen(); } catch (e) { }
        }, beforeClose: function (event, ui) {
            try { return onDialogBeforeClose(event, ui); } catch (e) { }
        },
        focus: function (event, ui) {
            try { return onDialogFocus(); } catch (e) { }
        },
        resize: function (event, ui) {
            dialogWidthClass($(this));
        },
        dragStart: function (event, ui) {
            $('.js-select-label.show').close();
        },
        close: function (event, ui) {
            try {
                return onDialogClose();
            } catch (e) { }
            $('[role=\"button\"][type=\"button\"]').show();
            $('#title_alert').html('Message');
            $('#confirm_texte').show().html('');
            $('#alertDialog').dialog({ height: 'auto', width: 430 });
        }
        , buttons: {
            'Close': function () {
                $('#alertDialog').dialog('close');
                if ($.isFunction(alert_close)) {
                    alert_close();
                } else if (alert_close) {
                    eval(alert_close);
                }
                alert_close = null;
            }
        }
    });

    /* admin */
    $('body').on('click', '.sw-header .controls-button', function () {
        $('.custom-controls').toggleClass('toggle-sw-options');
        return false;
    });

    $('body').on('click', '.ui-widget-overlay', function () {
        $('#editDialog').dialog('close');
        return false;
    });

    $('.ui-dialog-titlebar.ui-widget-header').on('click', function () {
        if (fullscreen_click == true) {
            dialogFullscreen();
            clearTimeout(fullscreen_timer);
            fullscreen_click = false;
        } else {
            fullscreen_click = true;
            fullscreen_timer = setTimeout(function () {
                fullscreen_click = false;
                clearTimeout(fullscreen_timer);
            }, 300);
        }
    });

    $('.ui-dialog .ui-dialog-titlebar .ui-dialog-title').before('<a class="ui-fullscreen" href="#" title="Full screen">Full screen</a>');
    $('.ui-fullscreen').click(function () {
        dialogFullscreen();
        return false;
    });

    wrap_autoc('Iarc', 'Authy', 'Iarc', '', '', '', 'std', ",'Username': request.term,'Email': request.term", '', 'select-box-');

    $('.left-panel-wrapper #Iarc').change(function () {
        if ($('#select-box-Authy').data('authy') != $(this).val() && $(this).val() != '') {
            document.location = _SITE_URL + 'admin?iarc=' + $(this).val();
        }
    });

    $('body').on('click', '.scroll-top', function () {
        var in_popup = false;

        $('.ui-dialog').each(function () {
            if ($(this).is(':visible')) {
                in_popup = true;
                $(this).find('.ui-dialog-content').animate({ scrollTop: 0 }, 250);
            }
        });

        if (in_popup == false) {
            $('.content-wrapper').animate({ scrollTop: 0 }, 250);
        }

        return false;
    });

    $('.left-panel .disconnect').click(function () {
        confirm('Logout?', function () { document.location = _SITE_URL + 'Authy/logout'; });
        return false;
    });

    $('body').on('change', '.divStdform input, .divStdform select, .divStdform textarea', function () {
        $('.divtd input[type="button"]').addClass('can-save');
    });

    $('body').on('keydown', '.divStdform input, .divStdform textarea', function () {
        $('.divtd input[type="button"]').addClass('can-save');
    });

    $(".ac-menu > li").click(function (e) {
        if (!$(e.target).hasClass("ac-alert-count")) {
            var hasClass = $(this).hasClass("active");
            $(".ac-menu > li").removeClass("active");
            if (!hasClass) {
                $(".ac-menu > li ul").slideUp();
            }

            $(this).find("ul.sub-menu").slideDown();
            $(this).addClass("active");
        }
    });
    if ($(".ac-menu li .active").parents("ul").hasClass("sub-menu")) {
        $(".ac-menu li .active").parents("ul").show().parent().addClass("active");
    }
    var location = document.location.href.replace("'._SITE_URL.'", "").split("#");
    if (location[1]) {
        if ($("[jhref='#" + location[1] + "']").length > 0) {
            $("[jhref='#" + location[1] + "']").parent().addClass("active").find("ul").show();
        }
    }
});

function dialogWidthClass(element) {
    $('.js-select-label.show').close();
    var width = element.width(), elementMedia = 'no-media';

    if (width <= 1024) {
        if (width >= 768) { elementMedia = '1024'; }
        else if (width >= 640) { elementMedia = '768'; }
        else { elementMedia = '480'; }
    } else { elementMedia = 'none'; }

    element.attr('data-media', elementMedia);
}

var timerDivContent = 0;
var noPerfectScroll;
var noSetHeight;

function setDivContent() {
    $('html#html_build .ui-tabs-nav li').unbind('click.hideTabs');
    $('html#html_build .ui-tabs-nav li').bind('click.hideTabs', function () {
        $(this).parent().removeClass('shown');
    });
    $('.formContent [j=ogf]').unbind('click.ogf');
    $('.formContent [j=ogf]').bind('click.ogf', function (event) {
        dialogWidthClass($(this).parents('.ui-dialog-content'));
        p = $(this).attr('p'); ogf = $(this).attr('href');
        i = $('#pannelList .ui-state-active[p=' + p + '][act=edit]').attr('i');
        $.post(_SITE_URL + 'GuiManager', { a: 'ixogf', p: p, i: i, ogf: ogf }, function (data) { });
    });
}

function number_format(number, decimals, dec_point, thousands_sep) {
    number = (number + '').replace(',', '').replace(' ', '');
    var n = !isFinite(+number) ? 0 : +number, prec = !isFinite(+decimals) ? 0 : Math.abs(decimals), sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep, dec = (typeof dec_point === 'undefined') ? '.' : dec_point, s = '', toFixedFix = function (n, prec) {
        var k = Math.pow(10, prec);
        return '' + Math.round(n * k) / k;
    }; s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}

function setFrmHeight() {
    frheight = (document.documentElement.offsetHeight); document.getElementById("FRAME_ID").style.height = (frheight + "px");
    document.getElementById("FRAMEDIV_ID").style.display = 'block';
}

(function ($) {
    var splitVersion = $.fn.jquery.split(".");
    var major = parseInt(splitVersion[0]);
    var minor = parseInt(splitVersion[1]);
    var JQ_LT_17 = (major < 1) || (major == 1 && minor < 7);
    function eventsData($el) {
        return JQ_LT_17 ? $el.data('events') : $._data($el[0]).events;
    }
    function moveHandlerToTop($el, eventName, isDelegated) {
        var data = eventsData($el);
        var events = data[eventName];
        if (!JQ_LT_17) {
            var handler = isDelegated ? events.splice(events.delegateCount - 1, 1)[0] : events.pop();
            events.splice(isDelegated ? 0 : (events.delegateCount || 0), 0, handler);
            return;
        }
        if (isDelegated) {
            data.live.unshift(data.live.pop());
        } else {
            events.unshift(events.pop());
        }
    }
    function moveEventHandlers($elems, eventsString, isDelegate) {
        var events = eventsString.split(/\s+/);
        $elems.each(function () {
            for (var i = 0; i < events.length; ++i) {
                var pureEventName = $.trim(events[i]).match(/[^\.]+/i)[0];
                moveHandlerToTop($(this), pureEventName, isDelegate);
            }
        });
    }
    $.fn.bindFirst = function () {
        var args = $.makeArray(arguments);
        var eventsString = args.shift();
        if (eventsString) {
            $.fn.bind.apply(this, arguments);
            moveEventHandlers(this, eventsString);
        }
        return this;
    };

    $.fn.delegateFirst = function () {
        var args = $.makeArray(arguments);
        var eventsString = args[1];
        if (eventsString) {
            args.splice(0, 2);
            $.fn.delegate.apply(this, arguments);
            moveEventHandlers(this, eventsString, true);
        }
        return this;
    };
    $.fn.liveFirst = function () {
        var args = $.makeArray(arguments);
        args.unshift(this.selector);
        $.fn.delegateFirst.apply($(document), args);
        return this;
    };
    if (!JQ_LT_17) {
        $.fn.onFirst = function (types, selector) {
            var $el = $(this);
            var isDelegated = typeof selector === 'string';
            $.fn.on.apply($el, arguments);
            if (typeof types === 'object') {
                for (type in types)
                    if (types.hasOwnProperty(type)) {
                        moveEventHandlers($el, type, isDelegated);
                    }
            } else if (typeof types === 'string') {
                moveEventHandlers($el, types, isDelegated);
            }
            return $el;
        };
    }
    jQuery.fn.putCursorAtEnd = function () {
        return this.each(function () {
            $(this).focus();
            if (this.setSelectionRange) {
                var len = $(this).val().length * 2;
                this.setSelectionRange(len, len);
            } else {
                $(this).val($(this).val());
            }
            this.scrollTop = 999999;
        });
    };
})(jQuery);

function alertb(title, msg, close) {
    $('#alertDialog').parent().find('.ui-dialog-title').html(title);
    $('#alertDialog #alert_text').show().html(msg);
    if (close) {
        $('#alertDialog').dialog({ close: close });
    }
    $('#alertDialog').dialog('open');
}

function addslashes(str) {
    return (str + '').replace(/[\\"']/g, '\\$&').replace(/\u0000/g, '\\0');
}

function wrap_autoc(name, table, childTable, IdParent, Id, autoCpJsVar, version, paramD, ms, formParentStr, formParentFull) {
    var formParent = 'form' + table;
    if (formParentFull) {
        formParent = formParentFull;
    } else if (formParentStr) {
        formParent = formParentStr + table;
    } else if (ms == 1) {
        formParent = 'formMs' + table;
    }

    $('#' + formParent + ' #' + name + 'Autoc').autocomplete({
        position: { collision: 'flip' }
        , source: function (request, response) {
            var dataParam;
            eval('dataParam={maxRows:12,ip:$("#' + formParent + ' #' + name + 'Autoc").parents("form").attr("id"),a:"autoc",t:childTable' + paramD + '};');
            $.ajax({
                url: _SITE_URL + 'mod/act/' + table + 'Act.php'
                , dataType: 'json'
                , autoFocus: true
                , data: dataParam,
                success: function (data) {
                    if (data.count == 1) {
                        $('#' + formParent + ' #' + name + 'Autoc').val(data.data[0]['show']);
                        $('#' + formParent + ' #' + name + '').val(data.data[0]['id']);
                        $('#' + formParent + ' #' + name + '').change();
                        eval('isSelected_' + name + 'AutocShow=0;');
                    }
                    if (data.count != 0) {
                        resp = $.map(data.data, function (item) {
                            return { label: item.show, value: item.id }
                        });
                        response(resp);
                    } else {
                        if ($('.ui-menu-item :visible').length < 1) {
                            var resp = [{ value: 0, label: 'No results' }];
                            response(resp);
                            eval('isSelected_' + name + 'Autoc=0;');
                        }
                    }
                }, error: function () { $('#' + formParent + ' #' + name + 'Autoc').val('Error'); }
            });
        },
        select: function (event, ui) {
            if (ui.item.value != 0) {
                $('#' + formParent + ' #' + name + 'Autoc').val(ui.item.label);
                $('#' + formParent + ' #' + name + '').val(ui.item.value);
                $('#' + formParent + ' #' + name + '').change();
                setTimeout('$("#' + formParent + ' #' + name + 'Autoc").val("' + ui.item.label + '");', '50');
            } else {
                eval('isSelected_' + name + 'Autoc=0;');
                event.preventDefault();
                event.stopPropagation();
                return false;
            }

        },
        change: function (event, ui) {
            eval('CCautocChange' + name + ';');
            if ($('#' + formParent + ' #' + name + 'Autoc').val() == '') {
                $('#' + formParent + ' #' + name + '').val('');
            }
        },
        search: function (event, ui) {

        },
        focus: function (event, ui) {
            if (ui.item.value != 0) {
                eval('isSelected_' + name + 'Autoc="' + ui.item.value + '";');
                eval('isSelected_' + name + 'AutocShow="' + ui.item.label + '";');
                setTimeout(function () { $('#' + formParent + ' #' + name + 'Autoc').val(ui.item.label); }, 10);
            } else {
                event.preventDefault();
                event.stopPropagation();
                eval('isSelected_' + name + 'Autoc=0;');
                return false;
            }
        },
        minLength: 2
        , open: function () {
            $(this).removeClass('ui-corner-all').addClass('ui-corner-top');
        },
        close: function () {
            $(this).removeClass('ui-corner-top').addClass('ui-corner-top');
        }
    });

    $('#' + formParent + ' #' + name + 'Autoc').click(function () {
        $('#' + formParent + ' #' + name + 'Autoc').select();
    });

    $('#' + formParent + ' #' + name + 'Autoc').bind('focusout', function () {
        if ($('#' + formParent + ' #' + name + '').val() == '' && $('#' + formParent + ' #' + name + 'Autoc').val() != '') {
            va = $('#' + formParent + ' #' + name + 'Autoc').val();
            $.ajax({
                url: _SITE_URL + 'mod/act/' + table + 'Act.php', dataType: 'json', autoFocus: true
                , data: {
                    maxRows: 12, ip: $('#' + formParent + ' #' + name + 'Autoc').parents('form').attr('id')
                    , a: 'autoc', t: childTable, 'name': $('#' + formParent + ' #' + name + 'Autoc').val()
                    , 'phone': $('#' + formParent + ' #' + name + 'Autoc').val()
                    , 'email': $('#' + formParent + ' #' + name + 'Autoc').val()
                },
                success: function (data) {
                    if (data.count == 1) {
                        $('#' + formParent + ' #' + name + 'Autoc').val(data.data[0]['show']);
                        $('#' + formParent + ' #' + name + '').val(data.data[0]['id']);
                        $('#' + formParent + ' #' + name + '').change();
                        eval('isSelected_' + name + 'AutocShow=0;');
                    } else {
                        $('#' + formParent + ' #' + name + 'Autoc').attr('saisVal', $('#' + formParent + ' #' + name + 'Autoc').val());
                        $('#' + formParent + ' #' + name + 'Autoc').val('');
                        $('#' + formParent + ' #' + name + 'Autoc').data().autocomplete.term = 'undefined';
                    }
                    if ($('#' + formParent + ' #' + name + 'Autoc').val() == '') {
                        $('#' + formParent + ' #' + name + '').val('').change();
                    };
                }
            });
        }


    });

    setTimeout(function () {
        $('#' + formParent + ' #' + name + 'Autoc').unbind('keydown.Autoc');
        $('#' + formParent + ' #' + name + 'Autoc').bind('keydown.Autoc', function (e) {
            var coded = e.which;
            if (coded == 13 || coded == 9) {
                var isSelectedAutoc;
                var isSelectedAutocShow;
                eval('isSelectedAutoc = isSelected_' + name + 'Autoc;');
                eval('isSelectedAutocShow = isSelected_' + name + 'AutocShow;');
                if (isSelectedAutoc) {
                    $('#' + formParent + ' #' + name + 'Autoc').val(isSelectedAutocShow).change();
                    $('#' + formParent + ' #' + name).val(isSelectedAutoc).change();
                } else if ($('#' + formParent + ' #' + name + 'Autoc').val() == '' || $('#' + formParent + ' #' + name).val() == '') {
                    $('#' + formParent + ' #' + name).val('');
                    $('#' + formParent + ' #' + name).val('').change();
                }
            } else {
                $('#' + formParent + ' #' + name).val('').change();
            }
        });
    }, 1000);
    eval(autoCpJsVar);
}

function isNumber(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}

if (!String.prototype.trim) {
    String.prototype.trim = function () {
        return this.replace(/^\s+|\s+$/g, '');
    };
}

function colorField(id, color, containerId) {
    if (id)
        id = id.replace('[]', '\\[\\]');
    if (containerId) {
        containerId = containerId.replace('[]', '\\[\\]');
        var containerRef = '#' + containerId;
    } else {
        var containerRef = '';
    }
    if ($(containerRef + ' #' + id).attr('type') == 'button') {
        return false;
    }
    if ($(containerRef + ' #' + id).attr('type') != 'hidden') {
        if ($(containerRef + ' #' + id).hasClass('hide')) {
            var objRef = containerRef + ' #' + id + 'Text';
        } else {
            var objRef = containerRef + ' #' + id;
        }
    } else {
        if ($(containerRef + ' #' + id).hasClass('selextbox-input')) {
            /*select*/
            var objRef = containerRef + ' [data-name=' + id + '] span';
        } else {
            var objRef = containerRef + ' #' + id + 'Text';
        }
    }
    $(objRef).attr('obc', $(objRef).css('background-color'));
    $(objRef).css('background-color', color);
}

(function ($) {
    $.fn.tagman = function (options) {
        var set = $.extend({
            tableName: '',
            phpName: '',
            strValue: '',
            idValue: '',
            ident: '',
            siteUrl: '',
            formName: ''
        }, options);
        if (set.formName == '') {
            set.formName = 'form' + set.tableName;
        }
        var windowId = set.ident + 'fm';
        var textInputId = set.phpName + 'Text';
        var input = '#' + set.phpName;

        $(this).after($("<input type='text' id='" + textInputId + "' placeholder='Click to choose " + set.desc + "' value='" + set.strValue + "' >"));
        var textField = $('#' + textInputId);
        $(this).after($("<div id='" + windowId + "' style='display: none;'>"));
        $('#' + windowId).dialog({ autoOpen: false, modal: true });
        if ($(this).val() != '' && $(this).val() != '0') {
            $.post(set.siteUrl + set.tableName, { a: set.phpName + 'name', id: $(this).val() }, function (data) {
                if (data != '') {
                    $('#' + set.formName + ' #' + textInputId).val(data);
                }
            });
        }
        $(this).attr('type', 'hidden');

        $(textField).click(function () {
            $.post(set.siteUrl + set.tableName, { 'a': set.phpName + '_fenetre_multiple', id: $('#' + set.phpName).val(), val: $('#' + set.phpName).val(), windowId: windowId }, function (data) {
                $('#' + windowId).html(data);
                $('#' + windowId).dialog('open');
            });
        });
    };

    $.fn.bindPaging = function (opt) {
        var element = $(this);

        $(this).children('a').off();
        $(this).children('a').on('click', function () {
            sw_message('Search in progress...', false, 'search-progress', true);
            current_page = parseInt($(element).children('#page').val());
            total_page = parseInt($(element).children('#page').data('total'));
            if ($(this).data('direction') == 'prev') {
                if (current_page > 1) {
                    current_page--;
                }
            }
            else if (current_page < total_page) {
                current_page++;
            }

            $('.pagination-wrapper #page').attr('value', current_page);

            $.get(_SITE_URL + opt.ajaxPageActParent, { ui: opt.uiTabsId, pg: current_page, ms: $("#formMs" + opt.tableName).serialize(), i: opt.parentId }, function (data) {
                $('#' + opt.uiTabsId).html(data);
                sw_message_remove('search-progress');
            });
        });

        $(this).children('#page').off();
        $(this).children('#page').on('keyup', function (e) {
            current_page = parseInt($(element).children('#page').val());
            total_page = parseInt($(element).children('#page').data('total'));
            if (e.keyCode == 13) {
                sw_message('Search in progress...', false, 'search-progress', true);
                current_page = parseInt($(this).val());

                if (current_page >= 1 && current_page <= total_page) {
                    $(this).attr('value', current_page);

                    $.get(_SITE_URL + opt.ajaxPageActParent, { ui: opt.uiTabsId, pg: current_page, ms: $("#formMs" + opt.tableName).serialize(), i: opt.parentId }, function (data) {
                        $('#' + opt.uiTabsId).html(data);
                        sw_message_remove('search-progress');
                    });
                }
            }
        });
    };

    $.fn.bindAutocOne = function (opt) {
        var element = $(this);

        $(this).bind('click', function () {
            var options = { a: 'autocOne', t: opt.SelRel };
            options[opt.pkname] = $(this).attr('i');

            $.post(_SITE_URL + opt.page, options, function (data) {
                if (data.data) {
                    idData = data.data[0]['id'];
                    var div = '';
                    if (opt.child == 1 && $(opt.SelEnt + ' ' + opt.SelId).lenght > 0) {
                        div = 'divChild';
                    }
                    $(opt.SelEnt + div + ' ' + opt.SelId).val(data.data[0]['id']);
                    $(opt.SelEnt + div + ' ' + opt.SelIdAuto).val(data.data[0]['show']);
                    $(opt.SelEnt + div + ' ' + opt.SelIdAuto).focus();
                    $(opt.SelEnt + div + ' ' + opt.SelId).change();

                    $(opt.uiTabsId).dialog('close');
                    $('body').css('cursor', 'auto');
                }
            });
        });
    };

    $.fn.bindEdit = function (opt) {
        $(this).bind('click', function (e) {
            var id = '';
            if (typeof $(this).attr('i') !== 'undefined') {
                var id = $(this).attr('i');
            }

            if (typeof opt.callback === "function") {
                opt.callback;
            } else {
                if (opt.destUi != 'tabsContain') {
                    $.get(_SITE_URL + opt.modelName + '/edit/' + id, { ui: opt.destUi, pc: opt.pc, ip: opt.ip, jet: opt.jet, tp: opt.tp },
                        function (data) {
                            dialogWidthClass($('#' + opt.destUi));
                            $('#' + opt.destUi).dialog({ width: 'auto' });
                            $('#' + opt.destUi).html(data).dialog('option', 'title', opt.description);
                            $('#' + opt.destUi).dialog('open');
                        });
                } else {
                    if (e.which == 2) {
                        window.open(_SITE_URL + opt.modelName + '/edit/' + id, '_blank');
                    }
                    else {
                        document.location = _SITE_URL + opt.modelName + '/edit/' + id;
                    }
                }
            }
        });
    };

    $.fn.bindSave = function (opt) {
        $(this).bind('click.save' + opt.modelName, function (data) {
            $('#form' + opt.modelName + ' #save' + opt.modelName + '').attr('disabled', 'disabled');
            $('body').css('cursor', 'progress');
            $('#form' + opt.modelName + ' #save' + opt.modelName).css('cursor', 'progress');
            $('#form' + opt.modelName + ' #save' + opt.modelName).switchClass('ac-light-red', 'ac-light-blue', 1000, 'easeInOutQuad');
            $('#form' + opt.modelName + ' .tinymce').each(function (index) {
                eval(' $("#form' + opt.modelName + ' #' + $(this).attr('Id') + '").val(CKEDITOR.instances.' + $(this).attr('Id') + '.getData());');
            });

            $.post(_SITE_URL + opt.modelName + '/update', {
                d: $(this).parents("#form" + opt.modelName).find("[s='d']").serialize(), ui: opt.destUi, pc: opt.pc, ip: opt.ip, je: opt.je, jet: opt.jet, dialog: opt.dialog, tp: opt.tp
            },
                function (data) {
                    $("#" + opt.destUi).append(data);
                }
            );
        });
    }

    $.fn.bindSorting = function (opt) {
        var url = (opt.url) ? opt.url : opt.modelName;

        $(this).bind('click', function () {
            sw_message('Sorting');
            col = $(this).attr('c');
            colR = col;

            if ($(this).attr('sens') !== undefined) {
                if ($(this).attr('sens') == 'asc') {
                    var sens = 'desc';
                } else if ($(this).attr('sens') == 'desc') {
                    var sens = '';
                } else {
                    var sens = $(this).attr('sens');
                }
            } else {
                var sens = 'asc';
            }

            order = '{\"col\":\"' + col + '\",\"sens\":\"' + sens.toLowerCase() + '\"}';
            $.get(_SITE_URL + url, { ui: opt.destUi, order: order, ms: $('#formMs' + opt.modelName).serialize() },
                function (data) {
                    $('#' + opt.destUi).html(data);
                });
        });
    }

    $.fn.bindDelete = function (opt) {
        $(this).bind('click.delete', function () {
            var id = $(this).parents('tr').attr('rid');
            $('#ui-dialog-title-confirmDialog').html(opt.title);
            confirm(opt.message, function () {
                $.post(_SITE_URL + opt.modelName + '/delete/' + id, { ui: opt.ui }, function (data) {
                    if (data) {
                        $('#' + opt.ui).append(data);
                    }
                });
            });
        });
    }

    $.fn.bindFormKeypress = function (opt) {
        $(this).bind('change.form' + opt.modelName + ' keypress.form' + opt.modelName + '', function (data) {
            $(this).removeClass('error_field');
            $(this).parent('.js-select-label').children('.select-label-span').removeClass('error_field');
            $('#form' + opt.modelName + ' #save' + opt.modelName + '').addClass('unsaved');
            $('#form' + opt.modelName + ' #formChanged' + opt.modelName + '').val('unsaved');
        });
    }
    $.fn.inDialog = function () {
        if ($(this).parents('.ui-widget-content').length) {
            return true;
        } else {
            return false;
        }
    }
}(jQuery));



/**
 * SwHeader
 * var SHeader = new SwHeader();
 * SHeader.addRight(...)
 */

function SwHeader() {

    this.rigth = '.sw-header .custom-controls';
    this.container = {};

    if (!$('.sw-header').length) {
        $('.tabsContain').append(
            $('<div>').addClass('sw-header')
                .append($('<a>').addClass('toggle-menu button-link-blue trigger-menu').href('Javascript:void(0)').append($('<span>').html('Open/close menu')))
                .append($('<div>').addClass('custom-controls').attr('id', 'ControlsList'))
        );
    }
    this.container = $('.sw-header');

};

SwHeader.prototype.addRight = function (caption, click) {
    var customControl = $('<button>').addClass('ac-button ac-light-red').attr('id', 'cc' + Math.random() + Math.random() + Math.random()).html(caption);
    $('.custom-controls').append(customControl);
    customControl.bind('click', click);
}

function dialogFullscreen() {
    var _this = $('.ui-fullscreen');

    if (_this.hasClass('default-size')) {
        var top = ($(window).height() / 2) - (default_height / 2);
        if (default_height > $(window).height()) { top = 0; }

        $('.ui-dialog.ui-widget-content').css({
            'width': default_width,
            'max-width': '60%',
            'height': default_height,
            'top': top,
            'left': ($(window).width() / 2) - (default_width / 2)
        });
    } else {
        $('.ui-dialog').each(function () {
            $('.ui-dialog').each(function () {
                if ($(this).is(':visible')) {
                    default_width = $(this).width();
                    default_height = $(this).height();
                }
            });
        });

        $('.ui-dialog.ui-widget-content').css({
            'width': $(window).width(),
            'max-width': $(window).width(),
            'height': $(window).height(),
            'top': '0px',
            'left': '0px',
        });
    }

    _this.toggleClass('default-size');
}

function sw_message(message, error, id, stick) {
    if (message === true) {
        sw_message_remove(id);
    }
    else {
        if (!stick) {
            stick = false;
        }

        var class_error = 'success';
        if (error == true) {
            class_error = 'error';
        }
        if (!$('.sw-message').length) {
            $('body').append('<ul class=\'sw-message\'></ul>');
        }
        if (!$('.sw-message li.' + id).length) {
            $('.sw-message').append('<li class=\'new ' + id + ' ' + class_error + '\'>' + message + '</li>');
        }

        setTimeout(function () {
            $('.sw-message li.new').each(function () {
                var line = $(this);
                line.removeClass('new');

                if (stick == false) {
                    var timer = setTimeout(function () {
                        sw_message_remove(id);
                    }, 1000);
                }
            });
        }, 10);
    }
}

function sw_message_remove(id) {
    setTimeout(function () {
        $('.sw-message li.' + id).remove();
        if (!$('.sw-message li').length) {
            $('.sw-message').slideUp(250, function () {
                $('.sw-message').remove();
            });
        }
    }, 750);
    $('body').css('cursor', 'default');
}

/**
 * Get timezone data (offset and dst)
 *
 *  Inspired by: http://goo.gl/E41sTi
 *
 * @returns {{offset: number, dst: number}}
 */
function getTimeZoneData() {
	var today = new Date();
  	var jan = new Date(today.getFullYear(), 0, 1);
  	var jul = new Date(today.getFullYear(), 6, 1);
  	var dst = today.getTimezoneOffset() < Math.max(jan.getTimezoneOffset(), jul.getTimezoneOffset());
  
  	return {
    	offset: -today.getTimezoneOffset() / 60,
    	dst: +dst
  	};
}
