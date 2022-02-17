const app = new Vue({
    el: '#booking-form',

    components: {
        vuejsDatepicker
    },

    data () {
        return {
            errors: {},
            page: 1,
            form: {
                // Page 1
                treatmentType: null,
                bodyArea: null,
                skinTone: null,
                hairColour: null,
                skinReaction: null,
                heritage: null,
                treatments: [],

                // Page 2
                name: null,
                phone: null,
                email: null,
                over16: null,
                acceptTerms: null,
            },
            options: window.vueVariables,
            submitting: false
        }
    },

    computed: {
        errorCount () {
            return Object.values(this.errors).filter(error => error).length;
        },
        timeSlots () {
            let items = [];
            for (let hour = 8; hour < 17; hour++) {
                items.push([hour, 0]);
                items.push([hour, 30]);
            }
            items.push([17, 0]);

            const formatter1 = new Intl.DateTimeFormat('en-US', {
                hour: 'numeric',
                minute: 'numeric',
                hour12: true
            });

            const formatter2 = new Intl.DateTimeFormat('en-US', {
                hour: 'numeric',
                minute: 'numeric',
                hour12: false
            });

            return items.map(time => {
                const [hour, minute] = time;
                const date = new Date();
                date.setHours(hour);
                date.setMinutes(minute);

                return { date: formatter2.format(date), label: formatter1.format(date) };
            });
        }
    },

    methods: {
        autofill () {
            this.form.treatmentType = this.options.treatments[0];
            this.form.bodyArea = this.options.bodyArea[0];
            this.form.skinTone = this.options.skinTone[0];
            this.form.hairColour = this.options.hairColour[0];
            this.form.skinReaction = this.options.skinReaction[0];
            this.form.heritage = this.options.heritage[0];
            this.toggleTreatment(this.form.treatmentType.services[0], this.form.treatmentType.name);
            this.toggleTreatment(this.form.treatmentType.services[1], this.form.treatmentType.name);

            this.form.name = 'Test User';
            this.form.phone = '0400000000';
            this.form.email = 'test@example.com';
            this.form.over16 = true;
            this.form.acceptTerms = true;
            this.form.treatments[0].date = new Date('2022-01-03');
            this.form.treatments[0].time = this.timeSlots[0].date;
            this.form.treatments[1].date = new Date('2022-01-01');
            this.form.treatments[1].time = this.timeSlots[1].date;
        },
        continueToPage2 () {
            const requiredFields = ['treatmentType', 'bodyArea', 'skinTone', 'hairColour', 'skinReaction', 'heritage'];

            for (const field of requiredFields) {
                if (!this.form[field]) {
                    Vue.set(this.errors, field, 'Please select an option from the list.');
                } else {
                    Vue.set(this.errors, field, null);
                }
            }

            if (this.form.treatments.length === 0) {
                Vue.set(this.errors, 'treatments', 'Please select at least one treatment.');
            } else {
                Vue.set(this.errors, 'treatments', null);
            }

            if (this.errorCount === 0) {
                this.page = 2;

                jQuery('html, body').animate({
                    scrollTop: jQuery("#booking-form").offset().top
                }, 1000);
            }
        },
        continueToPage3 () {
            this.page = 3;
        },
        goBackToPage1 () {
            this.errors = {};
            this.page = 1;
        },
        confirmBooking () {
            Vue.set(this.errors, 'page2', null);

            const requiredFields = ['name', 'phone', 'email'];
            Vue.set(this.errors, 'personalInformation', null);
            for (const field of requiredFields) {
                if (!this.form[field]) {
                    Vue.set(this.errors, 'personalInformation', 'Please complete your personal information.');
                    break;
                }
            }

            Vue.set(this.errors, 'dateAndTime', null);
            for (const treatment of this.form.treatments) {
                if (!treatment.date || !treatment.time) {
                    Vue.set(this.errors, 'dateAndTime', 'Please select a date and time for each treatment.');
                    break;
                }
            }

            if (this.errorCount > 0) {
                Vue.set(this.errors, 'page2', 'Please complete all fields to confirm your booking.');
                return;
            }

            const checkboxes = ['over16', 'acceptTerms'];
            for (const field of checkboxes) {
                if (!this.form[field]) {
                    Vue.set(this.errors, 'page2', 'The checkboxes above must be checked to confirm your booking.');
                    break;
                }
            }

            if (this.errorCount > 0) {
                return;
            }

            this.submitting = true;

            const formData = this.form;
            jQuery.ajax(window.ajax.url + '?action=submit_booking_form', {
                method: 'POST',
                data: JSON.stringify(formData),
                dataType: 'json',
                processData: false,
                contentType: 'application/json'
            }).success(response => {
                this.continueToPage3();
            }).fail(xhr => {
                console.log(xhr);
                Vue.set(this.errors, 'page2', 'Sorry, something went wrong. Please try again in a moment.');
            }).always(() => {
                this.submitting = false;
            });

        },
        dateTimeInputChanged () {
            for (const treatment of this.form.treatments) {
                if (!treatment.date || !treatment.time) {
                    return;
                }
            }
            Vue.set(this.errors, 'dateAndTime', null);
        },
        toggleTreatment (treatment, treatmentType) {
            if (treatmentType) {
                treatment.type = treatmentType;
                treatment.date = null;
                treatment.time = null;
            }

            if (this.form.treatments.includes(treatment)) {
                this.form.treatments.splice(this.form.treatments.findIndex(x => x.name === treatment.name), 1);
            } else {
                this.form.treatments.push(treatment);
                Vue.set(this.errors, 'treatments', null);
            }
        },
        inputChanged (field) {
            if (field === 'name' || field === 'phone' || field === 'email') {
                if (this.form.name && this.form.phone && this.form.email) {
                    Vue.set(this.errors, 'personalInformation', null);
                }
                return;
            }

            if (this.form[field]) {
                Vue.set(this.errors, field, null);
            }
        },
        updateField (field, value) {
            Vue.set(this.form, field, value);
            if (value) {
                Vue.set(this.errors, field, null);
            }
        }
    }
});

jQuery(document).ready(function ($) {
    $('#booking-sidebar').stickySidebar({
        topSpacing: 151,
        bottomSpacing: 60
    });

    // $('.next').click(function () {
    //     $('#tab-1').hide();
    //     $('#tab-2').show();
    //     $('.booking-summary .summary-header a').show();
    //     $('.booking-summary .summary-footer').css('display', 'flex');
    //     $('html, body').animate({
    //         scrollTop: $("#booking-form").offset().top
    //     }, 1000);
    //     $('.steps #step-1').removeClass('current').addClass('done');
    //     $('.steps #step-2').addClass('current');
    //
    //     $('.next').hide();
    //     $('.back').show();
    //     return false;
    // });
    //
    // $('.back').click(function () {
    //     $('#tab-2').hide();
    //     $('#tab-1').show();
    //     $('html, body').animate({
    //         scrollTop: $("#booking-form").offset().top
    //     }, 1000);
    //
    //     $('.booking-summary .summary-header a').hide();
    //     $('.booking-summary .summary-footer').css('display', 'none');
    //     $('.steps #step-1').removeClass('done').addClass('current');
    //     $('.steps #step-2').removeClass('current');
    //     $('.back').hide();
    //     $('.next').show();
    //     return false;
    // });
    //
    // $('.book-now').click(function () {
    //     $('#tab-2').hide();
    //     $('#tab-3').show();
    //     $('html, body').animate({
    //         scrollTop: $("#booking-form").offset().top
    //     }, 1000);
    //
    //     $('.booking-summary .summary-header a').hide();
    //     $('.booking-summary .summary-footer').css('display', 'none');
    //     $('.steps #step-2').removeClass('current').addClass('done');
    //     $('.steps #step-3').addClass('current');
    //     $('.back').hide();
    //     $('.home-button').show();
    //     return false;
    // });
    //
    // $('.service-button').click(function () {
    //     var btnID = $(this).data('id');
    //     $('.service-button').removeClass("active");
    //     $('.service-' + btnID).addClass('active');
    //     $('.service-list').removeClass("show");
    //     $('.list-' + btnID).toggleClass("show");
    //     $('.selected-list').removeClass("show");
    //     $('.selected-list-' + btnID).toggleClass("show");
    //     $('.summary-list').removeClass("show");
    //     $('.summary-' + btnID).toggleClass("show");
    // });
    //
    // $('.part-button').click(function () {
    //     var btnID = $(this).data('id');
    //     $('.part-button').removeClass("active");
    //     $('.part-' + btnID).addClass('active');
    // });
    //
    // $('.tone-button').click(function () {
    //     var btnID = $(this).data('id');
    //     $('.tone-button').removeClass("active");
    //     $('.tone-' + btnID).addClass('active');
    // });
    //
    // $('.hair-button').click(function () {
    //     var btnID = $(this).data('id');
    //     $('.hair-button').removeClass("active");
    //     $('.hair-' + btnID).addClass('active');
    // });
    //
    // $('.add-button').click(function () {
    //     var btnID = $(this).data('id');
    //
    //     $('.show .add-' + btnID).toggleClass('selected');
    //
    //     if ($('.show .add-' + btnID).hasClass('selected')) {
    //         $(this).text('REMOVE');
    //     } else {
    //         $(this).text('ADD');
    //     }
    //
    //     $('.show .item-' + btnID).toggleClass('show');
    //     $('.show .summary-' + btnID).toggleClass('show');
    //
    // });
    //
    // $('.remove').click(function () {
    //     var btnID = $(this).data('id');
    //     $('.show .add-' + btnID).toggleClass('selected');
    //     console.log(btnID);
    //
    //     $('.show .add-' + btnID).text('ADD');
    //
    //     $('.show .item-' + btnID).toggleClass('show');
    //     $('.show .summary-' + btnID).toggleClass('show');
    // });
    //
    // $('.select-date').datepicker();
    //
    // $('.select-time').timepicker({
    //     timeFormat: 'h:mm p',
    //     interval: 30,
    //     minTime: '8',
    //     maxTime: '5:00pm',
    //     defaultTime: '8',
    //     startTime: '8:00',
    //     dynamic: false,
    //     dropdown: true,
    //     scrollbar: true
    // });
});
