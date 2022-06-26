<template>
    <div class="position-relative">
        <div class="card-header">
            <i class="fa fa-list"></i>
            Mustahiq Reports
            <div class="card-header-actions p-0 m-0">
                <button class="btn btn-sm btn-ghost-danger" type="button" @click="reset('all')">
                    <span>Reset All</span>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <label class="mb-0">Program</label>
                    <select v-model.number="formData.program_type" class="form-control form-control-sm rounded-0">
                        <option value="">All</option>
                        <option v-for="item in initData.originPrograms" :key="item" :value="item">
                            {{ item }}
                        </option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="mb-0">Sponsor
                        <span style="float:right; padding-left: 10px">
              <a class="text-danger" style="cursor: pointer" @click="reset('sponsor')">Reset</a>
            </span></label>
                    <Select2 v-model.number="formData.sponsor_id" :options="initData.sponsors"
                             :settings="{ width: '100%', allowClear: true }"
                             data-vv-as="sponsor" data-vv-name="sponsor_id" data-vv-validate-on="change"/>
                </div>
                <div class="col-md-3">
                    <label class="mb-0">Status</label>
                    <select v-model.number="formData.status" class="form-control form-control-sm rounded-0">
                        <option value="">All</option>
                        <option v-for="item in initData.statuses" :key="item" :value="item">
                            {{ item }}
                        </option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label style="text-align:left;">
                        Created Range
                        <span style="float:right; padding-left: 10px">
              <a class="text-danger" style="cursor: pointer" @click=" reset('date')">Reset</a>
            </span>
                    </label>
                    <div class="row no-gutters">
                        <div class="col-md-6">
                            <input id="date_from" v-model="formData.date_from"
                                   :class="[(vvErrors.has('date_from') ? 'is-invalid' : '')]"
                                   class="form-control form-control-sm rounded-0 datepicker" data-vv-as="from date"
                                   data-vv-name="date_from"
                                   name="date_from" placeholder="From Date"
                                   type="text">
                            <div v-show="vvErrors.has('date_from')" class="invalid-feedback">
                                {{ vvErrors.first('date_from') }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <input id="date_to" v-model="formData.date_to"
                                   :class="[(vvErrors.has('date_to') ? 'is-invalid' : '')]"
                                   class="form-control form-control-sm rounded-0 datepicker" data-vv-as="to date"
                                   data-vv-name="date_to" name="date_to"
                                   placeholder="To Date" type="text">
                            <div v-show="vvErrors.has('date_to')" class="invalid-feedback">
                                {{ vvErrors.first('date_to') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4"></div>
            <div class="row">
                <div class="col-md-3">
                    <label class="mb-0">Gender</label>
                    <select v-model.number="formData.gender" class="form-control form-control-sm rounded-0">
                        <option value="">All</option>
                        <option v-for="item in initData.genders" :key="item" :value="item">
                            {{ item }}
                        </option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="mb-0">Religion</label>
                    <select v-model.number="formData.religion" class="form-control form-control-sm rounded-0">
                        <option value="">All</option>
                        <option v-for="item in initData.religions" :key="item" :value="item">
                            {{ item }}
                        </option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="mb-0">Earn Ability</label>
                    <select v-model="formData.is_earn_ability" class="form-control form-control-sm rounded-0">
                        <option value="">All</option>
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="mb-0">Disability</label>
                    <select v-model.number="formData.disability_id" class="form-control form-control-sm rounded-0">
                        <option value="">All</option>
                        <option class="text-success" value="all_not_disable">All Not Disable</option>
                        <option class="text-danger" value="all_disable">All Disability</option>
                        <option v-for="(item,index) in initData.disabilityTypes" :key="index" :value="item.id">
                            {{ item.name }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="mt-4"></div>
            <div class="row">
                <div class="col-md-3">
                    <label class="mb-0">Occupation</label>
                    <select v-model.number="formData.occupation_id" class="form-control form-control-sm rounded-0">
                        <option value="">All</option>
                        <option v-for="(item,index) in initData.occupations" :key="index" :value="item.id">
                            {{ item.name }}
                        </option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="mb-0">Highest Education Level</label>
                    <select v-model.number="formData.highest_education_level"
                            class="form-control form-control-sm rounded-0">
                        <option value="">All</option>
                        <option v-for="item in initData.educationLevels" :key="item" :value="item">
                            {{ item }}
                        </option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="mb-0">District</label>
                    <select v-model.number="formData.district_id" class="form-control form-control-sm rounded-0">
                        <option value="">All</option>
                        <option v-for="(item,index) in initData.districts" :key="index" :value="item.id">
                            {{ item.name }}
                        </option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label style="text-align:left;">
                        Age Range
                        <span style="float:right; padding-left: 10px">
              <a class="text-danger" style="cursor: pointer" @click="reset('age')">Reset</a>
            </span>
                    </label>
                    <div class="row no-gutters">
                        <div class="col-md-6">
                            <select ref="fromYear" v-model.number="formData.age_from"
                                    :class="[(vvErrors.has('age_from') ? 'is-invalid' : '')]"
                                    class="form-control form-control-sm rounded-0" data-vv-as="from year"
                                    data-vv-name="age_from"
                                    name="age_from">
                                <option value="">From</option>
                                <option v-for="(item,index) in Array(70).keys()" :key="index" :value="item+1">
                                    {{ item + 1 + ' Year' }}
                                </option>
                            </select>
                            <div v-show="vvErrors.has('age_from')" class="invalid-feedback">
                                {{ vvErrors.first('age_from') }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <select v-model.number="formData.age_to" v-validate="'greaterThen:'+this.formData.age_from"
                                    :class="[(vvErrors.has('age_to') ? 'is-invalid' : '')]"
                                    class="form-control form-control-sm rounded-0"
                                    data-vv-as="to year"
                                    data-vv-name="age_to"
                                    name="age_to">
                                <option value="">To</option>
                                <option v-for="(item,index) in Array(70).keys()" :key="index" :value="item+1">
                                    {{ item + 1 + ' Year' }}
                                </option>
                            </select>
                            <div v-show="vvErrors.has('age_to')" class="invalid-feedback">
                                {{ vvErrors.first('age_to') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-5"></div>
            <div class="row">
                <div class="col-md-2 offset-md-3">
                    <button class="btn btn-sm btn-outline-primary d-block rounded-0 w-100 mb-1" type="button"
                            @click="download('pdf')">
                        Download PDF
                    </button>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-sm btn-outline-info d-block rounded-0 w-100 mb-1" type="button"
                            @click="download('xls')">
                        Download XLS
                    </button>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-sm btn-outline-success d-block rounded-0 w-100" type="button"
                            @click="download('view')">
                        View
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Select2 from "v-select2-component";

export default {
    name: "ReportMustahiqC",
    components: {Select2},
    data() {
        return {
            loading: false,
            formData: {
                program_type: "",
                status: "",
                age_from: "",
                age_to: "",
                date_from: "",
                date_to: "",
                gender: "",
                religion: "",
                highest_education_level: "",
                is_earn_ability: "",
                sponsor_id: "",
                district_id: "",
                disability_id: "",
                occupation_id: "",
            },
            initData: {
                sponsors: [],
                originPrograms: [],
            },
            int: 0,
            errors: {},
            routes: window.appHelper.routes,
        };
    },
    methods: {
        reset(key) {
            let _this = this;
            if (key == "date") {
                _this.formData.date_from = "";
                _this.formData.date_to = "";
                $("#date_from").datepicker("update", null);
                $("#date_to").datepicker("update", null);
            } else if (key == "age") {
                _this.formData.age_from = "";
                _this.formData.age_to = "";
            } else if (key == "sponsor") {
                _this.formData.sponsor_id = "";
            } else if (key == "all") {
                _this.formData.program_type = "";
                _this.formData.status = "";
                /*_this.formData.sponsor_id = "";
                _this.formData.age_from = '';
                _this.formData.age_to = '';
                _this.formData.date_from = '';
                _this.formData.date_to = '';*/
                _this.formData.gender = "";
                _this.formData.religion = "";
                _this.formData.disability_id = "";
                _this.formData.occupation_id = "";
                _this.formData.highest_education_level = "";
                _this.formData.district_id = "";
                _this.formData.is_earn_ability = "";
                _this.reset("date");
                _this.reset("age");
                _this.reset("sponsor");
            }
        },
        getAll() {
            let _this = this;
            _this.loading = true;
            axios.post(_this.routes.init).then((res) => {
                if (res.data) {
                    _this.initData = res.data;
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
        checkValid() {
            let _this = this;
            let flag = true;
            let message = [];
            if (_this.formData.age_from && _this.formData.age_to == "") {
                message.push("Please select age rage to year.");
                flag = false;
            }
            if (_this.formData.age_to && _this.formData.age_from == "") {
                message.push("Please select age rage from year.");
                flag = false;
            }
            if (_this.formData.date_from && _this.formData.date_to == "") {
                message.push("Please select date rage to date.");
                flag = false;
            }
            if (_this.formData.date_to && _this.formData.date_from == "") {
                message.push("Please select date rage from date.");
                flag = false;
            }
            if (
                _this.formData.date_to &&
                _this.formData.date_from &&
                _this.formData.date_from > _this.formData.date_to
            ) {
                message.push("Date range to date must be after from date.");
                flag = false;
            }
            if (!flag) {
                toastr.error(message, "Error");
            }
            return flag;
        },
        download(key) {
            let _this = this;
            if (_this.checkValid()) {
                _this.veeValid(key);
            }
        },
        veeValid(key) {
            let _this = this;
            _this.$validator.validateAll().then((result) => {
                if (result) {
                    _this.downloadNow(key);
                }
            });
        },
        downloadNow(key) {
            let _this = this;
            _this.loading = true;
            _this.formData.report_type = key;
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
                    var myWindow = window.open("", _this.int + "_window");
                    myWindow.document.write(res.data);
                    _this.loading = false;
                    _this.int++;
                }).catch((err) => {
                    toastr.error(err.response.data.message, "Error");
                    if (err.response && err.response.data.errors) {
                        _this.errors = err.response.data.errors;
                    }
                    _this.loading = false;
                });
            }
        },
    },
    created() {
        let _this = this;
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
                    case "date_from":
                        _this.formData.date_from = value;
                        break;
                    case "date_to":
                        _this.formData.date_to = value;
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

<style scoped>
</style>
