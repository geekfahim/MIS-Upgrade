<template>
    <div class="position-relative">
        <div class="card-header">
            <i class="fa fa-list"></i> User
            <div class="card-header-actions p-0 m-0">
                <button v-if="!formView" class="btn btn-brand btn-sm btn-github" type="button" @click="addNew()">
                    <i class="fa fa-plus"></i>
                    <span>Add New User</span>
                </button>
                <button v-else class="btn btn-brand btn-sm btn-github" type="button" @click="getAll()">
                    <i class="fa fa-list"></i>
                    <span>View All User</span>
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
                                    <strong v-if="createView">Add New User</strong>
                                    <strong v-else>Update User</strong>
                                </h6>
                                <div class="text-left col-sm-12">All fields marked
                                    <span class="text-danger">*</span> are mandatory.
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Name<span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="fa fa-file-text-o"></i>
                                        </span>
                                    </div>
                                    <input v-model="formData.name" v-validate="'required|min:2|max:50'"
                                           :class="[(vvErrors.has('name') ? 'is-invalid' : '')]"
                                           class="form-control form-control-sm rounded-0"
                                           data-vv-as="name" data-vv-name="name" placeholder="name"
                                           type="text">
                                    <div v-show="vvErrors.has('name')" class="invalid-feedback">
                                        {{ vvErrors.first('name') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Office Id<span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fa fa-file-text-o"></i>
                    </span>
                                    </div>
                                    <input v-model.number="formData.office_id"
                                           v-validate="'required|numeric|min:3|max:50'"
                                           :class="[(vvErrors.has('office_id') ? 'is-invalid' : '')]"
                                           class="form-control form-control-sm rounded-0"
                                           data-vv-as="office id" data-vv-name="office_id"
                                           placeholder="office id" type="text">
                                    <div v-show="vvErrors.has('office_id')" class="invalid-feedback">
                                        {{ vvErrors.first('office_id') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Email<span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fa fa-file-text-o"></i>
                    </span>
                                    </div>
                                    <input v-model="formData.email" v-validate="'required|email|min:8|max:50'"
                                           :class="[(vvErrors.has('email') ? 'is-invalid' : '')]"
                                           class="form-control form-control-sm rounded-0"
                                           data-vv-as="email" data-vv-name="email"
                                           placeholder="email" type="text">
                                    <div v-show="vvErrors.has('email')" class="invalid-feedback">
                                        {{ vvErrors.first('email') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Mobile</label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">+880</span>
                                    </div>
                                    <input v-model="formData.mobile" v-validate="'numeric|mobile'"
                                           :class="[(vvErrors.has('mobile') ? 'is-invalid' : '')]"
                                           class="form-control form-control-sm rounded-0"
                                           data-vv-as="mobile" data-vv-name="mobile"
                                           placeholder="mobile" type="text">
                                    <div v-show="vvErrors.has('mobile')" class="invalid-feedback">
                                        {{ vvErrors.first('mobile') }}
                                    </div>
                                </div>
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
                                        <option v-for="item in statuses" :key='item' :value="item">
                                            {{ item }}
                                        </option>
                                    </select>
                                    <div v-show="vvErrors.has('status')" class="invalid-feedback">
                                        {{ vvErrors.first('status') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Password<span v-if="createView"
                                                                    class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="nav-icon icon-lock"></i>
                    </span>
                                    </div>
                                    <input ref='password' v-model="formData.password"
                                           v-validate="'min:6|max:16'"
                                           :class="[(vvErrors.has('password') ?'is-invalid': '')]"
                                           autocomplete="off"
                                           class="form-control form-control-sm rounded-0" data-vv-as="password"
                                           data-vv-name="password" placeholder="password" type="password">
                                    <div v-show="vvErrors.has('password')" class="invalid-feedback">
                                        {{ vvErrors.first('password') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Confirm Password<span v-if="createView"
                                                                            class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="nav-icon icon-lock"></i>
                    </span>
                                    </div>
                                    <input v-model="formData.password_confirmation"
                                           v-validate="'confirmed:password|min:6|max:16'"
                                           :class="[(vvErrors.has('password_confirmation') ? 'is-invalid': '')]"
                                           autocomplete="off"
                                           class="form-control form-control-sm rounded-0"
                                           data-vv-as="confirm password" data-vv-name="password_confirmation"
                                           placeholder="confirm password" type="password">
                                    <div v-show="vvErrors.has('password_confirmation')" class="invalid-feedback">
                                        {{ vvErrors.first('password_confirmation') }}
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
                                    <i class="fa fa-dot-circle-o"></i>
                                    Update
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
                <div class="table">
                    <table class="table table-responsive-sm table-sm table-striped table-hover">
                        <thead>
                        <tr>
                            <th style="width:50px">#</th>
                            <th class="sort" style="width:250px" @click="onClickSortItems('name')">Name</th>
                            <th class="sort" style="width:100px" @click="onClickSortItems('office_id')">Office Id</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Status</th>
                            <th class="sort" style=" " @click="onClickSortItems('created_at')">Created</th>
                            <th style="width: 150px; text-align:center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item,index) in outputRes.data" :key="index">
                            <td>{{ sl + index }}</td>
                            <td>{{ item.name }}</td>
                            <td>{{ item.office_id }}</td>
                            <td>{{ item.email }}</td>
                            <td>{{ item.mobile }}</td>
                            <td>
                                <span v-if="'Active'===item.status" class='badge badge-success'>Active</span>
                                <span v-else-if="'Inactive'===item.status" class='badge badge-warning'>Inactive</span>
                                <span v-else-if="'Blocked'===item.status" class='badge badge-danger'>Blocked</span>
                                <span v-else class="text-capitalize">{{ item.status }}</span>
                            </td>
                            <td>
                                {{ item.created_at | dateFormat }}
                            </td>
                            <td>
                                <button class="btn btn-xs btn-github rounded-0" @click="onClickView(item.id)">
                                    <i class="fa fa-eye"></i> View
                                </button>
                                <button class="btn btn-xs btn-info rounded-0" @click="onClickEdit(item.id)">
                                    <i class="fa fa-edit"></i> Edit
                                </button>
                            </td>
                        </tr>
                        <tr v-if="outputRes.data.length === 0">
                            <td class="text-center" colspan="8">No Data Found</td>
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
        <div id="viewModal" aria-hidden="true" aria-labelledby="viewModalTitle" class="modal fade" role="dialog"
             tabindex="-1">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div v-if="chunk" class="modal-content rounded-0">
                    <div class="modal-header">
                        <h6 id="exampleModalCenterTitle" class="modal-title">User Details</h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <tr v-if="chunk.name">
                                    <td style="width: 100px;">Name</td>
                                    <td style="width: 5px;">:</td>
                                    <td>{{ chunk.name }}</td>
                                </tr>
                                <tr v-if="chunk.office_id">
                                    <td style="width: 100px;">Office Id</td>
                                    <td style="width: 5px;">:</td>
                                    <td>{{ chunk.office_id }}</td>
                                </tr>
                                <tr v-if="chunk.email">
                                    <td style="width: 100px;">Email</td>
                                    <td style="width: 5px;">:</td>
                                    <td>{{ chunk.email }}</td>
                                </tr>
                                <tr v-if="chunk.mobile">
                                    <td style="width: 100px;">Mobile</td>
                                    <td style="width: 5px;">:</td>
                                    <td>{{ chunk.mobile }}</td>
                                </tr>
                                <tr v-if="chunk.status">
                                    <td style="width: 100px;">Status</td>
                                    <td style="width: 5px;">:</td>
                                    <td>
                                        <span v-if="'Active'===chunk.status" class='badge badge-success'>Active</span>
                                        <span v-else-if="'Inactive'===chunk.status"
                                              class='badge badge-warning'>Inactive</span>
                                        <span v-else-if="'Blocked'===chunk.status"
                                              class='badge badge-danger'>Blocked</span>
                                        <span v-else class="text-capitalize">{{ chunk.status }}</span>
                                    </td>
                                </tr>
                                <tr v-if="chunk.created_user">
                                    <td>Created By</td>
                                    <td>:</td>
                                    <td> {{ chunk.created_user.name }}</td>
                                </tr>
                                <tr>
                                    <td>Created</td>
                                    <td>:</td>
                                    <td>{{ chunk.created_at | dateFormat }}</td>
                                </tr>
                                <tr v-if="chunk.updated_user">
                                    <td>Updated By</td>
                                    <td>:</td>
                                    <td> {{ chunk.updated_user.name }}</td>
                                </tr>
                                <tr v-if="chunk.updated_user">
                                    <td>Last Updated</td>
                                    <td>:</td>
                                    <td>{{ chunk.updated_at | dateFormat }}</td>
                                </tr>
                            </table>
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
import pagination from "../../Pagination.vue";
import queryString from "query-string";

export default {
    name: "UserC.vue",
    components: {pagination},
    data() {
        return {
            loading: false,
            formView: false,
            createView: true,
            timeout: null,
            errors: {},
            sl: 1,
            search: {
                page: 1,
                sort: "name",
                type: "asc",
                query: "",
                item: "",
            },
            formData: {
                id: "",
                name: "",
                office_id: "",
                email: "",
                status: "",
                password: "",
                password_confirmation: "",
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
            _this.formView = false;
            _this.loading = true;
            _this.formData = {};
            axios.post(_this.routes.list, _this.search).then((res) => {
                if (res.data) {
                    _this.outputRes = res.data.lists;
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
            _this.createView = true;
            _this.formData = {};
            _this.formData.status = "";
            _this.errors = {};
            this.$validator.reset();
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
            _this.$validator.reset();
            _this.errors = {};
            axios.patch(_this.routes.one + "/" + id).then((res) => {
                if (res.data) {
                    _this.formView = true;
                    _this.createView = false;
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
        }
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
