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
    constructor(adminController, element) {

        adminController.log('Processing item', element);

        this.adminController = adminController;
        this.$element = $(element);
        this.$id = $('.js-address-picker__id', element);
        this.$label = $('.js-address-picker__label', element);
        this.$line_1 = $('.js-address-picker__line_1', element);
        this.$line_2 = $('.js-address-picker__line_2', element);
        this.$line_3 = $('.js-address-picker__label', element);
        this.$town = $('.js-address-picker__town', element);
        this.$region = $('.js-address-picker__region', element);
        this.$postcode = $('.js-address-picker__postcode', element);
        this.$country = $('.js-address-picker__country', element);
        this.id = this.$id.val();

        if (this.id) {
            this.adminController.log(`Looking up address ${this.id}`);

            $.get({
                'url': `${window.SITE_URL}api/address/address/${this.id}`
            })
                .done((response) => {
                    this.$label.val(response.data.label);
                    this.$line_1.val(response.data.line_1);
                    this.$line_2.val(response.data.line_2);
                    this.$line_3.val(response.data.line_3);
                    this.$town.val(response.data.town);
                    this.$region.val(response.data.region);
                    this.$postcode.val(response.data.postcode);
                    this.$country.val(response.data.country).trigger('change');
                })
                .fail(() => {
                    this.adminController.log('womp womp');
                })
                .always(() => {
                    this.$element.removeClass('loading');
                });

        } else {
            this.adminController.log('Nothing to do');
            this.$element.removeClass('loading');
        }
    }
}

export default AddressPicker;
