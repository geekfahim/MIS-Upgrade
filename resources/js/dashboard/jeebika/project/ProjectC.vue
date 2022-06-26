<template>
    <div class="position-relative">
        <div class="card-header">
            <i class="fa fa-list"></i>
            Projects
            <div class="card-header-actions p-0 m-0">
                <button v-if="!formView" class="btn btn-brand btn-sm btn-github" type="button" @click="addNew()">
                    <i class="fa fa-plus"></i>
                    <span>Add New Project</span>
                </button>
                <button v-else class="btn btn-brand btn-sm btn-github" type="button" @click="getAll()"><i
                    class="fa fa-list"></i>
                    <span>View All Project</span>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div v-if="!isEmpty(errors)" class="alert alert-danger alert-dismissible fade show" role="alert">
                <div v-html="errorHtml"></div>
                <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div v-show="formView">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-10 col-sm-10 col-xs-12">
                        <form class="form-horizontal" enctype="multipart/form-data" v-on:submit.prevent="onSubmit">
                            <div class="form-group row justify-content-center">
                                <h6 class="text-left col-sm-12">
                                    <strong v-if="createView">Add New Project</strong>
                                    <strong v-else>Update Project</strong>
                                </h6>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-lg-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="czm-xs">Project Name<span class="text-danger">*</span></label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="fa fa-file-text-o"></i>
                        </span>
                                            </div>
                                            <input v-model="formData.name"
                                                   v-validate="'required|name_with_number|min:2|max:50'"
                                                   :class="[vvErrors.has('name') ? 'is-invalid' : '']"
                                                   class="form-control form-control-sm rounded-0" data-vv-as="name"
                                                   data-vv-name="name" placeholder="project name" type="text"/>
                                            <div v-show="vvErrors.has('name')" class="invalid-feedback">
                                                {{ vvErrors.first("name") }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="czm-xs">Project Start Date<span
                                            class="text-danger">*</span></label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="fa fa-file-text-o"></i>
                        </span>
                                            </div>
                                            <input id="start_date" v-model="formData.start_date"
                                                   v-validate="'required|date_format:yyyy-mm-dd'"
                                                   :class="[this.vvErrors.has('start_date') ? 'is-invalid' : '']"
                                                   autocomplete="off"
                                                   class="form-control form-control-sm rounded-0 datepicker"
                                                   data-vv-as="start date" data-vv-name="start_date" name="start_date"
                                                   placeholder="date: yyyy-mm-dd" type="text"/>
                                            <div v-show="vvErrors.has('start_date')" class="invalid-feedback">
                                                {{ vvErrors.first("start_date") }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="czm-xs">Project Possible End Date<span
                                            class="text-danger">*</span></label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                          <i class="fa fa-file-text-o"></i>
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
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="czm-xs">Project Manager/In-Charge<span
                                            class="text-danger">*</span></label>
                                        <Select2 v-model="formData.manager_id" v-validate="'required'" :options="users"
                                                 :settings="{ width: '100%', allowClear: true }" data-vv-as="manager"
                                                 data-vv-name="manager_id" data-vv-validate-on="change"/>
                                        <div v-if="vvErrors.has('manager_id')"
                                             :class="[(vvErrors.has('manager_id') ? ' d-block' : '')]"
                                             class="invalid-feedback">
                                            {{ vvErrors.first('manager_id') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="czm-xs">District Cover<span class="text-danger">*</span></label>
                                        <Select2 v-model="formData.district_id" v-validate="'required'"
                                                 :options="districts" :settings="{ width: '100%', allowClear: true }"
                                                 data-vv-as="district" data-vv-name="district_id"
                                                 data-vv-validate-on="change"/>
                                        <div v-if="vvErrors.has('district_id')"
                                             :class="[(vvErrors.has('district_id') ? ' d-block' : '')]"
                                             class="invalid-feedback">
                                            {{ vvErrors.first('district_id') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="czm-xs">Sponsor/s Name<span class="text-danger">*</span></label>
                                        <Select2 v-model="formData.sponsor_ids" v-validate="'required'"
                                                 :options="sponsors"
                                                 :settings="{ width: '100%', allowClear: true, multiple: true }"
                                                 data-vv-as="sponsors" data-vv-name="sponsor_ids"/>
                                        <div v-if="vvErrors.has('sponsor_ids')"
                                             :class="[(vvErrors.has('sponsor_ids') ? ' d-block' : '')]"
                                             class="invalid-feedback">
                                            {{ vvErrors.first('sponsor_ids') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="czm-xs">Accounts Officer,Field Officers and Health Assistant
                                            <span class="text-danger">*</span></label>
                                        <Select2 v-model="formData.field_officer_ids" v-validate="'required'"
                                                 :options="users"
                                                 :settings="{ width: '100%', allowClear: true, multiple:true }"
                                                 data-vv-as="field officers" data-vv-name="field_officer_ids"/>
                                        <div v-if="vvErrors.has('field_officer_ids')"
                                             :class="[(vvErrors.has('field_officer_ids') ? ' d-block' : '')]"
                                             class="invalid-feedback">
                                            {{ vvErrors.first('field_officer_ids') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="czm-xs">Zone</label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="fa fa-arrow-circle-down"></i>
                        </span>
                                            </div>
                                            <select v-model="formData.j_zone_id"
                                                    :class="[vvErrors.has('j_zone_id') ? 'is-invalid' : '']"
                                                    class="form-control zone form-control-sm rounded-0"
                                                    data-vv-as="zone" data-vv-name="j_zone_id"
                                                    data-vv-validate-on="change" @change="selectZone()">
                                                <option value="">Select One</option>
                                                <option v-for="item in jZones" :key="item.id" :value="item.id">
                                                    {{ item.name }}
                                                </option>
                                            </select>
                                            <div v-show="vvErrors.has('j_zone_id')" class="invalid-feedback">
                                                {{ vvErrors.first("j_zone_id") }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="czm-xs">Area</label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="fa fa-arrow-circle-down"></i>
                        </span>
                                            </div>
                                            <select v-model="formData.j_area_id"
                                                    :class="[vvErrors.has('j_area_id') ? 'is-invalid' : '']"
                                                    :disabled="formData.j_zone_id==''"
                                                    class="form-control area form-control-sm rounded-0"
                                                    data-vv-as="area" data-vv-name="area_id">
                                                <option value="">Select One</option>
                                                <option v-for="item in tempJAreas" :key="item.id" :value="item.id">
                                                    {{ item.name }}
                                                </option>
                                            </select>
                                            <div v-show="vvErrors.has('j_area_id')" class="invalid-feedback">
                                                {{ vvErrors.first("j_area_id") }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="czm-xs">Number of Household Cover(Approved)<span
                                            class="text-danger">*</span></label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="fa fa-file-text-o"></i>
                        </span>
                                            </div>
                                            <input v-model.number="formData.number_of_household_cover"
                                                   v-validate="'required|numeric'"
                                                   :class="[vvErrors.has('number_of_household_cover') ? 'is-invalid' : '']"
                                                   class="form-control form-control-sm rounded-0"
                                                   data-vv-as="number of household cover"
                                                   data-vv-name="number_of_household_cover"
                                                   placeholder="number of household cover" type="number"/>
                                            <div v-show="vvErrors.has('number_of_household_cover')"
                                                 class="invalid-feedback">
                                                {{ vvErrors.first("number_of_household_cover") }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="czm-xs">Project Status<span class="text-danger">*</span></label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="fa fa-arrow-circle-down"></i>
                        </span>
                                            </div>
                                            <select v-model="formData.status" v-validate="'required'"
                                                    :class="[vvErrors.has('status') ? 'is-invalid' : '']"
                                                    class="form-control form-control-sm rounded-0" data-vv-as="status"
                                                    data-vv-name="status" data-vv-validate-on="change">
                                                <option value="">Select One</option>
                                                <option v-for="item in statuses" :key="item" :value="item">
                                                    {{ item }}
                                                </option>
                                            </select>
                                            <div v-show="vvErrors.has('status')" class="invalid-feedback">
                                                {{ vvErrors.first("status") }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="czm-xs">Remarks</label>
                                        <div class="input-group input-group-sm">
                                            <textarea v-model="formData.remarks" v-validate="'max:100'"
                                                      class="form-control rounded-0" data-vv-name="remarks"
                                                      placeholder="type here.." rows="2"></textarea>
                                            <div v-show="vvErrors.has('remarks')" class="invalid-feedback">
                                                {{ vvErrors.first("remarks") }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="czm-xs">Upload Project Related Files</label>
                                        <div v-if="existingFiles.length>0">
                                            <div v-for="(item,index) in existingFiles" :key="index"
                                                 class="p-1 mb-1 border border-secondary">
                        <span><b>File:</b>
                          <a :download="item.name" :href="item.path" class="badge bg-success">Download</a>
                        </span>
                                                <button class="btn btn-danger btn-xs pull-right" type="button"
                                                        @click="removeFile(index,item.id)">Remove
                                                </button>
                                                <p v-if="item.remarks" class="m-0"><b>Remarks:</b> {{ item.remarks }}
                                                </p>
                                            </div>
                                        </div>
                                        <div v-if="formData.files">
                                            <div v-for="(item,index) in formData.files" :key="index"
                                                 :class="[vvErrors.has('files.' + index) ? 'border-danger' : '']"
                                                 class="p-1 mb-1 border border-secondary ">
                                                <span><b>File Type:</b> {{ item.file.type }}</span>
                                                <button class="btn btn-danger btn-xs pull-right" type="button"
                                                        @click="removeFile(index)">Remove
                                                </button>
                                                <p v-if="item.remarks" class="m-0"><b>Remarks:</b> {{ item.remarks }}
                                                </p>
                                                <div v-show="vvErrors.has('files.'+index)" class="text-danger">
                                                    {{ vvErrors.first('files.' + index) }}
                                                </div>
                                            </div>
                                        </div>
                                        <BaseFile v-if="finalLimit>0" ref="baseFile" :limit="finalLimit" :max-size="500"
                                                  @addFile="addFileToFiles"/>
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
                                Search:
                                <input v-model="search.query" placeholder="Search..." type="text"
                                       @keyup="searchTimeOut()"/>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-responsive-sm table-sm table-striped table-hover">
                        <thead>
                        <tr class="text-start">
                            <th style="width: 10px">#</th>
                            <th class="sort" style="width: 300px" @click="onClickSortItems('name')">Name</th>
                            <th>Manager</th>
                            <th>District</th>
                            <th>House Cover</th>
                            <th>A. House Cover</th>
                            <th style="width: 105px">Start Date</th>
                            <th class="sort" @click="onClickSortItems('status')">Status</th>
                            <th class="sort" style="width: 105px; text-align:center"
                                @click="onClickSortItems('created_at')">Created
                            </th>
                            <th style="width: 150px; text-align:center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item, index) in outputRes.data" :key="index" class="text-start">
                            <td>{{ sl + index }}</td>
                            <td>{{ item.name }}</td>
                            <td>{{ item.manager ? item.manager.name : '' }}</td>
                            <td>{{ item.district ? item.district.name : '' }}</td>
                            <td>{{ item.number_of_household_cover }}</td>
                            <td>{{ item.families_count }}</td>
                            <td>{{ item.start_date | dateFormat }}</td>
                            <td>
                                <span v-if="'Active'===item.status" class='badge badge-success'>Active</span>
                                <span v-else-if="'Inactive'===item.status" class='badge badge-warning'>Inactive</span>
                                <span v-else-if="'Blocked'===item.status" class='badge badge-danger'>Blocked</span>
                                <span v-else class="text-capitalize">{{ item.status }}</span>
                            </td>
                            <td>{{ item.created_at | dateFormat }}</td>
                            <td>
                                <a :href="routes.one+'/'+item.id+'/view'" class="btn btn-xs btn-github rounded-0">
                                    <i class="fa fa-link"></i> Details
                                </a>
                                <button class="btn btn-xs btn-info rounded-0" @click="onClickEdit(item.id)">
                                    <i class="fa fa-edit"></i>
                                    Edit
                                </button>
                            </td>
                        </tr>
                        <tr v-if="outputRes.data.length === 0">
                            <td class="text-center" colspan="11">No Data Found</td>
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
                        <pagination v-if="outputRes.data.length >= 0" :records="outputRes" class="pull-right"
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
import BaseFile from "../../components/BaseFile";

export default {
    name: "ProjectC",
    components: {Pagination, Select2, BaseFile},
    data() {
        return {
            loading: false,
            createView: true,
            formView: false,
            timeout: null,
            errors: {},
            errorHtml: "",
            fileLimit: 5,
            existingFiles: [],
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
                district_id: "",
                files: [],
                delete_file_ids: [],
                sponsor_ids: [],
                field_officer_ids: [],
                manager_id: "",
                j_zone_id: "",
                j_area_id: "",
                start_date: "",
                end_date: "",
                number_of_household_cover: "",
                remarks: "",
                status: "",
            },
            users: [],
            districts: [],
            sponsors: [],
            statuses: [],
            jZones: [],
            jAreas: [],
            tempJAreas: [],
            outputRes: {
                data: [],
            },
            routes: window.appHelper.routes,
        };
    },
    methods: {
        isEmpty(obj) {
            for (let key in obj) {
                if (obj.hasOwnProperty(key)) {
                    return false;
                }
            }
            return true;
        },
        objToString(obj) {
            for (let property in obj) {
                if (obj.hasOwnProperty(property)) {
                    this.errorHtml += "<p class='p-0 m-0'>" + obj[property][0] + "</p>";
                }
            }
        },
        removeFile(index, id = 0) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    if (id) {
                        this.formData.delete_file_ids.push(id);
                        this.existingFiles.splice(index, 1);
                    } else {
                        this.formData.files.splice(index, 1);
                    }
                }
            });
        },
        resetFile() {
            this.$validator.reset();
            this.formData.delete_file_ids = [];
            this.formData.files = [];
            this.existingFiles = [];
            if (this.formView) {
                this.$refs.baseFile.reset();
            }
            this.formData.id = "";
            this.formData.name = "";
            this.formData.district_id = "";
            this.formData.sponsor_ids = [];
            this.formData.field_officer_ids = [];
            this.formData.manager_id = "";
            this.formData.j_zone_id = "";
            this.formData.j_area_id = "";
            this.formData.start_date = "";
            this.formData.end_date = "";
            this.formData.number_of_household_cover = "";
            this.formData.remarks = "";
            this.formData.status = "";
        },
        addFileToFiles(file, remarks) {
            this.formData.files.push({file, remarks});
        },
        selectZone() {
            let _this = this;
            _this.formData.j_area_id = "";
            _this.tempJAreas = [];
            if (_this.formData.j_zone_id) {
                _this.jAreas.forEach((item) => {
                    if (item.j_zone_id == _this.formData.j_zone_id) {
                        _this.tempJAreas.push(item);
                    }
                });
            }
        },
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
        newFormData() {
            let _this = this;
            let oldFormData = _this.formData;
            const formData = new FormData();
            for (let key in oldFormData) {
                if (oldFormData.hasOwnProperty(key)) {
                    if ("null" == oldFormData[key] || null == oldFormData[key]) {
                        formData.append(key, "");
                    } else if ("files" == key) {
                        for (let i = 0; i < oldFormData[key].length; i++) {
                            formData.append(key + "[" + i + "]", oldFormData[key][i].file);
                            formData.append(
                                "file_remarks[" + i + "]",
                                oldFormData[key][i].remarks
                            );
                        }
                    } else if (
                        "sponsor_ids" == key ||
                        "field_officer_ids" == key ||
                        "delete_file_ids" == key
                    ) {
                        for (let i = 0; i < oldFormData[key].length; i++) {
                            formData.append(key + "[" + i + "]", oldFormData[key][i]);
                        }
                    } else {
                        formData.append(key, oldFormData[key]);
                    }
                }
            }
            return formData;
        },
        onNewAdd() {
            let _this = this;
            _this.errors = {};
            _this.errorHtml = "";
            _this.loading = true;
            axios.post(_this.routes.one, _this.newFormData()).then((res) => {
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
            _this.errors = {};
            _this.errorHtml = "";
            _this.loading = true;
            axios.post(_this.routes.one + "/" + _this.formData.id, _this.newFormData()).then((res) => {
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
            _this.createView = true;
            _this.loading = true;
            _this.resetFile();
            _this.errors = {};
            _this.errorHtml = "";
            axios.post(_this.routes.list, _this.search).then((res) => {
                if (res.data) {
                    _this.outputRes = res.data.lists;
                    _this.sponsors = res.data.sponsors;
                    _this.users = res.data.users;
                    _this.districts = res.data.districts;
                    _this.statuses = res.data.statuses;
                    _this.jZones = res.data.jZones;
                    _this.jAreas = res.data.jAreas;
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
                        _this.$setErrorsFromLaravel(error.response.data);
                    }
                } else {
                    toastr.error(error.message, "Error");
                }
                _this.loading = false;
            });
        },
        addNew() {
            this.formView = true;
            this.resetFile();
        },
        onClickEdit(id) {
            let _this = this;
            _this.loading = true;
            _this.errors = {};
            axios.patch(_this.routes.one + "/" + id).then((res) => {
                if (res.data) {
                    _this.createView = false;
                    _this.formView = true;
                    _this.formData.id = res.data.id;
                    _this.formData.name = res.data.name;
                    _this.formData.manager_id = res.data.manager_id;
                    _this.formData.district_id = res.data.district_id;
                    _this.formData.sponsor_ids = res.data.sponsor_ids;
                    _this.formData.field_officer_ids = res.data.field_officer_ids;
                    _this.formData.start_date = res.data.start_date;
                    $("#start_date").datepicker("update", _this.formData.start_date);
                    _this.formData.end_date = res.data.end_date;
                    $("#end_date").datepicker("update", _this.formData.end_date);
                    _this.formData.number_of_household_cover =
                        res.data.number_of_household_cover;
                    _this.formData.status = res.data.status;
                    _this.formData.j_zone_id = res.data.j_zone_id ?? "";
                    _this.selectZone();
                    _this.formData.j_area_id = res.data.j_area_id ?? "";
                    _this.formData.remarks = res.data.remarks ?? "";
                    if (res.data.resource) {
                        res.data.resource.forEach((item) => {
                            _this.existingFiles.push({
                                id: item.id,
                                name: item.name,
                                path: item.path,
                                remarks: item.remarks,
                            });
                        });
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
                        _this.errors = error.response.data.errors;
                        _this.objToString(_this.errors);
                    }
                } else {
                    toastr.error(error.message, "Error");
                }
                _this.loading = false;
            });
        },
    },
    computed: {
        finalLimit() {
            return (
                this.fileLimit -
                (this.formData.files.length + this.existingFiles.length)
            );
        },
    },
    created() {
        let parsed = queryString.parse(location.search);
        this.search.page = !!parsed.page ? parsed.page : 1;
        this.search.sort = !!parsed.sort ? parsed.sort : "created_at";
        this.search.type = !!parsed.type ? parsed.type : "desc";
        this.search.query = !!parsed.query ? parsed.query : "";
        this.search.item = !!parsed.item ? parsed.item : 25;
        this.getAll();
    },
    updated() {
        let _this = this;
        $(".datepicker").datepicker({
            todayHighlight: true,
            format: "yyyy-mm-dd",
            startDate: "-100y",
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
    },
};
</script>

<style scoped>
</style>
