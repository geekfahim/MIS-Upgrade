<template>
    <div class="position-relative">
        <div class="card-header">
            <i class="fa fa-list"></i>
            Families
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 col-md-2">
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
                <div class="col-sm-12 col-md-7">
                    <div class="row justify-content-center">
                        <label class="d-inline-block">
                            Showing
                            <select v-model="search.select_p" @change="projectFilterSelect()">
                                <option value="">All</option>
                                <option v-for="(item,index) in allProjects" :key='index' :value="item.id">
                                    {{ item.name }}
                                </option>
                            </select>
                            Project
                            <select v-model="search.select_g" @change="groFilterSelect()">
                                <option value="">All</option>
                                <option v-for="(item,index) in allGROs" :key='index' :value="item.id">
                                    {{ item.name }}
                                </option>
                            </select>
                            GRO Families
                        </label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-3">
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
                        <th class="sort" style="width: 250px" @click="onClickSortItems('name')">Family Name</th>
                        <th>Total Family Member</th>
                        <th>Total Family Balance</th>
                        <th>Project</th>
                        <th>Gro</th>
                        <th class="sort" @click="onClickSortItems('status')">Status</th>
                        <th class="sort" style="width: 140px" @click="onClickSortItems('created_at')">Created</th>
                        <th class="sort" @click="onClickSortItems('need_assessment')">Need</th>
                        <th style="width: 100px; text-align: center">Action</th>
                    </tr>
                    </thead>
                    <tbody v-if="outputRes.data.length > 0">
                    <tr v-for="(item, index) in outputRes.data" :key="item.id">
                        <td>{{ sl + index }}</td>
                        <td>{{ item.name }}</td>
                        <td>{{ item.number_of_family_member }}</td>
                        <td><span class="tk">{{ item.family_balance ? item.family_balance.balance : '' }}</span></td>
                        <td>{{ item.jeebika ? item.jeebika.j_project.name : '' }}</td>
                        <td>{{ item.jeebika ? item.jeebika.j_gro.name : '' }}</td>
                        <td>
                            <span v-if="'Active'===item.status" class='badge badge-success'>Active</span>
                            <span v-else-if="'Inactive'===item.status" class='badge badge-secondary'>Inactive</span>
                            <span v-else-if="'Verified'===item.status" class='badge badge-primary'>Verified</span>
                            <span v-else-if="'Pending'===item.status" class='badge badge-warning'>Pending</span>
                            <span v-else-if="'Rejected'===item.status" class='badge badge-danger'>Rejected</span>
                            <span v-else-if="'Surrender'===item.status" class='badge badge-info'>Surrender</span>
                            <span v-else-if="'Graduate'===item.status" class='badge badge-dark'>Graduate</span>
                            <span v-else class="text-capitalize">{{ item.status }}</span>
                        </td>
                        <td>{{ item.created_at | dateFormat }}</td>
                        <td>
                <span v-if="item.need_assessment"> <i aria-hidden="true" class="fa fa-check green-color"></i>
                </span>
                            <span v-else>
                  <i aria-hidden="true" class="fa fa-times red-color"></i>
                </span>
                        </td>
                        <td>
                            <a :href='"family" + "/" + item.id + "/" + "view"' class="btn btn-xs btn-github rounded-0">
                                <i class="fa fa-link"></i> Details
                            </a>
                        </td>
                    </tr>
                    <tr v-if="outputRes.data.length == 0">
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
            <div v-if="loading" class="czm-loader">Loading&#8230;</div>
        </div>
    </div>
</template>

<script>
import Pagination from "../../Pagination";
import queryString from "query-string";

export default {
    name: "FamilyAdminViewC.Vue",
    components: {Pagination},
    data() {
        return {
            loading: false,
            timeout: null,
            errors: {},
            sl: 1,
            search: {
                page: 1,
                sort: "name",
                type: "asc",
                query: "",
                item: "",
                select_p: "",
                select_g: "",
            },
            allProjects: [],
            allGROs: [],
            chunk: [],
            statuses: [],
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
            let sort = key == "sort" ? value : !!parsed.sort ? parsed.sort : "name";
            let type = key == "type" ? value : !!parsed.type ? parsed.type : "asc";
            let query = key == "query" ? value : !!parsed.query ? parsed.query : "";
            let item = key == "item" ? value : !!parsed.item ? parsed.item : 25;
            let select_p =
                key == "select_p" ? value : !!parsed.select_p ? parsed.select_p : "";
            let select_g =
                key == "select_g" ? value : !!parsed.select_g ? parsed.select_g : "";

            let queryStringify = queryString.stringify({
                page,
                sort,
                type,
                query,
                item,
                select_p,
                select_g,
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
        projectFilterSelect() {
            this.updateQueryParams("select_p", this.search.select_p);
            this.search.select_g = "";
            this.groFilterSelect();
        },
        groFilterSelect() {
            this.updateQueryParams("select_g", this.search.select_g);
            this.getAll();
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
            axios
                .post(_this.routes.list, _this.search)
                .then((res) => {
                    if (res.data) {
                        _this.outputRes = res.data.lists;
                        _this.allProjects = res.data.allProjects;
                        _this.allGROs = res.data.allGROs;
                        _this.statuses = res.data.statuses;
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
                            console.log(error.response.data);
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
        this.search.sort = !!parsed.sort ? parsed.sort : "name";
        this.search.type = !!parsed.type ? parsed.type : "asc";
        this.search.query = !!parsed.query ? parsed.query : "";
        this.search.item = !!parsed.item ? parsed.item : 25;
        this.search.select_p = !!parsed.select_p ? parsed.select_p : "";
        this.search.select_g = !!parsed.select_g ? parsed.select_g : "";
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
.green-color {
    color: green;
}

.red-color {
    color: red;
}
</style>
