import {createApp} from 'vue';
// import VeeValidate, {Validator} from "vee-validate";

import * as Validate from 'vee-validate';


// window._ = require('lodash');
// window.moment = require("moment");
/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */
// window.axios = require('axios');

//Axios Load for Header
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
let token = document.head.querySelector('meta[name="csrf-token"]');


if (token) {
    window.axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
} else {
    console.error(
        "CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token"
    );
}
/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });

/*let paginatePlugin = {
    install: function (Vue) {
        let paginate = new Vue({
            data: {
                records: {
                    data: [],
                    total: 0,
                    per_page: 25,
                    current_page: 1,
                    last_page: 1,
                    from: 1,
                    to: 0
                }
            }
        });
        Vue.prototype.$paginateConfig = paginate.records;
        Vue.prototype.$paginateSetData = function (rows) {
            paginate.records.total = rows.length;
            paginate.records.last_page = Math.ceil(
                paginate.records.total / paginate.records.per_page
            );
            paginate.records.from = 1;

            if (paginate.records.current_page > 1) {
                paginate.records.from =
                    (paginate.records.current_page - 1) *
                    paginate.records.per_page +
                    1;
            }

            paginate.records.to =
                paginate.records.per_page + paginate.records.from - 1;
            paginate.records.data = [];
            for (
                let i = paginate.records.from - 1;
                i < paginate.records.to;
                i++
            ) {
                if (rows[i] && Object.entries(rows[i]).length !== 0) {
                    paginate.records.data.push(rows[i]);
                }
            }
        };
    }
};*/
const app = createApp({});

/*const proto = function (id, obj) {
    if (!id || !obj) return '';
    if (!obj.some(item => item.id == id)) return 'Not Found';
    return obj.find(item => item.id == id).name
}
app.provide(proto);*/

Vue.component('ValidationProvider', ValidationProvider);// app.use(VeeValidateLaravel);

// Vue.use(paginatePlugin);

// Validator.extend("name", {
//     getMessage(field, val) {
//         return "The " + field + " field format is invalid";
//     },
//     validate(value, field) {
//         if (value) {
//             let regex = new RegExp("^([a-zA-Z. ]+)$");
//             return regex.test(value);
//         }
//         return true;
//     }
// });
// Validator.extend("mobile", {
//     getMessage(field, val) {
//         return "The " + field + " only accept number and exact 10 digits";
//     },
//     validate(value, field) {
//         if (value) {
//             let regex = new RegExp(/^\s*-?[0-9]{10}\s*$/);
//             return regex.test(value);
//         }
//         return true;
//     }
// });
// Validator.extend("phone", {
//     getMessage(field, val) {
//         return "The " + field + " only accept number and exact 11 digits";
//     },
//     validate(value, field) {
//         if (value) {
//             let regex = new RegExp(/^\s*-?[0-9]{11}\s*$/);
//             return regex.test(value);
//         }
//         return true;
//     }
// });
// Validator.extend("phone_with_plus", {
//     getMessage(field, val) {
//         return "The " + field + " field format is invalid";
//     },
//     validate(value, field) {
//         if (value) {
//             let first = value.substring(0, 1);
//             if (first === "+" || parseInt(first) >= 0) {
//                 let str = value.substring(1, value.length);
//                 let num = parseInt(str);
//                 if (str === num.toString()) {
//                     return true;
//                 }
//             }
//             return false;
//         }
//         return true;
//     }
// });
// Validator.extend("name_with_number", {
//     getMessage(field, val) {
//         return "The " + field + " field format is invalid";
//     },
//     validate(value, field) {
//         if (value) {
//             let regex = new RegExp("^([-/a-zA-Z0-9, .)@(]+)$");
//             return regex.test(value);
//         }
//         return true;
//     }
// });
// Validator.extend("lessThen", {
//     paramNames: ["target"],
//     validate(value, {target}) {
//         let regex = new RegExp("^[0-9]*$");
//         return regex.test(value) && value < target;
//     },
//     getMessage(field, target, val) {
//         return "This field must be less than from '" + target + "'";
//     }
// });
// Validator.extend("greaterThen", {
//     paramNames: ["target"],
//     validate(value, {target}) {
//         // let regex = new RegExp(/^\d{2}:\d{2}$/);
//         let regex = new RegExp("^[0-9]*$");
//         return regex.test(value) && value > target;
//     },
//     getMessage(field, target, val) {
//         return "This field must be greater than from '" + target + "'";
//     }
// });
