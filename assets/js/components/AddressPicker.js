class AddressPicker {

    /**
     * Construct Address pickers
     * @param adminController
     */
    constructor(adminController) {

        this.adminController = adminController;
        this.instances = [];

        this.adminController.onRefreshUi((domElement) => {
            this.initPickers(domElement);
        });
    };

    // --------------------------------------------------------------------------

    /**
     * Processes Address pickers and populates them if they have an ID
     * @return {void}
     */
    initPickers(domElement) {
        this.adminController.log('Processing new Address Pickers');
        $('.js-address-picker:not(.processed)')
            .addClass('processed')
            .each((index, element) => {
                this.instances
                    .push(
                        new AddressPickerInstance(
                            this.adminController,
                            element
                        )
                    );
            });
    };
}

class AddressPickerInstance {

    /**
     * Construct AddressPickerInstance
     *
     * @param adminController
     * @param element
     */
    constructor(adminController, element) {

        adminController.log('Processing item', element);

        this.adminController = adminController;
        this.loading = true;
        this.dirty = false;

        this
            .findElements(element)
            .bindListeners()
            .init();
    }

    // --------------------------------------------------------------------------

    /**
     * Locates the various elements of the picker
     * @param element
     * @returns {AddressPickerInstance}
     */
    findElements(element) {
        this.$element = $(element);
        this.$form = this.$element.closest('form');
        this.$id = $('.js-address-picker__id', element);
        this.$label = $('.js-address-picker__label', element);
        this.$line_1 = $('.js-address-picker__line_1', element);
        this.$line_2 = $('.js-address-picker__line_2', element);
        this.$line_3 = $('.js-address-picker__line_3', element);
        this.$town = $('.js-address-picker__town', element);
        this.$region = $('.js-address-picker__region', element);
        this.$postcode = $('.js-address-picker__postcode', element);
        this.$country = $('.js-address-picker__country', element);

        return this;
    }

    // --------------------------------------------------------------------------

    /**
     * Binds listeners
     * @returns {AddressPickerInstance}
     */
    bindListeners() {

        this.sniffForChanges = [
            this.$label,
            this.$line_1,
            this.$line_2,
            this.$line_3,
            this.$town,
            this.$region,
            this.$postcode,
            this.$country,
        ];

        for (let i = 0; i < this.sniffForChanges.length; i++) {
            this.sniffForChanges[i]
                .on('blur', () => {
                    this.testDirty();
                });
        }

        this.$form.on('submit', () => {
            if (this.dirty) {
                this.$id.val(null);
            }
        })
        return this;
    }

    // --------------------------------------------------------------------------

    init() {

        let id = this.$id.val();

        if (id) {
            this.adminController.log(`Looking up address ${id}`);

            $.get({
                'url': `${window.SITE_URL}api/address/address/${id}`
            })
                .done((response) => {
                    //  Set orig values
                    this.$label.data('orig-value', response.data.label || '');
                    this.$line_1.data('orig-value', response.data.line_1 || '');
                    this.$line_2.data('orig-value', response.data.line_2 || '');
                    this.$line_3.data('orig-value', response.data.line_3 || '');
                    this.$town.data('orig-value', response.data.town || '');
                    this.$region.data('orig-value', response.data.region || '');
                    this.$postcode.data('orig-value', response.data.postcode || '');
                    this.$country.data('orig-value', response.data.country || '');

                    if (!this.$label.val().length) {
                        this.$label.val(response.data.label);
                    }

                    if (!this.$line_1.val().length) {
                        this.$line_1.val(response.data.line_1);
                    }

                    if (!this.$line_2.val().length) {
                        this.$line_2.val(response.data.line_2);
                    }

                    if (!this.$line_3.val().length) {
                        this.$line_3.val(response.data.line_3);
                    }

                    if (!this.$town.val().length) {
                        this.$town.val(response.data.town);
                    }

                    if (!this.$region.val().length) {
                        this.$region.val(response.data.region);
                    }

                    if (!this.$postcode.val().length) {
                        this.$postcode.val(response.data.postcode);
                    }

                    if (!this.$country.find(':selected').val()) {
                        this.$country.val(response.data.country).trigger('change');
                    }

                    this.testDirty();
                })
                .fail((response) => {

                    let data;
                    try {
                        data = JSON.parse(response.responseText);
                    } catch (e) {
                        data = {'error': 'An unknown error occurred.'}
                    }

                    this.adminController.error(data.error);
                })
                .always(() => {
                    this.setLoading(false);
                });

        } else {
            this.adminController.log('Nothing to do');
            this.$element.removeClass('loading');
            this.setLoading(false);
        }

        return this;
    }

    // --------------------------------------------------------------------------

    testDirty() {
        this.dirty = false;
        for (let i = 0; i < this.sniffForChanges.length; i++) {
            if (this.sniffForChanges[i].val() !== this.sniffForChanges[i].data('orig-value')) {
                this.dirty = true;
                break;
            }
        }
    }

    // --------------------------------------------------------------------------

    setLoading(isLoading) {
        if (isLoading) {
            this.loading = true;
            this.$element.addClass('loading');
        } else {
            this.loading = false;
            this.$element.removeClass('loading');
        }
    }
}

export default AddressPicker;
