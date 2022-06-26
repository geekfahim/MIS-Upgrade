<template>
    <div class="position-relative">
        <div class="card-header">
            <span v-if="!formView"><i class="fa fa-list"></i> Health Session Feedback</span>
            <span v-else><i class="fa fa-list"></i> Add Health Session Feedback</span>
            <div class="card-header-actions p-0 m-0">
                <button v-if="!formView" class="btn btn-brand btn-sm btn-github" type="button" @click="addNew()">
                    <i class="fa fa-plus"></i>
                    <span>Add New Feedback</span>
                </button>
                <button v-else class="btn btn-brand btn-sm btn-github" type="button" @click="resetAndGetAll()">
                    <i class="fa fa-list"></i>
                    <span>View All Feedback</span>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div v-if="formView">
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
                                               @keyup="searchTimeOutParticipantList()">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-responsive-sm table-sm table-striped table-hover">
                        <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th class="sort" @click="onClickSortItems('mustahiq_id')">
                                Participant Name
                            </th>
                            <th>Mobile</th>
                            <th>Reference Number</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item, index) in outputRes.data" :key="index">
                            <td>
                                <input :id="'id-'+item.mustahiq_id" :checked="checkIds.includes(item.mustahiq_id)"
                                       :value="item.mustahiq_id"
                                       type="checkbox" @change="selectCheckbox(item.mustahiq_id,$event)">
                            </td>
                            <td>
                                <label :for="'id-'+item.mustahiq_id">
                                    {{ item.mustahiq ? item.mustahiq.name : '' }}
                                </label>
                            </td>
                            <td>{{ item.mustahiq ? item.mustahiq.mobile : '' }}</td>
                            <td>{{ item.mustahiq ? item.mustahiq.reference_number : '' }}</td>
                        </tr>
                        <tr v-if="outputRes.data.length === 0">
                            <td class="text-center" colspan="8">No Data Found
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
                <div class="row justify-content-between">
                    <div class="col-lg-3 col-md-3 col-sm-12 my-4">
                        <input id="sa" :checked="allSelected" type="checkbox" @click="callAllSelect($event)">
                        <label for="sa">Select All</label>
                    </div>
                    <div class="col-lg-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="czm-xs">Remarks</label>
                                <div class="input-group input-group-sm">
                                            <textarea v-model="formData.remarks" v-validate="'max:100'"
                                                      class="form-control rounded-0" data-vv-name="remarks"
                                                      placeholder="type here.." rows="2"></textarea>
                                    <div v-show="vvErrors.has('remarks')" class="invalid-feedback">
                                        {{ vvErrors.first("remarks") }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 my-4">
                        <button :disabled="checkIds.length<=0" class="btn btn-xs btn-primary-gradient rounded-0 w-100"
                                @click="onClickStatus('yes','3a9d5d')">
                            <i class="fa fa-save"></i> Submit Feedback
                        </button>
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
                                               @keyup="searchTimeOutHealthSessionParticipant()">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="">
                    <table class="table table-responsive-sm table-sm table-striped table-hover">
                        <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th class="sort" @click="onClickSortItems('mustahiq_id')">
                                Participant Name
                            </th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Reference Number</th>
                            <th>Created</th>
                            <th style="width: 30% !important;word-wrap:break-word;">Remarks</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item, index) in outputRes.data" :key="index">
                            <td>{{ sl + index }}</td>
                            <td>{{
                                    item.mustahiq ? item.mustahiq.name : ''
                                }}
                            </td>
                            <td>{{
                                    item.mustahiq ? item.mustahiq.email : ''
                                }}
                            </td>
                            <td>{{
                                    item.mustahiq ? item.mustahiq.mobile : ''
                                }}
                            </td>
                            <td>{{
                                    item.mustahiq ? item.mustahiq.reference_number : ''
                                }}
                            </td>
                            <td>
                                {{ item.created_at | dateFormat }}
                            </td>
                            <td>{{ item.remarks }}</td>
                        </tr>
                        <tr v-if="outputRes.data.length === 0">
                            <td class="text-center" colspan="8">No Data Found
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
        <!-- Modal -->

    </div>
</template>

<script>
import Pagination from "../../Pagination.vue";
import Select2 from "v-select2-component";
import queryString from "query-string";

export default {
    name: "Health-Session-Feedback.vue",
    components: {
        Pagination,
        Select2: Select2,
    },
    data() {
        return {
            loading: false,
            allSelected: false,
            formView: true,
            createView: false,
            timeout: null,
            errors: {},
            sl: 1,
            search: {
                page: 1,
                sort: "session_heading",
                type: "desc",
                query: "",
                item: "",
            },
            formData: {
                id: "",
                remarks: ""
            },
            checkIds: [],
            originalData: [],
            searchedData: [],
            outputRes: {
                data: [],
            },
            routes: window.appHelper.routes,
        };
    },
    methods: {
        selectCheckbox(id, e) {
            let _this = this;
            if (e.target.checked) {
                _this.checkIds.push(id)
            } else {
                if (_this.checkIds.length > 0) {
                    _this.checkIds.forEach((item, index) => {
                        if (item === id) {
                            _this.checkIds.splice(index, 1);
                        }
                    });
                }
            }
            _this._checkedAllStatus();
        },
        _checkedAllStatus() {
            let _this = this;
            _this.allSelected = _this.originalData.length === _this.checkIds.length;
        },
        callAllSelect(e) {
            let _this = this;
            if (!_this.allSelected && e.target.checked) {
                _this.checkIds = [];
                _this.originalData.forEach(function (item) {
                    _this.checkIds.push(item.mustahiq_id);
                });
                _this.allSelected = true;
            } else {
                _this.checkIds = [];
                _this.allSelected = false;
            }
        },
        onClickStatus(status, color = '3085d6') {
            Swal.fire({
                title: "Are you sure?",
                html: `<p style="color:#${color}">You want to add feedback?</p>You won't be able to revert this!`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: `#${color}`, //"#d33",
                cancelButtonColor: "#2778c4",
                confirmButtonText: `Yes`,
            }).then((result) => {
                if (result.isConfirmed) {
                    this._submit(status);
                }
            });
        },
        _reset() {
            let _this = this;
            _this.allSelected = false;
            _this.statuses = [];
            _this.allProjects = [];
            _this.allGROs = [];
            _this.checkIds = [];
            _this.originalData = [];
            _this.searchedData = [];
            _this.dataPush();
        },
        _submit(flag) {
            let _this = this;
            if (_this.checkIds.length <= 0) {
                toastr.error("Please select at least one Participant.", "Error");
                return
            }
            _this.loading = true;
            axios.post(_this.routes.one, {
                flag: flag,
                participantIds: this.checkIds,
                remarks: _this.formData.remarks
            }).then((res) => {
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
                } else {
                    toastr.error(error.message, "Error");
                }
                _this.loading = false;
            });
        },
        paginationClicked(page) {
            this.updateQueryParams("page", page);
            this.search.page = page;
            this.formView === true ? this.getAllParticipant() : this.getAll();
        },
        updateQueryParams(key, value) {
            let parsed = queryString.parse(location.search);
            let page = key === "page" ? value : !!parsed.page ? parsed.page : 1;
            let sort = key === "sort" ? value : !!parsed.sort ? parsed.sort : "created_at";
            let type = key === "type" ? value : !!parsed.type ? parsed.type : "desc";
            let query = key === "query" ? value : !!parsed.query ? parsed.query : "";
            let item = key === "item" ? value : !!parsed.item ? parsed.item : 25;
            let queryStringify = queryString.stringify({
                page,
                sort,
                type,
                query,
                item,
            });
            let newUrl = this.routes.one + "?" + queryStringify;
            window.history.pushState({}, null, newUrl);
        },
        itemPerPageSelect() {
            this.search.page = 1;
            this.updateQueryParams("page", this.search.page);
            this.updateQueryParams("item", this.search.item);
            this.formView === true ? this.getAllParticipant() : this.getAll();
        },
        onClickSortItems(key) {
            let _this = this;
            _this.search.sort = key;
            if (_this.search.type === "asc") {
                _this.search.type = "desc";
            } else {
                _this.search.type = "asc";
            }
            this.updateQueryParams("sort", key);
            this.updateQueryParams("type", _this.search.type);
            this.formView === true ? this.getAllParticipant() : this.getAll();
        },
        searchTimeOutHealthSessionParticipant() {
            clearTimeout(this.timeout);
            this.timeout = setTimeout(() => {
                this.search.page = 1;
                this.updateQueryParams("page", this.search.page);
                this.updateQueryParams("query", this.search.query);
                this.getAll();
            }, 1000);
        },
        searchTimeOutParticipantList() {
            clearTimeout(this.timeout);
            this.timeout = setTimeout(() => {
                this.search.page = 1;
                this.updateQueryParams("page", this.search.page);
                this.updateQueryParams("query", this.search.query);
                this.getAllParticipant();
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
            axios
                .post(_this.routes.one, _this.formData)
                .then((res) => {
                    if (res.data.success) {
                        toastr.success(res.data.success, "Success");
                        _this.getAll();
                    } else {
                        toastr.error(res.data.message, "Warning");
                    }
                    _this.loading = false;
                })
                .catch((error) => {
                    if (error.response) {
                        toastr.error(error.response.data.message, "Error");
                        if (error.response && error.response.data.errors) {
                            _this.$setErrorsFromLaravel(
                                error.response.data
                            );
                        }
                    } else {
                        toastr.error(error.message, "Error");
                    }
                    _this.formData.managers = [];

                    _this.loading = false;
                });
        },
        __sortReset() {
            let _this = this;
            _this.search.page = 1;
            _this.search.sort = "created_at";
            _this.search.query = "";
            _this.search.type = "desc";
            _this.search.item = 25;
        },
        getAll() {
            let _this = this;
            _this.formView = false;
            _this.createView = true;
            _this.formData = {};
            _this.loading = true;
            _this.allSelected = false;
            _this.checkIds = [];
            _this.errors = {};
            _this.$validator.reset();
            axios
                .post(_this.routes.list, _this.search)
                .then((res) => {
                    if (res.data) {
                        _this.outputRes = res.data.lists;
                        _this.attendance = res.data.attendance;
                        if (_this.search.page > 1) {
                            _this.sl =
                                (_this.search.page - 1) * parseInt(_this.outputRes.per_page) +
                                1;
                        } else {
                            _this.sl = 1;
                        }
                    } else {
                        toastr.error(res.data.message, "Warning");
                    }
                    _this.loading = false;
                })
                .catch((error) => {
                    if (error.response) {
                        toastr.error(error.response.data.message, "Error");
                        if (error.response && error.response.data.errors) {
                            _this.$setErrorsFromLaravel(
                                error.response.data
                            );
                        }
                    } else {
                        toastr.error(error.message, "Error");
                    }
                    _this.loading = false;
                });
        },
        /* Fetching participants list from the projects who need health session*/
        getAllParticipant() {
            let _this = this;
            axios
                .post(_this.routes.allParticipant, _this.search)
                .then((res) => {
                    if (res.data) {
                        _this.originalData = res.data.lists.data;
                        _this.outputRes = res.data.lists;
                        if (_this.search.page > 1) {
                            _this.sl =
                                (_this.search.page - 1) * parseInt(_this.outputRes.per_page) +
                                1;
                        } else {
                            _this.sl = 1;
                        }
                    } else {
                        toastr.error(res.data.message, "Warning");
                    }
                    _this.loading = false;
                })
                .catch((error) => {
                    if (error.response) {
                        toastr.error(error.response.data.message, "Error");
                        if (error.response && error.response.data.errors) {
                            _this.$setErrorsFromLaravel(
                                error.response.data
                            );
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
            _this.errors = {};
            _this.$validator.reset();
            _this.__sortReset();
            this.getAllParticipant();
        },
        resetAndGetAll() {
            this.__sortReset();
            this.getAll();
        }
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
