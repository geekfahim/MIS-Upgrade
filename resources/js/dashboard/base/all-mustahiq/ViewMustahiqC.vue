<template>
    <div class="position-relative">
        <div class="card-body">
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
                        <th class="sort" @click="onClickSortItems('name')">Full Name</th>
                        <th class="sort" @click="onClickSortItems('gender')">Gender</th>
                        <th class="sort" @click="onClickSortItems('religion')">Religion</th>
                        <th class="sort" @click="onClickSortItems('origin_program')">Program</th>
                        <th>Earn Ability</th>
                        <th class="sort" @click="onClickSortItems('status')">Status</th>
                        <th class="sort" style="width: 140px" @click="onClickSortItems('created_at')">Created</th>
                        <!-- <th style="width: 104px">Action</th> -->
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(item, index) in outputRes.data" v-if="outputRes.data.length > 0" :key="index">
                        <td>{{ sl + index }}</td>
                        <td>{{ item.name }}</td>
                        <td>{{ item.gender }}</td>
                        <td>{{ item.religion }}</td>
                        <td>{{ item.origin_program }}</td>
                        <td> {{ item.details ? (item.details.is_earn_ability ? 'Yes' : 'No') : 'Not Found' }}</td>
                        <td>
                            <span class='badge badge-success' v-if="'Active'===item.status">Active</span>
                            <span class='badge badge-warning' v-else-if="'Inactive'===item.status">Inactive</span>
                            <span class='badge badge-danger' v-else-if="'Blocked'===item.status">Blocked</span>
                            <span class="text-capitalize" v-else>{{ item.status }}</span>
                        </td>
                        <td>{{ item.created_at | dateFormat }}</td>
                        <!-- <td>
                          <button class="btn btn-xs btn-github rounded-0">
                            <i class="fa fa-eye"></i>
                          </button>
                          <button class="btn btn-xs btn-info rounded-0">
                            <i class="fa fa-edit"></i>
                          </button>
                          <button class="btn btn-xs btn-danger rounded-0">
                            <i class="fa fa-remove"></i>
                          </button>
                        </td> -->
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
import queryString from "query-string";
import Pagination from "../../Pagination";
import Select2 from "v-select2-component";

export default {
    name: "ViewMustahiqC",
    components: {Select2, Pagination},
    data() {
        return {
            loading: false,
            timeout: null,
            sl: 1,
            search: {
                page: 1,
                sort: "name",
                type: "asc",
                query: "",
                item: "",
            },
            statuses: [],
            genders: [],
            religions: [],
            originPrograms: [],
            outputRes: {
                data: [],
            },
            errors: {},
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

            let queryStringify = queryString.stringify({page, sort, type, query, item,});
            let newUrl = this.routes.list + "?" + queryStringify;
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
            _this.formView = false;
            _this.loading = true;
            _this.createView = true;
            _this.formData = {};
            axios.post(_this.routes.list, _this.search).then((res) => {
                if (res.data) {
                    _this.outputRes = res.data.lists;
                    _this.statuses = res.data.statuses;
                    _this.genders = res.data.genders;
                    _this.religions = res.data.religions;
                    _this.originPrograms = res.data.originPrograms;
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
            }).catch((error) => {
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
        /*download() {
            let _this = this;
            _this.loading = true;
            axios({
                method: "POST",
                url: window.appHelper.routes.download,
                responseType: "blob",
                data: [],
            }).then(function (response) {
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement("a");
                link.href = url;
                link.setAttribute("download", response.headers.file_name);
                document.body.appendChild(link);
                link.click();
                _this.loading = false;
            }).catch((error) => {
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
        },*/
    },
    created() {
        let parsed = queryString.parse(location.search);
        this.search.page = !!parsed.page ? parsed.page : 1;
        this.search.sort = !!parsed.sort ? parsed.sort : "name";
        this.search.type = !!parsed.type ? parsed.type : "asc";
        this.search.query = !!parsed.query ? parsed.query : "";
        this.search.item = !!parsed.item ? parsed.item : 25;
        this.getAll();
    },
    filters: {
        dateFormat(value) {
            if (!value) return "";
            return moment(value).format("MMM DD, YYYY");
        }
    },
};
</script>

<style scoped>
</style>
