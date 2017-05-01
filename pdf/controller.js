(function($ ){

    'use strict';

    // API
    window.controller = {};

    /**
     * Hide an issue from the list
     * @param img
     */
    window.controller.hideIssue = function(img) {
        $(img.parentElement.parentElement.parentElement).hide();
    };

    /**
     * Handles a month change by user
     */
    window.controller.dateChanged = function() {

        var month = monthPicker.val();
        var nextMonth = (parseInt(month) % 12) + 1;
        var year = yearPicker.val();

        if(year === '2007' && !disabled) {
            disabled = true;
            _disableMonthOptions();
        } else if (year !== '2007' && disabled) {
            disabled = false;
            _enableMonthOptions();
        }

        if(year !== '2007' && parseInt(month) < 7) {
            _disableYearOption();
        } else {
            _enableYearOption();
        }

        var firstDayOfTheMonth = moment(month + '-01-' + year);
        var lastDayOfTheMonth = moment((nextMonth < 10 ? '0' + nextMonth : nextMonth) + '-01-' + (nextMonth !== 1 ? year : (parseInt(year) + 1)));
        lastDayOfTheMonth = lastDayOfTheMonth.subtract(1, 'days').format('L');

        // get all month's dates, if it is this month then take all days until today
        var res;
        if(today < lastDayOfTheMonth) {
            res = _getIssuesBetweenDates(firstDayOfTheMonth.format('L'), today);
        } else {
            res = _getIssuesBetweenDates(firstDayOfTheMonth.format('L'), lastDayOfTheMonth);
        }

        res.reverse();
        _emptyList();
        res.forEach(function(date){
            var elem = _createIssueElement(date);
            _addIssuesToList(elem);
        });

    };

    // private

    var list, monthPicker, yearPicker;
    var today = new Date();
    var disabled = false;

    /**
     * Create an array of dates from a specific date.
     * @param from - {Date/String}the date which from it and forth the dates will be counted
     * @param amount {Number} - the amount of dates to insert to the array
     * @returns {Array} of moment objects
     * @private
     */
    function _getIssuesDates(from, amount) {
        var datesArray = [];
        for(var i = 0; i < amount; i++ ) {
            var date = moment(from).add(i, 'days');
            if(date.get('day') === 6) {
                continue;
            }
            datesArray.push(date);
        }
        return datesArray;
    }

    /**
     * Create an array of dates from a specific date.
     * @param from - {Date/String} beginning date
     * @param to - {Date/String} end date
     * @returns {Array} of moment objects
     * @private
     */
    function _getIssuesBetweenDates(from, to) {
        var datesArray = [];
        var i = 0;
        while(moment(from).add(i, 'days') <= moment(to)) {
            var date = moment(from).add(i, 'days');
            i++;
            if(date.get('day') === 6) {
                continue;
            }
            datesArray.push(date);
        }
        return datesArray;
    }

    /**
     * Add an issue element to the list DOM
     * @param issue - {Object} the jquery element of the issue
     * @private
     */
    function _addIssuesToList(issue) {
        list.append(issue);
        $('img', issue).hide().fadeIn(1000);
    }

    /**
     * Create a jQuery element of the list item
     * @param date
     * @returns {*|HTMLElement}
     * @private
     */
    function _createIssueElement(date) {
        return $(
            '<li>' +
                '<div class="pv">' +
                    '<a target="_blank" href="http://digital-edition.israelhayom.co.il/Olive/ODN/Israel/Default.aspx?href=ITD%2F' +
                        moment(date).format('YYYY') +'%2F' + moment(date).format('MM') + '%2F' + moment(date).format('DD') +' ">' +
                        '<img src="http://digital-edition.israelhayom.co.il/Olive/ODN/Israel/get/ITD-' +
                            moment(date).format('YYYY-MM-DD') +
                            '/image.ashx?kind=preview&page=1" onError="controller.hideIssue(this)"/>' +
                        '<div class="border"></div>' +
                        '<div class="date">' + moment(date).format('DD/MM/YYYY') + '</div>' +
                    '</a>' +
                '</div>' +
            '</li>'
        );
    }


    function _disableYearOption() {
        var year = $('#year_picker option:eq(0)');
        year.prop('disabled', true);
    }

    function _enableYearOption() {
        var year = $('#year_picker option:eq(0)');
        year.prop('disabled', false);
    }

    function _disableMonthOptions() {
        var options = $('#month_picker option:lt(6)');
        options.each(function(){
            $(this).prop('disabled', true);
        });
    }

    function _enableMonthOptions() {
        var options = $('#month_picker option:lt(6)');
        options.each(function(){
            $(this).prop('disabled', false);
        });
    }

    /**
     * Remove all <li> elements from the father <ul>
     * @private
     */
    function _emptyList() {
        list.empty();
    }

    // init
    $(function(){

        list        = $('#doc_list');
        monthPicker = $('#month_picker');
        yearPicker  = $('#year_picker');

        var someday     = moment().subtract(1, 'months').calendar();
        var res         = _getIssuesBetweenDates(someday, today);
        res.reverse();

        // create the initial issues (30 days back from today)
        res.forEach(function(date){
            // console.log(moment(date).format('YYYY-MM-DD'));
            // console.log(date.get('day'));
            var element = _createIssueElement(date);
            _addIssuesToList(element);
        });

        // init the year picker
        var thisYear = today.getFullYear();
        for(var y = 2007; y <= thisYear; y++) {
            var option = $('<option value="' + y + '">' + y + '</option>');
            yearPicker.append(option);
        }
        // init this year as selected
        yearPicker.val(thisYear);

        // init the month picker
        // monthPicker.append('<option value="-1"></option>');
        for(var m = 1; m <= 12; m++) {
            var option = $('<option value="' + (m < 10 ? '0' + m : m) + '">' + m + '</option>');
            monthPicker.append(option);
        }
        monthPicker.val(today.getMonth() + 1);

    });



})(jQuery);
