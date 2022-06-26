<template>
    <div class="position-relative">
        <div class="card-header">
            <i class="fa fa-list"></i> Health Session
            <div class="card-header-actions p-0 m-0">
                <button v-if="!formView" class="btn btn-brand btn-sm btn-github" type="button" @click="addNew()">
                    <i class="fa fa-plus"></i>
                    <span>Add New Health Session</span>
                </button>
                <button v-else class="btn btn-brand btn-sm btn-github" type="button" @click="getAll()">
                    <i class="fa fa-list"></i>
                    <span>View All Health Session</span>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div v-show="formView">
                <div class="row justify-content-center">
                    <div class="col-lg-10  col-sm-12 col-xs-12">
                        <form class="form-horizontal" v-on:submit.prevent="onSubmit">
                            <div class="form-group row justify-content-center">
                                <h6 class="text-left col-sm-12">
                                    <strong v-if="createView">Add New Health Session</strong>
                                    <strong v-else>Update Health Session</strong>
                                </h6>
                            </div>
                            <div class="row">
                                <div class="col-md-4 my-2">
                                    <label class="czm-xs">Select Project <span class="text-danger">*</span> </label>
                                    <Select2 v-model="formData.j_project_id"
                                             v-validate="'required'"
                                             :options="projects"
                                             :settings="projectSettings"
                                             data-vv-as="project" data-vv-name="j_project_id"
                                             data-vv-validate-on="change"/>
                                    <div v-if="vvErrors.has('j_project_id')"
                                         :class="[(vvErrors.has('j_project_id') ? ' d-block' : '')]"
                                         class="invalid-feedback">
                                        {{ vvErrors.first('j_project_id') }}
                                    </div>
                                </div>
                                <div class="col-md-4 my-2">
                                    <label class="czm-xs">Health Session Title<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                    <span class="input-group-text">
                                      <i class="fa fa-file-text-o"></i>
                                    </span>
                                        </div>
                                        <input v-model="formData.session_heading"
                                               v-validate="'required|name_with_number|min:2|max:50'"
                                               :class="[(vvErrors.has('session_heading') ? 'is-invalid' : '')]"
                                               class="form-control form-control-sm rounded-0"
                                               data-vv-as="session heading" data-vv-name="session_heading"
                                               placeholder="session heading"
                                               type="text">
                                        <div v-show="vvErrors.has('session_heading')" class="invalid-feedback">
                                            {{ vvErrors.first('session_heading') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 my-2">
                                    <label class="czm-xs">Session Location</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                              <i class="fa fa-map-marker"></i>
                                            </span>
                                        </div>
                                        <input v-model="formData.session_location"
                                               v-validate="'name_with_number|min:2|max:50'"
                                               :class="[(vvErrors.has('session_location') ? 'is-invalid' : '')]"
                                               class="form-control form-control-sm rounded-0"
                                               data-vv-as="session location" data-vv-name="session_location"
                                               placeholder="session location"
                                               type="text">
                                        <div v-show="vvErrors.has('session_location')" class="invalid-feedback">
                                            {{ vvErrors.first('session_location') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 my-2">
                                    <label class="czm-xs">Session Method <span
                                        class="text-danger">*</span></label>
                                    <br>
                                    <div class="form-check form-check-inline">
                                        <input id="session_method_true"
                                               v-model="formData.session_method" class="form-check-input"
                                               name="session_method" type="radio" value="Online"/>
                                        <label class="form-check-label" for="session_method_true">Online</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input id="session_method_false"
                                               v-model="formData.session_method" class="form-check-input"
                                               name="session_method" type="radio" value="Offline"/>
                                        <label class="form-check-label"
                                               for="session_method_false">Offline</label>
                                    </div>
                                </div>
                                <div class="col-md-4 my-2">
                                    <label class="czm-xs">Start Date<span
                                        class="text-danger">*</span></label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="fa fa-calendar-check-o"></i>
                                        </span>
                                        </div>
                                        <input id="start_date" v-model="formData.start_date"
                                               v-validate="'required|date_format:yyyy-mm-dd'"
                                               :class="[this.vvErrors.has('start_date') ? 'is-invalid' : '',]"
                                               autocomplete="off"
                                               class="form-control form-control-sm rounded-0 datepicker"
                                               data-vv-as="start date" data-vv-name="start_date" name="start_date"
                                               placeholder="date: yyyy-mm-dd" type="text"/>
                                        <div v-show="vvErrors.has('start_date')" class="invalid-feedback">
                                            {{ vvErrors.first("start_date") }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 my-2">
                                    <label class="czm-xs">End Date<span
                                        class="text-danger">*</span></label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="fa fa-calendar-check-o"></i>
                                        </span>
                                        </div>
                                        <input id="end_date" v-model="formData.end_date"
                                               v-validate="'required|date_format:yyyy-mm-dd'"
                                               :class="[this.vvErrors.has('end_date') ? 'is-invalid' : '',]"
                                               autocomplete="off"
                                               class="form-control form-control-sm rounded-0 datepicker"
                                               data-vv-as="end date" data-vv-name="end_date" name="end_date"
                                               placeholder="date: yyyy-mm-dd" type="text"/>
                                        <div v-show="vvErrors.has('end_date')" class="invalid-feedback">
                                            {{ vvErrors.first("end_date") }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 my-2">
                                    <label class="czm-xs">Resource Person Name<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                    <span class="input-group-text">
                                      <i class="fa fa-user"></i>
                                    </span>
                                        </div>
                                        <input v-model="formData.resource_person_name"
                                               v-validate="'required|name_with_number|min:2|max:50'"
                                               :class="[(vvErrors.has('resource_person_name') ? 'is-invalid' : '')]"
                                               class="form-control form-control-sm rounded-0"
                                               data-vv-as="resource person name" data-vv-name="resource_person_name"
                                               placeholder="resource person name"
                                               type="text">
                                        <div v-show="vvErrors.has('resource_person_name')" class="invalid-feedback">
                                            {{ vvErrors.first('resource_person_name') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 my-2">
                                    <label class="czm-xs">Resource Person Phone</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                              <i class="fa fa-phone"></i>
                                            </span>
                                        </div>
                                        <input v-model="formData.resource_person_phone"
                                               v-validate="'phone|min:2|max:50'"
                                               :class="[(vvErrors.has('resource_person_phone') ? 'is-invalid' : '')]"
                                               class="form-control form-control-sm rounded-0"
                                               data-vv-as="resource person phone" data-vv-name="resource_person_phone"
                                               placeholder="resource person phone"
                                               type="text">
                                        <div v-show="vvErrors.has('resource_person_phone')" class="invalid-feedback">
                                            {{ vvErrors.first('resource_person_phone') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 my-2">
                                    <label class="czm-xs">Resource Person Designation</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                    <span class="input-group-text">
                                      <i class="fa fa-hashtag"></i>
                                    </span>
                                        </div>
                                        <input v-model="formData.resource_person_designation"
                                               v-validate="'name|min:2|max:50'"
                                               :class="[(vvErrors.has('resource_person_designation') ? 'is-invalid' : '')]"
                                               class="form-control form-control-sm rounded-0"
                                               data-vv-as="resource person designation"
                                               data-vv-name="resource_person_designation"
                                               placeholder="resource person designation"
                                               type="text">
                                        <div v-show="vvErrors.has('resource_person_designation')"
                                             class="invalid-feedback">
                                            {{ vvErrors.first('resource_person_designation') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 my-2">
                                    <label class="czm-xs">Remarks</label>
                                    <div class="input-group input-group-sm">
                                        <textarea v-model="formData.remarks"
                                                  v-validate="'name_with_number|min:2|max:999'"
                                                  :class="[(vvErrors.has('remarks') ? 'is-invalid' : '')]"
                                                  class="form-control form-control-sm rounded-0"
                                                  data-vv-as="remarks" data-vv-name="remarks"
                                                  placeholder=""
                                                  type="text"></textarea>
                                        <div v-show="vvErrors.has('remarks')" class="invalid-feedback">
                                            {{ vvErrors.first('remarks') }}
                                        </div>
                                    </div>
                                </div>
                                <div v-if="!createView" class="col-md-4 my-2">
                                    <label class="czm-xs">Status <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                    <span class="input-group-text">
                                      <i class="fa fa-arrow-circle-down"></i>
                                    </span>
                                        </div>
                                        <select v-model="formData.status" v-validate="'required'"
                                                :class="[vvErrors.has('status') ? 'is-invalid' : '']"
                                                class="form-control form-control-sm rounded-0" data-vv-as="status"
                                                data-vv-name="status"
                                                data-vv-validate-on="change">
                                            <option value="">Select One</option>
                                            <option v-for="(item,index) in updateStatuses" :key="index" :value="item">
                                                {{ item | textCapitalize }}
                                            </option>
                                        </select>
                                        <div v-show="vvErrors.has('status')" class="invalid-feedback">
                                            {{ vvErrors.first("status") }}
                                        </div>

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
                <div class="">
                    <table class="table table-responsive-sm table-sm table-striped table-hover">
                        <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th class="sort" @click="onClickSortItems('session_heading')">
                                Session Heading
                            </th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Project Name</th>
                            <th class="sort" style="width: 150px" @click="onClickSortItems('created_at')">Created
                            </th>
                            <th class="sort" style="width: 100px;" @click="onClickSortItems('status')">Status
                            </th>
                            <th style="width: 120px; text-align:center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item, index) in outputRes.data" :key="index">
                            <td>{{ sl + index }}</td>
                            <td>{{ item.session_heading | textCapitalize }}</td>
                            <td>{{ item.start_date | dateFormat }}</td>
                            <td>{{ item.end_date | dateFormat }}</td>
                            <td>{{ item.j_project.name }}</td>
                            <td>{{ item.created_at | dateFormat }}</td>
                            <td>
                                <span v-if="'Upcoming'===item.status" class='badge badge-warning'>Upcoming</span>
                                <span v-else-if="'Complete'===item.status" class='badge badge-success'>Complete</span>
                                <span v-else-if="'Postponed'===item.status" class='badge badge-primary'>Postponed</span>
                                <span v-else-if="'Rejected'===item.status" class='badge badge-danger'>Rejected</span>
                                <span v-else class="text-capitalize">{{ item.status }}</span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button id="btnGroupDrop1" aria-expanded="false"
                                            class="btn btn-xs btn-primary  dropdown-toggle" data-toggle="dropdown"
                                            type="button">
                                        <i class="fa fa-link"></i> Action
                                    </button>
                                    <div aria-labelledby="btnGroupDrop1" class="dropdown-menu">
                                        <button :disabled="(item.status==='Complete' )|| (item.status==='Rejected')"
                                                class="dropdown-item py-1 px-3" @click="onClickEdit(item.id)">
                                            <i class="fa fa-edit"></i> Edit
                                        </button>
                                        <button :disabled="(item.status==='Complete' )|| (item.status==='Rejected')"
                                                class="dropdown-item py-1 px-3" @click="onClickDelete(item)">
                                            <i class="fa fa-remove"></i> Delete
                                        </button>
                                        <a :href="routes.one+'/'+item.id+'/participant'" class="dropdown-item">
                                            <i class="fa fa-user-o"></i> Participants
                                        </a>
                                        <a :href="routes.one+'/'+item.id+'/implementation'" class="dropdown-item">
                                            <i aria-hidden="true" class="fa fa-dot-circle-o"></i> Implementation
                                        </a>
                                        <a :class="[item.status!=='Complete'?'disabled':'']"
                                           :href="routes.one+'/'+item.id+'/feedback'" class="dropdown-item">
                                            <i aria-hidden="true" class="fa fa-dot-circle-o"></i> Feedback
                                        </a>
                                    </div>
                                </div>

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
    </div>
</template>

<script>
import Pagination from "../../Pagination.vue";
import Select2 from "v-select2-component";
import queryString from "query-string";

export default {
    components: {Pagination, Select2},
    name: "HealthSession.vue",
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
                sort: "session_heading",
                type: "desc",
                query: "",
                item: "",
            },
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

            formData: {
                id: "",
                j_project_id: "",
                session_heading: "",
                session_method: "Offline",
                start_date: "",
                end_date: "",
                session_location: "",
                resource_person_name: "",
                resource_person_phone: "",
                resource_person_designation: "",
                remarks: "",
            },
            chunk: [],
            statuses: [],
            updateStatuses: [],
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
            let queryStringify = queryString.stringify({page, sort, type, query, item});
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
                _this.formData.managers = [];

                _this.loading = false;
            });
        },
        getAll() {
            let _this = this;
            _this.formView = false;
            _this.createView = true;
            _this.formData = {};
            _this.loading = true;
            axios.post(_this.routes.list, _this.search).then((res) => {
                if (res.data) {
                    _this.outputRes = res.data.lists;
                    _this.statuses = res.data.statuses;
                    _this.updateStatuses = res.data.updateStatuses;
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
                console.log('aaaaaaaaaaaaaaaaaa');
                console.log(error);
                console.log('bbbbbbbbbbbbbbbb');
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
            $("#start_date").datepicker("update", "");
            $("#end_date").datepicker("update", "");
            _this.formData.session_method = "Offline";
            _this.errors = {};
            this.$validator.reset();
        },
        onClickEdit(id) {
            let _this = this;
            _this.loading = true;
            _this.errors = {};
            this.$validator.reset();
            axios.patch(_this.routes.one + "/" + id).then((res) => {
                if (res.data) {
                    _this.createView = false;
                    _this.formView = true;
                    _this.formData = res.data;
                    _this.projects.push(res.data.j_project);

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
        onClickDelete(item) {
            let _this = this;
            Swal.fire({
                title: "Are you sure?",
                html: '<p style="color:#3085d6">"' + item.session_heading + '"</p>' + "You won't be able to revert this!",
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
    },
    created() {
        let _this = this;
        _this.projectSettings.ajax.url = this.routes.projectSearch;
        _this.projectSettings.ajax.processResults = function (data) {
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
    mounted() {
        let _this = this;
        $(".datepicker").datepicker({
            todayHighlight: true,
            format: "yyyy-mm-dd",
            startDate: "-200y",
            autoclose: true,
        }).on("changeDate", (event) => {
            let value = event.currentTarget.value;
            switch (event.currentTarget.name) {
                case "start_date":
                    _this.formData.start_date = value;
                    break;
                case "end_date":
                    _this.formData.end_date = value;
                    break;
            }
        });
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
