<template>
    <div class="position-relative">
        <div class="card-header">
            <i class="fa fa-list"></i>
            GRO's
            <div class="card-header-actions p-0 m-0">
                <button v-if="!formView" class="btn btn-brand btn-sm btn-github" type="button" @click="addNew()">
                    <i class="fa fa-plus"></i>
                    <span>Add New GRO</span>
                </button>
                <button v-else class="btn btn-brand btn-sm btn-github" type="button" @click="getAll()">
                    <i class="fa fa-list"></i>
                    <span>View All GRO</span>
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
                                    <strong v-if="createView">Add New GRO</strong>
                                    <strong v-else>Update GRO</strong>
                                </h6>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Select Project<span class="text-danger">*</span></label>
                                <div>
                                    <Select2 v-model.number="formData.j_project_id" v-validate="'required'"
                                             :options="projects"
                                             :settings="projectSettings" data-vv-as="project"
                                             data-vv-name="j_project_id"/>
                                </div>
                                <div v-if="vvErrors.has('j_project_id')"
                                     :class="[(vvErrors.has('j_project_id') ? ' d-block' : '')]"
                                     class="invalid-feedback">
                                    {{ vvErrors.first('j_project_id') }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">GRO Name<span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fa fa-file-text-o"></i>
                    </span>
                                    </div>
                                    <input v-model="formData.name" v-validate="'required|name_with_number|min:2|max:50'"
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
                                <label class="czm-xs">Reference Id</label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fa fa-file-text-o"></i>
                    </span>
                                    </div>
                                    <input v-model="formData.reference_id" v-validate="'min:2|max:50'"
                                           :class="[(vvErrors.has('reference_id') ? 'is-invalid' : '')]"
                                           class="form-control form-control-sm rounded-0"
                                           data-vv-as="reference" data-vv-name="reference_id"
                                           placeholder="reference id" type="text">
                                    <div v-show="vvErrors.has('reference_id')" class="invalid-feedback">
                                        {{ vvErrors.first('reference_id') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">GRO Leader</label>
                                <div>
                                    <Select2 v-model="formData.leader_id" :options="leaders" :settings="leaderSettings"
                                             data-vv-as="leader" data-vv-name="leader_id"/>
                                </div>
                                <div v-if="vvErrors.has('leader_id')"
                                     :class="[(vvErrors.has('leader_id') ? ' d-block' : '')]"
                                     class="invalid-feedback">
                                    {{ vvErrors.first('leader_id') }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">GRO Cashier</label>
                                <div>
                                    <Select2 v-model="formData.cashier_id" :options="cashiers"
                                             :settings="cashierSettings" data-vv-as="cashier"
                                             data-vv-name="cashier_id"/>
                                </div>
                                <div v-if="vvErrors.has('cashier_id')"
                                     :class="[(vvErrors.has('cashier_id') ? ' d-block' : '')]"
                                     class="invalid-feedback">
                                    {{ vvErrors.first('cashier_id') }}
                                </div>
                            </div>
                            <!--                            <div class="form-group">
                                                            <label class="czm-xs">Number of Family</label>
                                                            <div class="input-group input-group-sm">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                      <i class="fa fa-file-text-o"></i>
                                                                    </span>
                                                                </div>
                                                                <input v-model="formData.number_of_family" v-validate="'numeric|min:2|max:50'"
                                                                       :class="[(vvErrors.has('number_of_family') ? 'is-invalid' : '')]"
                                                                       class="form-control form-control-sm rounded-0"
                                                                       data-vv-as="number of family" data-vv-name="number_of_family"
                                                                       placeholder="number of family" type="text">
                                                                <div v-show="vvErrors.has('number_of_family')" class="invalid-feedback">
                                                                    {{ vvErrors.first('number_of_family') }}
                                                                </div>
                                                            </div>
                                                        </div>-->
                            <div class="form-group">
                                <label class="czm-xs">GRO Bank</label>
                                <div>
                                    <Select2 v-model="formData.bank_id" :options="banks" :settings="bankSettings"
                                             data-vv-as="bank" data-vv-name="bank_id"/>
                                </div>
                                <div v-if="vvErrors.has('bank_id')"
                                     :class="[(vvErrors.has('bank_id') ? ' d-block' : '')]"
                                     class="invalid-feedback">
                                    {{ vvErrors.first('bank_id') }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Bank Branch Name</label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fa fa-file-text-o"></i>
                    </span>
                                    </div>
                                    <input v-model="formData.bank_branch_name"
                                           v-validate="'name_with_number|min:2|max:50'"
                                           :class="[(vvErrors.has('bank_branch_name') ? 'is-invalid' : '')]"
                                           class="form-control form-control-sm rounded-0"
                                           data-vv-as="branch name" data-vv-name="bank_branch_name"
                                           type="text">
                                    <div v-show="vvErrors.has('bank_branch_name')" class="invalid-feedback">
                                        {{ vvErrors.first('bank_branch_name') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Bank Account Name</label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fa fa-file-text-o"></i>
                    </span>
                                    </div>
                                    <input v-model="formData.bank_account_name"
                                           v-validate="'name_with_number|min:2|max:50'"
                                           :class="[(vvErrors.has('bank_account_name') ? 'is-invalid' : '')]"
                                           class="form-control form-control-sm rounded-0"
                                           data-vv-as="account name" data-vv-name="bank_account_name"
                                           type="text">
                                    <div v-show="vvErrors.has('bank_account_name')" class="invalid-feedback">
                                        {{ vvErrors.first('bank_account_name') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Bank Account Number</label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fa fa-file-text-o"></i>
                    </span>
                                    </div>
                                    <input v-model="formData.bank_account_number" v-validate="'numeric|min:2|max:50'"
                                           :class="[(vvErrors.has('bank_account_number') ? 'is-invalid' : '')]"
                                           class="form-control form-control-sm rounded-0"
                                           data-vv-as="account number" data-vv-name="bank_account_number"
                                           type="text">
                                    <div v-show="vvErrors.has('bank_account_number')" class="invalid-feedback">
                                        {{ vvErrors.first('bank_account_number') }}
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
                <div class="table-responsive">
                    <table class="table table-responsive-sm table-sm table-striped table-hover">
                        <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th class="sort" style="width: 250px" @click="onClickSortItems('name')">Name</th>
                            <th>Project Name</th>
                            <th>Reference Id</th>
                            <th>Number of Family</th>
                            <th>A. Number of Family</th>
                            <th class="sort" style="width: 140px" @click="onClickSortItems('created_at')">Created
                            </th>
                            <th style="width: 220px; text-align:center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item, index) in outputRes.data" v-if="outputRes.data.length > 0" :key="index">
                            <td>{{ sl + index }}</td>
                            <td>{{ item.name | textCapitalize }}</td>
                            <td>{{ item.j_project_name }}</td>
                            <td>{{ item.reference_id }}</td>
                            <td>{{ item.number_of_family }}</td>
                            <td>{{ item.families_count }}</td>
                            <td>{{ item.created_at | dateFormat }}</td>
                            <td>
                                <a :href="routes.one+'/'+item.id+'/view'" class="btn btn-xs btn-github rounded-0">
                                    <i class="fa fa-link"></i> Details
                                </a>
                                <button class="btn btn-xs btn-info rounded-0" @click="onClickEdit(item.id)">
                                    <i class="fa fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-xs btn-danger rounded-0" @click="onClickDelete(item)">
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
import Select2 from "v-select2-component";
import Pagination from "../../Pagination";
import queryString from "query-string";

export default {
    name: "GroProjectManagerView.Vue",
    components: {
        Pagination,
        Select2: Select2,
    },
    data() {
        return {
            loading: false,
            createView: true,
            formView: false,
            timeout: null,
            errors: {},
            sl: 1,
            projects: [],
            projectSettings: {
                multiple: false,
                width: "100%",
                placeholder: "Select One",
                minimumInputLength: 2,
                ajax: {
                    type: "POST",
                    delay: 1000,
                    url: null,
                    dataType: "json",
                    processResults: null,
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                },
            },
            leaders: [],
            leaderSettings: {
                multiple: false,
                width: "100%",
                placeholder: "Select One",
                minimumInputLength: 2,
                ajax: {
                    type: "POST",
                    delay: 1000,
                    url: null,
                    dataType: "json",
                    processResults: null,
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                },
            },
            cashiers: [],
            cashierSettings: {
                multiple: false,
                width: "100%",
                placeholder: "Select One",
                minimumInputLength: 2,
                ajax: {
                    type: "POST",
                    delay: 1000,
                    url: null,
                    dataType: "json",
                    processResults: null,
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                },
            },
            banks: [],
            bankSettings: {
                multiple: false,
                width: "100%",
                placeholder: "Select One",
                minimumInputLength: 2,
                ajax: {
                    type: "POST",
                    delay: 1000,
                    url: null,
                    dataType: "json",
                    processResults: null,
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                },
            },
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
                reference_id: "",
                j_project_id: "",
                leader_id: "",
                cashier_id: "",
                bank_id: "",
                number_of_family: "",
                bank_branch_name: "",
                bank_account_name: "",
                bank_account_number: "",
            },
            chunk: [],
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
            let sort = key == "sort" ? value : !!parsed.sort ? parsed.sort : "created_at";
            let type = key == "type" ? value : !!parsed.type ? parsed.type : "desc";
            let query = key == "query" ? value : !!parsed.query ? parsed.query : "";
            let item = key == "item" ? value : !!parsed.item ? parsed.item : 25;

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
        getAll() {
            let _this = this;
            _this.formView = false;
            _this.loading = true;
            _this.createView = true;
            _this.formData = {};
            this.$validator.reset();
            axios
                .post(_this.routes.list, _this.search)
                .then((res) => {
                    if (res.data) {
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
            _this.formData = {};
        },
        onClickEdit(id) {
            let _this = this;
            _this.loading = true;
            _this.errors = {};
            axios
                .patch(_this.routes.one + "/" + id)
                .then((res) => {
                    if (res.data) {
                        console.log(res.data.bank);
                        _this.createView = false;
                        _this.formView = true;
                        _this.formData.id = res.data.id;
                        _this.formData.name = res.data.name;
                        _this.formData.reference_id = res.data.reference_id;
                        _this.formData.number_of_family = res.data.number_of_family;
                        _this.formData.j_project_id = res.data.j_project_id;
                        _this.formData.leader_id = res.data.leader_id;
                        _this.formData.cashier_id = res.data.cashier_id;
                        _this.formData.bank_id = res.data.bank_id;
                        _this.formData.bank_branch_name = res.data.bank_branch_name;
                        _this.formData.bank_account_name = res.data.bank_account_name;
                        _this.formData.bank_account_number = res.data.bank_account_number;
                        _this.projects.push(res.data.j_project);
                        _this.leaders.push(res.data.leader);
                        _this.cashiers.push(res.data.cashier);
                        _this.banks.push(res.data.bank);
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
                    item.name +
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
        _this.projectSettings.ajax.url = this.routes.projectSearch;
        _this.projectSettings.ajax.processResults = function (data) {
            return {
                results: data,
            };
        };
        _this.leaderSettings.ajax.url = this.routes.mustahiqSearch;
        _this.leaderSettings.ajax.processResults = function (data) {
            return {
                results: data,
            };
        };
        _this.cashierSettings.ajax.url = this.routes.mustahiqSearch;
        _this.cashierSettings.ajax.processResults = function (data) {
            return {
                results: data,
            };
        };
        _this.bankSettings.ajax.url = this.routes.bankSearch;
        _this.bankSettings.ajax.processResults = function (data) {
            return {
                results: data,
            };
        };
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

<style scoped>
</style>
