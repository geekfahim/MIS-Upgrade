<template>
    <div class="position-relative">
        <div class="card-header">
            <i class="fa fa-list"></i>
            GRO Reports
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="mb-0">Project<span class="text-danger">*</span></label>
                            <select v-model="formData.j_project_id"
                                    :class="[(errors.hasOwnProperty('j_project_id') ? 'is-invalid' : '')]"
                                    class="form-control form-control-sm rounded-0"
                                    @change="getGROByProjectId">
                                <option value="">Select One</option>
                                <option v-for="(item,index) in init.jProjects" :key="index" :value="item.id">
                                    {{ item.name }}
                                </option>
                            </select>
                            <div v-if="errors.hasOwnProperty('j_project_id')" class="invalid-feedback d-block">
                                {{ errors.j_project_id[0] }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-sm btn-outline-primary d-block rounded-0 w-100 my-1"
                                    type="button" @click="searchNow()">
                                Search
                            </button>
                        </div>
                    </div>
                    <div v-show="isDisabled">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="mb-0">Report Type<span class="text-danger">*</span></label>
                                <select v-model="formData.report_type"
                                        :class="[(errors.hasOwnProperty('report_type') ? 'is-invalid' : '')]"
                                        class="form-control form-control-sm rounded-0">
                                    <option value="">Select One</option>
                                    <option value="summary">Summary</option>
                                    <option value="active_business_plan">Active Business Plan</option>
                                </select>
                                <div v-if="errors.hasOwnProperty('report_type')" class="invalid-feedback d-block">
                                    {{ errors.report_type[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 my-4">
                                <button class="btn btn-sm btn-outline-primary d-block rounded-0 w-100 my-1"
                                        type="button"
                                        @click="downloadNow('pdf')">
                                    Download PDF
                                </button>
                                <button class="btn btn-sm btn-outline-info d-block rounded-0 w-100 my-1"
                                        type="button" @click="downloadNow('xls')">
                                    Download XLS
                                </button>
                                <button class="btn btn-sm btn-outline-success d-block rounded-0 w-100 my-1"
                                        type="button"
                                        @click="downloadNow('view')">
                                    View
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <table class="table table-responsive-sm table-sm table-striped table-hover">
                        <thead>
                        <tr>
                            <th style="width: 10px;">#</th>
                            <th>Gro Name</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item, index) in paginate.data" :key="index">
                            <td>
                                <input :id="'id-'+index" :checked="checkedIds.includes(item.id)"
                                       :value="item.id" type="checkbox" @click="selectAFamily($event, item)">
                            </td>
                            <td>
                                <label :for="'id-'+index">{{ item.name }}</label>
                            </td>
                        </tr>
                        <tr v-if="paginate.data.length <= 0">
                            <td colspan="2" style="text-align: center;">No Data
                                Found
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div v-if="paginate.data.length>0" class="row no-gutters">
                        <div class="col-md-6">
                            <div class="form-check w-50">
                                <input id="select-all-button" :checked="allSelected" class="form-check-input"
                                       type="checkbox" @click="callAllSelect($event)">
                                <label class="form-check-label p-1" for="select-all-button">Select All</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="float-right">
                                <pagination v-if="paginate.data.length>0" :records="paginate"
                                            @onclicked="paginationClicked"></pagination>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Pagination from "../../Pagination";

export default {
    name: "FamilyReportC",
    components: {Pagination},
    data() {
        return {
            allSelected: false,
            isDisabled: false,
            loading: false,
            timeout: 0,
            checkedIds: [],
            paginate: {
                data: [],
                total: 0,
                per_page: 15,
                current_page: 1,
                last_page: 1,
                from: 1,
                to: 0,
            },
            formData: {
                j_project_id: "",
                j_gro_id: "",
                from_date: "",
                to_date: "",
                report_type: "",
            },
            init: {
                jProjects: [],
                jGROs: [],
                families: [],
            },
            errors: {},
            report_init: 0,
            routes: window.appHelper.routes,
        };
    },
    methods: {
        paginationClicked(page) {
            this.$paginateConfig.current_page = page;
            this.dataPush();
        },
        dataPush() {
            let _this = this;
            _this.$paginateSetData(_this.init.jGROs);
            _this.paginate = _this.$paginateConfig;
        },
        selectAFamily(event, item) {
            let _this = this;
            if (event.target.checked) {
                _this.checkedIds.push(item.id);
            } else {
                if (_this.checkedIds.length > 0) {
                    _this.checkedIds.forEach(function (value, i) {
                        if (item.id == value) {
                            _this.checkedIds.splice(i, 1);
                        }
                    });
                }
            }
            _this._checkedAllStatus();
        },
        _checkedAllStatus() {
            let _this = this;
            _this.allSelected = _this.init.jGROs.length === _this.checkedIds.length;
        },
        callAllSelect(e) {
            let _this = this;
            if (!_this.allSelected && e.target.checked) {
                _this.checkedIds = [];
                _this.init.jGROs.forEach(function (value) {
                    _this.checkedIds.push(value.id);
                });
                _this.allSelected = true;
            } else {
                _this.checkedIds = [];
                _this.allSelected = false;
            }
        },
        searchNow() {
            let _this = this;
            _this.errors = {};
            _this.formData.from_date = "";
            _this.formData.to_date = "";
            $("#from_date").datepicker("update", "");
            $("#to_date").datepicker("update", "");
            if (_this.formData.j_project_id == "") {
                _this.errors.j_project_id = [];
                _this.errors.j_project_id.push("Please select a project.");
                this.$forceUpdate();
            }
            _this.loading = true;
            _this.errors = {};
            _this.formData.ids = [];
            _this.formData.report_type = "";
            axios.post(_this.routes.searchGROByProjectId, _this.formData).then((res) => {
                if (res.data) {
                    _this.init.jGROs = res.data;
                    _this.dataPush();
                    _this.checkedIds = [];
                    _this._checkedAllStatus();
                    _this.isDisabled = _this.init.jGROs.length > 0;
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
        _checkValidDownload() {
            let _this = this;
            let flag = true;
            _this.errors = {};
            this.$validator.reset();
            if (_this.checkedIds.length === 0) {
                flag = false;
                toastr.error("Please select a gro", "Error");
            }
            if (_this.formData.report_type === "") {
                flag = false;
                _this.errors.report_type = [];
                _this.errors.report_type.push("Please select a report type.");
            }
            this.$forceUpdate();
            return flag;
        },
        downloadNow(key) {
            let _this = this;
            if (_this._checkValidDownload()) {
                _this.loading = true;
                _this.formData["ids"] = _this.checkedIds;
                _this.formData.download_type = key;
                if (key == "pdf" || key == "xls") {
                    axios({
                        method: "POST",
                        url: _this.routes.download,
                        responseType: "blob",
                        data: _this.formData,
                    }).then(function (response) {
                        const url = window.URL.createObjectURL(new Blob([response.data]));
                        const link = document.createElement("a");
                        link.href = url;
                        link.setAttribute("download", response.headers.file_name);
                        document.body.appendChild(link);
                        link.click();
                        _this.loading = false;
                    }).catch((error) => {
                        let b = new Blob([error.response.data], {
                                type: "application/json",
                            }),
                            fr = new FileReader();
                        fr.onload = function () {
                            let error = JSON.parse(this.result);
                            toastr.error(error.message, "Error");
                            _this.errors = error.errors;
                        };
                        fr.readAsText(b);
                        _this.loading = false;
                    });
                } else {
                    axios.post(_this.routes.download, _this.formData).then((res) => {
                        let myWindow = window.open("", _this.report_init + "_window");
                        myWindow.document.write(res.data);
                        _this.report_init++;
                        _this.loading = false;
                    }).catch((err) => {
                        toastr.error(err.response.data.message, "Error");
                        if (err.response && err.response.data.errors) {
                            _this.errors = err.response.data.errors;
                        }
                        _this.loading = false;
                    });
                }
            }
        },
        getJProjects() {
            let _this = this;
            _this.loading = true;
            _this.errors = {};
            axios.post(_this.routes.init).then((res) => {
                if (res.data) {
                    _this.init.jProjects = res.data;
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
        getGROByProjectId() {
            let _this = this;
            _this.loading = true;
            _this.errors = {};
            axios.post(_this.routes.searchGROByProjectId, {
                j_project_id: _this.formData.j_project_id,
            }).then((res) => {
                if (res.data) {
                    _this.init.jGROs = res.data;
                    _this.formData.j_gro_id = "";
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
    },
    created() {
        this.getJProjects();
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
                case "from_date":
                    _this.formData.from_date = value;
                    break;
                case "to_date":
                    _this.formData.to_date = value;
                    break;
            }
        });
    },
    filters: {
        dateFormat(value) {
            if (!value) return "";
            return moment(value).format("MMM DD, YYYY");
        }
    }
};
</script>

<style scoped>
</style>
