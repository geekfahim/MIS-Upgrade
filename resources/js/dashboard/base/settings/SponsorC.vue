<template>
    <div class="position-relative">
        <div class="card-header">
            <i class="fa fa-list"></i>
            Sponsor
            <div class="card-header-actions p-0 m-0">
                <button v-if="!formView" class="btn btn-brand btn-sm btn-github" type="button" @click="addNew()">
                    <i class="fa fa-plus"></i>
                    <span>Add New Sponsor</span>
                </button>
                <button v-else class="btn btn-brand btn-sm btn-github" type="button" @click="getAll()">
                    <i class="fa fa-list"></i>
                    <span>View All Sponsor</span>
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
                                    <strong v-if="createView">Add New Sponsor</strong>
                                    <strong v-else>Update Sponsor</strong>
                                </h6>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Name<span class="text-danger">*</span></label>
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
                                <label class="czm-xs">Mobile<span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">+880</span>
                                    </div>
                                    <input v-model="formData.mobile" v-validate="'required|mobile'"
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
                                <label class="czm-xs">Type<span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fa fa-arrow-circle-down"></i>
                    </span>
                                    </div>
                                    <select v-model="formData.type" v-validate="'required'"
                                            :class="[(vvErrors.has('type') ? 'is-invalid' : '')]"
                                            class="form-control form-control-sm rounded-0"
                                            data-vv-as="type"
                                            data-vv-name="type">
                                        <option value="">Select One</option>
                                        <option v-for="item in types" :key="item" :value="item">
                                            {{ item }}
                                        </option>
                                    </select>
                                    <div v-show="vvErrors.has('type')" class="invalid-feedback">
                                        {{ vvErrors.first('type') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Phone/Landline(if any)</label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fa fa-file-text-o"></i>
                    </span>
                                    </div>
                                    <input v-model="formData.phone" v-validate="'numeric|min:4|max:50'"
                                           :class="[(vvErrors.has('phone') ? 'is-invalid' : '')]"
                                           class="form-control form-control-sm rounded-0"
                                           data-vv-as="phone" data-vv-name="phone"
                                           placeholder="phone" type="text">
                                    <div v-show="vvErrors.has('phone')" class="invalid-feedback">
                                        {{ vvErrors.first('phone') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Contact Person<span class="text-danger"></span></label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fa fa-file-text-o"></i>
                    </span>
                                    </div>
                                    <input v-model="formData.contact_person"
                                           v-validate="'name_with_number|min:2|max:50'"
                                           :class="[(vvErrors.has('contact_person') ? 'is-invalid' : '')]"
                                           class="form-control form-control-sm rounded-0"
                                           data-vv-as="contact person" data-vv-name="contact_person"
                                           placeholder="contact person" type="text">
                                    <div v-show="vvErrors.has('contact_person')" class="invalid-feedback">
                                        {{ vvErrors.first('contact_person') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Contact Person Mobile<span class="text-danger"></span></label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">+880</span>
                                    </div>
                                    <input v-model="formData.contact_person_mobile" v-validate="'mobile'"
                                           :class="[(vvErrors.has('contact_person_mobile') ? 'is-invalid' : '')]"
                                           class="form-control form-control-sm rounded-0"
                                           data-vv-as="contact person mobile"
                                           data-vv-name="contact_person_mobile" placeholder="contact person mobile"
                                           type="text">
                                    <div v-show="vvErrors.has('contact_person_mobile')" class="invalid-feedback">
                                        {{ vvErrors.first('contact_person_mobile') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Address</label>
                                <textarea v-model="formData.address" v-validate="'name_with_number|max:999'"
                                          :class="[(vvErrors.has('address') ? 'is-invalid' : '')]"
                                          class="form-control form-control-sm rounded-0"
                                          cols="4"
                                          data-vv-as="address" data-vv-name="address"
                                          placeholder="type here"></textarea>
                                <div v-show="vvErrors.has('address')" class="invalid-feedback">
                                    {{ vvErrors.first('address') }}
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
                            <th>Type</th>
                            <th>Status</th>
                            <th class="sort" style="width: 140px" @click="onClickSortItems('created_at')">Created
                            </th>
                            <th style="width: 210px; text-align:center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item, index) in outputRes.data" :key="index">
                            <td>{{ sl + index }}</td>
                            <td class="text-capitalize">{{ item.name }}</td>
                            <td class="text-capitalize">{{ item.type }}</td>
                            <td>
                                <span v-if="'Active'===item.status" class='badge badge-success'>Active</span>
                                <span v-else-if="'Inactive'===item.status" class='badge badge-warning'>Inactive</span>
                                <span v-else-if="'Blocked'===item.status" class='badge badge-danger'>Blocked</span>
                                <span v-else class="text-capitalize">{{ item.status }}</span>
                            </td>
                            <td>{{ item.created_at | dateFormat }}</td>
                            <td>
                                <button class="btn btn-xs btn-github rounded-0" @click="onClickView(item.id)">
                                    <i class="fa fa-eye"></i> View
                                </button>
                                <button class="btn btn-xs btn-info rounded-0" @click="onClickEdit(item.id)">
                                    <i class="fa fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-xs btn-danger rounded-0" @click="onClickDelete(item)">
                                    <i class="fa fa-remove"></i> Delete
                                </button>
                            </td>
                        </tr>
                        <tr v-if="outputRes.data.length === 0">
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
            </div>
            <div v-if="loading" class="czm-loader">Loading&#8230;</div>
        </div>
        <!-- Modal -->
        <div id="viewModal" aria-hidden="true" aria-labelledby="viewModalTitle" class="modal fade" role="dialog"
             tabindex="-1">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div v-if="chunk" class="modal-content rounded-0">
                    <div class="modal-header">
                        <h6 id="exampleModalCenterTitle" class="modal-title">Sponsor Details</h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <tr v-if="chunk.name">
                                    <td style="width: 108px;">Name</td>
                                    <td style="width: 5px;">:</td>
                                    <td>{{ chunk.name }}</td>
                                </tr>
                                <tr v-if="chunk.address">
                                    <td>Address</td>
                                    <td>:</td>
                                    <td>{{ chunk.address }}</td>
                                </tr>
                                <tr v-if="chunk.phone">
                                    <td>Phone/Landline</td>
                                    <td>:</td>
                                    <td>{{ chunk.phone }}</td>
                                </tr>
                                <tr v-if="chunk.mobile">
                                    <td>Mobile</td>
                                    <td>:</td>
                                    <td>{{ chunk.mobile }}</td>
                                </tr>
                                <tr v-if="chunk.contact_person">
                                    <td>Contact Person</td>
                                    <td>:</td>
                                    <td>{{ chunk.contact_person }}</td>
                                </tr>
                                <tr v-if="chunk.contact_person_mobile">
                                    <td>Contact Person Mobile</td>
                                    <td>:</td>
                                    <td>{{ chunk.contact_person_mobile }}</td>
                                </tr>
                                <tr>
                                    <td>Type</td>
                                    <td>:</td>
                                    <td> {{ chunk.type }}</td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>:</td>
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
import Pagination from "../../Pagination";
import queryString from "query-string";

export default {
    name: "SponsorC",
    components: {Pagination},
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
                item: "",
            },
            formData: {
                id: "",
                name: "",
                address: "",
                phone: "",
                mobile: "",
                contact_person: "",
                contact_person_mobile: "",
                type: "",
                status: "",
            },
            types: [],
            statuses: [],
            chunk: [],
            outputRes: {
                data: [],
            },
            routes: window.appHelper.routes,
        };
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
    methods: {
        addNew() {
            let _this = this;
            _this.formView = true;
            _this.formData.name = "";
            _this.formData.phone = "";
            _this.formData.mobile = "";
            _this.formData.address = "";
            _this.formData.contact_person = "";
            _this.formData.contact_person_mobile = "";
            _this.formData.status = "";
            _this.formData.type = "";
            _this.errors = {};
            _this.$validator.reset();
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
                    _this.types = res.data.types;
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
        itemPerPageSelect() {
            this.search.page = 1;
            this.updateQueryParams("page", this.search.page);
            this.updateQueryParams("item", this.search.item);
            this.getAll();
        },
        onClickDelete(item) {
            let _this = this;
            Swal.fire({
                title: "Are you sure?",
                html: '<p style="color:#3085d6">"' + item.name + '"</p>' + "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#2778c4",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.value) {
                    _this.onDeleteRequest(item.id);
                }
            });
        },
        onClickEdit(id) {
            let _this = this;
            _this.loading = true;
            _this.$validator.reset();
            _this.errors = {};
            axios.patch(_this.routes.one + "/" + id).then((res) => {
                if (res.data) {
                    _this.createView = false;
                    _this.formView = true;
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
        onClickSortItems(key) {
            let _this = this;
            _this.search.sort = key;
            _this.search.type = _this.search.type === "asc" ? "desc" : "asc";
            this.updateQueryParams("sort", key);
            this.updateQueryParams("type", _this.search.type);
            this.getAll();
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
        onDeleteRequest(id) {
            let _this = this;
            _this.loading = true;
            _this.errors = {};
            axios.delete(_this.routes.one + "/" + id).then((res) => {
                if (res.data.success) {
                    Swal.fire("Deleted!", res.data.success, "success");
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
        paginationClicked(page) {
            this.updateQueryParams("page", page);
            this.search.page = page;
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
        updateQueryParams(key, value) {
            let parsed = queryString.parse(location.search);
            let page = key == "page" ? value : !!parsed.page ? parsed.page : 1;
            let sort = key == "sort" ? value : !!parsed.sort ? parsed.sort : "name";
            let type = key == "type" ? value : !!parsed.type ? parsed.type : "asc";
            let query = key == "query" ? value : !!parsed.query ? parsed.query : "";
            let item = key == "item" ? value : !!parsed.item ? parsed.item : 25;
            let queryStringify = queryString.stringify({page, sort, type, query, item});
            let newUrl = this.routes.one + "?" + queryStringify;
            window.history.pushState({}, null, newUrl);
        },
    },
};
</script>

<style scoped>
</style>
