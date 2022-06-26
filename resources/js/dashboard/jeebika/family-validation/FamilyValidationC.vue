<template>
    <div class="position-relative">
        <div class="card-header">
            <i class="fa fa-list"></i>
            Families
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 col-md-7">
                    <div class="pull-left">
                        <label class="d-inline-block">
                            Showing
                            <select v-model="search.p" @change="projectFilterSelect()">
                                <option value="">All</option>
                                <option v-for="(item,index) in allProjects" :key='index' :value="item.id">
                                    {{ item.name }}
                                </option>
                            </select>
                            Project
                        </label>
                        <label class="d-inline-block">
                            <select v-model="search.g" @change="groFilterSelect()">
                                <option value="">All</option>
                                <option v-for="(item,index) in allGROs" :key='index' :value="item.id">
                                    {{ item.name }}
                                </option>
                            </select>
                            GRO Families
                        </label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-2">
                    <div class="pull-right">
                        <label class="d-inline-block">
                            Status
                            <select v-model="search.s" @change="statusFilterSelect()">
                                <option value="">All</option>
                                <option v-for="(item,index) in statuses" :key='index' :value="item">
                                    {{ item }}
                                </option>
                            </select>
                        </label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-3">
                    <div class="float-md-right">
                        <label>
                            Search: <input v-model="query" placeholder="Search..." type="text"
                                           @keyup="searchTimeOut()">
                        </label>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-responsive-sm table-sm table-striped table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th class="sort" @click="onClickSortItems('name')">Name</th>
                        <th>Total Family Member</th>
                        <th>Reference Number</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th style="width: 135px; text-align: center">Action</th>
                    </tr>
                    </thead>
                    <tbody v-if="paginate.data.length > 0">
                    <tr v-for="(item, index) in paginate.data" :key="index">
                        <td>
                            <input :id="'id-'+item.id" :checked="checkIds.includes(item.id)" :value="item.id"
                                   type="checkbox" @change="selectCheckbox(item.id,$event)">
                        </td>
                        <td><label :for="'id-'+item.id">{{ item.name }}</label></td>
                        <td>{{ item.number_of_family_member }}</td>
                        <td>{{ item.family_reference_number }}</td>
                        <td>
                            <span v-if="'Pending'===item.status" class="badge badge-warning">Pending</span>
                            <span v-else-if="'Verified'===item.status" class="badge badge-primary">Verified</span>
                            <span v-else-if="'Rejected'===item.status" class="badge badge-danger">Rejected</span>
                            <span v-else-if="'Inactive'===item.status"
                                  class="badge badge-secondary">Inactive</span>
                            <span v-else-if="'Active'===item.status" class="badge badge-success">Active</span>
                            <span v-else-if="'Surrender'===item.status" class="badge badge-info">Surrender</span>
                            <span v-else-if="'Graduate'===item.status" class="badge badge-dark">Graduate</span>
                            <span class="text-capitalize" v-else>{{ item.status }}</span>
                        </td>
                        <td>{{ item.created_at | dateFormat }}</td>
                        <td>
                            <button class="btn btn-xs btn-github rounded-0" @click="onClickView(item.id)">
                                <i class="fa fa-eye"></i> View
                            </button>
                            <a
                                :href="routes.edit+'/?fid='+item.id"
                                class="btn btn-xs btn-info rounded-0">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                        </td>
                    </tr>
                    <tr v-if="paginate.data.length === 0">
                        <td class="text-center" colspan="6">No Data Found
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="pull-left">
                        Showing
                        {{ paginate.total === 0 ? 0 : paginate.from }}
                        to
                        {{ paginate.to > paginate.total ? paginate.total : paginate.to }}
                        of
                        {{ paginate.total ? paginate.total : 0 }} entries
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <pagination v-if="paginate.data.length>=0" :records="paginate" class="pull-right"
                                @onclicked="paginationClicked"></pagination>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-3 col-md-3 col-sm-12">
                    <input id="sa" :checked="allSelected" type="checkbox" @click="callAllSelect($event)">
                    <label for="sa">Select All</label>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12">
                    <button :disabled="checkIds.length<=0" class="btn btn-xs btn-outline-danger rounded-0 w-100"
                            @click="onClickStatus('reject','f86c6b')">
                        <i class="fa fa-remove"></i> Reject
                    </button>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12">
                    <button :disabled="checkIds.length<=0" class="btn btn-xs btn-outline-primary rounded-0 w-100"
                            @click="onClickStatus('verify','20a8d8')">
                        <i class="fa fa-circle-o"></i> Verify
                    </button>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12">
                    <button :disabled="checkIds.length<=0" class="btn btn-xs btn-outline-success rounded-0 w-100"
                            @click="onClickStatus('approve','3a9d5d')">
                        <i class="fa fa-check"></i> Approve
                    </button>
                </div>
            </div>
            <div v-if="loading" class="czm-loader">Loading&#8230;</div>
        </div>
    </div>
</template>
<script>
import queryString from "query-string";
import Pagination from "../../Pagination";

export default {
    name: "FamilyValidationC",
    components: {Pagination},
    data() {
        return {
            loading: false,
            allSelected: false,
            timeout: 0,
            report_serial: 0,
            errors: {},
            sl: 1,
            search: {
                p: "",
                g: "",
                s: "",
            },
            statuses: [],
            allProjects: [],
            allGROs: [],
            checkIds: [],
            originalData: [],
            searchedData: [],
            paginate: {
                data: [],
                total: 0,
                per_page: 15,
                current_page: 1,
                last_page: 1,
                from: 1,
                to: 0
            },
            query: '',
            routes: window.appHelper.routes,
        };
    },
    methods: {
        dataPush() {
            let _this = this;
            _this.$paginateSetData(_this.searchedData);
            _this.paginate = _this.$paginateConfig;
        },
        paginationClicked(page) {
            this.$paginateConfig.current_page = page;
            this.dataPush();
        },
        searchTimeOut() {
            let _this = this;
            clearTimeout(this.timeout);
            this.timeout = setTimeout(() => {
                _this.searchInData(_this.query.toLowerCase());
            }, 500);
        },
        searchInData(query) {
            let _this = this;
            let temp = [];
            let data = _this.originalData;
            if (query === "" || query === " ") {
                _this.searchedData = _this.originalData;
            } else {
                if (data.length > 0) {
                    data.forEach(function (item, key) {
                        if (item.name.split("'").join('').toLowerCase().indexOf(query) > -1) {
                            temp.push(item);
                        } else {
                            if (!temp.length) {
                                _this.searchedData = [];
                            }
                        }
                    })
                }
                _this.searchedData = temp;
            }
            _this.dataPush();
            _this._checkedAllStatus();
        },
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
                    _this.checkIds.push(item.id);
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
                html: `<p style="color:#${color}">You want to ${status} selected.</p>You won't be able to revert this!`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: `#${color}`, //"#d33",
                cancelButtonColor: "#2778c4",
                confirmButtonText: `Yes, ${status} it!`,
            }).then((result) => {
                if (result.isConfirmed) {
                    this._submit(status);
                }
            });
        },
        _submit(flag) {
            let _this = this;
            if (_this.checkIds.length <= 0) {
                toastr.error("Please select at least one family.", "Error");
                return
            }
            _this.loading = true;
            axios.post(_this.routes.one, {flag: flag, fIds: this.checkIds}).then((res) => {
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
        onClickView(id) {
            let _this = this;
            _this.loading = true;
            axios.get(`${_this.routes.one}/${id}/view`).then((res) => {
                _this.loading = false;
                if (res.data) {
                    let myWindow = window.open("", _this.report_serial + "_window");
                    myWindow.document.write(res.data);
                    _this.report_serial++;
                }
            }).catch((err) => {
                toastr.error(err.response.data.message, "Error");
                _this.loading = false;
            });
        },
        updateQueryParams(key, value) {
            let parsed = queryString.parse(location.search);
            let p = key == "p" ? value : !!parsed.p ? parsed.p : "";
            let g = key == "g" ? value : !!parsed.g ? parsed.g : "";
            let s = key == "s" ? value : !!parsed.s ? parsed.s : "";
            let queryStringify = queryString.stringify({p, g, s});
            let newUrl = this.routes.one + "?" + queryStringify;
            window.history.pushState({}, null, newUrl);
        },
        projectFilterSelect() {
            this.updateQueryParams("p", this.search.p);
            this.search.g = "";
            this.groFilterSelect();
        },
        groFilterSelect() {
            this.updateQueryParams("g", this.search.g);
            this.getAll();
        },
        statusFilterSelect() {
            this.updateQueryParams("s", this.search.s);
            this.getAll();
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
        getAll() {
            let _this = this;
            _this._reset();
            _this.loading = true;
            axios.post(_this.routes.list, _this.search).then((res) => {
                if (res.data) {
                    _this.originalData = res.data.lists;
                    _this.searchedData = res.data.lists;
                    _this.statuses = res.data.statuses;
                    _this.allProjects = res.data.allProjects;
                    _this.allGROs = res.data.allGROs;
                    _this.dataPush();
                } else {
                    toastr.error(res.data.message, "Warning");
                }
                _this.loading = false;
            }).catch((error) => {
                if (error.response) {
                    toastr.error(error.response.data.message, "Error");
                    if (error.response && error.response.data.errors) {
                        console.log(error.response.data);
                    }
                } else {
                    toastr.error(error.message, "Error");
                }
                _this.loading = false;
            });
        },
        onClickSortItems(key) {
            let _this = this;
            _this.search.sort = key;
            if (_this.search.type == "asc") {
                _this.search.type = "desc";
            } else {
                _this.search.type = "asc";
            }
            this.updateQueryParams("sort", key);
            this.updateQueryParams("type", _this.search.type);
            this.getAll();
        },
    },
    created() {
        let parsed = queryString.parse(location.search);
        this.search.p = !!parsed.p ? parsed.p : "";
        this.search.g = !!parsed.g ? parsed.g : "";
        this.search.s = !!parsed.s ? parsed.s : "";
        this.search.sort = !!parsed.sort ? parsed.sort : "created_at";
        this.search.type = !!parsed.type ? parsed.type : "desc";
        this.getAll();
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


