<template>
    <div class="position-relative">
        <div class="card-header">
            <i class="fa fa-list"></i>
            Family Reports
            <!--            <div class="card-header-actions p-0 m-0">-->
            <!--                <button @click="reset('all')" class="btn btn-sm btn-ghost-danger" type="button">-->
            <!--                    <span>Reset All</span>-->
            <!--                </button>-->
            <!--            </div>-->
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="mb-0">Project<span class="text-danger">*</span></label>
                            <select v-model="formData.j_project_id" class="form-control form-control-sm rounded-0"
                                    :class="[(errors.hasOwnProperty('j_project_id') ? 'is-invalid' : '')]"
                                    @change="getGROByProjectId">
                                <option value="">Select One</option>
                                <option v-for="(item,index) in init.jProjects" :key="index" :value="item.id">
                                    {{ item.name }}
                                </option>
                            </select>
                            <div class="invalid-feedback d-block" v-if="errors.hasOwnProperty('j_project_id')">
                                {{ errors.j_project_id[0] }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label class="mb-0">GRO<span class="text-danger">*</span></label>
                            <select v-model="formData.j_gro_id" class="form-control form-control-sm rounded-0"
                                    :class="[(errors.hasOwnProperty('j_gro_id') ? 'is-invalid' : '')]">
                                <option value="">Select One</option>
                                <option v-for="(item,index) in init.jGROs" :key="index" :value="item.id">
                                    {{ item.name }}
                                </option>
                            </select>
                            <div class="invalid-feedback d-block" v-if="errors.hasOwnProperty('j_gro_id')">
                                {{ errors.j_gro_id[0] }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button @click="searchNow()"
                                    class="btn btn-sm btn-outline-primary d-block rounded-0 w-100 my-1" type="button">
                                Search
                            </button>
                        </div>
                    </div>
                    <div v-show="isDisabled">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="mb-0">Report Type<span class="text-danger">*</span></label>
                                <select v-model="formData.report_type" class="form-control form-control-sm rounded-0"
                                        @change="changeReportType()"
                                        :class="[(errors.hasOwnProperty('report_type') ? 'is-invalid' : '')]">
                                    <option value="">Select One</option>
                                    <option value="summary">Summary</option>
                                    <option value="full">Full</option>
                                    <option value="savings">Savings</option>
                                    <option value="equity">Equity</option>
                                    <option value="bank_charge">Bank Charge</option>
                                    <option value="miscellaneous">Miscellaneous</option>
                                    <option value="withdrawal">Withdrawal</option>
                                    <option value="settlement">Settlement</option>
                                </select>
                                <div class="invalid-feedback d-block" v-if="errors.hasOwnProperty('report_type')">
                                    {{ errors.report_type[0] }}
                                </div>
                            </div>
                        </div>
                        <div
                            v-show="(formData.report_type !=='full' && formData.report_type!=='summary') && (formData.report_type!=='' && formData.report_type!=='extended') "
                            class="row">
                            <div class="col-md-12">
                                <div class="form-group  mb-0">
                                    <label class="mb-0">From Date</label>
                                    <div class="input-group input-group-sm">
                                        <input placeholder="date: yyyy-mm-dd" id="from_date" name="from_date"
                                               type="text" data-vv-name="from_date" data-vv-as="from date"
                                               :class="[(errors.hasOwnProperty('from_date') ? 'is-invalid' : '')]"
                                               v-validate="'date_format:yyyy-mm-dd'"
                                               class="form-control form-control-sm rounded-0 datepicker"
                                               v-model="formData.from_date" autocomplete="off"/>
                                        <div class="invalid-feedback" v-show="errors.hasOwnProperty('from_date')">
                                            {{ errors.from_date ? errors.from_date[0] : '' }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group  mb-0">
                                    <label class="mt-0 mb-0">To Date</label>
                                    <div class="input-group input-group-sm">
                                        <input placeholder="date: yyyy-mm-dd" id="to_date" name="to_date" type="text"
                                               data-vv-name="to_date" data-vv-as="date from"
                                               :class="[(errors.hasOwnProperty('to_date') ? 'is-invalid' : '')]"
                                               v-validate="'date_format:yyyy-mm-dd'"
                                               class="form-control form-control-sm rounded-0 datepicker"
                                               v-model="formData.to_date" autocomplete="off"/>
                                        <div class="invalid-feedback" v-show="errors.hasOwnProperty('to_date')">
                                            {{ errors.to_date ? errors.to_date[0] : '' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 my-4">
                                <button @click="downloadNow('pdf')"
                                        class="btn btn-sm btn-outline-primary d-block rounded-0 w-100 my-1"
                                        type="button">
                                    Download PDF
                                </button>
                                <button @click="downloadNow('xls')"
                                        class="btn btn-sm btn-outline-info d-block rounded-0 w-100 my-1" type="button">
                                    Download XLS
                                </button>
                                <button @click="downloadNow('view')"
                                        class="btn btn-sm btn-outline-success d-block rounded-0 w-100 my-1"
                                        type="button">
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
                            <th>Family Name</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item, index) in paginate.data" :key="index">
                            <td>
                                <input :checked="checkedIds.includes(item.family_id)" :value="item.family_id"
                                       @click="selectAFamily($event, item)" type="checkbox" :id="'id-'+index">
                            </td>
                            <td>
                                <label :for="'id-'+index">{{ item.family ? item.family.name : '' }}</label>
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
                                <input :checked="allSelected" @click="callAllSelect($event)" type="checkbox"
                                       class="form-check-input" id="select-all-button">
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
            _this.$paginateSetData(_this.init.families);
            _this.paginate = _this.$paginateConfig;
        },
        selectAFamily(event, item) {
            let _this = this;
            if (event.target.checked) {
                _this.checkedIds.push(item.family_id);
            } else {
                if (_this.checkedIds.length > 0) {
                    _this.checkedIds.forEach(function (value, i) {
                        if (item.family_id == value) {
                            _this.checkedIds.splice(i, 1);
                        }
                    });
                }
            }
            _this._checkedAllStatus();
        },
        _checkedAllStatus() {
            let _this = this;
            _this.allSelected = _this.init.families.length === _this.checkedIds.length;
        },
        callAllSelect(e) {
            let _this = this;
            if (!_this.allSelected && e.target.checked) {
                _this.checkedIds = [];
                _this.init.families.forEach(function (value) {
                    _this.checkedIds.push(value.family_id);
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
            if (_this.formData.j_gro_id == "") {
                _this.errors.j_gro_id = [];
                _this.errors.j_gro_id.push("Please select a gro.");
                this.$forceUpdate();
                return;
            }
            _this.loading = true;
            _this.errors = {};
            _this.formData.ids = [];
            _this.formData.report_type = "";
            axios.post(_this.routes.searchFamilies, _this.formData).then((res) => {
                if (res.data) {
                    _this.init.families = res.data;
                    _this.dataPush();
                    _this.checkedIds = [];
                    _this._checkedAllStatus();
                    _this.isDisabled = _this.init.families.length > 0;
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
                toastr.error("Please select a family", "Error");
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
        changeReportType() {
            let _this = this;
            _this.formData.from_date = "";
            _this.formData.to_date = "";
        }
    },
    created() {
        let _this = this;
        _this.getJProjects();
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
