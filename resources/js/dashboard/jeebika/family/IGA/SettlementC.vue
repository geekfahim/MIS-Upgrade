<template>
    <div class="position-relative">
        <div class="card-header">
            <i class="fa fa-list"></i>
            Settlement
            <div class="card-header-actions p-0 m-0">
                <button v-if="!formView" class="btn btn-brand btn-sm btn-github" type="button" @click="addNew()">
                    <i class="fa fa-plus"></i>
                    <span>Add New Settlement</span>
                </button>
                <button v-else class="btn btn-brand btn-sm btn-github" type="button" @click="getAll()">
                    <i class="fa fa-list"></i>
                    <span>View All Settlement</span>
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
                        <form class="form-horizontal" v-on:submit.prevent="onSubmit">
                            <div class="form-group row justify-content-center">
                                <h6 class="text-left col-sm-12">
                                    <strong v-if="createView">Add New Settlement</strong>
                                    <strong v-else>Confirmation Settlement</strong>
                                </h6>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Date<span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <input id="date" v-model="formData.date"
                                           v-validate="'required|date_format:yyyy-mm-dd'"
                                           :class="[this.vvErrors.has('date') ? 'is-invalid' : '',]"
                                           autocomplete="off" class="form-control form-control-sm rounded-0 datepicker"
                                           data-vv-as="date"
                                           data-vv-name="date"
                                           name="date"
                                           placeholder="date: yyyy-mm-dd" type="text"/>
                                    <div v-show="vvErrors.has('date')" class="invalid-feedback">
                                        {{ vvErrors.first("date") }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Amount<span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <input v-model.number="formData.confirmed_amount" v-validate="'required|numeric'"
                                           :class="[this.vvErrors.has('confirmed_amount') ? 'is-invalid' : '',]"
                                           autocomplete="off" class="form-control form-control-sm rounded-0"
                                           data-vv-as="amount"
                                           data-vv-name="confirmed_amount"
                                           name="confirmed_amount"
                                           placeholder="amount" type="text"/>
                                    <div v-show="vvErrors.has('confirmed_amount')" class="invalid-feedback">
                                        {{ vvErrors.first("confirmed_amount") }}
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
                            <th class="sort" @click="onClickSortItems('date')">Date</th>
                            <th class="sort" @click="onClickSortItems('confirmed_amount')">Confirmed Amount
                            </th>
                            <th class="sort" @click="onClickSortItems('status')">Status
                            </th>
                            <th class="sort" @click="onClickSortItems('approved_amount')">Approved Amount
                            </th>
                            <th class="sort" @click="onClickSortItems('created_at')">Created
                            </th>
                            <th style="width:160px; text-align:center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item, index) in outputRes.data" :key="index">
                            <td>{{ sl + index }}</td>
                            <td>{{ item.date |dateFormat }}</td>
                            <td class="tk">{{ item.confirmed_amount }}</td>
                            <td>
                                <span class='badge badge-success' v-if="'Approved'===item.status">Approved</span>
                                <span class='badge badge-warning' v-else-if="'Pending'===item.status">Pending</span>
                                <span class='badge badge-danger' v-else-if="'Rejected'===item.status">Rejected</span>
                                <span class='badge badge-primary' v-else-if="'Confirmed'===item.status">Confirmed</span>
                                <span class="text-capitalize" v-else>{{ item.status }}</span>
                            </td>
                            <td><span v-if="item.approved_amount" class="tk">{{ item.approved_amount }}</span></td>
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
                        <tr v-if="outputRes.data.length === 0">
                            <td class="text-center" colspan="7">No Data Found
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
                        <pagination v-if="outputRes.data.length>=0" :records="outputRes" class="pull-right"
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
                        <h6 id="exampleModalCenterTitle" class="modal-title">Settlement Details</h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-borderless table-sm table-hover">
                                        <tr v-if="chunk.date">
                                            <td>Date</td>
                                            <td>:</td>
                                            <td>{{ chunk.date | dateFormat }}</td>
                                        </tr>
                                        <tr v-if="chunk.collector">
                                            <td>Collected By</td>
                                            <td>:</td>
                                            <td>{{ chunk.collector.name }}</td>
                                        </tr>
                                        <tr v-if="chunk.project">
                                            <td>Project Name</td>
                                            <td>:</td>
                                            <td>{{ chunk.project.name }}</td>
                                        </tr>
                                        <tr v-if="chunk.gro">
                                            <td>Gro Name</td>
                                            <td>:</td>
                                            <td>{{ chunk.gro.name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Status</td>
                                            <td>:</td>
                                            <td>
                                                <span class='badge badge-success' v-if="'Approved'===chunk.status">Approved</span>
                                                <span class='badge badge-warning' v-else-if="'Pending'===chunk.status">Pending</span>
                                                <span class='badge badge-danger' v-else-if="'Rejected'===chunk.status">Rejected</span>
                                                <span class='badge badge-primary'
                                                      v-else-if="'Confirmed'===chunk.status">Confirmed</span>
                                                <span class="text-capitalize" v-else>{{ chunk.status }}</span>
                                            </td>
                                        </tr>
                                        <tr v-if="chunk.confirmed_amount">
                                            <td>Confirmed Amount</td>
                                            <td>:</td>
                                            <td class="tk">{{ chunk.confirmed_amount }}</td>
                                        </tr>
                                        <tr v-if="chunk.approved_amount">
                                            <td>Approved Amount</td>
                                            <td>:</td>
                                            <td class="tk">{{ chunk.approved_amount }}</td>
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
import Pagination from "../../../Pagination.vue";
import queryString from "query-string";

export default {
    name: "Settlement.Vue",
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
                date: "",
                confirmed_amount: "",
                remarks: "",
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
                    _this.onUpdate();
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
            this.$validator.reset();
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
        addNew() {
            let _this = this;
            _this.formView = true;
            $("#date").datepicker("update", "");
            _this.errors = {};
            this.$validator.reset();
        },
        onUpdate() {
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
        onClickDelete(item) {
            let _this = this;
            Swal.fire({
                title: "Are you sure?",
                html: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.value) {
                    _this.onDeleteRequest(item.id);
                }
            });
        },
        onDeleteRequest(id) {
            let _this = this;
            _this.loading = true;
            _this.errors = {};
            axios.delete(_this.routes.one + "/" + id).then((res) => {
                if (res.data.success) {
                    Swal.fire("Deleted!", res.data.success, "success");
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
    },
};
</script>
<style scoped>
</style>
