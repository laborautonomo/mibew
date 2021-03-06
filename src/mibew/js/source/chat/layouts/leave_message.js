/*!
 * Copyright 2005-2014 the original author or authors.
 *
 * Licensed under the Apache License, Version 2.0 (the "License").
 * You may obtain a copy of the License at
 *     http://www.apache.org/licenses/LICENSE-2.0
 */

(function(Mibew, Backbone){

    /**
     * Represents leave message page layout
     */
    Mibew.Layouts.LeaveMessage = Backbone.Marionette.Layout.extend(
        /** @lends Mibew.Layouts.LeaveMessage.prototype */
        {
            /**
             * Template function
             * @type Function
             */
            template: Handlebars.templates['leave_message/layout'],

            /**
             * Regions list
             * @type Object
             */
            regions: {
                leaveMessageFormRegion: '#content-wrapper',
                descriptionRegion: '#description-region'
            },

            /**
             * Override Backbone.Marionette.ItemView.serializeData to pass some
             * extra fields to template.
             *
             * Use undocumented feature of layouts: passing data to template via
             * serializeData method.
             *
             * @returns {Object} Template data
             */
            serializeData: function() {
                return {
                    page: Mibew.Objects.Models.page.toJSON()
                }
            }
        }
    );

})(Mibew, Backbone);