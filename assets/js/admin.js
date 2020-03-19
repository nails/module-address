'use strict';

import '../sass/admin.scss';
import AddressPicker from './components/AddressPicker.js';

(function() {
    window.NAILS.ADMIN.registerPlugin(
        'nails/module-address',
        'AddressPicker',
        function(controller) {
            return new AddressPicker(controller);
        }
    );
})();
