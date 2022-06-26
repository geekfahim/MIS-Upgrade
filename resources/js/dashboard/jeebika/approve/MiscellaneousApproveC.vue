<template>
    <div class="position-relative">
        <div class="card-header">
            <i class="fa fa-list"></i>Approve Miscellaneous
            <div class="card-header-actions p-0 m-0">
                <button v-if="formView" class="btn btn-brand btn-sm btn-github" type="button" @click="getAll()">
                    <i class="fa fa-list"></i>
                    <span>View All Miscellaneous</span>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div v-show="formView">
                <div class="row justify-content-center">
                    <div class="col-10">
                        <table class="table table-sm table-striped table-hover">
                            <tbody>
                            <tr>
                                <td class="font-weight-bold">Family Name:</td>
                                <td>{{ chunk.name }}</td>
                                <td class="font-weight-bold">Collection Date:</td>
                                <td>{{ chunk.date|dateFormat }}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Confirmed Amount :</td>
                                <td>{{ chunk.confirmed_amount }}</td>
                                <td class="font-weight-bold">Remarks :</td>
                                <td>{{ chunk.remarks }}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Status :</td>
                                <td>
                                    <span class='badge badge-success' v-if="'Approved'===chunk.status">Approved</span>
                                    <span class='badge badge-warning'
                                          v-else-if="'Pending'===chunk.status">Pending</span>
                                    <span class='badge badge-danger'
                                          v-else-if="'Rejected'===chunk.status">Rejected</span>
                                    <span class='badge badge-primary'
                                          v-else-if="'Confirmed'===chunk.status">Confirmed</span>
                                    <span class="text-capitalize" v-else>{{ chunk.status }}</span>
                                </td>
                                <td class="font-weight-bold">Created By :</td>
                                <td>{{ chunk.created_user ? chunk.created_user.name : '' }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-5 col-md-6 col-sm-8 col-xs-12">
                        <div class="form-group">
                            <label class="czm-xs">Date<span class="text-danger">*</span></label>
                            <div class="input-group input-group-sm">
                                <input id="date" v-model="formData.date" v-validate="'required|date_format:yyyy-mm-dd'"
                                       :class="[this.vvErrors.has('date') ? 'is-invalid' : '',]"
                                       autocomplete="off" class="form-control form-control-sm rounded-0 datepicker"
                                       data-vv-as="date"
                                       data-vv-name="date"
                                       name="date" placeholder="date: yyyy-mm-dd"
                                       type="text"/>
                                <div v-show="vvErrors.has('date')" class="invalid-feedback">
                                    {{ vvErrors.first("date") }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="czm-xs">Approved Amount<span class="text-danger">*</span></label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fa fa-money"></i>
                  </span>
                                </div>
                                <input v-model="formData.approved_amount" v-validate="'required|numeric'"
                                       :class="[(vvErrors.has('approved_amount') ? 'is-invalid' : '')]"
                                       class="form-control form-control-sm rounded-0" data-vv-as="approved amount"
                                       data-vv-name="approved_amount" placeholder="approved amount" type="text">
                                <div v-show="vvErrors.has('approved_amount')" class="invalid-feedback">
                                    {{ vvErrors.first('approved_amount') }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="czm-xs">Remarks </label>
                            <div class="input-group input-group-sm">
                                <textarea v-model="formData.remarks" v-validate="'min:2|max:998'"
                                          :class="[(vvErrors.has('remarks') ? 'is-invalid' : '')]"
                                          class="form-control form-control-sm rounded-0"
                                          data-vv-as="Remarks" data-vv-name="remarks"
                                          placeholder="type here...." type="text"></textarea>
                                <div v-if="vvErrors.has('remarks')" class="invalid-feedback">
                                    {{ vvErrors.first('remarks') }}
                                </div>
                            </div>
                        </div>
                        <div v-if="'Confirmed'===chunk.status" class="form-group my-4">
                            <button class="btn btn-sm btn-success pull-right rounded-0" type="button"
                                    @click="onApprove">
                                <i class="fa fa-dot-circle-o"></i>
                                Approve
                            </button>
                            <button class="btn btn-sm btn-danger pull-left rounded-0" type="button" @click="onReject">
                                <i class="fa fa-dot-circle-o"></i>
                                Reject
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="!formView">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="pull-left">
                            <label class="d-inline-block">
                                Show
                                <select v-model="search.item" @change="itemPerPageSelect()">
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                    <option value="200">200</option>
                                </select>
                                entries
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="float-md-right">
                            <label>
                                Search: <input v-model="search.query" placeholder="Search..." type="text"
                                               @keyup="searchTimeOut()">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-responsive-sm table-sm table-striped table-hover">
                        <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th class="sort" @click="onClickSortItems('name')">Family Name</th>
                            <th class="sort" @click="onClickSortItems('date')">Date</th>
                            <th class="sort" @click="onClickSortItems('confirmed_amount')">Confirmed
                                Amount
                            </th>
                            <th class="sort" @click="onClickSortItems('status')">Status</th>
                            <th class="sort" @click="onClickSortItems('approved_amount')">Approved Amount
                            </th>
                            <th class="sort" @click="onClickSortItems('created_by')">Created By</th>
                            <th class="sort" style="width: 100px" @click="onClickSortItems('created_at')">Created
                            </th>
                            <th style="width: 75px; text-align:center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item, index) in outputRes.data" :key="index">
                            <td>{{ sl + index }}</td>
                            <td>{{ item.name }}</td>
                            <td>{{ item.date | dateFormat }}</td>
                            <td class="tk">{{ item.confirmed_amount }}</td>
                            <td>
                                <span class='badge badge-success' v-if="'Approved'===item.status">Approved</span>
                                <span class='badge badge-warning' v-else-if="'Pending'===item.status">Pending</span>
                                <span class='badge badge-danger' v-else-if="'Rejected'===item.status">Rejected</span>
                                <span class='badge badge-primary' v-else-if="'Confirmed'===item.status">Confirmed</span>
                                <span class="text-capitalize" v-else>{{ item.status }}</span>
                            </td>
                            <td><span v-if="item.approved_amount" class="tk">{{ item.approved_amount }}</span></td>
                            <td>{{ item.created_by ? item.created_user.name : '' }}</td>
                            <td>{{ item.created_at | dateFormat }}</td>
                            <td>
                                <button class="btn btn-xs btn-github rounded-0" @click="onClickView(item)">
                                    <i class="fa fa-eye"></i> View
                                </button>
                            </td>
                        </tr>
                        <tr v-if="outputRes.data.length === 0">
                            <td class="text-center" colspan="9">No Data Found
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="pull-left">
                            Showing {{ outputRes.from ? outputRes.from : 0 }} to {{ outputRes.to ? outputRes.to : 0 }}
                            of {{ outputRes.total ? outputRes.total : 0 }} entries
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <pagination v-if="outputRes.data.length>=0" :records="outputRes" class="pull-right"
                                    @onclicked="paginationClicked"></pagination>
                    </div>
                </div>
            </div>
            <div v-if="loading" class="czm-loader">Loading&#8230;</div>
        </div>
    </div>
</template>

<script>
import Pagination from "../../Pagination.vue";
import queryString from "query-string";

export default {
    name: "BankChargeApprove",
    components: {Pagination},
    data() {
        return {
            loading: false,
            formView: false,
            timeout: null,
            errors: {},
            sl: 1,
            search: {
                page: 1,
                sort: "created_at",
                type: "desc",
                query: "",
                item: "",
            },
            formData: {
                id: "",
                name: "",
                approved_amount: "",
                remarks: "",
            },
            statuses: [],
            chunk: [],
            outputRes: {
                data: [],
            },
            routes: window.appHelper.routes,
        };
    },
    methods: {
        paginationClicked(page) {
            this.updateQueryParams("page", page);
            this.search.page = page;
            this.getAll();
        },
        updateQueryParams(key, value) {
            let parsed = queryString.parse(location.search);
            let page = key == "page" ? value : !!parsed.page ? parsed.page : 1;
            let sort =
                key == "sort" ? value : !!parsed.sort ? parsed.sort : "created_at";
            let type = key == "type" ? value : !!parsed.type ? parsed.type : "desc";
            let query = key == "query" ? value : !!parsed.query ? parsed.query : "";
            let item = key == "item" ? value : !!parsed.item ? parsed.item : 25;
            let queryStringify = queryString.stringify({page, sort, type, query, item});
            let newUrl = this.routes.one + "?" + queryStringify;
            window.history.pushState({}, null, newUrl);
        },
        itemPerPageSelect() {
            this.search.page = 1;
            this.updateQueryParams("page", this.search.page);
            this.updateQueryParams("item", this.search.item);
            this.getAll();
        },
        onClickSortItems(key) {
            let _this = this;
            _this.search.sort = key;
            _this.search.type = _this.search.type === "asc" ? "desc" : "asc";
            this.updateQueryParams("sort", key);
            this.updateQueryParams("type", _this.search.type);
            this.getAll();
        },
        searchTimeOut() {
            clearTimeout(this.timeout);
            this.timeout = setTimeout(() => {
                this.search.page = 1;
                this.updateQueryParams("page", this.search.page);
                this.updateQueryParams("query", this.search.query);
                this.getAll();
            }, 1000);
        },
        getAll() {
            let _this = this;
            _this.formData = {};
            _this.formView = false;
            _this.loading = true;
            _this.errors = {};
            _this.$validator.reset();
            axios.post(_this.routes.list, _this.search).then((res) => {
                if (res.data) {
                    _this.outputRes = res.data.lists;
                    _this.statuses = res.data.statuses;
                    if (_this.search.page > 1) {
                        _this.sl = (_this.search.page - 1) * parseInt(_this.outputRes.per_page) + 1;
                    } else {
                        _this.sl = 1;
                    }
                } else {
                    toastr.error(res.data.message, "Warning");
                }
                _this.loading = false;
            }).catch((error) => {
                if (error.response) {
                    toastr.error(error.response.data.message, "Error");
                    if (error.response && error.response.data.errors) {
                        _this.$setErrorsFromLaravel(error.response.data);
                    }
                } else {
                    toastr.error(error.message, "Error");
                }
                _this.loading = false;
            });
        },
        onClickView(item) {
            let _this = this;
            _this.errors = {};
            _this.formView = true;
            _this.formData.id = item.id;
            _this.formData.date = item.date;
            $("#date").datepicker("update", _this.formData.date);
            _this.formData.approved_amount = item.approved_amount ?? item.confirmed_amount;
            _this.formData.remarks = item.remarks;
            _this.chunk = item;
            _this.chunk.name = item.name;
            _this.chunk.statuses = item.statuses;
        },
        onReject() {
            let _this = this;
            _this.loading = true;
            _this.formData.status = "Rejected";
            axios.put(_this.routes.one + "/" + _this.formData.id, _this.formData).then((res) => {
                if (res.data.success) {
                    toastr.success(res.data.success, "Success");
                    _this.getAll();
                } else {
                    toastr.error(res.data.message, "Warning");
                }
                _this.loading = false;
            }).catch((error) => {
                if (error.response) {
                    toastr.error(error.response.data.message, "Error");
                    if (error.response && error.response.data.errors) {
                        _this.$setErrorsFromLaravel(error.response.data);
                    }
                } else {
                    toastr.error(error.message, "Error");
                }
                _this.loading = false;
            });
        },
        onApprove() {
            let _this = this;
            _this.loading = true;
            _this.formData.status = "Approved";
            axios.put(_this.routes.one + "/" + _this.formData.id, _this.formData).then((res) => {
                if (res.data.success) {
                    toastr.success(res.data.success, "Success");
                    _this.getAll();
                } else {
                    toastr.error(res.data.message, "Warning");
                }
                _this.loading = false;
            }).catch((error) => {
                if (error.response) {
                    toastr.error(error.response.data.message, "Error");
                    if (error.response && error.response.data.errors) {
                        _this.$setErrorsFromLaravel(error.response.data);
                    }
                } else {
                    toastr.error(error.message, "Error");
                }
                _this.loading = false;
            });
        },
    },
    created() {
        let parsed = queryString.parse(location.search);
        this.search.page = !!parsed.page ? parsed.page : 1;
        this.search.sort = !!parsed.sort ? parsed.sort : "created_at";
        this.search.type = !!parsed.type ? parsed.type : "desc";
        this.search.query = !!parsed.query ? parsed.query : "";
        this.search.item = !!parsed.item ? parsed.item : 25;
        this.getAll();
    },
    mounted() {
        let _this = this;
        $(".datepicker")
            .datepicker({
                todayHighlight: true,
                format: "yyyy-mm-dd",
                startDate: "-200y",
                autoclose: true,
            })
            .on("changeDate", (event) => {
                _this.formData.date = event.currentTarget.value;
            });
    },
    filters: {
        dateFormat(value) {
            if (!value) return "";
            return moment(value).format("MMM DD, YYYY");
        },
        dateTimeFormat(value) {
            if (!value) return "";
            return moment(value).format("MMM DD, YYYY, hh:mm a");
        },
        textCapitalize(value) {
            if (!value) return "";
            value = value.toString();
            return value.charAt(0).toUpperCase() + value.slice(1);
        },
    },
};
</script>
