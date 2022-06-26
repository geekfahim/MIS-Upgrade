<template>
    <div class="position-relative">
        <div class="card-header">
            <i class="fa fa-list"></i>
            Final
            <div v-if="outputRes.data.length === 0" class="card-header-actions p-0 m-0">
                <button v-if="!formView" class="btn btn-brand btn-sm btn-github"
                        type="button" @click="addNew()">
                    <i class="fa fa-plus"></i>
                    <span>Add New Final Feedback</span>
                </button>
                <button v-else class="btn btn-brand btn-sm btn-github"
                        type="button" @click="getAll()">
                    <i class="fa fa-list"></i>
                    <span>View All Final Feedback</span>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div v-show="formView">
                <div v-if="!isEmpty(errors)" class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div v-html="errorHtml"></div>
                    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6 col-sm-8 col-xs-12">
                        <form ref="FinalForm" class="form-horizontal" v-on:submit.prevent="onSubmit">
                            <div class="form-group row justify-content-center">
                                <h6 class="text-left col-sm-12">
                                    <strong v-if="createView">Add New Final Feedback</strong>
                                    <strong v-else>Confirmation Final Feedback</strong>
                                </h6>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Final Date<span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <input id="final_date" v-model="formData.final_date"
                                           v-validate="'required|date_format:yyyy-mm-dd'"
                                           :class="[this.vvErrors.has('final_date') ? 'is-invalid' : '',]"
                                           autocomplete="off" class="form-control form-control-sm rounded-0 datepicker"
                                           data-vv-as="final date"
                                           data-vv-name="final_date"
                                           name="final_date"
                                           placeholder="date: yyyy-mm-dd" type="text"/>
                                    <div v-show="vvErrors.has('final_date')" class="invalid-feedback">
                                        {{ vvErrors.first("final_date") }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Total Invested Amount<span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <input v-model.number="formData.total_investment"
                                           v-validate="'required|numeric|min:2|max:6'"
                                           :class="[this.vvErrors.has('total_investment') ? 'is-invalid' : '',]"
                                           autocomplete="off" class="form-control form-control-sm rounded-0"
                                           data-vv-as="invested amount"
                                           data-vv-name="total_investment"
                                           name="total_investment"
                                           placeholder="invested amount" type="text"/>
                                    <div v-show="vvErrors.has('total_investment')" class="invalid-feedback">
                                        {{ vvErrors.first("total_investment") }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Total Return Amount<span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <input v-model.number="formData.total_return"
                                           v-validate="'required|numeric|min:2|max:6'"
                                           :class="[this.vvErrors.has('total_return') ? 'is-invalid' : '',]"
                                           autocomplete="off" class="form-control form-control-sm rounded-0"
                                           data-vv-as="invested return amount"
                                           data-vv-name="total_return"
                                           name="total_return"
                                           placeholder="return amount" type="text"/>
                                    <div v-show="vvErrors.has('total_return')" class="invalid-feedback">
                                        {{ vvErrors.first("total_return") }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="d-block czm-xs">Is Investment as per Application<span
                                    class="text-danger">*</span></label>
                                <div class="form-check form-check-inline">
                                    <input id="is_valid_information_true"
                                           v-model.number="formData.is_investment_as_per_application"
                                           class="form-check-input czm-xs" name="is_valid_information" type="radio"
                                           value="1"/>
                                    <label class="form-check-label" for="is_valid_information_true">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input id="is_valid_information_false"
                                           v-model.number="formData.is_investment_as_per_application"
                                           class="form-check-input czm-xs" name="is_valid_information" type="radio"
                                           value="0"/>
                                    <label class="form-check-label" for="is_valid_information_false">No</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="d-block czm-xs" for="">Is Recommended<span
                                    class="text-danger">*</span></label>
                                <div class="form-check form-check-inline">
                                    <input id="is_recommended_true" v-model.number="formData.is_recommended"
                                           class="form-check-input czm-xs" name="is_recommended" type="radio"
                                           value="1"/>
                                    <label class="form-check-label" for="is_recommended_true">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input id="is_recommended_false" v-model.number="formData.is_recommended"
                                           class="form-check-input czm-xs" name="is_recommended" type="radio"
                                           value="0"/>
                                    <label class="form-check-label" for="is_recommended_false">No</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Tenure Of Business (Month)<span
                                    class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <input v-model="formData.business_tenure"
                                           v-validate="'required|numeric|min:1|max:6'"
                                           :class="[this.vvErrors.has('business_tenure') ? 'is-invalid' : '',]"
                                           autocomplete="off" class="form-control form-control-sm rounded-0"
                                           data-vv-as="tenure of business"
                                           data-vv-name="business_tenure"
                                           name="business_tenure"
                                           placeholder="business tenure" type="text"/>
                                    <div v-show="vvErrors.has('business_tenure')" class="invalid-feedback">
                                        {{ vvErrors.first("business_tenure") }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Profit Status<span class="text-danger">*</span></label>
                                <select v-model="formData.profit_status" v-validate="'required'"
                                        :class="[(this.vvErrors.has('profit_status') ? 'is-invalid' : '')]"
                                        class="form-control form-control-sm rounded-0"
                                        data-vv-as="profit status"
                                        data-vv-name="profit_status">
                                    <option value="">Select One</option>
                                    <option v-for="item in outputRes.profitStatus" :key="item" :value="item">
                                        {{ item }}
                                    </option>
                                </select>
                                <div v-show="vvErrors.has('profit_status')" class="invalid-feedback">
                                    {{ vvErrors.first('profit_status') }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Investment Findings </label>
                                <div class="input-group input-group-sm">
                                    <textarea v-model="formData.investment_findings" v-validate="'min:2|max:998'"
                                              :class="[(vvErrors.has('investment_findings') ? 'is-invalid' : '')]"
                                              class="form-control form-control-sm rounded-0"
                                              data-vv-as="investment findings"
                                              data-vv-name="investment_findings" placeholder="type here...."
                                              type="text"></textarea>
                                    <div v-if="vvErrors.has('investment_findings')" class="invalid-feedback">
                                        {{ vvErrors.first('investment_findings') }}
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
                            <div class="form-group">
                                <button v-if="createView" class="btn btn-sm btn-primary pull-right rounded-0"
                                        type="submit">
                                    <i class="fa fa-dot-circle-o"></i>
                                    Submit
                                </button>
                                <button v-else class="btn btn-sm btn-primary pull-right rounded-0" type="submit">
                                    <i class="fa fa-check"></i>
                                    Confirm
                                </button>
                            </div>
                        </form>
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
                            <th class="sort" @click="onClickSortItems('final_date')">Final Date</th>
                            <th class="sort" @click="onClickSortItems('total_investment')">Total Investment
                                Amount
                            </th>
                            <th class="sort" @click="onClickSortItems('total_return')">Total Return Amount
                            </th>
                            <th class="sort" @click="onClickSortItems('profit_status')">Profit Status</th>
                            <th>Recommendation</th>
                            <th>Investment As Application</th>
                            <th class="sort" @click="onClickSortItems('status')">Status</th>
                            <th class="sort" style="width: 140px" @click="onClickSortItems('created_at')">Created
                            </th>
                            <th style="width:160px; text-align:center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item, index) in outputRes.data" :key="index">
                            <td>{{ sl + index }}</td>
                            <td>{{ item.final_date |dateFormat }}</td>
                            <td class="tk">{{ item.total_investment }}</td>
                            <td class="tk">{{ item.total_return }}</td>
                            <td>
                                <span v-if="'Profit' === item.profit_status" class="badge badge-success">Profit</span>
                                <span v-else-if="'Loss' === item.profit_status" class="badge badge-danger">Loss</span>
                                <span v-else-if="'Break Even' === item.profit_status" class="badge badge-primary">Break Even</span>
                                <span v-else class="text-capitalize">{{ item.status }}</span>
                            </td>
                            <td>
                                <span v-if="1 === item.is_recommended" class="badge badge-success">Yes</span>
                                <span v-else class="badge badge-danger">No</span>
                            </td>
                            <td>
                                <span v-if="1 === item.is_investment_as_per_application"
                                      class="badge badge-success">Yes</span>
                                <span v-else class="badge badge-danger">No</span>
                            </td>
                            <td>
                                <span v-if="'Approved'===item.status" class='badge badge-success'>Approved</span>
                                <span v-else-if="'Pending'===item.status" class='badge badge-warning'>Pending</span>
                                <span v-else-if="'Confirmed'===item.status" class='badge badge-info'>Confirmed</span>
                                <span v-else-if="'Rejected'===item.status" class='badge badge-danger'>Rejected</span>
                                <span v-else class="text-capitalize">{{ item.status }}</span>
                            </td>
                            <td>{{ item.created_at | dateFormat }}</td>
                            <td>
                                <button class="btn btn-xs btn-github rounded-0" @click="onClickView(item.id)">
                                    <i class="fa fa-eye"></i> View
                                </button>
                                <button :disabled="'Pending' !== item.status" class="btn btn-xs btn-behance rounded-0"
                                        @click="onClickEdit(item.id)">
                                    <i class="fa fa-check"></i> Confirm
                                </button>
                            </td>
                        </tr>
                        <tr v-if="outputRes.length === 0">
                            <td class="text-center" colspan="10">No Data Found
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="pull-left">
                            Showing
                            {{ outputRes.from ? outputRes.from : 0 }}
                            to
                            {{ outputRes.to ? outputRes.to : 0 }}
                            of
                            {{ outputRes.total ? outputRes.total : 0 }} entries
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <pagination v-if="outputRes.length>=0" :records="outputRes" class="pull-right"
                                    @onclicked="paginationClicked"></pagination>
                    </div>
                </div>
            </div>
            <div v-if="loading" class="czm-loader">Loading&#8230;</div>
        </div>
        <!-- Modal -->
        <div id="viewModal" aria-hidden="true" aria-labelledby="viewModalTitle" class="modal fade" role="dialog"
             tabindex="-1">
            <div class="modal-dialog modal modal-dialog-centered" role="document">
                <div v-if="chunk" class="modal-content rounded-0">
                    <div class="modal-header">
                        <h6 id="exampleModalCenterTitle" class="modal-title">Final Details</h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-borderless table-sm table-hover">
                                        <tr v-if="chunk.j_business_plan">
                                            <td>Business Plan Name</td>
                                            <td>:</td>
                                            <td>{{ chunk.j_business_plan.business_name }}</td>
                                        </tr>
                                        <tr v-if="chunk.total_investment">
                                            <td>Total Investment Amount</td>
                                            <td>:</td>
                                            <td><span v-if="chunk.total_investment"
                                                      class="tk">{{ chunk.total_investment }}</span></td>
                                        </tr>
                                        <tr v-if="chunk.business_tenure">
                                            <td>Business Tenure(Monthly)</td>
                                            <td>:</td>
                                            <td>{{ chunk.business_tenure }}</td>
                                        </tr>
                                        <tr v-if="chunk.business_start_date">
                                            <td>Business Start Date</td>
                                            <td>:</td>
                                            <td>{{ chunk.business_start_date | dateFormat }}</td>
                                        </tr>
                                        <tr v-if="chunk.final_date">
                                            <td>Final Date</td>
                                            <td>:</td>
                                            <td>{{ chunk.final_date | dateFormat }}</td>
                                        </tr>
                                        <tr v-if="chunk.total_investment">
                                            <td>Total Invested</td>
                                            <td>:</td>
                                            <td><span class="tk">{{ chunk.total_investment }}</span></td>
                                        </tr>
                                        <tr v-if="chunk.total_return">
                                            <td>Total Returned</td>
                                            <td>:</td>
                                            <td><span class="tk">{{ chunk.total_return }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>Is Recommended</td>
                                            <td>:</td>
                                            <td>
                                                <span v-if="1===chunk.is_recommended"
                                                      class="badge badge-success">Yes</span>
                                                <span v-else class="badge badge-danger">No</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Investment As Application</td>
                                            <td>:</td>
                                            <td>
                                                <span v-if="1===chunk.is_investment_as_per_application"
                                                      class="badge badge-success">Yes</span>
                                                <span v-else class="badge badge-danger">No</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Status</td>
                                            <td>:</td>
                                            <td>
                                                <span v-if="'Approved'===chunk.status" class='badge badge-success'>Approved</span>
                                                <span v-else-if="'Pending'===chunk.status" class='badge badge-warning'>Pending</span>
                                                <span v-else-if="'Confirmed'===chunk.status" class='badge badge-info'>Confirmed</span>
                                                <span v-else-if="'Rejected'===chunk.status" class='badge badge-danger'>Rejected</span>
                                                <span v-else class="text-capitalize">{{ chunk.status }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Profit Status</td>
                                            <td>:</td>
                                            <td>
                                                <span v-if="'Profit' === chunk.profit_status"
                                                      class="badge badge-success">Profit</span>
                                                <span v-else-if="'Loss' === chunk.profit_status"
                                                      class="badge badge-danger">Loss</span>
                                                <span v-else-if="'Break Even' === chunk.profit_status"
                                                      class="badge badge-primary">Break Even</span>
                                                <span v-else class="text-capitalize">{{ chunk.status }}</span>
                                            </td>
                                        </tr>
                                        <tr v-if="chunk.confirmed_amount">
                                            <td>Confirmed Amount</td>
                                            <td>:</td>
                                            <td class="tk">{{ chunk.confirmed_amount }}</td>
                                        </tr>
                                        <tr v-if="chunk.investment_findings">
                                            <td>Investment Findings</td>
                                            <td>:</td>
                                            <td>{{ chunk.investment_findings }}</td>
                                        </tr>
                                        <tr v-if="chunk.remarks">
                                            <td>Remarks</td>
                                            <td>:</td>
                                            <td>{{ chunk.remarks }}</td>
                                        </tr>
                                        <tr>
                                            <td>Created</td>
                                            <td>:</td>
                                            <td>{{ chunk.created_at | dateFormat }}</td>
                                        </tr>
                                        <tr v-if="chunk.created_user">
                                            <td>Created By</td>
                                            <td>:</td>
                                            <td> {{ chunk.created_user.name }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-brand btn-sm rounded-0" data-dismiss="modal" type="button">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Pagination from "../../../../Pagination.vue";
import queryString from "query-string";

export default {
    name: "FinalC",
    components: {Pagination},
    data() {
        return {
            loading: false,
            createView: true,
            formView: false,
            timeout: null,
            errorHtml: "",
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
                is_investment_as_per_application: 0,
                is_recommended: 0,
                total_investment: "",
                total_return: "",
                business_tenure: "",
                final_date: "",
                investment_findings: "",
                remarks: "",
                status: "",
            },
            outputRes: {
                data: [],
            },
            chunk: [],
            routes: window.appHelper.routes,
        };
    },
    methods: {
        isEmpty(obj) {
            for (let key in obj) {
                if (obj.hasOwnProperty(key)) {
                    return false;
                }
            }
            return true;
        },
        objToString(obj) {
            for (let property in obj) {
                if (obj.hasOwnProperty(property)) {
                    this.errorHtml += "<p class='p-0 m-0'>" + obj[property][0] + "</p>";
                }
            }
        },
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
        onSubmit() {
            let _this = this;
            _this.$validator.validateAll().then((result) => {
                if (result && _this.createView) {
                    _this.onNewAdd();
                } else if (result && !_this.createView) {
                    _this.onConfirm();
                }
            });
        },
        onNewAdd() {
            let _this = this;
            _this.loading = true;
            _this.errors = {};
            _this.errorHtml = "";
            axios.post(_this.routes.one, _this.formData).then((res) => {
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
                        _this.errors = error.response.data.errors;
                        _this.objToString(_this.errors);
                    }
                } else {
                    toastr.error(error.message, "Error");
                }
                _this.loading = false;
            });
        },
        getAll() {
            let _this = this;
            _this.formView = false;
            _this.loading = true;
            _this.createView = true;
            _this.formData = {};
            _this.formData.is_investment_as_per_application = 0;
            _this.formData.is_recommended = 0;
            _this.formData.profit_status = '';
            $("#final_date").datepicker("update", "");
            this.$validator.reset();
            axios.post(_this.routes.list, _this.search).then((res) => {
                if (res.data) {
                    _this.outputRes = res.data.lists;
                    _this.statuses = res.data.statuses;
                    _this.outputRes.profitStatus = res.data.profitStatus;
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
        addNew() {
            let _this = this;
            _this.formView = true;
            $("#date").datepicker("update", "");
            _this.errors = {};
            this.$validator.reset();
        },
        onConfirm() {
            let _this = this;
            _this.loading = true;
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
        onClickView(id) {
            let _this = this;
            _this.loading = true;
            _this.errors = {};
            axios.patch(_this.routes.one + "/" + id).then((res) => {
                if (res.data) {
                    _this.chunk = res.data;
                    $("#viewModal").modal({show: true, backdrop: "static"});
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
        onClickEdit(id) {
            let _this = this;
            _this.loading = true;
            _this.errors = {};
            axios.patch(_this.routes.one + "/" + id).then((res) => {
                if (res.data) {
                    _this.createView = false;
                    _this.formView = true;
                    _this.formData = res.data;
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
                case "final_date":
                    _this.formData.final_date = value;
                    break;
            }
        });
    },
    filters: {
        dateFormat(value) {
            if (!value) return "";
            return moment(value).format("MMM DD, YYYY");
        },
    },
};
</script>

<style scoped>
</style>
