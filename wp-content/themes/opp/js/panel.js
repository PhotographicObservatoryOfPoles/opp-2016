(function(window) {

    'use strict';

    /**
     * Extend Object helper function.
     */
    function extend(a, b) {
        for(var key in b) {
            if(b.hasOwnProperty(key)) {
                a[key] = b[key];
            }
        }
        return a;
    }

    /**
     * Each helper function.
     */
    function each(collection, callback) {
        for (var i = 0; i < collection.length; i++) {
            var item = collection[i];
            callback(item);
        }
    }

    /**
     * Panel Constructor.
     */
    function Panel(options) {
        this.options = extend({}, this.options);
        extend(this.options, options);
        this._init();
    }

    /**
     * Panel Options.
     */
    Panel.prototype.options = {
        panel: '#panel-id',                      // The panel ID
        type: '',                                // The panel type: push(-right)(-left), slide(-right)(-left)(-top)(-bottom)
        openerClass: '.button--panel-open',      // The panel opener class names (i.e. the buttons)
        maskId: '#mask'                          // The ID of the mask (can be optional)
    };

    /**
     * Initialise Panel.
     */
    Panel.prototype._init = function() {
        this.body = document.body;
        this.mask = document.querySelector(this.options.maskId);
        this.panel = document.querySelector(this.options.panel);
        this.type = this.options.type;
        this.closeBtn = this.panel.querySelector('.button--panel-close');
        this.panelOpeners = document.querySelectorAll(this.options.openerClass);
        this._initEvents();
    };

    /**
     * Initialise Panel Events.
     */
    Panel.prototype._initEvents = function() {
        // Event for clicks on the close button inside the panel.
        this.closeBtn.addEventListener('click', function(e) {
            e.preventDefault();
            this.close();
        }.bind(this));

        // Event for clicks on the mask.
        if (this.mask) {
            this.mask.addEventListener('click', function(e) {
                e.preventDefault();
                this.close();
            }.bind(this));
        }
        
    };

    /**
     * Open Panel.
     */
    Panel.prototype.open = function() {
        if (this.type === 'push-left') {
            this.body.classList.add('panel-push-toright');
        }
        if (this.type === 'push-right') {
            this.body.classList.add('panel-push-toleft');
        }
        this.panel.classList.add('panel-open');
        if (this.mask) {
            this.mask.classList.add('is-active');
        }
        this.disablePanelOpeners();
    };

    /**
     * Close Panel.
     */
    Panel.prototype.close = function() {
        if (this.type === 'push-left') {
            this.body.classList.remove('panel-push-toright');
        }
        if (this.type === 'push-right') {
            this.body.classList.remove('panel-push-toleft');
        }
        this.panel.classList.remove('panel-open');
        if (this.mask) {
            this.mask.classList.remove('is-active');
        }
        this.enablePanelOpeners();
    };

    /**
     * Disable Panel Openers.
     */
    Panel.prototype.disablePanelOpeners = function() {
        var isMainNavPanel = this.options.panel == '#panel-navigation' ? true : false;
        each(this.panelOpeners, function(item) {
            item.disabled = true;
            if (isMainNavPanel) {
                item.classList.add('is-active');
            }
        });
    };

    /**
     * Enable Panel Openers.
     */
    Panel.prototype.enablePanelOpeners = function() {
        var isMainNavPanel = this.options.panel == '#panel-navigation' ? true : false;
        each(this.panelOpeners, function(item) {
            item.disabled = false;
            if (isMainNavPanel) {
                item.classList.remove('is-active');
            }
        });
    };

    /**
     * Add to global namespace.
     */
    window.Panel = Panel;

})(window);