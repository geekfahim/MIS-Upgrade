<template>
    <div class="position-relative">
        <div class="card-header">
            <i class="fa fa-list"></i>
            Role Assign
            <div class="card-header-actions p-0 m-0">
                <button v-if="!formView" class="btn btn-brand btn-sm btn-github" type="button" @click="addNew()">
                    <i class="fa fa-plus"></i>
                    <span>Add New</span>
                </button>
                <button v-else class="btn btn-brand btn-sm btn-github" type="button" @click="getAll()">
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
                                    <strong v-if="createView">Add New</strong>
                                    <strong v-else>Update</strong>
                                </h6>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">User<span class="text-danger">*</span></label>
                                <Select2 v-model="formData.user_id" v-validate="'required'" :options="users"
                                         :settings="{ width: '100%', allowClear: true }" data-vv-as="user"
                                         data-vv-name="user_id" data-vv-validate-on="change"/>
                                <div v-if="vvErrors.has('user_id')"
                                     :class="[(vvErrors.has('user_id') ? ' d-block' : '')]"
                                     class="invalid-feedback">
                                    {{ vvErrors.first('user_id') }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Roles<span class="text-danger">*</span></label>
                                <div>
                                    <Select2
                                        v-model="formData.role_ids"
                                        v-validate="'required'"
                                        :options="roles"
                                        :settings="{ width: '100%', multiple:true }"
                                        data-vv-as="roles"
                                        data-vv-name="role_ids"/>
                                </div>
                                <div v-if="vvErrors.has('role_ids')"
                                     :class="[(vvErrors.has('role_ids') ? ' d-block' : '')]"
                                     class="invalid-feedback">
                                    {{ vvErrors.first('role_ids') }}
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
                <div class="table-responsive">
                    <table class="table table-responsive-sm table-sm table-striped">
                        <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th style="cursor: pointer; width: 250px" @click="onClickSortItems('name')">Employee
                                Name
                            </th>
                            <th>Roles</th>
                            <th style="cursor: pointer;" @click="onClickSortItems('created_at')">Created
                            </th>
                            <th style="width: 140px;text-align: center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item, index) in outputRes.data" v-if="outputRes.data.length > 0">
                            <td>{{ sl + index }}</td>
                            <td>{{ item.name | textCapitalize }}</td>
                            <td>{{ item.roles ? _getRoleNames(item.roles) : '' }}</td>
                            <!--                            <td class="text-capitalize">
                                                            <span class="badge badge-success"
                                                                  v-if="item.status == 'active'">{{ item.status }}</span>
                                                            <span class="badge badge-warning" v-else-if="item.status == 'inactive'">{{
                                                                    item.status
                                                                }}</span>
                                                            <span class="badge badge-danger" v-else>{{ item.status }}</span>
                                                        </td>-->
                            <td>{{ item.created_at | dateFormat }}</td>
                            <td>
                                <button class="btn btn-xs btn-info rounded-0"
                                        @click="onClickEdit(item.id)">
                                    <i class="fa fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-xs btn-danger rounded-0"
                                        @click="onClickDelete(item)">
                                    <i class="fa fa-remove"></i> Delete
                                </button>
                            </td>
                        </tr>
                        <tr v-if="outputRes.data.length == 0">
                            <td class="text-center" colspan="8">No Data Found
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
                        <pagination v-if="outputRes.data.length>=0" :records="outputRes"
                                    class="pull-right" @onclicked="paginationClicked"></pagination>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="loading" class="czm-loader">Loading&#8230;</div>
    </div>
</template>

<script>
import Pagination from "../../Pagination";
import queryString from 'query-string';
import Select2 from "v-select2-component";

export default {
    name: "UserRoleAssignC",
    components: {Pagination, Select2},
    data() {
        return {
            loading: false,
            createView: true,
            formView: false,
            timeout: null,
            errors: {},
            sl: 1,
            search: {
                page: 1,
                sort: "name",
                type: "asc",
                query: "",
                item: ""
            },
            formData: {
                id: "",
                user_id: "",
                role_ids: []
            },
            users: [],
            roles: [],
            chunk: [],
            outputRes: {
                data: [],
                editable: false,
                deletable: false
            },
            routes: window.appHelper.routes,
        }
    },
    methods: {
        paginationClicked(page) {
            this.updateQueryParams('page', page);
            this.search.page = page;
            this.getAll();
        },
        updateQueryParams(key, value) {
            let parsed = queryString.parse(location.search);
            let page = (key == 'page') ? value : (!!parsed.page ? parsed.page : 1);
            let sort = (key == 'sort') ? value : (!!parsed.sort ? parsed.sort : "name");
            let type = (key == 'type') ? value : (!!parsed.type ? parsed.type : "asc");
            let query = (key == 'query') ? value : (!!parsed.query ? parsed.query : "");
            let item = (key == 'item') ? value : (!!parsed.item ? parsed.item : 25);

            let queryStringify = queryString.stringify({page, sort, type, query, item});
            let newUrl = this.routes.one + "?" + queryStringify;
            window.history.pushState({}, null, newUrl);
        },
        itemPerPageSelect() {
            this.search.page = 1;
            this.updateQueryParams('page', this.search.page);
            this.updateQueryParams('item', this.search.item);
            this.getAll();
        },
        onClickSortItems(key) {
            let _this = this;
            _this.search.sort = key;
            _this.search.type = _this.search.type === "asc" ? "desc" : "asc";
            this.updateQueryParams('sort', key);
            this.updateQueryParams('type', _this.search.type);
            this.getAll();
        },
        searchTimeOut() {
            clearTimeout(this.timeout);
            this.timeout = setTimeout(() => {
                this.search.page = 1;
                this.updateQueryParams('page', this.search.page);
                this.updateQueryParams('query', this.search.query);
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
                    _this.roles = res.data.roles;
                    _this.users = res.data.users;
                    if (_this.search.page > 1) {
                        _this.sl = ((_this.search.page - 1) * parseInt(_this.outputRes.per_page)) + 1;
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
            _this.formData.user_id = '';
            _this.formData.role_ids = [];
        },
        onClickEdit(id) {
            let _this = this;
            _this.loading = true;
            _this.errors = {};
            axios.patch(_this.routes.one + "/" + id).then((res) => {
                if (res.data) {
                    _this.createView = false;
                    _this.formView = true;
                    _this.formData.id = res.data.user_id;
                    _this.formData.user_id = res.data.user_id;
                    _this.users = res.data.users;
                    _this.formData.role_ids = res.data.role_ids;
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
                title: 'Are you sure?',
                html: '<p style="color:#3085d6">"' + item.name + '"</p>' + "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    _this.onDeleteRequest(item.id);
                }
            })
        },
        onDeleteRequest(id) {
            let _this = this;
            _this.loading = true;
            _this.errors = {};
            axios.delete(_this.routes.one + "/" + id).then((res) => {
                if (res.data.success) {
                    Swal.fire('Deleted!', res.data.success, 'success')
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
        _getRoleNames(obj) {
            let flag = '';
            obj.forEach(item => {
                flag += item.name;
                flag += ' ';
            });
            return flag;
        }
    },
    created() {
        let _this = this;
        let parsed = queryString.parse(location.search);
        this.search.page = !!parsed.page ? parsed.page : 1;
        this.search.sort = !!parsed.sort ? parsed.sort : "name";
        this.search.type = !!parsed.type ? parsed.type : "asc";
        this.search.query = !!parsed.query ? parsed.query : "";
        this.search.item = !!parsed.item ? parsed.item : 25;
        _this.getAll();
    },
    filters: {
        dateFormat(value) {
            if (!value) return '';
            return moment(value).format("MMM DD, YYYY");
        },
        textCapitalize(value) {
            if (!value) return '';
            value = value.toString();
            return value.charAt(0).toUpperCase() + value.slice(1)
        }
    }
}
</script>

<style scoped>

</style>
