<template>
    <div class="position-relative">
        <div class="card-header">
            <i class="fa fa-list"></i>
            Projects
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="pull-left">
                        <label class="d-inline-block">
                            Show
                            <select v-model="search.item" @change="itemPerPageSelect()">
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
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
                        <th>File</th>
                        <th class="sort" @click="onClickSortItems('status')">Status</th>
                        <th>Start Date</th>
                        <th class="sort" style="width: 105px; text-align:center"
                            @click="onClickSortItems('created_at')">Created
                        </th>
                        <th style="width: 220px; text-align:center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(item, index) in outputRes.data" v-if="outputRes.data.length > 0" :key="item.id"
                        class="text-start">
                        <td>{{ sl + index }}</td>
                        <td>{{ item.name }}</td>
                        <td>{{ item.manager_name }}</td>
                        <td>{{ item.district_name }}</td>
                        <td>{{ item.number_of_household_cover }}</td>
                        <td>
                            <a v-if="item.file_path" :href="item.file_path" :text="item.file"
                               class="btn btn-czm-green btn-xs" target="_blank"
                               @click:prevent="downloadItem(formData)">Download</a>
                        </td>
                        <td class="text-capitalize">
                                <span v-if="item.status == 'Active'" class="badge badge-success">{{
                                        item.status
                                    }}</span>
                            <span v-else-if="item.status == 'Inactive'" class="badge badge-warning">{{
                                    item.status
                                }}</span>
                            <span v-else class="badge badge-danger">{{ item.status }}</span>
                        </td>
                        <td>{{ item.start_date | dateFormat }}</td>
                        <td>{{ item.created_at | dateFormat }}</td>
                        <td>
                            <a :href="routes.one+'/'+item.id+'/view'" class="btn btn-xs btn-github rounded-0">
                                <i class="fa fa-link"></i> Details
                            </a>
                            <button class="btn btn-xs btn-info rounded-0" @click="onClickEdit(item.id)">
                                <i class="fa fa-edit"></i>
                                Edit
                            </button>
                            <button class="btn btn-xs btn-danger rounded-0" @click="onClickDelete(item)">
                                <i class="fa fa-remove"></i>
                                Delete
                            </button>
                        </td>
                    </tr>
                    <tr v-if="outputRes.data.length == 0">
                        <td class="text-center" colspan="8">No Data Found</td>
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
                    <pagination v-if="outputRes.data.length >= 0" :records="outputRes"
                                class="pull-right" @onclicked="paginationClicked"></pagination>
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
    name: "ProjectManagerView.Vue",
    components: {Pagination, Select2: Select2},
    data() {
        return {
            loading: false,
            createView: true,
            formView: false,
            timeout: null,
            errors: {},
            sl: 1,
            sponsors: [],
            sponsorSettings: {
                multiple: true,
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
            fieldOfficers: [],
            fieldOfficerSettings: {
                multiple: true,
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
            managers: [],
            managerSettings: {
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
            districtSettings: {
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
            districts: [],
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
                sponsor_ids: [],
                field_officer_ids: [],
                manager_id: "",
                j_zone_id: "",
                j_area_id: "",
                start_date: "",
                end_date: "",
                maturity_date: "",
                fund_transfer_date: "",
                number_of_household_cover: "",
                remarks: "",
                file: "",
                file_name: "",
                status: "",
            },
            statuses: [],
            jZones: [],
            jAreas: [],
            tempJAreas: [],
            chunk: [],
            outputRes: {
                data: [],
            },
            fileExist: false,
            isFileAdded: false,
            routes: window.appHelper.routes,
        };
    },

    methods: {
        selectArea() {
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
        removeItem() {
            let _this = this;
            Swal.fire({
                title: "Are you sure?",
                html: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.value) {
                    _this.fileExist = false;
                    _this.isFileAdded = false;
                    _this.formData.file = {};
                    _this.formData.file_name = "delete";
                    _this.formData.file_path = "";
                }
            });
        },
        downloadItem(item) {
            axios.get(item.file_path, {responseType: "blob"}).then((response) => {
                const blob = new Blob([response.data]);
                const link = document.createElement("a");
                link.href = URL.createObjectURL(blob);
                link.download = item.file_name;
                link.click();
                URL.revokeObjectURL(link.href);
            }).catch(toastr.error("Download Error.", "Error"));
        },
        fileUpload(e) {
            let _this = this;
            let files = e.target.files || e.dataTransfer.files;
            if (!files.length) return;
            if (/\.(jpeg|jpg|png|pdf)$/i.test(files[0].name)) {
                if (files[0].size < 202400) {
                    _this.isFileAdded = true;
                    _this.formData.file = files[0];
                    _this.formData.file_name = files[0].name;
                } else {
                    Swal.fire("Invalid file size!", "max-size:100kb", "warning");
                    _this.formData.file = {};
                    _this.formData.file_name = "";
                    _this.$refs.file.value = null;
                }
            } else {
                Swal.fire(
                    "Invalid file type!",
                    "Select in - jpeg,jpg,png,pdf",
                    "warning"
                );
                _this.formData.file = {};
                _this.formData.file_name = "";
                _this.$refs.file.value = null;
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
            let sort = key == "sort" ? value : !!parsed.sort ? parsed.sort : "name";
            let type = key == "type" ? value : !!parsed.type ? parsed.type : "asc";
            let query = key == "query" ? value : !!parsed.query ? parsed.query : "";
            let item = key == "item" ? value : !!parsed.item ? parsed.item : 10;

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
        newFormData() {
            let _this = this;
            let oldFormData = _this.formData;
            const formData = new FormData();
            for (let key in oldFormData) {
                if (oldFormData.hasOwnProperty(key)) {
                    if (("sponsor_ids" == key || 'field_officer_ids' == key) && oldFormData[key].length > 0) {
                        for (let i = 0; i < oldFormData[key].length; i++) {
                            formData.append(key + "[" + i + "]", oldFormData[key][i]);
                        }
                    } else if (key != "file") {
                        formData.append(key, oldFormData[key]);
                    }
                }
            }
            if (_this.isFileAdded) {
                formData.append("file_name", _this.formData.file_name);
                formData.append("file", _this.formData.file);
            }
            if (_this.formData.file_name == "delete") {
                formData.append("file_name", _this.formData.file_name);
            }
            return formData;
        },
        onNewAdd() {
            let _this = this;
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
            _this.formData.manager_id = '';
            _this.formData.district_id = '';
            _this.formData.sponsor_ids = [];
            _this.formData.field_officer_ids = [];
            _this.$validator.reset();
            axios.post(_this.routes.list, _this.search).then((res) => {
                if (res.data) {
                    _this.outputRes = res.data.lists;
                    _this.statuses = res.data.statuses;
                    _this.jZones = res.data.jZones;
                    _this.jAreas = res.data.jAreas;
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
        fileReset() {
            let _this = this;
            _this.fileExist = false;
            _this.isFileAdded = false;
            _this.formData.file = {};
            _this.formData.file_name = "";
            _this.$refs.file.value = null;
        },
        addNew() {
            let _this = this;
            _this.formView = true;
            _this.formData.district_id = "";
            _this.formData.sponsor_ids = [];
            _this.formData.field_officer_ids = [];
            _this.formData.manager_id = "";
            _this.formData.name = "";
            _this.formData.status = "";
            _this.formData.j_zone_id = "";
            _this.formData.j_area_id = "";
            _this.formData.number_of_household_cover = "";
            $("#start_date").datepicker("update", "");
            $("#end_date").datepicker("update", "");
            _this.fileReset();
        },
        onClickEdit(id) {
            let _this = this;
            _this.loading = true;
            _this.errors = {};
            axios.patch(_this.routes.one + "/" + id).then((res) => {
                if (res.data) {
                    _this.createView = false;
                    _this.fileExist = false;
                    _this.formView = true;
                    _this.formData.id = res.data.id;
                    _this.formData.name = res.data.name;
                    _this.formData.manager_id = res.data.manager_id;
                    _this.managers.push(res.data.manager);
                    _this.formData.district_id = res.data.district_id;
                    _this.districts.push(res.data.district);
                    _this.formData.sponsor_ids = res.data.sponsor_ids;
                    _this.sponsors = res.data.sponsors;
                    _this.formData.field_officer_ids = res.data.field_officer_ids;
                    _this.fieldOfficers = res.data.fieldOfficers;
                    _this.formData.start_date = res.data.start_date;
                    $("#start_date").datepicker("update", _this.formData.start_date);
                    _this.formData.end_date = res.data.end_date;
                    $("#end_date").datepicker("update", _this.formData.end_date);
                    _this.formData.number_of_household_cover =
                        res.data.number_of_household_cover;
                    _this.formData.status = res.data.status;
                    _this.formData.j_zone_id = "";
                    if (res.data.j_zone_id) {
                        _this.formData.j_zone_id = res.data.j_zone_id;
                    }
                    _this.formData.j_area_id = "";
                    if (res.data.j_area_id) {
                        _this.formData.j_area_id = res.data.j_area_id;
                    }
                    if (res.data.remarks) {
                        _this.formData.remarks = res.data.remarks;
                    }
                    if (res.data.file_name && res.data.file_path) {
                        _this.fileExist = true;
                        _this.formData.file_name = res.data.file_name;
                        _this.formData.file_path = res.data.file_path;
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
        onClickDelete(item) {
            let _this = this;
            Swal.fire({
                title: "Are you sure?",
                html: '<p style="color:#3085d6">"' + item.name + '"</p>' + "You won't be able to revert this!",
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
        _this.sponsorSettings.ajax.url = this.routes.sponsorSearch;
        _this.sponsorSettings.ajax.processResults = function (data) {
            return {
                results: data,
            };
        };
        _this.districtSettings.ajax.url = this.routes.districtSearch;
        _this.districtSettings.ajax.processResults = function (data) {
            return {
                results: data,
            };
        };
        _this.managerSettings.ajax.url = this.routes.userSearch;
        _this.managerSettings.ajax.processResults = function (data) {
            return {
                results: data,
            };
        };
        _this.fieldOfficerSettings.ajax.url = this.routes.userSearch;
        _this.fieldOfficerSettings.ajax.processResults = function (data) {
            return {
                results: data,
            };
        };
        let parsed = queryString.parse(location.search);
        this.search.page = !!parsed.page ? parsed.page : 1;
        this.search.sort = !!parsed.sort ? parsed.sort : "name";
        this.search.type = !!parsed.type ? parsed.type : "asc";
        this.search.query = !!parsed.query ? parsed.query : "";
        this.search.item = !!parsed.item ? parsed.item : 10;
        this.getAll();
    },
    mounted() {
        let _this = this;
        $(".datepicker")
            .datepicker({
                todayHighlight: true,
                format: "yyyy-mm-dd",
                startDate: "-200y",
                autoclose: true,
            })
            .on("changeDate", (event) => {
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
        }
    },
};
</script>

<style scoped>
</style>
