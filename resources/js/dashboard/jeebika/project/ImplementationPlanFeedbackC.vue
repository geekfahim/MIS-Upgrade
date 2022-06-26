<template>
    <div class="position-relative">
        <div class="card-header">
            <i class="fa fa-list"></i>
            Implementation Plan Feedback
            <div class="card-header-actions p-0 m-0">
                <button v-if="formView" class="btn btn-brand btn-sm btn-github" type="button" @click="getAll()">
                    <i class="fa fa-list"></i>
                    <span>View All</span>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div v-show="formView">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6 col-sm-8 col-xs-12">
                        <form class="form-horizontal" v-on:submit.prevent="onSubmit">
                            <div class="form-group row justify-content-center">
                                <h6 class="text-left col-sm-12">
                                    <strong>Feedback</strong>
                                </h6>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-borderless table-sm table-hover">
                                    <tr v-if="chunk.gro_name">
                                        <td>GRO Name</td>
                                        <td>:</td>
                                        <td>{{ chunk.gro_name }}</td>
                                    </tr>
                                    <tr v-if="chunk.family_name">
                                        <td>Family Name</td>
                                        <td>:</td>
                                        <td>{{ chunk.family_name }}</td>
                                    </tr>
                                    <tr v-if="chunk.member_name">
                                        <td>Member Name</td>
                                        <td>:</td>
                                        <td>{{ chunk.member_name }}</td>
                                    </tr>
                                    <tr v-if="chunk.indicator_name">
                                        <td>Indicator Name</td>
                                        <td>:</td>
                                        <td>{{ chunk.indicator_name }}</td>
                                    </tr>
                                    <tr v-if="chunk.status">
                                        <td>Status</td>
                                        <td>:</td>
                                        <td>
                                            <span v-if="chunk.status == 'Pending'"
                                                  class="badge badge-warning">Pending</span>
                                            <span v-else-if="chunk.status == 'Implemented'" class="badge badge-success">Implemented</span>
                                            <span v-else class="badge badge-danger">{{ chunk.status }}</span>
                                        </td>
                                    </tr>
                                    <tr v-if="chunk.possible_implementation_date">
                                        <td>Possible Implementation Date</td>
                                        <td>:</td>
                                        <td>{{ chunk.possible_implementation_date | dateFormat }}</td>
                                    </tr>
                                    <tr v-if="chunk.implemented_date">
                                        <td>Implemented Date</td>
                                        <td>:</td>
                                        <td>{{ chunk.implemented_date | dateFormat }}</td>
                                    </tr>
                                    <tr v-if="chunk.implemented_by">
                                        <td>Implemented By</td>
                                        <td>:</td>
                                        <td>{{ chunk.implemented_by }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Status<span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fa fa-arrow-circle-down"></i>
                    </span>
                                    </div>
                                    <select v-model="formData.status" v-validate="'required'"
                                            :class="[(vvErrors.has('status') ? 'is-invalid' : '')]"
                                            class="form-control form-control-sm rounded-0" data-vv-as="status"
                                            data-vv-name="status"
                                            data-vv-validate-on="change">
                                        <option value="">Select One</option>
                                        <option v-for="(item,index) in statuses" :key='index' :value="item">
                                            {{ item }}
                                        </option>
                                    </select>
                                    <div v-show="vvErrors.has('status')" class="invalid-feedback">
                                        {{ vvErrors.first('status') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Implementation Date <span class="text-danger">(required when Implemented)</span></label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fa fa-calendar"></i>
                    </span>
                                    </div>
                                    <input id="date" v-model="formData.date"
                                           :class="[(vvErrors.has('date') ? 'is-invalid' : '')]"
                                           class="form-control form-control-sm rounded-0 ipf_datepicker"
                                           data-vv-as="date" data-vv-name="date" data-vv-validate-on="change"
                                           name="date"
                                           placeholder="date:yyyy-mm-dd"
                                           type="text">
                                    <div v-show="vvErrors.has('date')" class="invalid-feedback">
                                        {{ vvErrors.first('date') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Remarks <span
                                    class="text-danger">(required when Rejected)</span></label>
                                <textarea v-model="formData.remarks" v-validate="'name_with_number|max:999'"
                                          :class="[(vvErrors.has('remarks') ? 'is-invalid' : '')]"
                                          class="form-control form-control-sm rounded-0"
                                          cols="4"
                                          data-vv-as="remarks" data-vv-name="remarks"
                                          placeholder="type here"></textarea>
                                <div v-show="vvErrors.has('remarks')" class="invalid-feedback">
                                    {{ vvErrors.first('remarks') }}
                                </div>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-sm btn-primary pull-right rounded-0" type="submit">
                                    <i class="fa fa-dot-circle-o"></i>
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div v-if="!formView">
                <div class="row">
                    <div class="col-sm-12 col-md-3">
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
                        <div class="text-center">
                            <label class="d-inline-block">
                                From
                                <input id="from_date" v-model="search.from_date"
                                       :class="[(errors.hasOwnProperty('from_date') ? 'custom-is-invalid' : '')]"
                                       class="ipf_datepicker"
                                       name="from_date"
                                       placeholder="date:yyyy-mm-dd">
                                To
                                <input id="to_date" v-model="search.to_date"
                                       :class="[(errors.hasOwnProperty('to_date') ? 'custom-is-invalid' : '')]"
                                       class="ipf_datepicker"
                                       name="to_date"
                                       placeholder="date:yyyy-mm-dd">
                            </label>
                            <span class="text-danger" style="cursor: pointer" @click="resetDates()">Reset</span>
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
                <div class="row justify-content-center">
          <span v-if="errors.hasOwnProperty('from_date')" class="text-danger">
            {{ errors.from_date[0] }}</span>
                    <span v-if="errors.hasOwnProperty('to_date')" class="text-danger">
            {{ errors.to_date[0] }}</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-responsive-sm table-sm table-striped table-hover">
                        <thead>
                        <tr>
                            <th>Sl.</th>
                            <th style="cursor: pointer;" @click="onClickSortItems('gro_name')">GRO Name
                            </th>
                            <th style="cursor: pointer;" @click="onClickSortItems('family_name')">Family
                                Name
                            </th>
                            <th style="cursor: pointer;" @click="onClickSortItems('member_name')">Member
                                Name
                            </th>
                            <th style="cursor: pointer;" @click="onClickSortItems('indicator_name')">Indicator
                                Name
                            </th>
                            <th>Proposed Date</th>
                            <th>Implemented Date</th>
                            <th>Implemented By</th>
                            <th>Status</th>
                            <th style="text-align:center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item, index) in outputRes.data" :key="index">
                            <td>{{ sl + index }}</td>
                            <td>{{ item.gro_name }}</td>
                            <td>{{ item.family_name }}</td>
                            <td>{{ item.member_name }}</td>
                            <td>{{ item.indicator_name }}</td>
                            <td>{{ item.possible_implementation_date | dateFormat }}</td>
                            <td>{{ item.implemented_date | dateFormat }}</td>
                            <td>{{ item.implemented_by_name }}</td>
                            <td class="text-capitalize">
                                <span v-if="'Pending'===item.status" class="badge badge-warning">Pending</span>
                                <span v-else-if="item.status == 'Implemented'"
                                      class="badge badge-success">Implemented</span>
                                <span v-else class="badge badge-danger">{{ item.status }}</span>
                            </td>
                            <td>
                                <button class="btn btn-xs btn-info rounded-0" @click="onClickSet(item)">
                                    <i class="fa fa-edit"></i> Set
                                </button>
                            </td>
                        </tr>
                        <tr v-if="outputRes.data.length === 0">
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
import Pagination from "../../Pagination";
import queryString from "query-string";

export default {
    name: "ImplementationPlanFeedbackC",
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
                sort: "possible_implementation_date",
                type: "asc",
                query: "",
                item: 50,
                from_date: "",
                to_date: "",
            },
            formData: {
                id: "",
                date: "",
                status: "",
                remarks: "",
            },
            chunk: [],
            statuses: [],
            outputRes: {
                data: [],
            },
            routes: window.appHelper.routes,
        };
    },
    methods: {
        resetDates() {
            let _this = this;
            _this.search.from_date = "";
            _this.search.to_date = "";
            $("#from_date").datepicker("update", "");
            $("#to_date").datepicker("update", "");
            _this.itemPerPageSelect();
        },
        paginationClicked(page) {
            this.updateQueryParams("page", page);
            this.search.page = page;
            this.getAll();
        },
        updateQueryParams(key, value) {
            let parsed = queryString.parse(location.search);
            let page = key == "page" ? value : !!parsed.page ? parsed.page : 1;
            let sort = key == "sort" ? value : !!parsed.sort ? parsed.sort : "possible_implementation_date";
            let type = key == "type" ? value : !!parsed.type ? parsed.type : "asc";
            let query = key == "query" ? value : !!parsed.query ? parsed.query : "";
            let item = key == "item" ? value : !!parsed.item ? parsed.item : 25;
            let from_date = key == "from_date" ? value : !!parsed.from_date ? parsed.from_date : "";
            let to_date = key == "to_date" ? value : !!parsed.to_date ? parsed.to_date : "";
            let queryStringify = queryString.stringify({
                page, sort, type, query, item, from_date, to_date
            });
            let newUrl = this.routes.one + "?" + queryStringify;
            window.history.pushState({}, null, newUrl);
        },
        itemPerPageSelect() {
            this.search.page = 1;
            this.updateQueryParams("page", this.search.page);
            this.updateQueryParams("item", this.search.item);
            this.updateQueryParams("from_date", this.search.from_date);
            this.updateQueryParams("to_date", this.search.to_date);
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
                if (result) {
                    _this.submit();
                }
            });
        },
        submit() {
            let _this = this;
            _this.loading = true;
            _this.errors = {};
            this.$validator.errors.clear();
            axios.put(_this.routes.one + "/" + _this.formData.id, _this.formData).then((res) => {
                if (res.data.success) {
                    toastr.success(res.data.success, "Success");
                    _this.getAll();
                } else if (res.data.warning) {
                    toastr.warning(res.data.warning, "Warning");
                } else {
                    toastr.error(res.data.message, "Error");
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
        getAll() {
            let _this = this;
            _this.formView = false;
            _this.loading = true;
            _this.errors = {};
            _this.formData = {};
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
                        _this.errors = error.response.data.errors;
                    }
                } else {
                    toastr.error(error.message, "Error");
                }
                _this.loading = false;
            });
        },
        onClickSet(item) {
            let _this = this;
            _this.formData.id = item.id;
            _this.chunk = item;
            _this.formData.status = item.status;
            _this.formView = true;
        },
    },
    created() {
        let parsed = queryString.parse(location.search);
        this.search.page = !!parsed.page ? parsed.page : 1;
        this.search.sort = !!parsed.sort ? parsed.sort : "possible_implementation_date";
        this.search.type = !!parsed.type ? parsed.type : "asc";
        this.search.query = !!parsed.query ? parsed.query : "";
        this.search.item = !!parsed.item ? parsed.item : 25;
        this.search.from_date = !!parsed.from_date ? parsed.from_date : "";
        this.search.to_date = !!parsed.to_date ? parsed.to_date : "";
        this.getAll();
    },
    mounted() {
        let _this = this;
        $(".ipf_datepicker").datepicker({
            todayHighlight: true,
            format: "yyyy-mm-dd",
            startDate: "-200y",
            autoclose: true,
        }).on("changeDate", (event) => {
            let value = event.currentTarget.value;
            switch (event.currentTarget.name) {
                case "from_date":
                    _this.search.from_date = value;
                    _this.itemPerPageSelect();
                    break;
                case "to_date":
                    _this.search.to_date = value;
                    _this.itemPerPageSelect();
                    break;
                case "date":
                    _this.formData.date = value;
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
.custom-is-invalid {
    border-color: #f86c6b;
}
</style>
