/* eslint-disable */
(function () {
    /* eslint-disable */
    if (!window.$mcSite) {
        $mcSite = {
            optinFeatures: [],
            enableOptIn: function () {
                this.createCookie("mc_user_optin", true, 365);
                this.optinFeatures.forEach(function (fn) {
                    fn();
                });
            },

            runIfOptedIn: function (fn) {
                if (this.hasOptedIn()) {
                    fn();
                } else {
                    this.optinFeatures.push(fn);
                }
            },

            hasOptedIn: function () {
                var cookieValue = this.readCookie("mc_user_optin");

                if (cookieValue === undefined) {
                    return true;
                }

                return cookieValue === "true";
            },

            createCookie: function (name, value, expirationDays) {
                var cookie_value = encodeURIComponent(value) + ";";
                
                if (expirationDays === undefined) {
                    throw new Error("expirationDays is not defined");
                }

                // set expiration
                if (expirationDays !== null) {
                    var expirationDate = new Date();
                    expirationDate.setDate(expirationDate.getDate() + expirationDays);
                    cookie_value += " expires=" + expirationDate.toUTCString() + ";";
                }
    
                cookie_value += "path=/";
                document.cookie = name + "=" + cookie_value;
            },

            readCookie: function (name) {
                var nameEQ = name + "=";
                var ca = document.cookie.split(";");
    
                for (var i = 0; i < ca.length; i++) {
                    var c = ca[i];
    
                    while (c.charAt(0) === " ") {
                        c = c.substring(1, c.length);
                    }
    
                    if (c.indexOf(nameEQ) === 0) {
                        return c.substring(nameEQ.length, c.length);
                    }
                }
    
                return undefined;
            }
        };
    }

    $mcSite.shopify_attribution_cookie={settings:{}};
})();
/**
 * This file contains code that will maintain an MC cookie on a Shopify store's site.
 * The cookie stores data from our tracking params (utm_*, mc_* params) to then be
 * attributed to an order during the Shopify checkout process and allow us to have
 * more flexibility in conversion attribution for our outreaches (campaigns, ads, etc).
 */
(function () {
    /**
     * A namespace for MC for Shopify's conversion attribution.
     * @namespace
     */
    var conversion = {
        /**
         * Looks for MC tracking params, validates their values, then stores them in a cookie.
         */
        processParameters: function () {
            var utmCampaignParam = this.getParameter("utm_campaign");
            var utmSourceParam = this.getParameter("utm_source");
            var utmMediumParam = this.getParameter("utm_medium");
            var gclid = this.getParameter("gclid");
            var mccid = this.getParameter("mc_cid");

            if (this.isValidUTMCampaign(utmCampaignParam) &&
                this.isValidUTMSource(utmSourceParam) &&
                this.isValidUTMMedium(utmMediumParam)
            ) {
                this.storeEngagement(utmCampaignParam, utmSourceParam, utmMediumParam, gclid, /* expiration, in days */ 365);
            } else if (this.isValidMCCID(mccid)) {
                this.storeMCCIDEngagement(mccid, 365);
            }
        },
        /**
         * Convert our saved engagement data to Shopify cart attributes
         * @param {Object}  engagement Engagement object from our cookie.
         * @return {Object} Engagement object to be sent to Shopify's cart attribute input fields.
         */
        engagementToAttribs: function (engagement) {
            return {
                "utm_campaign": engagement.id,
                "utm_source": engagement.src,
                "utm_medium": engagement.medium,
                "created_at": engagement.created_at,
                "gclid": engagement.gclid,
                "mc_cid": engagement.mccid
            };
        },
        /**
         * Handles injecting cart attribute input fields into the Shopify Cart form.
         * @param {Element} cartForm   Shopify Cart form's Document Element.
         * @param {Object}  engagement Engagement object from our cookie.
         */
        injectCartAttributes: function (cartForm, engagement) {
            var attribs = this.engagementToAttribs(engagement);
            var p = this.createAttributeParagraphElement();
            for (var attribName in attribs) {
                if (attribs.hasOwnProperty(attribName)) {
                    var input = this.createAttributeInputField(attribName, attribs[attribName]);
                    p.appendChild(input);
                }
            }
            cartForm.appendChild(p);
        },
        /**
         * Checks if "Do Not Track" is enabled.
         * @return {Boolean} Whether the browser has "Do Not Track" enabled.
         */
        isDoNotTrack: function () {
            if (navigator.doNotTrack === "1") {
                return true;
            }

            if (navigator.msDoNotTrack === "1") {
                return true;
            }

            return false;
        },
        /**
         * Gets the current unix timestamp.
         * @return {Number} The timestamp in seconds.
         */
        getUnixTimestamp: function () {
            return Math.round((new Date()).getTime() / 1000);
        },
        /**
         * Gets the value of a query parameter.
         * @param {String} name     The param name.
         * @return {String|null}    The param value.
         */
        getParameter: function (name) {
            name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
            var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
            var results = regex.exec(location.search);

            return results === null ? null : decodeURIComponent(results[1].replace(/\+/g, " "));
        },
        /**
         * Checks if the "utm_campaign" value is valid.
         * @param {String} utmCampaignParam The param value.
         * @return {Boolean}                Whether the value is valid.
         */
        isValidUTMCampaign: function (utmCampaignParam) {
            if (!utmCampaignParam) {
                return false;
            }

            var regex = new RegExp("^[a-zA-Z0-9]{10,12}$"); // unique_id for campaigns is 10, ads is 12

            return utmCampaignParam.search(regex) === -1 ? false : true;
        },
        /**
         * Checks if the "utm_source" value is valid.
         * @param {String} utmSourceParam   The param value.
         * @return {Boolean}                Whether the value is valid.
         */
        isValidUTMSource: function (utmSourceParam) {
            if (!utmSourceParam) {
                return false;
            }

            var regex = new RegExp("^mailchimp$", "i");

            return utmSourceParam.search(regex) === -1 ? false : true;
        },
        /**
         * Checks if the "utm_medium" value is valid.
         * @param {String} utmMediumParam   The param value.
         * @return {Boolean}                Whether the value is valid.
         */
        isValidUTMMedium: function (utmMediumParam) {
            if (!utmMediumParam) {
                return false;
            }

            var regex = new RegExp("^(campaign|ad)$", "i");

            return utmMediumParam.search(regex) === -1 ? false : true;
        },
        /**
         * Checks if the "mc_cid" value is valid.
         * @param {String} mccid            The param value.
         * @return {Boolean}                Whether the value is valid.
         */
        isValidMCCID: function (mccid) {
            if (!mccid) {
                return false;
            }

            var regex = new RegExp("^[a-zA-Z0-9]{10,12}$"); // unique_id for campaigns is 10, ads is 12

            return mccid.search(regex) === -1 ? false : true;
        },
        /**
         * Gets engagement objects from the stored cookie.
         * @return {Object[]} An array of engagement objects.
         */
        getEngagements: function () {
            var cookie = this.readCookie("mc_track");
            var engagements = JSON.parse(decodeURIComponent(cookie));

            return engagements !== null ? engagements : [];
        },
        /**
         * Gets engagement objects from the stored cookie, sorted by creation time.
         * @return {Object[]} An array of engagement objects.
         */
        getEngagementsSortedByCreatedAt: function () {
            var engagements = this.getEngagements();
            return engagements.sort(function (a, b) {return b.created_at - a.created_at;});
        },
        /**
         * Gets the most recent engagement object.
         * @return {Object|null} An engagement object.
         */
        getMostRecentEngagement: function () {
            var engagements = this.getEngagementsSortedByCreatedAt();
            return engagements.length > 0 ? engagements[0] : null;
        },
        /**
         * Gets whether an engagement with the provided id is already stored.
         * @param {String} id   Engagment id to be checked.
         * @return {Boolean}    Whether the engagement is already stored.
         */
        hasStoredEngagement: function (id) {
            var engagements = this.getEngagements();
            return engagements.filter(function (obj) {return obj.id === id;}).length === 0 ? false : true;
        },
        /**
         * Returns whether an mc_cid is already stored as an engagement.
         *
         * @param {String} mccid    The mc_cid.
         *
         * @return {boolean}        Whether the engagement is already stored.
         */
        hasStoredMCCIDEngagement: function (mccid) {
            return this.getEngagements().filter(function (obj) {return obj.mccid && obj.mccid === mccid;}).length === 0 ? false : true;
        },
        /**
         * Stores an engagement object in the cookie.
         * @param {String} id           The engagement id / utm_campaign.
         * @param {String} source       The utm_source.
         * @param {String} medium       The utm_medium.
         * @param {String} gclid        The gclid.
         * @param {number} expiration   Number of days before this should expire.
         */
        storeEngagement: function (id, source, medium, gclid, expiration) {
            if (!this.hasStoredEngagement(id)) {
                var engagements = this.getEngagements();

                var engagementObj = this.generateEngagementObject(id, source, medium, gclid, null);
                engagements.push(engagementObj);

                // unix timestamp of ~2 months ago
                var twoMonthsAgo = this.getUnixTimestamp() - 60 * 60 * 24 * 60;

                // remove engagements older than 2 months
                var recentEngagements = engagements.filter(function (obj) {
                    return obj.created_at > twoMonthsAgo;
                });

                this.createCookie("mc_track", JSON.stringify(recentEngagements), expiration);
            }
        },
        /**
         * Stores an mc_cid engagement.
         *
         * @param {String} mccid        The mc_cid.
         * @param {number} expiration   Expiration, in days.
         */
        storeMCCIDEngagement: function (mccid, expiration) {
            if (this.hasStoredMCCIDEngagement(mccid)) {
                return;
            }

            var engagements = this.getEngagements();

            var engagementObj = this.generateEngagementObject(null, null, null, null, mccid);
            engagements.push(engagementObj);

            // unix timestamp of ~2 months ago
            var twoMonthsAgo = this.getUnixTimestamp() - 60 * 60 * 24 * 60;

            // remove engagements older than 2 months
            var recentEngagements = engagements.filter(function (obj) {
                return obj.created_at > twoMonthsAgo;
            });

            this.createCookie("mc_track", JSON.stringify(recentEngagements), expiration);
        },
        /**
         * Generates an engagement object.
         * @param {String} id           The engagement id / utm_campaign value.
         * @param {String} source       The utm_source value.
         * @param {String} medium       The utm_medium value.
         * @param {String} gclid        The gclid value.
         * @param {String} mccid        The mc_cid value.
         * @return {Object}             The generated engagement object.
         */
        generateEngagementObject: function (id, source, medium, gclid, mccid) {
            return {
                "id": id,
                "src": source,
                "medium": medium,
                "gclid": gclid,
                "mccid": mccid,
                "created_at": this.getUnixTimestamp()
            };
        },
        /**
         * Creates a cookie.
         * @param {String} name             The cookie name.
         * @param {String} value            The cookie value.
         * @param {Number} expirationDays   The cookie's expiration time, in days.
         */
        createCookie: function (name, value, expirationDays) {
            var cookie_value = encodeURIComponent(value) + ";";

            // set expiration
            if (expirationDays !== null) {
                var expirationDate = new Date();
                expirationDate.setDate(expirationDate.getDate() + expirationDays);
                cookie_value += " expires=" + expirationDate.toUTCString() + ";";
            }

            // set path
            cookie_value += "path=/";

            document.cookie = name + "=" + cookie_value;
        },
        /**
         * Retrieves a cookie value.
         * @param {String} name     The cookie name.
         * @return {String|null}    The cookie value.
         */
        readCookie: function (name) {
            var nameEQ = name + "=";
            var ca = document.cookie.split(";");

            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];

                while (c.charAt(0) === " ") {
                    c = c.substring(1, c.length);
                }

                if (c.indexOf(nameEQ) === 0) {
                    return c.substring(nameEQ.length, c.length);
                }
            }

            return null;
        },
        /**
         * Retrieves the Shopify Cart form from the DOM.
         * @return {Element|null} The Shopify cart form element.
         */
        getCartForm: function () {
            return document.querySelector("form[action='/cart']");
        },
        /**
         * Creates a hidden Input Field element for cart attribute injection.
         * @param {String} name     The "name" value for the input field.
         * @param {String} value    The "value" value for the input field.
         * @return {Element}        The created input field element.
         */
        createAttributeInputField: function (name, value) {
            var input = document.createElement("input");
            input.type = "hidden";
            input.name = "attributes[" + name + "]";
            input.value = value;

            return input;
        },
        /**
         * Creates a Paragraph element for Shopify's custom cart attributes.
         * @return {Element}        The created paragraph element.
         */
        createAttributeParagraphElement: function () {
            var p = document.createElement("p");
            p.setAttribute("class", "cart-attribute__field");

            return p;
        },
        /**
         * Save the engagement using the Shopify Ajax API. Eats errors.
         * @param {Object} engagement Engagement object from our cookie.
         */
        postCartAttributes: function (engagement) {
            var attribs = this.engagementToAttribs(engagement);
            try {
                var req = new XMLHttpRequest();
                req.open("POST", "/cart/update.js", true);
                req.setRequestHeader("Content-Type", "application/json");
                req.send(JSON.stringify({attributes: attribs}));
            } catch (send_error) {
                console.warn("Unable to set attribution params in Shopify: " + send_error.message);
            }
        },

        updateCustomerSession: function () {
            var customer_session_id = this.readCookie("mc_customer_session_id");
            if (customer_session_id) {

                var data = {
                    attributes: {
                        customer_session_id: customer_session_id
                    }
                };

                try {
                    var req = new XMLHttpRequest();
                    req.open("POST", "/cart/update.js", true);
                    req.setRequestHeader("Content-Type", "application/json");
                    req.send(JSON.stringify(data));
                } catch (send_error) {
                    console.warn("Unable to set attribution params in Shopify: " + send_error.message);
                }
            }
        }
    };

    if (window.$mcSite === undefined || window.$mcSite.shopify_attribution_cookie === undefined) {
        return;
    }

    var module = window.$mcSite.shopify_attribution_cookie;

    if (module.installed === true) {
        return;
    }

    module.installed = true;

    if (conversion.isDoNotTrack()) {
        return;
    }

    conversion.processParameters();

    // wait a sec for the attribution call to be made
    setTimeout(function () {
        conversion.updateCustomerSession();
    }, 3000);

    var engagement = conversion.getMostRecentEngagement();
    if (engagement === null || engagement === undefined) {
        return;
    }

    var cartForm = conversion.getCartForm();
    if (cartForm === null) {
        conversion.postCartAttributes(engagement);
    } else {
        conversion.injectCartAttributes(cartForm, engagement);
    }
}());
