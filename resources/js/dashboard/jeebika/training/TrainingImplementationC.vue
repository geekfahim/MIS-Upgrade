<template>
    <div class="position-relative">
        <div class="card-header">
            <span><i class="fa fa-list"></i> Implementation</span>
        </div>
        <div class="card-body">
            <div>
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
                                               @keyup="searchTimeOutTrainingParticipant()">
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
                            <th>Attendance</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item, index) in originalData.data" :key="index">
                            <td>
                                <input v-if="training.status!=='Complete'" :id="'id-'+item.id"
                                       :checked="checkIds.includes(item.id)" :value="item.id"
                                       type="checkbox" @change="selectCheckbox(item.id,$event)">
                            </td>
                            <td>
                                <label :for="'id-'+item.id">
                                    {{ item.mustahiq ? item.mustahiq.name : '' }}
                                </label>
                            </td>
                            <td>{{ item.mustahiq ? item.mustahiq.mobile : '' }}</td>
                            <td>{{ item.mustahiq ? item.mustahiq.reference_number : '' }}</td>
                            <td>
                                <span v-if="item.is_present===true" class="badge badge-success">Present</span>
                                <span v-else-if="item.is_present===false" class="badge badge-danger">Absent</span>
                                <span v-else></span>
                            </td>
                        </tr>
                        <tr v-if="originalData.data.length === 0">
                            <td class="text-center" colspan="8">No Data Found
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="pull-left">
                            Showing {{ originalData.from ? originalData.from : 0 }} to
                            {{ originalData.to ? originalData.to : 0 }}
                            of {{ originalData.total ? originalData.total : 0 }} entries
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <pagination v-if="originalData.data.length>=0" :records="originalData" class="pull-right"
                                    @onclicked="paginationClicked"></pagination>
                    </div>
                </div>
                <div v-if="training.status!=='Complete'" class="row justify-content-center">
                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <input id="sa" :checked="allSelected" type="checkbox" @click="callAllSelect($event)">
                        <label for="sa">Select All</label>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <button :disabled="checkIds.length<=0" class="btn btn-xs btn-primary-gradient rounded-0 w-100"
                                @click="onClickStatus('Present','3a9d5d')">
                            <i class="fa fa-check"></i> Present
                        </button>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <button :disabled="checkIds.length<=0" class="btn btn-xs btn-danger-gradient rounded-0 w-100"
                                @click="onClickStatus('Absent','f86c6b')">
                            <i aria-hidden="true" class="fa fa-user-times"></i> Absent
                        </button>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <button class="btn btn-xs btn-warning-gradient rounded-0 w-100"
                                @click="onClickStatus('Complete')">
                            <i aria-hidden="true" class="fa fa-list"></i> Complete
                        </button>
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
    components: {
        Pagination,
        Select2: Select2,
    },
    name: "Training-Implementation.vue",
    props: {
        training: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            loading: false,
            createView: false,
            allSelected: false,
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
            },
            checkIds: [],
            searchedData: [],
            originalData: {
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
                _this.originalData.data.forEach(function (item) {
                    _this.checkIds.push(item.id);
                });
                _this.allSelected = true;
            } else {
                _this.checkIds = [];
                _this.allSelected = false;
            }
        },
        onClickStatus(status, color = '3085d6') {
            let _status = status.toLowerCase().trim();
            let _msg = (_status === 'complete') ? `<p style="color:#${color}">You want to ${_status} this training.</p>You won't be able to revert this!`
                : `<p style="color:#${color}">You want to ${_status} selected participant.</p>You won't be able to revert this!`;
            Swal.fire({
                title: "Are you sure?",
                html: _msg,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: `#${color}`, //"#d33",
                cancelButtonColor: "#e74c3c",
                confirmButtonText: `Yes, ${status} it!`,
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
            if (_this.checkIds.length <= 0 && flag !== 'Complete') {
                toastr.error("Please select at least one Participant.", "Error");
                return
            }
            _this.loading = true;
            axios.put(_this.routes.one, {flag: flag, participantIds: this.checkIds}).then((res) => {
                if (res.data.success) {
                    toastr.success(res.data.success, "Success");
                    _this.checkIds = [];
                    _this.getAll();
                    window.location.reload();
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
            this.getAll();
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
            this.getAll();
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
            this.getAll();
        },
        searchTimeOutTrainingParticipant() {
            clearTimeout(this.timeout);
            this.timeout = setTimeout(() => {
                this.search.page = 1;
                this.updateQueryParams("page", this.search.page);
                this.updateQueryParams("query", this.search.query);
                this.getAll();
            }, 1000);
        },
        selectTrainingType() {
            let _this = this;
            _this.trades = [];
            _this.formData.trade_id = "";
            if (_this.formData.training_type === "vocational") {
                _this.trades = _this.vocationals;
            } else if (_this.formData.training_type === "skill") {
                _this.trades = _this.skills;
            } else
                _this.trades = [];
        },
        getAll() {
            let _this = this;
            _this.formData = {};
            _this.loading = true;
            _this.allSelected = false;
            _this.errors = {};
            _this.$validator.reset();
            axios
                .post(_this.routes.list, _this.search)
                .then((res) => {
                    if (res.data) {
                        _this.originalData = res.data.lists;
                        _this.trainingStatus = res.data.trainingStatus;
                        _this.selectTrainingType();
                        if (_this.search.page > 1) {
                            _this.sl =
                                (_this.search.page - 1) * parseInt(_this.originalData.per_page) +
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
        /* Fetching participants list from the projects who need training*/
        addNew() {
            let _this = this;
            _this.formView = true;
            _this.errors = {};
            this.$validator.reset();
            _this.search.query = "";
            this.getAllParticipant();
        },
        onClickDetails(id) {
            let _this = this;
            _this.loading = true;
            _this.errors = {};
            axios
                .post(_this.routes.details + "/" + id)
                .then((res) => {
                    if (res.data) {
                        _this.chunk = res.data;
                        $("#viewModal").modal("show");
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
        onClickEdit(id) {
            let _this = this;
            _this.loading = true;
            _this.errors = {};
            axios
                .patch(_this.routes.one + "/" + id)
                .then((res) => {
                    if (res.data) {
                        _this.formData = res.data;
                        _this.formData.training_type = res.data.training_type === 1 ? 'vocational' : 'skill';
                        _this.formData.training_method = res.data.training_methods === 1 ? 'online' : 'offline';
                        _this.formData.trade_id = res.data.vocational ? res.data.vocational_id : res.data.skill_id;
                        _this.projects.push(res.data.j_project);

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
        onUpdate() {
            let _this = this;
            _this.loading = true;
            axios
                .put(_this.routes.one + "/" + _this.formData.id, _this.formData)
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
                    _this.loading = false;
                });
        },
        onClickDelete(item) {
            let _this = this;
            Swal.fire({
                title: "Are you sure?",
                html:
                    '<p style="color:#3085d6">"' +
                    item.mustahiq.name +
                    '"</p>' +
                    "You won't be able to revert this!",
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
            axios
                .delete(_this.routes.one + "/" + id)
                .then((res) => {
                    if (res.data.success) {
                        Swal.fire("Deleted!", res.data.success, "success");
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
                    _this.loading = false;
                });
        },
    },
    created() {
        let _this = this;

        let parsed = queryString.parse(location.search);
        this.search.page = !!parsed.page ? parsed.page : 1;
        this.search.sort = !!parsed.sort ? parsed.sort : "created_at";
        this.search.type = !!parsed.type ? parsed.type : "desc";
        this.search.query = !!parsed.query ? parsed.query : "";
        this.search.item = !!parsed.item ? parsed.item : 25;
        _this.getAll();
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
