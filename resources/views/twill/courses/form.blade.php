@extends('layouts.admin.jobrole_form')

@php
    $customForm = true;

@endphp


@push('extra_css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/admin/multiselect_css/style.css') }}">

    <style>
        .filter-select {
            height: 43px !important;
            margin-bottom: 2rem;
            width: 100%;
            border: 1px solid rgba(60, 60, 60, .26);
        }

        textarea.form-control {
            min-height: 200px !important;
            /* Adjust as needed */
        }

        .input {
            margin-top: 35px;
            position: relative;
        }

        .fieldset__content {
            margin-top: 2em;
        }

        .fieldset__content .row {
            padding-bottom: 2em;
        }

        .multi-select {
            display: flex;
            box-sizing: border-box;
            flex-direction: column;
            position: relative;
            width: 100%;

            user-select: none;
        }

        .multi-select .multi-select-header {
            border: 1px solid #dee2e6;
            padding: 7px 30px 7px 12px;
            overflow: hidden;
            gap: 7px;
            min-height: 45px !important;
        }

        .multi-select .multi-select-header::after {
            content: "";
            display: block;
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23949ba3' viewBox='0 0 16 16'%3E%3Cpath d='M8 13.1l-8-8 2.1-2.2 5.9 5.9 5.9-5.9 2.1 2.2z'/%3E%3C/svg%3E");
            height: 12px;
            width: 12px;
        }

        .multi-select .multi-select-header.multi-select-header-active {
            border: 1px solid #ced4da;
        }

        .multi-select .multi-select-header.multi-select-header-active::after {
            transform: translateY(-50%) rotate(180deg);
        }

        .multi-select .multi-select-header.multi-select-header-active+.multi-select-options {
            display: flex;
        }

        .multi-select .multi-select-header .multi-select-header-placeholder {
            color: #65727e;
            font-size: 13px;
        }

        .multi-select .multi-select-header .multi-select-header-option {
            display: inline-flex;
            align-items: center;
            background-color: #d9d9d9;
            font-size: 13px;
            padding: 3px 8px;
            border-radius: 10px;
        }

        .multi-select .multi-select-header .multi-select-header-max {
            font-size: 13px;
            color: #65727e;
        }

        .multi-select .multi-select-options {
            display: none;
            box-sizing: border-box;
            flex-flow: wrap;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            z-index: 999;
            margin-top: 5px;
            padding: 5px;
            background-color: #fbfbfb;
            border-radius: 0px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-height: 200px;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .multi-select .multi-select-options::-webkit-scrollbar {
            width: 5px;
        }

        .multi-select .multi-select-options::-webkit-scrollbar-track {
            background: #f0f1f3;
        }

        .multi-select .multi-select-options::-webkit-scrollbar-thumb {
            background: #cdcfd1;
        }

        .multi-select .multi-select-options::-webkit-scrollbar-thumb:hover {
            background: #b2b6b9;
        }

        .multi-select .multi-select-options .multi-select-option,
        .multi-select .multi-select-options .multi-select-all {
            padding: 4px 12px;
            height: 42px;
        }

        .multi-select .multi-select-options .multi-select-option .multi-select-option-radio,
        .multi-select .multi-select-options .multi-select-all .multi-select-option-radio {
            margin-right: 14px;
            height: 16px;
            width: 16px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        .multi-select .multi-select-options .multi-select-option .multi-select-option-text,
        .multi-select .multi-select-options .multi-select-all .multi-select-option-text {
            box-sizing: border-box;
            flex: 1;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            color: inherit;
            font-size: 13px;
            line-height: 20px;
        }

        .multi-select .multi-select-options .multi-select-option.multi-select-selected .multi-select-option-radio,
        .multi-select .multi-select-options .multi-select-all.multi-select-selected .multi-select-option-radio {
            border-color: #40c979;
            background-color: #40c979;
        }

        .multi-select .multi-select-options .multi-select-option.multi-select-selected .multi-select-option-radio::after,
        .multi-select .multi-select-options .multi-select-all.multi-select-selected .multi-select-option-radio::after {
            content: "";
            display: block;
            width: 3px;
            height: 7px;
            margin: 0.12em 0 0 0.27em;
            border: solid #fff;
            border-width: 0 0.15em 0.15em 0;
            transform: rotate(45deg);
        }

        .multi-select .multi-select-options .multi-select-option.multi-select-selected .multi-select-option-text,
        .multi-select .multi-select-options .multi-select-all.multi-select-selected .multi-select-option-text {
            color: #40c979;
        }

        .multi-select .multi-select-options .multi-select-option:hover,
        .multi-select .multi-select-options .multi-select-option:active,
        .multi-select .multi-select-options .multi-select-all:hover,
        .multi-select .multi-select-options .multi-select-all:active {
            background-color: #f3f4f7;
        }

        .multi-select .multi-select-options .multi-select-all {
            border-bottom: 1px solid #f1f3f5;
            border-radius: 0;
        }

        .multi-select .multi-select-options .multi-select-search {
            padding: 7px 10px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            margin: 10px 10px 5px 10px;
            width: 100%;
            outline: none;
            font-size: 13px;
        }

        .multi-select .multi-select-options .multi-select-search::placeholder {
            color: #b2b5b9;
        }

        .multi-select .multi-select-header,
        .multi-select .multi-select-option,
        .multi-select .multi-select-all {
            display: flex;
            flex-wrap: wrap;
            box-sizing: border-box;
            align-items: center;
            border-radius: 5px;
            cursor: pointer;
            display: flex;
            align-items: center;
            width: 100%;
            font-size: 13px;
            color: #212529;
        }

        .form-control {
            border: 1px solid #ccc;
            /* adjust as needed */
            box-sizing: border-box;
            outline: 0;
            padding: .75rem;
            width: 100%;
            position: relative;
            cursor: pointer;
        }

        /* Make native date/time picker icon clickable */
        input[type="date"]::-webkit-calendar-picker-indicator,
        input[type="datetime-local"]::-webkit-calendar-picker-indicator {
            background: transparent;
            bottom: 0;
            color: transparent;
            cursor: pointer;
            height: 100%;
            left: 0;
            position: absolute;
            right: 0;
            top: 0;
            width: 100%;
        }

        /* Optional: remove default arrow in Firefox */
        input[type="date"]::-moz-calendar-picker-indicator,
        input[type="datetime-local"]::-moz-calendar-picker-indicator {
            cursor: pointer;
        }
    </style>
@endpush
@section('contentFields')


    <div class="col-12 no-padding-right ">
        <div class="row">
            <div class="col-2 mt-4 mb-4 ">
                <label class="filter_by" style="color:#000">Select Domains</label>
            </div>
            <div class="col-4" style="margin-top:5px">

                <select class="multi-select" name="domain_experience_id[]" id="domain_experience_id"
                    data-label = "Domain Experience" multiple data-multi-select>

                    @foreach (app\Models\DomainExperience::published()->get() as $team)
                        <option value="{{ $team->id }}" {{ in_array($team->id, $selectedDomainIds) ? 'selected' : '' }}>
                            {{ $team->title }}
                        </option>
                    @endforeach
                </select>

            </div>
        </div>

    </div>

    <div class="col-12 no-padding-right ">
        <div class="row">
            <div class="col-2 mt-4 mb-4 ">
                <label class="filter_by" style="color:#000">Topics of Interests</label>
            </div>
            <div class="col-4" style="margin-top:5px">

                <select class="multi-select" name="interest_id[]" id="interest_id" data-label = "Interests" multiple
                    data-multi-select>

                    @foreach (app\Models\Interest::published()->get() as $theme)
                        <option value="{{ $theme->id }}"
                            {{ in_array($theme->id, $selectedInterestIds) ? 'selected' : '' }}>
                            {{ $theme->title }}
                        </option>
                    @endforeach
                </select>

            </div>
        </div>

    </div>

    <div class="col-12 no-padding-right ">
        <div class="row">
            <div class="col-2 mt-4 mb-4 ">
                <label class="filter_by" style="color:#000">Select Skill Levels</label>
            </div>
            <div class="col-4" style="margin-top:5px">

                <select class="multi-select" name="skill_level_id[]" id="skill_level_id" data-label = "Skill Level" multiple
                    data-multi-select>

                    @foreach (\App\Models\SkillLevel::published()->get() as $skill)
                        <option value="{{ $skill->id }}"
                            {{ in_array($skill->id, $selectedSkillLevelIds ?? []) ? 'selected' : '' }}>
                            {{ $skill->title }}
                        </option>
                    @endforeach

                </select>

            </div>
        </div>

    </div>


    <div class="col-12 no-padding-right ">
        <div class="row">
            <div class="col-2 mt-4 mb-4 ">
                <label class="filter_by" style="color:#000">Select Learning Goals</label>
            </div>
            <div class="col-4" style="margin-top:5px">

                <select name="learnin_goal_id[]" id="learnin_goal_id" class="multi-select" multiple="multiple"
                    data-label = "Learning Goals" multiple data-multi-select>

                    @foreach (App\Models\LearninGoal::published()->get() as $theme)
                        <option value="{{ $theme->id }}"
                            {{ in_array($theme->id, $selectedLearningGoalIds ?? []) ? 'selected' : '' }}>
                            {{ $theme->title }}
                        </option>
                    @endforeach
                </select>
            </div>


        </div>







    @stop

    @push('extra_js')
        <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
        <script src="{{ asset('assets/admin/multiselect_js/popper.js') }}"></script>
        <script src="{{ asset('assets/admin/multiselect_js/bootstrap.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
        <script src="{{ asset('assets/admin/multiselect_js/main.js') }}"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                const blockMap = {
                    '1': 'individual',
                    '2': 'job_role',
                    '3': 'adminstrative_role',
                    '4': 'department',
                    // '5': 'team'
                };

                function toggleBlocks() {
                    let selected = $('#message_type_id').val();
                    $('.filter-block').hide();

                    if (selected && blockMap[selected]) {
                        $('.filter-block[data-block="' + blockMap[selected] + '"]').show();
                    }
                }

                toggleBlocks();
                $('#message_type_id').on('change', toggleBlocks);

                let route = "";

                $('#is_recurrent').on('change', function() {
                    let choice = $(this).val();
                    let $recurrentFields = $('.recurrent-fields');

                    if (choice == 1) {
                        $recurrentFields.show();
                    } else {
                        $recurrentFields.hide();
                    }
                });
                $('#is_recurrent').trigger('change');

                // -----------------------------
                // Department -> Teams dynamic population
                $(document).on('click', '#department_id .multi-select-option', function() {
                    let selectedValues = $('#department_id input[name="department_id[]"]')
                        .map(function() {
                            return $(this).val();
                        })
                        .get();

                    let $team = $('#team_id');
                    let $optionsWrapper = $team.find('.multi-select-options');

                    // capture previously selected BEFORE clearing
                    let previouslySelected = $team.find('input[name="team_id[]"]').map(function() {
                        return String($(this).val());
                    }).get();

                    // clear options + hidden inputs
                    $optionsWrapper.empty();
                    $team.find('input[name="team_id[]"]').remove();

                    if (selectedValues.length === 0) {
                        updateMultiSelectHeader($team);
                        return;
                    }

                    let url = "";
                    url = url.replace('DEPT_ID', selectedValues.join(','));

                    $.get(url, function(data) {
                        // --- Add Search Box ---
                        let $searchBox = $(`
                <div class="multi-select-search" style="padding:5px; width:100%;">
                    <input type="text" class="form-control form-control-sm team-search" placeholder="Search team...">
                </div>
            `);
                        $optionsWrapper.append($searchBox);

                        // --- Add Select All ---
                        let $selectAll = $(`
                <div class="multi-select-all" data-value="all" style="display:flex;">
                    <span class="multi-select-option-radio"></span>
                    <span class="multi-select-option-text">Select all</span>
                </div>
            `);
                        $optionsWrapper.append($selectAll);

                        // --- Add team options ---
                        $.each(data, function(index, teamName) {
                            let strIndex = String(index);
                            let isSelected = previouslySelected.includes(strIndex);

                            let $option = $(`
                    <div class="multi-select-option${isSelected ? ' multi-select-selected' : ''}" 
                         data-value="${strIndex}" style="display:flex;">
                        <span class="multi-select-option-radio"></span>
                        <span class="multi-select-option-text">${teamName}</span>
                    </div>
                `);

                            $optionsWrapper.append($option);

                            if (isSelected) {
                                $team.append('<input type="hidden" name="team_id[]" value="' +
                                    strIndex + '">');
                            }
                        });

                        // mark Select All if all already selected
                        if (
                            $optionsWrapper.find('.multi-select-option').length > 0 &&
                            $optionsWrapper.find('.multi-select-option.multi-select-selected')
                            .length === $optionsWrapper.find('.multi-select-option').length
                        ) {
                            $optionsWrapper.find('.multi-select-all').addClass('multi-select-selected');
                        }

                        updateMultiSelectHeader($team);
                    });
                });

                // Delegated click handler for team options
                $(document).on('click', '#team_id .multi-select-option', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    let $opt = $(this);
                    let $wrapper = $opt.closest('#team_id');
                    let value = String($opt.data('value'));

                    if ($opt.hasClass('multi-select-selected')) {
                        // deselect
                        $opt.removeClass('multi-select-selected');
                        $wrapper.find(`input[name="team_id[]"][value="${value}"]`).remove();
                    } else {
                        // select
                        $opt.addClass('multi-select-selected');
                        if ($wrapper.find(`input[name="team_id[]"][value="${value}"]`).length === 0) {
                            $wrapper.append(`<input type="hidden" name="team_id[]" value="${value}">`);
                        }
                    }

                    updateMultiSelectHeader($wrapper);
                });

                // Delegated click handler for "Select All"
                $(document).on('click', '#team_id .multi-select-all', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    let $all = $(this);
                    let $wrapper = $all.closest('#team_id');
                    let $options = $wrapper.find('.multi-select-option');
                    let $optionsWrapper = $wrapper.find('.multi-select-options');

                    if ($all.hasClass('multi-select-selected')) {
                        // Deselect all
                        $all.removeClass('multi-select-selected');
                        $options.removeClass('multi-select-selected');
                        $wrapper.find('input[name="team_id[]"]').remove();
                    } else {
                        // Select all
                        $all.addClass('multi-select-selected');
                        $options.addClass('multi-select-selected');
                        $wrapper.find('input[name="team_id[]"]').remove();

                        $options.each(function() {
                            let value = String($(this).data('value'));
                            $wrapper.append(`<input type="hidden" name="team_id[]" value="${value}">`);
                        });
                    }

                    updateMultiSelectHeader($wrapper);
                });

                // Delegated input handler for team search
                $(document).on('keyup', '#team_id .team-search', function() {
                    let term = $(this).val().toLowerCase();

                    $(this).closest('.multi-select-options')
                        .find('.multi-select-option')
                        .each(function() {
                            let txt = $(this).find('.multi-select-option-text').text().toLowerCase();
                            $(this).toggle(txt.indexOf(term) !== -1);
                        });
                });

                // Helper: update header text
                function updateMultiSelectHeader($multiSelectWrapper) {
                    let selectedTexts = $multiSelectWrapper
                        .find('.multi-select-option.multi-select-selected .multi-select-option-text')
                        .map(function() {
                            return $(this).text().trim();
                        })
                        .get();

                    $multiSelectWrapper.find('.multi-select-header .multi-select-header-option').remove();

                    if (selectedTexts.length === 0) {
                        $multiSelectWrapper.find('.multi-select-header').text('');
                        return;
                    }

                    selectedTexts.forEach(function(txt) {
                        $multiSelectWrapper.find('.multi-select-header')
                            .append(`<span class="multi-select-header-option">${txt}</span>`);
                    });

                    $multiSelectWrapper.find('.multi-select-header-max')
                        .text(selectedTexts.length > 1 ? ('+' + (selectedTexts.length - 1)) : '');
                }

                // send_date validation
                document.getElementById('send_date').addEventListener('input', function() {
                    const minTime = new Date();
                    minTime.setMinutes(minTime.getMinutes() + 10); // now + 10 mins

                    const selected = new Date(this.value);

                    if (selected < minTime) {
                        alert('Please select a date/time at least 10 minutes from now.');
                        this.value = ''; // reset
                    }
                });
            });
        </script>



        <script>
            class MultiSelect {

                constructor(element, options = {}) {
                    let defaults = {
                        placeholder: '' + ' ' + element.getAttribute('data-label') + '(s)',
                        max: null,
                        search: true,
                        selectAll: true,
                        listAll: true,
                        closeListOnItemSelect: false,
                        name: '',
                        width: '',
                        height: '',
                        dropdownWidth: '',
                        dropdownHeight: '',
                        data: [],
                        onChange: function() {},
                        onSelect: function() {},
                        onUnselect: function() {}
                    };
                    this.options = Object.assign(defaults, options);
                    this.selectElement = typeof element === 'string' ? document.querySelector(element) : element;
                    for (const prop in this.selectElement.dataset) {
                        if (this.options[prop] !== undefined) {
                            this.options[prop] = this.selectElement.dataset[prop];
                        }
                    }
                    this.name = this.selectElement.getAttribute('name').replace('[]', '');
                    if (!this.options.data.length) {
                        let options = this.selectElement.querySelectorAll('option');
                        for (let i = 0; i < options.length; i++) {
                            this.options.data.push({
                                value: options[i].value,
                                text: options[i].innerHTML,
                                selected: options[i].selected,
                                html: options[i].getAttribute('data-html')
                            });
                        }
                    }
                    this.element = this._template();
                    this.selectElement.replaceWith(this.element);
                    this._updateSelected();
                    this._eventHandlers();
                    this.findVueComponent();
                    this.updateVueForm();
                }

                _template() {
                    let optionsHTML = '';
                    for (let i = 0; i < this.data.length; i++) {
                        optionsHTML += `
                        <div class="multi-select-option${this.selectedValues.includes(this.data[i].value) ? ' multi-select-selected' : ''}" data-value="${this.data[i].value}">
                            <span class="multi-select-option-radio"></span>
                            <span class="multi-select-option-text">${this.data[i].html ? this.data[i].html : this.data[i].text}</span>
                        </div>
                    `;
                    }
                    let selectAllHTML = '';
                    if (this.options.selectAll === true || this.options.selectAll === 'true') {
                        selectAllHTML = `<div class="multi-select-all">
                        <span class="multi-select-option-radio"></span>
                        <span class="multi-select-option-text">Select all</span>
                    </div>`;
                    }
                    let template = `
                    <div class="multi-select ${this.name}"${this.selectElement.id ? ' id="' + this.selectElement.id + '"' : ''} style="${this.width ? 'width:' + this.width + ';' : ''}${this.height ? 'height:' + this.height + ';' : ''}">
                        ${this.selectedValues.map(value => `<input type="hidden" name="${this.name}[]" value="${value}">`).join('')}
                        <div class="multi-select-header" style="${this.width ? 'width:' + this.width + ';' : ''}${this.height ? 'height:' + this.height + ';' : ''}">
                            <span class="multi-select-header-max">${this.options.max ? this.selectedValues.length + '/' + this.options.max : ''}</span>
                            <span class="multi-select-header-placeholder">${this.placeholder}</span>
                        </div>
                        <div class="multi-select-options" style="${this.options.dropdownWidth ? 'width:' + this.options.dropdownWidth + ';' : ''}${this.options.dropdownHeight ? 'height:' + this.options.dropdownHeight + ';' : ''}">
                            ${this.options.search === true || this.options.search === 'true' ? '<input type="text" class="multi-select-search" placeholder="Search Option...">' : ''}
                            ${selectAllHTML}
                            ${optionsHTML}
                        </div>
                    </div>
                `;
                    let element = document.createElement('div');
                    element.innerHTML = template;
                    return element;
                }

                _eventHandlers() {
                    let headerElement = this.element.querySelector('.multi-select-header');
                    this.element.querySelectorAll('.multi-select-option').forEach(option => {
                        option.onclick = () => {
                            let selected = true;
                            if (!option.classList.contains('multi-select-selected')) {
                                if (this.options.max && this.selectedValues.length >= this.options.max) {
                                    return;
                                }
                                option.classList.add('multi-select-selected');
                                if (this.options.listAll === true || this.options.listAll === 'true') {
                                    if (this.element.querySelector('.multi-select-header-option')) {
                                        let opt = Array.from(this.element.querySelectorAll(
                                            '.multi-select-header-option')).pop();
                                        opt.insertAdjacentHTML('afterend',
                                            `<span class="multi-select-header-option" data-value="${option.dataset.value}">${option.querySelector('.multi-select-option-text').innerHTML}</span>`
                                        );
                                    } else {
                                        headerElement.insertAdjacentHTML('afterbegin',
                                            `<span class="multi-select-header-option" data-value="${option.dataset.value}">${option.querySelector('.multi-select-option-text').innerHTML}</span>`
                                        );
                                    }
                                }
                                this.element.querySelector('.multi-select').insertAdjacentHTML('afterbegin',
                                    `<input type="hidden" name="${this.name}[]" value="${option.dataset.value}">`
                                );
                                this.data.filter(data => data.value == option.dataset.value)[0].selected = true;
                            } else {
                                option.classList.remove('multi-select-selected');
                                this.element.querySelectorAll('.multi-select-header-option').forEach(
                                    headerOption => headerOption.dataset.value == option.dataset.value ?
                                    headerOption.remove() : '');
                                this.element.querySelector(`input[value="${option.dataset.value}"]`).remove();
                                this.data.filter(data => data.value == option.dataset.value)[0].selected =
                                    false;
                                selected = false;
                            }
                            if (this.options.listAll === false || this.options.listAll === 'false') {
                                if (this.element.querySelector('.multi-select-header-option')) {
                                    this.element.querySelector('.multi-select-header-option').remove();
                                }
                                headerElement.insertAdjacentHTML('afterbegin',
                                    `<span class="multi-select-header-option">${this.selectedValues.length} selected</span>`
                                );
                            }
                            if (!this.element.querySelector('.multi-select-header-option')) {
                                headerElement.insertAdjacentHTML('afterbegin',
                                    `<span class="multi-select-header-placeholder">${this.placeholder}</span>`
                                );
                            } else if (this.element.querySelector('.multi-select-header-placeholder')) {
                                this.element.querySelector('.multi-select-header-placeholder').remove();
                            }
                            if (this.options.max) {
                                this.element.querySelector('.multi-select-header-max').innerHTML = this
                                    .selectedValues.length + '/' + this.options.max;
                            }
                            if (this.options.search === true || this.options.search === 'true') {
                                this.element.querySelector('.multi-select-search').value = '';
                            }
                            this.element.querySelectorAll('.multi-select-option').forEach(option => option.style
                                .display = 'flex');
                            if (this.options.closeListOnItemSelect === true || this.options
                                .closeListOnItemSelect === 'true') {
                                headerElement.classList.remove('multi-select-header-active');
                            }

                            this.updateVueForm();

                            this.options.onChange(option.dataset.value, option.querySelector(
                                '.multi-select-option-text').innerHTML, option);
                            if (selected) {
                                this.options.onSelect(option.dataset.value, option.querySelector(
                                    '.multi-select-option-text').innerHTML, option);
                            } else {
                                this.options.onUnselect(option.dataset.value, option.querySelector(
                                    '.multi-select-option-text').innerHTML, option);
                            }
                        };
                    });
                    headerElement.onclick = () => headerElement.classList.toggle('multi-select-header-active');
                    if (this.options.search === true || this.options.search === 'true') {
                        let search = this.element.querySelector('.multi-select-search');
                        search.oninput = () => {
                            this.element.querySelectorAll('.multi-select-option').forEach(option => {
                                option.style.display = option.querySelector('.multi-select-option-text')
                                    .innerHTML.toLowerCase().indexOf(search.value.toLowerCase()) > -1 ? 'flex' :
                                    'none';
                            });
                        };
                    }
                    if (this.options.selectAll === true || this.options.selectAll === 'true') {
                        let selectAllButton = this.element.querySelector('.multi-select-all');
                        selectAllButton.onclick = () => {
                            let allSelected = selectAllButton.classList.contains('multi-select-selected');
                            this.element.querySelectorAll('.multi-select-option').forEach(option => {
                                let dataItem = this.data.find(data => data.value == option.dataset.value);
                                if (dataItem && ((allSelected && dataItem.selected) || (!allSelected && !
                                        dataItem.selected))) {
                                    option.click();
                                }
                            });
                            selectAllButton.classList.toggle('multi-select-selected');
                        };
                    }
                    if (this.selectElement.id && document.querySelector('label[for="' + this.selectElement.id + '"]')) {
                        document.querySelector('label[for="' + this.selectElement.id + '"]').onclick = () => {
                            headerElement.classList.toggle('multi-select-header-active');
                        };
                    }

                    document.addEventListener('click', event => {
                        if (!event.target.closest('.' + this.name) && !event.target.closest('label[for="' + this
                                .selectElement.id + '"]')) {
                            headerElement.classList.remove('multi-select-header-active');
                        }
                    });

                    // Initialize Vue form data
                    this.updateVueForm();
                }

                updateVueForm() {
                    // Find the Vue component instance
                    const vueComponent = this.findVueComponent();
                    if (vueComponent && vueComponent.form) {
                        // Convert selected values to integers (matching your validation rule)
                        const selectedJobRoles = this.selectedValues.map(val => parseInt(val));

                        // Update the Vue form data
                        if (vueComponent.form.hasOwnProperty('job_roles')) {
                            vueComponent.form.job_roles = selectedJobRoles;
                        } else {
                            vueComponent.$set(vueComponent.form, 'job_roles', selectedJobRoles);
                        }

                        console.log('Vue form job_roles updated:', vueComponent.form.job_roles);
                    }
                }

                findVueComponent() {
                    // Look for the course-form Vue component
                    let element = this.element.closest('form');
                    while (element) {
                        if (element.__vue__) {
                            return element.__vue__;
                        }
                        element = element.parentElement;
                    }

                    // Fallback: try to find any Vue instance on the page
                    const vueElements = document.querySelectorAll('[data-v-*], [class*="v-"], form');
                    for (let el of vueElements) {
                        if (el.__vue__ && el.__vue__.form) {
                            return el.__vue__;
                        }
                    }

                    return null;
                }

                _updateSelected() {
                    if (this.options.listAll === true || this.options.listAll === 'true') {
                        this.element.querySelectorAll('.multi-select-option').forEach(option => {
                            if (option.classList.contains('multi-select-selected')) {
                                this.element.querySelector('.multi-select-header').insertAdjacentHTML('afterbegin',
                                    `<span class="multi-select-header-option" data-value="${option.dataset.value}">${option.querySelector('.multi-select-option-text').innerHTML}</span>`
                                );
                            }
                        });
                    } else {
                        if (this.selectedValues.length > 0) {
                            this.element.querySelector('.multi-select-header').insertAdjacentHTML('afterbegin',
                                `<span class="multi-select-header-option">${this.selectedValues.length} selected</span>`
                            );
                        }
                    }
                    if (this.element.querySelector('.multi-select-header-option')) {
                        this.element.querySelector('.multi-select-header-placeholder').remove();
                    }
                }

                get selectedValues() {
                    return this.data.filter(data => data.selected).map(data => data.value);
                }

                get selectedItems() {
                    return this.data.filter(data => data.selected);
                }

                set data(value) {
                    this.options.data = value;
                }

                get data() {
                    return this.options.data;
                }

                set selectElement(value) {
                    this.options.selectElement = value;
                }

                get selectElement() {
                    return this.options.selectElement;
                }

                set element(value) {
                    this.options.element = value;
                }

                get element() {
                    return this.options.element;
                }

                set placeholder(value) {
                    this.options.placeholder = value;
                }

                get placeholder() {
                    return this.options.placeholder;
                }

                set name(value) {
                    this.options.name = value;
                }

                get name() {
                    return this.options.name;
                }

                set width(value) {
                    this.options.width = value;
                }

                get width() {
                    return this.options.width;
                }

                set height(value) {
                    this.options.height = value;
                }

                get height() {
                    return this.options.height;
                }

            }
            document.querySelectorAll('[data-multi-select]').forEach(select => new MultiSelect(select));
        </script>
    @endpush
