require('./bootstrap');
window.Vue = require('vue');
require('./settings');

window.moment = require('moment');

Vue.component('std-alert', require('./components/Alert.vue'));
Vue.component('std-button', require('./components/ActionButton.vue'));
Vue.component('std-remove-image', require('./components/RemoveImage.vue'));
Vue.component('images', require('./components/Images.vue'));
Vue.component('prx-alert', require('./components/Alert.vue'));

// Admin
Vue.component('applicants-table', require('./views/applicants/ApplicantsTable.vue'));
Vue.component('applicant-details', require('./views/applicants/ApplicantDetails.vue'));

Vue.component('tenants-table', require('./views/tenants/TenantsTable.vue'));

Vue.component('contracts-table', require('./views/contracts/ContractsTable.vue'));
Vue.component('contract-details', require('./views/contracts/ContractDetails.vue'));
Vue.component('contract-create', require('./views/contracts/ContractCreate.vue'));

Vue.component('building-details', require('./views/buildings/BuildingDetails.vue'));
Vue.component('buildings-list', require('./views/buildings/BuildingsList.vue'));

Vue.component('rooms-list', require('./views/rooms/RoomsList.vue'));
Vue.component('room-details', require('./views/rooms/RoomDetails.vue'));

Vue.component('billings-table', require('./views/billings/BillingsTable.vue'));
Vue.component('billing-details', require('./views/billings/BillingDetails.vue'));
Vue.component('billing-utilities-table', require('./views/billings/BillingUtilitiesTable.vue'));
Vue.component('billing-utility-details', require('./views/billings/BillingUtilityDetails.vue'));

Vue.component('billings-history', require('./views/billings/BillingHistoryTable.vue'));
Vue.component('billing-history-details', require('./views/billings/BillingHistoryDetails.vue'));

Vue.component('page-item-table', require('./views/page-items/PageItemTable.vue'));
Vue.component('page-item-details', require('./views/page-items/PageItemDetails.vue'));

Vue.component('page-table', require('./views/pages/PageTable.vue'));
Vue.component('page-details', require('./views/pages/PageDetails.vue'));

Vue.component('carousels-table', require('./views/carousels/CarouselsTable.vue'));
Vue.component('carousel-details', require('./views/carousels/CarouselDetails.vue'));

Vue.component('about-contents-table', require('./views/aboutus/AboutUsContentsTable.vue'));
Vue.component('about-content-details', require('./views/aboutus/AboutUsContentDetails.vue'));

Vue.component('galleries-table', require('./views/gallery/GalleriesTable.vue'));
Vue.component('gallery-details', require('./views/gallery/GalleryDetails.vue'));

Vue.component('permission-details', require('./views/permissions/PermissionDetails.vue'));
Vue.component('billing-officer-list', require('./views/permissions/BillingOfficerList.vue'));
Vue.component('admin-list', require('./views/permissions/AdminList.vue'));

// Tenant
Vue.component('unpaid-bills-table', require('./views/tenant/overview/UnpaidBillsTable.vue'));

Vue.component('profile', require('./views/tenant/profile/Profile.vue'));

Vue.component('document', require('./views/tenant/document/Document.vue'));

Vue.component('checkout', require('./views/tenant/checkout/Checkout.vue'));

Vue.component('rent-payments-table', require('./views/payment/RentPaymentsTable.vue'));
Vue.component('utility-payments-table', require('./views/payment/UtilityPaymentsTable.vue'));
Vue.component('payment-history-table', require('./views/payment/PaymentHistoryTable.vue'));

Vue.component('tab', require('./views/includes/Tab.vue'))

const app = {
	init() {
		this.setupVue();
	},

	setupVue() {
		new Vue({
		    el: '#app',

		    methods: {
		    	runDatatable(ref = null, elem = 'datatable', method = 'fetch') {
		            const table = this.$refs[ref].$refs[elem];

		            if (!table.empty) {
		                table[method]();
		            }
		        },

		        runComponent(ref = null, method = 'run') {
		            const elem = this.$refs[ref];

		            if (!elem.hasInit) {
		                elem[method]();
		            }
		        },
		    }
		});
	}
};

app.init();