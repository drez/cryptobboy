

/**
*   0.4
**/
var SelectBox, originalVal,
  bind = function (fn, me) { return function () { return fn.apply(me, arguments); }; };

SelectBox = (function () {
  var elementInViewport;

  function SelectBox(time) {
    this.eventMultipleMouseEnd = bind(this.eventMultipleMouseEnd, this);
    this.unbindMouseMultiple = bind(this.unbindMouseMultiple, this);
    this.bindMouseMultiple = bind(this.bindMouseMultiple, this);
    this.unbindKeyPressAutoComplete = bind(this.unbindKeyPressAutoComplete, this);
    this.unbindKeyPressInnerSelect = bind(this.unbindKeyPressInnerSelect, this);
    this.bindKeyPressAutoComplete = bind(this.bindKeyPressAutoComplete, this);
    this.bindKeyPressInnerSelect = bind(this.bindKeyPressInnerSelect, this);
    this.checkIfInView = bind(this.checkIfInView, this);
    this.checkSelectInView = bind(this.checkSelectInView, this);
    this.resetValue = bind(this.resetValue, this);
    this.updateValue = bind(this.updateValue, this);
    this.updateSelected = bind(this.updateSelected, this);
    this.bindChange = bind(this.bindChange, this);
    this.updateData = bind(this.updateData, this);
    this.checkDefault = bind(this.checkDefault, this);
    this.changeMultiple = bind(this.changeMultiple, this);
    this.change = bind(this.change, this);
    this.basicBinds = bind(this.basicBinds, this);
    this.selectboxClass = "js-select-label";
    this.searchedString = "";
    this.shiftKeyFirst = "";
    this.isMobile = false;
    this.keypressTime = typeof time !== 'undefined' ? time : 400;
    $(document).unbind('click.unselectLabel scroll.unselectLabel');
    $(document).bind('click.unselectLabel scroll.unselectLabel', (function (_this) {
      return function (e) {
        if (!e) {
          e = window.event;
        }
        if (!$(e.target).hasClass(_this.selectboxClass) && !$(e.target).parent().hasClass(_this.selectboxClass)) {
          if (!$('.' + _this.selectboxClass + '.show').is('[multiple]') || !(e.ctrlKey || e.metaKey || e.shiftKey) && !_this.isMobile) {
            if ($('.' + _this.selectboxClass + '.show').length > 0) {
              $('.' + _this.selectboxClass + '.show').close();
            }
          }
        }
      };
    })(this));
    $(document).unbind('keydown.SpecialKeys');
    $(document).bind('keydown.SpecialKeys', (function (_this) {
      return function (e) {
        var key;
        key = e.keyCode || e.which;
        if (e.ctrlKey && key === 65 && $('.' + _this.selectboxClass + '.show').length > 0) {
          e.preventDefault();
          if (_this.searchedString !== "") {
            $('.' + _this.selectboxClass + '.show .select-label-span').wrapInner('<i></i>').addClass('selected');
          }
        }
        if (key === 39 && $('.' + _this.selectboxClass + '.show .select-label-span').hasClass('selected')) {
          $('.' + _this.selectboxClass + '.show .select-label-span').removeClass('selected');
          $('.' + _this.selectboxClass + '.show .select-label-span').html(_this.searchedString);
        }
        if (key === 8 && !$(e.target).is("input, textarea")) {
          e.preventDefault();
          if ($(e.target).is(".select-label-span")) {
            if ($('.' + _this.selectboxClass + '.show .select-label-span').hasClass('selected')) {
              $('.' + _this.selectboxClass + '.show .select-label-span').removeClass('selected');
              _this.searchedString = "";
            } else {
              _this.searchedString = _this.searchedString.slice(0, -1);
            }
            if (_this.searchedString !== " " && _this.searchedString !== "") {
              return $('.' + _this.selectboxClass + '.show .select-label-span').html(_this.searchedString);
            } else {
              return _this.resetValue($('.' + _this.selectboxClass + '.show'));
            }
          }
        }
      };
    })(this));
  }

  SelectBox.prototype.init = function (selectbox) {
    if (!selectbox.find('.select-element').data('default-selected')) {
      selectbox.find('.select-element').data('default-selected', 'default');
    }
    this.checkDefault(selectbox);
    selectbox.data('bound', false);
    if (selectbox.find('.select-element li.default').length === 0 && selectbox.find('input').val() === '') {
      this.change(selectbox, selectbox.find('ul li').eq(0), true);
    }
    if (selectbox.find('input.changed-value').length > 0) {
      this.updateSelected(selectbox);
    }
    if (!selectbox.is('[disabled]')) {
      this.selectbox = selectbox;
      this.open(this.selectbox).updateData(selectbox).bindChange(selectbox).hide(selectbox).destroy(selectbox);
      selectbox.find('.select-label-span').unbind('focus.tabbed');
      selectbox.find('.select-label-span').bind('focus.tabbed', (function (_this) {
        return function (e) {
          $(window).unbind('keyup.tabbedKeyup');
          $(window).bind('keyup.tabbedKeyup', function (e) {
            var code;
            code = e.keyCode ? e.keyCode : e.which;
            if (code === 9) {
              selectbox.open();
            }
          });
        };
      })(this));
      selectbox.find('.select-label-span').unbind('focusout.tabbed');
      selectbox.find('.select-label-span').bind('focusout.tabbed', (function (_this) {
        return function (e) {
          $(window).unbind('keyup.tabbedKey');
          $(window).bind('keyup.tabbedKey', function (e) {
            var code;
            code = e.keyCode ? e.keyCode : e.which;
            if (code === 9) {
              selectbox.close();
            }
          });
        };
      })(this));
      this.selectbox.find('.select-label-span').unbind('click.selectSpan');
      this.selectbox.find('.select-label-span').bind('click.selectSpan', (function (_this) {
        return function () {
          if (!selectbox.hasClass('show')) {
            if (!selectbox.data('bound')) {
              _this.basicBinds(selectbox);
              selectbox.data('bound', true);
            }
            selectbox.open();
          } else {
            selectbox.close();
          }
        };
      })(this));
    }
    return this;
  };

  SelectBox.prototype.basicBinds = function (selectbox) {
    if (!selectbox.is('[disabled]')) {
      this.bindKeyPressInnerSelect(selectbox).bindKeyPressAutoComplete(selectbox).bindMouseMultiple(selectbox).unbindKeyPressInnerSelect(selectbox).unbindKeyPressAutoComplete(selectbox).unbindMouseMultiple(selectbox);
      if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        this.mobile(selectbox);
      }
      this.widestLi = this.getMaxLiWidth(selectbox.find('ul li'));
      selectbox.undelegate('.select-element li', 'click.selectOption');
      selectbox.delegate('.select-element li', 'click.selectOption', (function (_this) {
        return function (e) {
          if (!e) {
            e = window.event;
          }
          if (!$(this).hasClass('selected' && !selectbox.is('[multiple]'))) {
            if (!selectbox.is('[multiple]')) {
              _this.change(selectbox, $(this), true);
            } else {
              _this.changeMultiple(selectbox, $(this), e);
            }
          }
        };
      })(this));
    }
    return this;
  };

  SelectBox.prototype.open = function (selectbox) {
    selectbox.unbind('open.Open');
    selectbox.bind('open.Open', (function (_this) {
      return function () {
        var bottomValue, elementList, selectboxPos, selectboxWidth;
        if (!selectbox.is('[disabled]')) {
          elementList = selectbox.find('ul.select-element');
          selectboxPos = selectbox.offset();
          var widthLeftPanel = $('#body .left-panel').width();

          if ($('#body').hasClass('toggle-left-panel') || $(window).width() <= 1280) { widthLeftPanel = 0; }

          if (selectbox.find('li.selected').length > 0) {
            selectbox.find('.select-element').scrollTop(selectbox.find('li.selected').eq(0).position().top + selectbox.find('.select-element').scrollTop());
          } else {
            selectbox.find('.select-element').scrollTop(0);
          }
          if ($('.' + _this.selectboxClass + '.show').length > 0) {
            $('.' + _this.selectboxClass + '.show').close();
          }
          selectbox.find('.scrollable').isolatedScroll();
          selectbox.addClass('show');
          if (_this.widestLi > selectbox.outerWidth()) {
            selectboxWidth = _this.widestLi;
          } else {
            selectboxWidth = selectbox.outerWidth();
          }
          if (!elementInViewport(selectbox.find('ul'))) {
            return elementList.css({
              top: selectboxPos.top - selectbox.find('ul').outerHeight() - $(window).scrollTop(),
              left: parseFloat(selectboxPos.left) - parseFloat(widthLeftPanel),
              right: $(window).width() - (selectboxPos.left + selectboxWidth)
            });
          } else {
            if ($(window).height() - selectboxPos.top - selectbox.find('.select-label-span').outerHeight() < 332 && selectbox.find('.select-element').outerHeight() > $(window).height() - selectboxPos.top - selectbox.find('.select-label-span').outerHeight()) {
              bottomValue = 0;
            } else {
              bottomValue = 'auto';
            }
            /*return elementList.css({
              top: selectboxPos.top + selectbox.outerHeight() - $(window).scrollTop(),
              left: parseFloat(selectboxPos.left)-parseFloat(widthLeftPanel),
              right: $(window).width() - (selectboxPos.left + selectboxWidth),
              bottom: bottomValue
            });*/
          }
        }
      };
    })(this));
    return this;
  };

  elementInViewport = function (el) {
    var height, left, top;
    el.removeAttr('style');
    top = el.offset().top;
    left = el.offset().left;
    height = el.find('li').eq(1).outerHeight() * 2;
    return top >= window.pageYOffset && top + height - $(window).scrollTop() <= window.pageYOffset + window.innerHeight;
  };

  SelectBox.prototype.getMaxLiWidth = function (lis) {
    var maxWidth;
    maxWidth = 0;
    lis.each(function (i) {
      var padding;
      padding = parseInt($(this).css('padding-right').replace('px', '')) + parseInt($(this).css('padding-left').replace('px', ''));
      if ($(this).find('strong').outerWidth() + padding > maxWidth) {
        maxWidth = $(this).find('strong').outerWidth() + padding;
      }
    });
    return maxWidth;
  };

  SelectBox.prototype.hide = function (selectbox) {
    selectbox.unbind('close.Hide');
    selectbox.bind('close.Hide', (function (_this) {
      return function () {
        selectbox.find('.scrollable').removeIsolatedScroll();
        selectbox.find('.hovered').removeClass('hovered');
        selectbox.removeClass('show');
        setTimeout(function () {
          return selectbox.removeClass('show-top');
        }, 500);
        $(window).unbind('keyup.tabbedKeyup');
        return _this.searchedString = "";
      };
    })(this));
    return this;
  };

  SelectBox.prototype.destroy = function (selectbox) {
    selectbox.unbind('destroy.Destroy');
    selectbox.bind('destroy.Destroy', (function (_this) {
      return function () {
        return selectbox.removeData('bound').unbind().undelegate().off().find('*').unbind().undelegate().off();
      };
    })(this));
    return this;
  };

  SelectBox.prototype.mobile = function (selectbox) {
    selectbox.addClass('mobile');
    this.isMobile = true;
    selectbox.find('.js-select-close-button').unbind('click.CloseButton');
    selectbox.find('.js-select-close-button').bind('click.CloseButton', (function (_this) {
      return function () {
        return selectbox.close();
      };
    })(this));
    return this;
  };

  SelectBox.prototype.change = function (selectbox, element, updateVal) {
    selectbox.find('.select-element li.selected').removeClass('selected');
    element.addClass('selected');
    if (element.hasClass('default')) {
      selectbox.find('.select-label-span').addClass('default');
    } else {
      selectbox.find('.select-label-span').removeClass('default');
    }
    if (updateVal) {
      this.updateValue(selectbox);
    } else {
      this.resetValue(selectbox);
    }
    this.checkDefault(selectbox);
    return this;
  };

  SelectBox.prototype.changeMultiple = function (selectbox, element, e) {
    var amountSelected, elementSelected;
    if (!e) {
      e = window.event;
    }
    if (selectbox.find('li.default').hasClass('selected')) {
      selectbox.find('li.default').removeClass('selected');
    }
    amountSelected = selectbox.find('.select-element li.selected').length;
    elementSelected = element.hasClass('selected');
    if (e && !e.ctrlKey && !e.metaKey && !this.isMobile) {
      selectbox.find('.select-element li.selected').removeClass('selected');
    }
    if (!elementSelected || (amountSelected > 1 && e && !e.ctrlKey && !e.metaKey && !this.isMobile)) {
      element.addClass('selected');
    } else {
      element.removeClass('selected');
    }
    if (e && e.shiftKey) {
      if (this.shiftKeyFirst !== "") {
        this.eventMultipleMouseEnd(selectbox, this.shiftKeyFirst, element);
      } else {
        this.shiftKeyFirst = element;
      }
    } else {
      this.shiftKeyFirst = "";
      this.updateValue(selectbox, true);
    }
    return this;
  };

  SelectBox.prototype.checkDefault = function (selectbox) {
    setTimeout((function (_this) {
      return function () {
        if (selectbox.find('.select-element li.selected').data('value') === 'default') {
          return selectbox.find('.select-element li.default').hide();
        } else {
          return selectbox.find('.select-element li.default').show();
        }
      };
    })(this), 300);
    return this;
  };

  SelectBox.prototype.updateData = function (selectbox) {
    selectbox.off('newData');
    selectbox.on('newData', (function (_this) {
      return function (e, data) {
        var i, k, v;
        selectbox.find('ul').html('');
        i = Object.keys(data).length;
        for (k in data) {
          v = data[k];
          selectbox.find('ul').append(v);
          i--;
          if (i === 0) {
            _this.change(selectbox, selectbox.find('ul li').eq(0), true);
          }
        }
      };
    })(this));
    return this;
  };

  SelectBox.prototype.bindChange = function (selectbox) {
    selectbox.find('input').unbind('change.inputChange');
    selectbox.find('input').bind('change.inputChange', (function (_this) {
      return function (e) {
        return _this.updateSelected(selectbox);
      };
    })(this));
    return this;
  };

  SelectBox.prototype.updateSelected = function (selectbox) {
    var arrayLabels, arrayValues, dataVal, i, j, len;
    if (!selectbox.is('[multiple]')) {

      this.change(selectbox, selectbox.find('li[data-value="' + selectbox.find('input').val() + '"]'), false);
      if (!selectbox.find('input').val()) {
        selectbox.find('.select-label-span').addClass('gray');
      } else {
        selectbox.find('.select-label-span').removeClass('gray');
      }
      selectbox.find('.select-label-span').text(selectbox.find('li.selected').data('label'));

    } else {
      selectbox.find('li.selected').removeClass('selected');
      arrayValues = selectbox.find('input').val().split(',');
      arrayLabels = [];
      if (arrayValues.length > 0) {
        i = arrayValues.length;
        for (j = 0, len = arrayValues.length; j < len; j++) {
          dataVal = arrayValues[j];
          selectbox.find('li[data-value="' + dataVal + '"]').addClass('selected');
          arrayLabels.push(selectbox.find('li[data-value="' + dataVal + '"]').data('label'));
          i--;
          if (i === 0) {
            selectbox.find('.select-label-span').text(arrayLabels);
            selectbox.find('.select-element').data('default-selected', arrayValues);
          }
        }
      } else {
        selectbox.find('li.default').addClass('selected');
        selectbox.find('.select-label-span').text(selectbox.find('li.default').data('label'));
      }
    }
    return this;
  };

  SelectBox.prototype.updateValue = function (selectbox) {
    var arrayLabels, arrayValues, i;
    if (selectbox.find('li.default').hasClass('selected')) {
      selectbox.find('li.default').removeClass('selected');
      selectbox.find('.select-label-span').addClass('gray');
    } else {
      selectbox.find('.select-label-span').removeClass('gray');
    }
    arrayValues = [];
    arrayLabels = [];
    if (selectbox.find('.select-element li.selected').length > 0) {
      i = selectbox.find('.select-element li.selected').length;
      selectbox.find('.select-element li.selected').each((function (_this) {
        return function () {
          arrayValues.push($(this).attr('data-value'));
          arrayLabels.push($(this).data('label'));
          i--;
          if (i === 0) {
            selectbox.find('input').val(arrayValues);
            selectbox.find('.select-label-span').text(arrayLabels);
            return selectbox.find('.select-element').data('default-selected', arrayValues);
          }
        };
      })(this));
    } else {
      selectbox.find('input').val('');
      selectbox.find('li.default').addClass('selected');
      selectbox.find('.select-label-span').text(selectbox.find('li.default').data('label'));
    }
    return this;
  };

  SelectBox.prototype.resetValue = function (selectbox) {
    var arrayLabels, i;
    arrayLabels = [];
    selectbox.find('.select-label-span').removeClass('selected');
    if (selectbox.find('.select-element li.selected').length > 0) {
      i = selectbox.find('.select-element li.selected').length;
      selectbox.find('.select-element li.selected').each((function (_this) {
        return function () {
          arrayLabels.push($(this).data('label'));
          i--;
          if (i === 0) {
            return selectbox.find('.select-label-span').text(arrayLabels);
          }
        };
      })(this));
    } else if (selectbox.find('li.default').length > 0) {
      selectbox.find('.select-label-span').text(selectbox.find('li.default').data('label'));
    } else {
      selectbox.find('.select-label-span').text('');
    }
    return this;
  };

  SelectBox.prototype.checkSelectInView = function (selectbox) {
    var amount, height, liHeight, offset, parent;
    height = selectbox.find('.select-element').outerHeight();
    liHeight = selectbox.find('li').outerHeight();
    amount = selectbox.find('li').length;
    offset = selectbox.parents('.divtr').position().top;
    parent = $('.ui-dialog');
  };

  SelectBox.prototype.checkIfInView = function (element, parent, direction) {
    var height, offset;
    height = element.outerHeight();
    offset = element.position().top;
    if (offset + height > parent.innerHeight() && direction === 'down') {
      parent.animate({
        scrollTop: (height + offset + parent.scrollTop()) - parent.innerHeight()
      }, 200);
    } else if (offset <= 0 && direction === 'up') {
      parent.animate({
        scrollTop: parent.scrollTop() + offset
      }, 200);
    }
  };

  SelectBox.prototype.bindKeyPressInnerSelect = function (selectbox) {
    selectbox.unbind('open.KeyPressInnerSelect');
    selectbox.bind('open.KeyPressInnerSelect', (function (_this) {
      return function () {
        _this.currentHighlighted = -1;
        if (selectbox.find('.select-element li.selected').data('value') === 'default' || (selectbox.is('[multiple]') && selectbox.find('.select-element li.selected').data('value') === void 0)) {
          _this.currentHighlighted = 0;
        } else {
          _this.currentHighlighted = selectbox.find('.select-element li.selected').eq(0).index() - 1;
        }
        selectbox.unbind('keyup.KeyPressInnerSelect');
        return selectbox.bind('keyup.KeyPressInnerSelect', function (e) {
          var direction, key;
          if (selectbox.find('li[data-label].found').length > 0 && (typeof _this.currentFoundIndex === 'undefined' || selectbox.find('li[data-label].found').eq(0).index() !== _this.currentFoundIndex)) {
            _this.currentHighlighted = selectbox.find('li[data-label].found').eq(0).index() - 1;
            _this.currentFoundIndex = selectbox.find('li[data-label].found').eq(0).index();
          }
          selectbox.find('li.hovered').removeClass('hovered');
          key = e.keyCode || e.which;
          if (key === 38) {
            if (!(_this.currentHighlighted <= -1)) {
              _this.currentHighlighted--;
            }
            direction = 'up';
          }
          if (key === 40) {
            if (_this.currentHighlighted !== selectbox.find('li').length - 1) {
              _this.currentHighlighted++;
            }
            direction = 'down';
          }
          if (key === 13) {
            if (!selectbox.hasClass('show')) {
              selectbox.open();
            } else {
              if (!selectbox.is('[multiple]')) {
                _this.change(selectbox, selectbox.find('li').eq(_this.currentHighlighted), true);
                selectbox.close();
              } else {
                _this.changeMultiple(selectbox, selectbox.find('li').eq(_this.currentHighlighted), e);
              }
            }
          }
          if (key === 27) {
            selectbox.close();
          }
          if (!(_this.currentHighlighted < 0 || _this.currentHighlighted === selectbox.find('li').length)) {
            _this.checkIfInView(selectbox.find('li').eq(_this.currentHighlighted), selectbox.find('ul'), direction);
            return selectbox.find('li').eq(_this.currentHighlighted).addClass('hovered');
          }
        });
      };
    })(this));
    return this;
  };

  SelectBox.prototype.bindKeyPressAutoComplete = function (selectbox) {
    selectbox.unbind('open.KeyPressAutoComplete');
    selectbox.bind('open.KeyPressAutoComplete', (function (_this) {
      return function () {
        $(document).unbind('keypress.KeyPressAutoComplete');
        return $(document).bind('keypress.KeyPressAutoComplete', function (e) {
          var key;
          selectbox.find("li[data-label].found").each(function () {
            return $(this).removeClass('found').find('strong').html($(this).text());
          });
          key = e.keyCode || e.which;
          e.preventDefault();
          if (key === 32 && _this.searchedString !== "") {
            _this.searchedString += ' ';
            clearTimeout(_this.keypressTimeout);
          }
          if (!(key === 13 || key === 10 || key === 38 || key === 40 || key === 27)) {
            if (selectbox.find('.select-label-span').hasClass('selected')) {
              _this.searchedString = String.fromCharCode(key);
              selectbox.find('.select-label-span').removeClass('selected');
            } else {
              _this.searchedString += String.fromCharCode(key);
            }
            clearTimeout(_this.keypressTimeout);
            if (_this.searchedString !== " ") {
              selectbox.find('.select-label-span').html(_this.searchedString);
            } else {
              _this.resetValue(selectbox);
            }
          }
          return _this.keypressTimeout = setTimeout(function () {
            var first, found, results, searchString;
            first = true;
            searchString = _this.searchedString;
            if (selectbox.find('li:not(.default)').length > 0) {
              if (isNaN(searchString)) {
                found = selectbox.find("li[data-label]").filter(function () {
                  if (isNaN($(this).data("label")) && $(this).data("value") !== 'default' && $(this).data("label").toLowerCase().indexOf(searchString.toLowerCase()) === 0) {
                    $(this).addClass('found').find('strong').html($(this).find('strong').text().replace(new RegExp(searchString, 'i'), '<i>' + searchString.capitalize() + '</i>'));
                    if (first) {
                      selectbox.find('.select-element').animate({
                        scrollTop: $(this).position().top + selectbox.find('.select-element').scrollTop()
                      }, 250, 'swing');
                      first = false;
                      return $(this);
                    }
                  }
                });
                results = [];
                while (found.data('label') === void 0) {
                  searchString = searchString.slice(0, -1);
                  results.push(found = selectbox.find("li[data-label]").filter(function () {
                    if (isNaN($(this).data("label")) && $(this).data("value") !== 'default' && $(this).data("label").toLowerCase().indexOf(searchString.toLowerCase()) === 0) {
                      $(this).addClass('found').find('strong').html($(this).find('strong').text().replace(new RegExp(searchString, 'i'), '<i>' + searchString.capitalize() + '</i>'));
                      if (first) {
                        selectbox.find('.select-element').animate({
                          scrollTop: $(this).position().top + selectbox.find('.select-element').scrollTop()
                        }, 250, 'swing');
                        first = false;
                        return $(this);
                      }
                    }
                  }));
                }
                return results;
              } else {
                if (selectbox.find('li[data-label^="' + searchString + '"]').length > 0) {
                  selectbox.find('li[data-label^="' + searchString + '"]').each(function () {
                    $(this).addClass('found').find('strong').html($(this).find('strong').text().replace(new RegExp(searchString, 'i'), '<i>' + searchString + '</i>'));
                  });
                  return selectbox.find('.select-element').animate({
                    scrollTop: selectbox.find('li[data-label^="' + searchString + '"]').first().position().top + selectbox.find('.select-element').scrollTop()
                  }, 250, 'swing');
                }
              }
            }
          }, _this.keypressTime);
        });
      };
    })(this));
    return this;
  };

  SelectBox.prototype.unbindKeyPressInnerSelect = function (selectbox) {
    selectbox.unbind('close.KeyPressInnerSelect');
    selectbox.bind('close.KeyPressInnerSelect', (function (_this) {
      return function () {
        return selectbox.unbind('keyup.KeyPressInnerSelect');
      };
    })(this));
    return this;
  };

  SelectBox.prototype.unbindKeyPressAutoComplete = function (selectbox) {
    selectbox.unbind('close.KeyPressAutoComplete');
    selectbox.bind('close.KeyPressAutoComplete', (function (_this) {
      return function () {
        $(document).unbind('keypress.KeyPressAutoComplete');
        _this.resetValue(selectbox);
        return selectbox.find("li[data-label].found").each(function () {
          return $(this).removeClass('found').find('strong').html($(this).text());
        });
      };
    })(this));
    return this;
  };

  SelectBox.prototype.bindMouseMultiple = function (selectbox) {
    if (!!selectbox.is('[multiple]')) {
      selectbox.unbind('open.MouseMultiple');
      selectbox.bind('open.MouseMultiple', (function (_this) {
        return function () {
          var elementEnd, elementStart;
          elementStart = "";
          elementEnd = "";
          selectbox.find('.select-element').bind('mousedown.mouseDown', function (e) {
            elementStart = $(e.target);
            selectbox.find('.select-element').bind('mouseover.mouseover', function (e) {
              if (elementStart.index() < $(e.target).index()) {
                return elementStart.nextUntil($(e.target).next(), 'li').andSelf().addClass('selected');
              } else {
                return $(e.target).nextUntil(elementStart.next(), 'li').andSelf().addClass('selected');
              }
            });
            selectbox.find('.select-element').bind('mouseout.mouseout', function (e) {
              return $(e.target).removeClass('selected');
            });
          });
          return selectbox.find('.select-element').bind('mouseup.mouseUp', function (e) {
            selectbox.find('.select-element').unbind('mouseout.mouseout');
            selectbox.find('.select-element').unbind('mouseover.mouseover');
            elementEnd = $(e.target);
            _this.eventMultipleMouseEnd(selectbox, elementStart, elementEnd, e);
          });
        };
      })(this));
    }
    return this;
  };

  SelectBox.prototype.unbindMouseMultiple = function (selectbox) {
    if (!!selectbox.is('[multiple]')) {
      selectbox.unbind('close.MouseMultiple');
      selectbox.bind('close.MouseMultiple', (function (_this) {
        return function () {
          selectbox.find('.select-element').unbind('mousedown.mouseDown');
          selectbox.find('.select-element').unbind('mouseup.mouseUp');
          selectbox.find('.select-element').unbind('mouseout.mouseout');
          return selectbox.find('.select-element').unbind('mouseover.mouseover');
        };
      })(this));
    }
    return this;
  };

  SelectBox.prototype.eventMultipleMouseEnd = function (selectbox, elementStart, elementEnd, e) {
    if (elementStart.index() !== elementEnd.index()) {
      if (!e) {
        e = window.event;
      }
      if (e && !e.ctrlKey && !e.metaKey && !e.shiftKey) {
        selectbox.find('.select-element li.selected').removeClass('selected');
        selectbox.close();
      }
      if (elementStart.index() < elementEnd.index()) {
        elementStart.nextUntil(elementEnd.next(), 'li').andSelf().addClass('selected');
      } else {
        elementEnd.nextUntil(elementStart.next(), 'li').andSelf().addClass('selected');
      }
      this.updateValue(selectbox, true);
    }
  };

  return SelectBox;

})();

$.fn.extend({
  isolatedScroll: function () {
    this.bind('mousewheel.isolatedScroll DOMMouseScroll.isolatedScroll', function (e) {
      var bottomOverflow, delta, topOverflow;
      delta = e.wheelDelta || e.originalEvent && e.originalEvent.wheelDelta || -e.detail;
      bottomOverflow = this.scrollTop + $(this).outerHeight() - this.scrollHeight >= 0;
      topOverflow = this.scrollTop <= 0;
      if (delta < 0 && bottomOverflow || delta > 0 && topOverflow) {
        e.preventDefault();
      }
    });
    return this;
  },
  removeIsolatedScroll: function () {
    this.unbind('mousewheel.isolatedScroll DOMMouseScroll.isolatedScroll');
    return this;
  }
});

$.fn.SelectBox = function (time) {
  var SelectBoxInstance;
  SelectBoxInstance = new SelectBox(time);
  return $(this).each(function (index) {
    if ($(this).data('bound') === void 0) {
      SelectBoxInstance.init($(this));
    }
  });
};

$.fn.open = function () {
  return $(this).each(function () {
    $(this).trigger('open');
  });
};

originalVal = $.fn.val;

$.fn.val = function () {
  var hasChanged, oldVal, result, vals;
  if (this.hasClass('selextbox-input')) {
    oldVal = this[0].attributes[3].nodeValue;
  }
  result = originalVal.apply(this, arguments);
  if (arguments.length > 0) {
    if ($.isArray(arguments[0])) {
      vals = arguments[0].toString();
    } else {
      vals = arguments[0];
    }
  }
  if (this.hasClass('selextbox-input')) {
    hasChanged = oldVal !== vals;
    if (arguments.length > 0 && hasChanged) {
      $(this).change().addClass('changed-value');
    }
  }
  return result;
};

$.fn.close = function () {
  return $(this).each(function () {
    $(this).trigger('close');
  });
};

$.fn.destroy = function () {
  return $(this).each(function () {
    $(this).close().trigger('destroy');
  });
};

$.fn.setVal = function (val) {
  return $(this).each(function () {
    $(this).find('input').val(val);
  });
};

String.prototype.capitalize = function () {
  return this.charAt(0).toUpperCase() + this.slice(1);
};
