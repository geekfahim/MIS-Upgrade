<template>
    <div class="position-relative">
        <div class="card-header"><i class="fa fa-list"></i> Business Plan Approve</div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 col-md-4">
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
                <div class="col-sm-12 col-md-4">
                    <div class="row justify-content-center">
                        <label class="d-inline-block">
                            Status
                            <select v-model="search.status" @change="statusFilterSelect()">
                                <option value="">All</option>
                                <option v-for="item in statuses" :key='item' :value="item">
                                    {{ item }}
                                </option>
                            </select>
                        </label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="float-md-right">
                        <label>
                            Search: <input v-model="search.query" @keyup="searchTimeOut()" type="text"
                                           placeholder="Search...">
                        </label>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-responsive-sm table-sm table-striped table-hover">
                    <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th @click="onClickSortItems('family_name')" class="sort">Family Name
                        </th>
                        <th @click="onClickSortItems('business_name')" class="sort">Business Name
                        </th>
                        <th @click="onClickSortItems('area_name')" class="sort">Investment
                            Area
                        </th>
                        <th>Seed Money</th>
                        <th @click="onClickSortItems('status')" class="sort">Status
                        </th>
                        <th @click="onClickSortItems('created_at')" class="sort" style="width: 140px">Created
                        </th>
                        <th style="width: 250px; text-align:center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(item, index) in outputRes.data" :key="index">
                        <td>{{ sl + index }}</td>
                        <td>{{ item.family_name }}</td>
                        <td>{{ item.business_name }}</td>
                        <td>{{ item.area_name }}</td>
                        <td>{{ item.business_seed_money }}</td>
                        <td class="text-capitalize">
                            <span class="badge badge-warning" v-if="'Pending'===item.status">Pending</span>
                            <span class="badge badge-info" v-else-if="'Hold'===item.status">Hold</span>
                            <span class="badge badge-primary" v-else-if="'Approved'===item.status">Approved</span>
                            <span class="badge badge-success" v-else-if="'Ongoing'===item.status">Ongoing</span>
                            <span class="badge badge-secondary" v-else-if="'Completed'===item.status">Completed</span>
                            <span class="badge badge-danger" v-else-if="'Rejected'===item.status">Rejected</span>
                            <span class="text-capitalize" v-else>{{ item.status }}</span>
                        </td>
                        <td>{{ item.created_at | dateFormat }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <button id="btnGroupDrop1" type="button" class="btn btn-xs btn-success dropdown-toggle"
                                        data-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-link"></i> Feedback
                                </button>
                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                    <a class="dropdown-item py-1 px-3"
                                       :href="routes.one+'/'+item.id+'/feedback/verification'">
                                        <i class="fa fa-money text-info"></i>
                                        Verification
                                    </a>
                                    <a class="dropdown-item py-1 px-3" :href="routes.one+'/'+item.id+'/feedback/visit'">
                                        <i class="fa fa-money text-info"></i>
                                        Visit
                                    </a>
                                    <a class="dropdown-item py-1 px-3" :href="routes.one+'/'+item.id+'/feedback/final'">
                                        <i class="fa fa-money text-info"></i>
                                        Final
                                    </a>
                                </div>
                            </div>
                            <a :href="routes.one+'/'+item.id+'/view'" class="btn btn-xs btn-github rounded-0">
                                <i class="fa fa-link"></i> Details
                            </a>
                        </td>
                    </tr>
                    <tr v-if="outputRes.data.length === 0">
                        <td colspan="8" class="text-center">No Data Found
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
                    <pagination v-if="outputRes.data.length>=0" :records="outputRes" @onclicked="paginationClicked"
                                class="pull-right"></pagination>
                </div>
            </div>
            <div class="czm-loader" v-if="loading">Loading&#8230;</div>
        </div>
    </div>
</template>

<script>
import Pagination from "../../../Pagination";
import queryString from "query-string";

export default {
    name: "BPApproveListC",
    components: {Pagination},
    data() {
        return {
            loading: false,
            timeout: null,
            sl: 1,
            search: {
                page: 1,
                sort: "business_name",
                type: "asc",
                query: "",
                item: "",
                status: "",
            },
            outputRes: {
                data: [],
            },
            statuses: [],
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
            let sort = key == "sort" ? value : !!parsed.sort ? parsed.sort : "business_name";
            let type = key == "type" ? value : !!parsed.type ? parsed.type : "asc";
            let query = key == "query" ? value : !!parsed.query ? parsed.query : "";
            let item = key == "item" ? value : !!parsed.item ? parsed.item : 25;
            let status = key == "status" ? value : !!parsed.status ? parsed.status : "";
            let queryStringify = queryString.stringify({page, sort, type, query, item, status});
            let newUrl = this.routes.one + "?" + queryStringify;
            window.history.pushState({}, null, newUrl);
        },
        statusFilterSelect() {
            this.updateQueryParams("status", this.search.status);
            this.getAll();
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
            _this.loading = true;
            _this.errors = {};
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
        this.search.sort = !!parsed.sort ? parsed.sort : "business_name";
        this.search.type = !!parsed.type ? parsed.type : "asc";
        this.search.query = !!parsed.query ? parsed.query : "";
        this.search.item = !!parsed.item ? parsed.item : 25;
        this.search.status = !!parsed.status ? parsed.status : "";
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
