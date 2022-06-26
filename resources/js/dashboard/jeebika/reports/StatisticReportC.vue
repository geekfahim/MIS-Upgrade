<template>
    <div class="position-relative">
        <div class="card-header">
            <i class="fa fa-list"></i>
            Statistic Reports
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 col-md-4">
                    <label class="d-inline-block">
                        Showing
                        <select v-model="search.select" @change="filterSelect()">
                            <option value="">All</option>
                            <option v-for="(item,index) in allProjects" :key='index' :value="item.id">
                                {{ item.name | textCapitalize }}
                            </option>
                        </select>
                        Project
                    </label>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="row">
                        <label for="" class="col-sm-3 col-form-label">From Date</label>
                        <div class="col-sm-8">
                            <input id="from_date" v-model="formData.from_date"
                                   v-validate="'required|date_format:yyyy-mm-dd'"
                                   autocomplete="off"
                                   class="form-control form-control-sm rounded-0 datepicker"
                                   data-vv-name="from_date" name="from_date"
                                   placeholder="date: yyyy-mm-dd" type="text"/>

                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="row">
                        <label for="" class="col-sm-12 col-md-3 col-form-label">To Date</label>
                        <div class="col-sm-12 col-md-6">
                            <input id="to_date" v-model="formData.to_date"
                                   v-validate="'required|date_format:yyyy-mm-dd'"
                                   autocomplete="off"
                                   class="form-control form-control-sm rounded-0 datepicker"
                                   data-vv-name="to_date" name="to_date"
                                   placeholder="date: yyyy-mm-dd" type="text"/>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <button class="btn btn-sm btn-danger" @click="resetForm()">
                                Reset
                            </button>
                        </div>
                    </div>
                </div>

            </div>

            <div class="container-fluid">
                <div class="row">
                    <div class="col"><h5>প্রকল্প সুচনা কার্যক্রম</h5></div>
                </div>
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-6">
                        <div class="callout callout-info bg-white">
                            <small class="text-muted">Total Validated Family</small><br>
                            <strong class="h4">{{ outputRes.validateFamily }}</strong>
                        </div>
                    </div>
                    <!--/.col-->
                    <div class="col-lg-2 col-md-2 col-sm-6">
                        <div class="callout callout-danger bg-white">
                            <small class="text-muted">Total Need Completed Family</small><br>
                            <strong class="h4">{{ outputRes.needFamily }}</strong>
                        </div>
                    </div>
                    <!--/.col-->
                    <div class="col-lg-2 col-md-2 col-sm-6">
                        <div class="callout callout-warning bg-white">
                            <small class="text-muted">Total Savings Family</small><br>
                            <strong class="h4">{{ outputRes.savingFamily }}</strong>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <h5>ইনসানিয়াত </h5>
                    </div>
                </div>
                <table class="table table-sm table-bordered bg-white">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Indicator</th>
                        <th scope="col">Total</th>
                        <th scope="col">Target</th>
                        <th scope="col">Achievement</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(item,index) in outputRes.indicators">
                        <th scope="row">{{ sl + index }}</th>
                        <td>{{ item.name }}</td>
                        <td>{{ item.total }}</td>
                        <td>{{ item.target }}</td>
                        <td>{{ item.achievement }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <h5>জীবিকা</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-6">
                        <div class="callout callout-primary bg-white">
                            <small class="text-muted">Total Family Skill Training</small><br>
                            <strong class="h4">{{ outputRes.skillFamily }}</strong>
                        </div>
                    </div>
                    <!--/.col-->
                    <div class="col-lg-2 col-md-2 col-sm-6">
                        <div class="callout bg-white">
                            <small class="text-muted">Total Mustahiq Vocational Training</small><br>
                            <strong class="h4">{{ outputRes.vocationalMustahiq }}</strong>
                        </div>
                    </div>
                    <!--/.col-->
                    <div class="col-lg-2 col-md-2 col-sm-6">
                        <div class="callout callout-warning bg-white">
                            <small class="text-muted">Total Family Savings</small><br>
                            <strong class="h4">{{ outputRes.savingFamily }}</strong>
                        </div>
                    </div>
                    <!--/.col-->
                    <div class="col-lg-2 col-md-2 col-sm-6">
                        <div class="callout callout-success bg-white">
                            <small class="text-muted">Approved Business Plan</small><br>
                            <strong class="h4">{{ outputRes.approveBusinessPlan }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import queryString from "query-string";

export default {
    name: "StatisticReportC",
    data() {
        return {
            loading: false,
            timeout: 0,
            sl: 1,
            search: {
                select: "",
                from_date: "",
                to_date: "",
            },
            formData: {
                j_project_id: "",
                from_date: "",
                to_date: "",
            },
            allProjects: [],
            outputRes: {
                savingFamily: 0,
                validateFamily: 0,
                needFamily: 0,
                indicators: [],
                skillFamily: 0,
                vocationalMustahiq: 0,
                approveBusinessPlan: 0,
                savings: 0,
            },
            errors: {},
            routes: window.appHelper.routes,
        };
    },
    methods: {
        updateQueryParams(key, value) {
            let parsed = queryString.parse(location.search);
            let select = key == "select" ? value : !!parsed.select ? parsed.select : "";
            let from_date = key == "from_date" ? value : !!parsed.from_date ? parsed.from_date : "";
            let to_date = key == "to_date" ? value : !!parsed.to_date ? parsed.to_date : "";
            let queryStringify = queryString.stringify({select, from_date, to_date});
            let newUrl = this.routes.one + "?" + queryStringify;
            window.history.pushState({}, null, newUrl);
        },
        getAll() {
            console.log('aaaaaaaaaaaaa');
            let _this = this;
            _this.loading = true;
            _this.errors = {};
            axios.post(_this.routes.list, _this.formData).then((res) => {
                if (res.data) {
                    // console.log(res.data);
                    _this.outputRes = res.data;
                    _this.allProjects = res.data.allProjects;
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
        filterSelect() {
            console.log('bbbbbbbbbbbbbbbbb');
            this.formData.j_project_id = this.search.select;
            this.updateQueryParams("select", this.search.select);
            this.updateQueryParams("from_date", this.search.from_date);
            this.updateQueryParams("to_date", this.search.to_date);
            this.getAll();
        },
        resetForm() {
            let _this = this;
            _this.search.select = "";
            _this.formData = {};
            _this.getAll();
        }
    },
    created() {
        let parsed = queryString.parse(location.search);
        this.search.select = !!parsed.select ? parsed.select : "";
        this.search.from_date = !!parsed.from_date ? parsed.from_date : "";
        this.search.to_date = !!parsed.to_date ? parsed.to_date : "";
        this.getAll();
    },
    mounted() {
        let _this = this;
        $(".datepicker")
            .datepicker({
                todayHighlight: true,
                format: "yyyy-mm-dd",
                startDate: "-100y",
                autoclose: true,
            })
            .on("changeDate", (event) => {
                let value = event.currentTarget.value;
                switch (event.currentTarget.name) {
                    case "from_date":
                        console.log('from_datefrom_datefrom_datefrom_date');
                        _this.formData.from_date = value;
                        _this.filterSelect();
                        break;
                    case "to_date":
                        console.log('to_dateto_dateto_dateto_dateto_date');
                        _this.formData.to_date = value;
                        _this.filterSelect();
                        break;
                }
            });
    },
    filters: {
        dateFormat(value) {
            if (!value) return "";
            return moment(value).format("MMM DD, YYYY");
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
