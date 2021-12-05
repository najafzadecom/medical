(function( $ ) {

    var TimingField = function(element, options)
    {
        this.elem = $(element);
        this.settings = $.extend({}, $.fn.timingfield.defaults, options);
        this.tpl = $($.fn.timingfield.template);

        this.init();
    };

    TimingField.prototype = {
        init: function () {
            this.elem.after(this.tpl);
            this.elem.hide();
            var timeoutId = 0;

            this.getHours().value = this.tsToHours(this.elem.val());
            this.getMinutes().value = this.tsToMinutes(this.elem.val());
            this.getSeconds().value = this.tsToSeconds(this.elem.val());

            this.tpl.width(this.settings.width);
            this.tpl.find('.timingfield_hours   .input-group-append .input-group-text').text(this.settings.hoursText);
            this.tpl.find('.timingfield_minutes .input-group-append .input-group-text').text(this.settings.minutesText);
            this.tpl.find('.timingfield_seconds .input-group-append .input-group-text').text(this.settings.secondsText);

            this.tpl.find('.timingfield_hours .timingfield_next')
                .on('mouseup', function() { clearInterval(timeoutId); return false; })
                .on('mousedown', function(e) { timeoutId = setInterval($.proxy(this.upHour, this), 100); return false;  })
            ;

            // +/- triggers
            this.tpl.find('.timingfield_hours   .timingfield_next').on('mousedown', $.proxy(this.upHour,    this));
            this.tpl.find('.timingfield_hours   .timingfield_prev').on('mousedown', $.proxy(this.downHour,  this));
            this.tpl.find('.timingfield_minutes .timingfield_next').on('mousedown', $.proxy(this.upMin,     this));
            this.tpl.find('.timingfield_minutes .timingfield_prev').on('mousedown', $.proxy(this.downMin,   this));
            this.tpl.find('.timingfield_seconds .timingfield_next').on('mousedown', $.proxy(this.upSec,     this));
            this.tpl.find('.timingfield_seconds .timingfield_prev').on('mousedown', $.proxy(this.downSec,   this));

            // input triggers
            this.tpl.find('.timingfield_hours   input').on('keyup', $.proxy(this.inputHour, this));
            this.tpl.find('.timingfield_minutes input').on('keyup', $.proxy(this.inputMin,  this));
            this.tpl.find('.timingfield_seconds input').on('keyup', $.proxy(this.inputSec,  this));
        },
        getHours: function() {
            return this.tpl.find('.timingfield_hours input')[0];
        },
        getMinutes: function() {
            return this.tpl.find('.timingfield_minutes input')[0];
        },
        getSeconds: function() {
            return this.tpl.find('.timingfield_seconds input')[0];
        },
        tsToHours: function(timestamp) {
            return parseInt(timestamp/3600);
        },
        tsToMinutes: function(timestamp) {
            return parseInt((timestamp%3600) / 60);
        },
        tsToSeconds: function(timestamp) {
            return parseInt((timestamp%3600) % 60);
        },
        hmsToTimestamp: function(h, m, s) {
            return parseInt(h)*3600 + parseInt(m)*60 + parseInt(s);
        },
        updateElem: function() {
            this.elem.val(this.hmsToTimestamp(
                this.getHours().value,
                this.getMinutes().value,
                this.getSeconds().value
            )).trigger( "change" );
        },
        upHour: function() {
            if (this.getHours().value < this.settings.maxHour) {
                this.getHours().value = parseInt(this.getHours().value) + 1;
                this.updateElem();
                return true;
            }
            return false;
        },
        downHour: function() {
            if (this.getHours().value > 0) {
                this.getHours().value = parseInt(this.getHours().value) - 1;
                this.updateElem();
                return true;
            }
            return false;
        },
        inputHour: function() {
            if (this.getHours().value < 0) {
                this.getHours().value = 0;
            } else if (this.getHours().value > this.settings.maxHour) {
                this.getHours().value = this.settings.maxHour;
            }

            this.updateElem();
        },
        upMin: function() {
            if (this.getMinutes().value < 59) {
                this.getMinutes().value = parseInt(this.getMinutes().value) + 1;
                this.updateElem();
                return true;
            } else if (this.upHour()) {
                this.getMinutes().value = 0;
                this.updateElem();
                return true;
            }
            return false;
        },
        downMin: function() {
            if (this.getMinutes().value > 0) {
                this.getMinutes().value = parseInt(this.getMinutes().value) - 1;
                this.updateElem();
                return true;
            } else if (this.downHour()) {
                this.getMinutes().value = 59;
                this.updateElem();
                return true;
            }
            return false;
        },
        inputMin: function() {
            if (this.getMinutes().value < 0) {
                this.getMinutes().value = 0;
            } else if (this.getMinutes().value > 59) {
                this.getMinutes().value = 59;
            }

            this.updateElem();
        },
        upSec: function() {
            if (this.getSeconds().value < 59) {
                this.getSeconds().value = parseInt(this.getSeconds().value) + 1;
                this.updateElem();
                return true;
            } else if (this.upMin()) {
                this.getSeconds().value = 0;
                this.updateElem();
                return true;
            }
            return false;
        },
        downSec: function() {
            if (this.getSeconds().value > 0) {
                this.getSeconds().value = parseInt(this.getSeconds().value) - 1;
                this.updateElem();
                return true;
            } else if (this.downMin()) {
                this.getSeconds().value = 59;
                this.updateElem();
                return true;
            }
            return false;
        },
        inputSec: function() {
            if (this.getSeconds().value < 0) {
                this.getSeconds().value = 0;
            } else if (this.getSeconds().value > 59) {
                this.getSeconds().value = 59;
            }

            this.updateElem();
        },
    };

    $.fn.timingfield = function(options) {
        // Iterate and reformat each matched element.
        return this.each(function() {
            var element = $(this);

            // Return early if this element already has a plugin instance
            if (element.data('timingfield')) return;

            var timingfield = new TimingField(this, options);

            // Store plugin object in this element's data
            element.data('timingfield', timingfield);
        });
    };

    $.fn.timingfield.defaults = {
        maxHour:        23,
        width:          263,
        hoursText:      'H',
        minutesText:    'M',
        secondsText:    'S'
    };

    $.fn.timingfield.template = '<div class="timingfield">\
        <div class="timingfield_hours">\
            <button type="button" class="timingfield_next btn btn-light btn-xs btn-block" tabindex="-1"><i class="icon-plus2"></i></button>\
            <div class="input-group">\
                <input type="text" class="form-control">\
                <span class="input-group-append"><span class="input-group-text"></span></span>\
            </div>\
            <button type="button" class="timingfield_prev btn btn-light btn-xs btn-block" tabindex="-1"><i class="icon-minus3"></i></button>\
        </div>\
        <div class="timingfield_minutes">\
            <button type="button" class="timingfield_next btn btn-light btn-xs btn-block" tabindex="-1"><i class="icon-plus2"></i></button>\
            <span class="input-group">\
                <input type="text" class="form-control">\
                <span class="input-group-append"><span class="input-group-text"></span></span>\
            </span>\
            <button type="button" class="timingfield_prev btn btn-light btn-xs btn-block" tabindex="-1"><i class="icon-minus3"></i></button>\
        </div>\
        <div class="timingfield_seconds">\
            <button type="button" class="timingfield_next btn btn-light btn-xs btn-block" tabindex="-1"><i class="icon-plus2"></i></button>\
            <span class="input-group">\
                <input type="text" class="form-control">\
                <span class="input-group-append"><span class="input-group-text">%</span></span>\
            </span>\
            <button type="button" class="timingfield_prev btn btn-light btn-xs btn-block" tabindex="-1"><i class="icon-minus3"></i></button>\
        </div>\
    </div>';

}( jQuery ));