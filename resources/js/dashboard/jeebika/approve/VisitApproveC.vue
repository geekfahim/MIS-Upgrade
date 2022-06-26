<template>
    <div class="position-relative">
        <div class="card-header">
            <i class="fa fa-list"></i>Approve Visit
            <div class="card-header-actions p-0 m-0">
                <button v-if="formView" class="btn btn-brand btn-sm btn-github" type="button" @click="getAll()">
                    <i class="fa fa-list"></i>
                    <span>View All Visit</span>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div v-show="formView">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6 col-sm-8 col-xs-12">
                        <div class="form-group row justify-content-center">
                            <h6 class="text-left col-sm-12">
                                <strong>
                                    <div class="pull-right">
                                        <span class='badge badge-success'
                                              v-if="'Approved'===chunk.status">Approved</span>
                                        <span class='badge badge-warning'
                                              v-else-if="'Pending'===chunk.status">Pending</span>
                                        <span class='badge badge-info'
                                              v-else-if="'Confirmed'===chunk.status">Confirmed</span>
                                        <span class='badge badge-danger'
                                              v-else-if="'Rejected'===chunk.status">Rejected</span>
                                        <span class="text-capitalize" v-else>{{ chunk.status }}</span>
                                    </div>
                                </strong>
                            </h6>
                        </div>
                        <div class="form-group">
                            <label class="czm-xs">Visit Date<span class="text-danger">*</span></label>
                            <div class="input-group input-group-sm">
                                <input id="visit_date" v-model="formData.visit_date"
                                       v-validate="'required|date_format:yyyy-mm-dd'"
                                       :class="[this.vvErrors.has('visit_date') ? 'is-invalid' : '',]"
                                       autocomplete="off" class="form-control form-control-sm rounded-0 datepicker"
                                       data-vv-as="visit date"
                                       data-vv-name="visit_date"
                                       name="visit_date"
                                       placeholder="date: yyyy-mm-dd" type="text"/>
                                <div v-show="vvErrors.has('visit_date')" class="invalid-feedback">
                                    {{ vvErrors.first("visit_date") }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="czm-xs">Visit By<span class="text-danger">*</span></label>
                            <select v-model="formData.visit_id" v-validate="'required'"
                                    :class="[(this.vvErrors.has('visit_id') ? 'is-invalid' : '')]"
                                    class="form-control form-control-sm rounded-0"
                                    data-vv-as="visit by"
                                    data-vv-name="visit_id">
                                <option value="">Select One</option>
                                <option v-for="(item,index) in outputRes.fieldOfficers" :key="index" :value="item.id">
                                    {{ item.name }}
                                </option>
                            </select>
                            <div v-show="vvErrors.has('visit_id')" class="invalid-feedback">
                                {{ vvErrors.first('visit_id') }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="czm-xs">Business Status<span class="text-danger">*</span></label>
                            <select v-model="formData.business_status" v-validate="'required'"
                                    :class="[(this.vvErrors.has('business_status') ? 'is-invalid' : '')]"
                                    class="form-control form-control-sm rounded-0"
                                    data-vv-as="business status"
                                    data-vv-name="business_status">
                                <option value="">Select One</option>
                                <option v-for="item in outputRes.businessStatus" :key="item" :value="item">
                                    {{ item }}
                                </option>
                            </select>
                            <div v-show="vvErrors.has('business_status')" class="invalid-feedback">
                                {{ vvErrors.first('business_status') }}
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
                        <div v-if="'Confirmed' === chunk.status" class="form-group">
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
                            <th class="sort" @click="onClickSortItems('j_business_plan_id')">Business Name
                            </th>
                            <th class="sort" @click="onClickSortItems('visit_date')">Visit Date</th>
                            <th class="sort" @click="onClickSortItems('visit_id')">Visit By</th>
                            <th class="sort" @click="onClickSortItems('status')">Status</th>
                            <th class="sort" @click="onClickSortItems('business_status')">Business Status
                            </th>
                            <th class="sort" style="width: 140px" @click="onClickSortItems('created_at')">Created
                            </th>
                            <th style="width: 75px; text-align:center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item, index) in outputRes.data" :key="index">
                            <td>{{ sl + index }}</td>
                            <td>{{ item.business_name }}</td>
                            <td>{{ item.visit_date | dateFormat }}</td>
                            <td>{{ item.visit_by.name }}</td>
                            <td>
                                <span class='badge badge-success' v-if="'Approved'===item.status">Approved</span>
                                <span class='badge badge-warning' v-else-if="'Pending'===item.status">Pending</span>
                                <span class='badge badge-info' v-else-if="'Confirmed'===item.status">Confirmed</span>
                                <span class='badge badge-danger' v-else-if="'Rejected'===item.status">Rejected</span>
                                <span class="text-capitalize" v-else>{{ item.status }}</span>
                            </td>
                            <td>
                                <span class='badge badge-warning' v-if="'Not Started'===item.business_status">Not Started</span>
                                <span class='badge badge-primary'
                                      v-else-if="'Started'===item.business_status">Started</span>
                                <span class='badge badge-success' v-else-if="'In Profit'===item.business_status">In Profit</span>
                                <span class='badge badge-danger'
                                      v-else-if="'In Loss'===item.business_status">In Loss</span>
                                <span class='badge badge-danger' v-else-if="'Capital Loss'===item.business_status">Capital Loss</span>
                                <span class='badge badge-primary' v-else-if="'Break Even'===item.business_status">Break Even</span>
                                <span class="text-capitalize" v-else>{{ item.business_status }}</span>
                            </td>
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
    name: "VisitApprove",
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
                visit_date: "",
                visit_id: "",
                remarks: "",
                status: "",
                business_status: "",
            },
            chunk: [],
            outputRes: {
                data: [],
                fieldOfficers: [],
                businessStatus: [],
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
            let sort = key == "sort" ? value : !!parsed.sort ? parsed.sort : "created_at";
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
                    _this.outputRes.fieldOfficers = res.data.fieldOfficers;
                    _this.outputRes.businessStatus = res.data.businessStatus;
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
            _this.formData.visit_date = item.visit_date;
            _this.formData.visit_id = item.visit_id;
            _this.formData.remarks = item.remarks;
            _this.formData.status = item.status;
            _this.formData.business_status = item.business_status;
            $("#visit_date").datepicker("update", _this.formData.visit_date);
            _this.chunk.status = item.status;
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
        $(".datepicker").datepicker({
            todayHighlight: true,
            format: "yyyy-mm-dd",
            startDate: "-200y",
            autoclose: true,
        }).on("changeDate", (event) => {
            let value = event.currentTarget.value;
            switch (event.currentTarget.name) {
                case "visit_date":
                    _this.formData.visit_date = value;
                    break;
            }
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
