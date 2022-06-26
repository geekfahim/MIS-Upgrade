<template>
    <div class="position-relative">
        <div v-if="planView">
            <div class="card-header"><i class="fa fa-at"></i>
                <span v-if="indicatorName" class="text-danger font-weight-bold">{{ indicatorName }}</span>
                <span v-else>Need name not found</span>
                <div class="card-header-actions p-0 m-0">
                    <button class="btn btn-brand btn-sm btn-github" type="button" @click="allPlanView()">
                        <i class="fa fa-arrow-left"></i><span>Back to List</span>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 offset-lg-9 col-md-3 offset-sm-9 col-sm-3 offset-sm-9">
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
                            <th>Family Name</th>
                            <th>Member Name</th>
                            <th>Implementation Plan</th>
                        </tr>
                        </thead>
                        <tbody v-if="paginate.data.length > 0">
                        <tr v-for="(item, index) in paginate.data" :key="index">
                            <td>
                                <span v-if="!item.is_implementation">
                                    <input :id="item.j_indicator_id+'_'+item.family_id+'_'+item.member_id"
                                           :checked="checkedIds.includes(item.j_indicator_id+'_'+item.family_id+'_'+item.member_id)"
                                           :value="item.j_indicator_id+'_'+item.family_id+'_'+item.member_id"
                                           type="checkbox"
                                           @change="selectItem($event)">
                                </span>
                            </td>
                            <td>
                                <label :for="item.j_indicator_id+'_'+item.family_id+'_'+item.member_id">
                                    {{ item.family.name }}
                                </label>
                            </td>
                            <td>{{ item.member ? item.member.name : '' }}</td>
                            <td>
                                <span v-if="item.is_implementation">
                                    <i aria-hidden="true" class="fa fa-check green-color"></i>
                                </span>
                                <span v-else><i aria-hidden="true" class="fa fa-times red-color"></i></span>
                            </td>
                        </tr>
                        <tr v-if="paginate.data.length === 0">
                            <td class="text-center" colspan="4">No Data Found</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div v-if="allSelectedAndDatesButtonShow" class="row no-gutters">
                    <div class="col-md-12 p-1">
                        <div class="form-check">
                            <input id="selAll" :checked="allSelected" class="form-check-input"
                                   type="checkbox" @click="callAllSelect($event)">
                            <label class="form-check-label" for="selAll">Select All</label>
                            <button class="btn btn-brand btn-sm btn-github pull-right" type="button" @click="setDates">
                                <i class="fa fa-calendar"></i><span>Set Dates</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-sm-12 col-md-6">
                        <div class="pull-left">
                            Showing
                            {{ paginate.total === 0 ? 0 : paginate.from }}
                            to
                            {{ paginate.to > paginate.total ? paginate.total : paginate.to }}
                            of
                            {{ paginate.total ? paginate.total : 0 }} entries
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <pagination v-if="paginate.data.length>=0" :records="paginate" class="pull-right"
                                    @onclicked="paginationClicked"></pagination>
                    </div>
                </div>
            </div>
        </div>
        <div v-else>
            <div class="card-header"><i class="fa fa-list"></i> Implementation Plan Create</div>
            <div class="card-body">
                <div v-if="project.programs.length === 0">
                    <span class="text-danger">Need Assessment is not done yet.</span>
                </div>
                <div v-for="(program, programName) in project.programs" v-else
                     id="accordion" :key="programName" class="accordion" role="tablist">
                    <div class="card mb-0">
                        <div class="card-header" role="tab">
                            <h5 class="mb-0">
                                <a :href="'#'+programName" aria-expanded="false" class="collapsed"
                                   data-toggle="collapse"><i
                                    class="fa fa-plus"></i> {{ programName }}
                                </a>
                            </h5>
                        </div>
                        <div :id="programName" aria-labelledby="programName" class="collapse" data-parent="#accordion"
                             role="tabpanel">
                            <div class="card-body">
                                <table class="table table-sm">
                                    <thead>
                                    <th>Sl.</th>
                                    <th>Indicator Name</th>
                                    <th>Total</th>
                                    <th style="width: 25%; text-align: center">Action</th>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(item, index) in program" :key="index">
                                        <td>{{ 1 + index }}</td>
                                        <td>{{ item.name }}</td>
                                        <td>{{ item.total_need }}</td>
                                        <td>
                                            <button class="btn btn-brand btn-sm btn-github"
                                                    type="button"
                                                    @click="getDataForPlan(item)"><i class="fa fa-list-alt"></i>
                                                <span>Plan {{ item.name }}</span>
                                            </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="loading" class="czm-loader">Loading&#8230;</div>
        <!-- Modal -->
        <div id="viewModal" aria-hidden="true" aria-labelledby="viewModalTitle" class="modal fade" role="dialog"
             tabindex="-1">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content rounded-0">
                    <div class="modal-body">
                        <form>
                            <ul class="list-group list-group-sm">
                                <li v-for="(date,index) in dates" :key="index" class="list-group-item">{{ date }}
                                    <span class="pull-right">
                                        <button class="btn btn-sm btn-danger" type="button" @click="spliceDate(index)">
                                            <i class="fa fa-times"></i> Delete
                                        </button>
                                    </span>
                                </li>
                            </ul>
                            <div class="form-group">
                                <label class="col-form-label" for="dateFor">Possible Implementation Date</label>
                                <input id="dateFor" v-model="date" :class="[(dateExistMessageFlag ? 'is-invalid' : '')]"
                                       class="form-control ip_datepicker"
                                       name="ip_date"
                                       placeholder="date: yyyy-mm-dd" type="text">
                                <div v-show="dateExistMessageFlag" class="invalid-feedback">
                                    {{ dateExistMessage }}
                                </div>
                            </div>
                            <button class="btn btn-brand btn-sm btn-github" type="button" @click="addDate"><i
                                class="fa fa-plus"></i>
                                <span>Add Date</span>
                            </button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-brand btn-sm btn-youtube" data-dismiss="modal" type="button">
                            <i class="fa fa-times"></i>
                            <span>Close</span>
                        </button>
                        <button class="btn btn-brand btn-sm btn-spotify" type="button" @click="submit">
                            <i class="fa fa-floppy-o"></i>
                            <span>Submit</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Pagination from "../../Pagination";

export default {
    name: "ImplementationPlanCreateC",
    components: {Pagination},
    props: {
        project: {
            type: Object,
            required: true
        },
    },
    data() {
        return {
            allSelectedAndDatesButtonShow: false,
            allSelected: false,
            planView: false,
            indicatorName: '',
            loading: false,
            timeout: 0,
            errors: {},
            sl: 1,
            searchType: "Family",
            search: {
                query: ''
            },
            paginate: {
                data: [],
                total: 0,
                per_page: 15,
                current_page: 1,
                last_page: 1,
                from: 1,
                to: 0
            },
            searchedData: [],
            originalData: [],
            dateExistMessageFlag: false,
            dateExistMessage: '',
            dates: [],
            date: '',
            checkedIds: [],
            routes: window.appHelper.routes,
        }
    },
    methods: {
        //submit
        setDates() {
            let _this = this;
            if (_this.checkedIds.length === 0) {
                toastr.error("Please select at least one person/family.", "Warning");
            } else if (_this.checkedIds.length > 0) {
                $("#viewModal").modal({show: true, backdrop: "static",});
            }
        },
        allPlanView() {
            let _this = this;
            _this.checkedIds = [];
            _this.dates = [];
            _this.date = "";
            _this.allSelected = false;
            _this.planView = !_this.planView;
        },
        addDate() {
            let _this = this;
            _this.dateExistMessageFlag = false;
            _this.dateExistMessage = '';
            if ('' === _this.date) {
                _this.dateExistMessageFlag = true;
                _this.dateExistMessage = 'select date first.';
                return;
            }
            let exist = false;
            _this.dates.forEach(function (value) {
                if (value == _this.date) {
                    exist = true;
                    _this.dateExistMessageFlag = true;
                    _this.dateExistMessage = value + ' is already selected.';
                }
            });
            if (!exist) {
                _this.dates.push(_this.date);
                _this.date = '';
                $("#dateFor").datepicker("update", "");
            }
        },
        spliceDate(index) {
            let _this = this;
            _this.dates.splice(index, 1);
        },
        submit() {
            let _this = this;
            if (_this.checkedIds.length === 0) {
                toastr.error("Please select at least one person/family.", "Warning");
            } else if (_this.dates.length === 0) {
                toastr.error("Please add a date.", "Warning");
            } else {
                $('#viewModal').modal('hide')
                _this.loading = true;
                let finalData = {};
                finalData['ids'] = _this.checkedIds;
                finalData['dates'] = _this.dates;
                axios.post(_this.routes.create, finalData).then((res) => {
                    if (res.data) {
                        _this.checkedIds = [];
                        _this.dates = [];
                        _this.date = "";
                        _this.allSelected = false;
                        _this.planView = !_this.planView;

                        toastr.success(res.data.success, "Success");
                    } else {
                        toastr.error(res.data.message, "Warning");
                    }
                    _this.loading = false;
                }).catch((error) => {
                    if (error.response) {
                        toastr.error(error.response.data.message, "Error");
                        if (error.response && error.response.data.errors) {
                            _this.errors = err.response.data.errors;
                        }
                    } else {
                        toastr.error(error.message, "Error");
                    }
                    _this.loading = false;
                });
            }
        },
        //searching query
        searchTimeOut() {
            let _this = this;
            clearTimeout(this.timeout);
            this.timeout = setTimeout(() => {
                _this.searchInData(_this.doLowerCase(_this.search.query));
            }, 500);
        },
        searchInData(query) {
            let _this = this;
            let temp = [];
            let data = _this.originalData;
            if (query == "" || query == " ") {
                _this.searchedData = _this.originalData;
            } else {
                if (data.length > 0) {
                    data.forEach(function (item, key) {
                        if (_this.searchType == 'Family' && _this.doLowerCase(item.family.name).indexOf(query) > -1) {
                            temp.push(item);
                        } else if (_this.searchType == 'Member' && (_this.doLowerCase(item.family.name).indexOf(query) > -1 || _this.doLowerCase(item.member.name).indexOf(query) > -1)) {
                            temp.push(item);
                        } else {
                            if (!temp.length) {
                                _this.searchedData = [];
                            }
                        }
                    })
                }
                _this.searchedData = temp;
            }
            _this.dataPush();
            _this._checkedAllStatus();
        },
        doLowerCase(value) {
            if (!value == "" || !value == " ") return value.toLowerCase();
            return value;
        },
        _checkedAllStatus() {
            let _this = this;
            let temp = 0;
            _this.searchedData.forEach(function (value) {
                if (!value.is_implementation) {
                    temp += 1;
                }
            });
            _this.allSelected = _this.searchedData.length > 0 && _this.checkedIds.length === temp;
        },
        callAllSelect(event) {
            let _this = this;
            _this.checkedIds = [];
            _this.allSelected = false;
            if (!_this.allSelected && event.target.checked) {
                _this.searchedData.forEach(function (value) {
                    if (!value.is_implementation) {
                        _this.checkedIds.push(value.j_indicator_id + '_' + value.family_id + '_' + value.member_id);
                    }
                });
                _this.allSelected = true;
            }
        },
        selectItem(event) {
            let _this = this;
            if (event.target.checked) {
                _this.checkedIds.push(event.target.value);
            } else if (_this.checkedIds.length > 0) {
                _this.checkedIds.forEach(function (value, i) {
                    if (event.target.value == value) {
                        _this.checkedIds.splice(i, 1);
                    }
                });
            }
            _this._checkedAllStatus();
        },
        paginationClicked(page) {
            this.$paginateConfig.current_page = page;
            this.dataPush();
        },
        dataPush() {
            let _this = this;
            _this.$paginateSetData(_this.searchedData);
            _this.paginate = _this.$paginateConfig;
        },
        _checkSelectedButtonShow() {
            let _this = this;
            _this.allSelectedAndDatesButtonShow = false;
            _this.searchedData.forEach(function (value) {
                if (!value.is_implementation) {
                    _this.allSelectedAndDatesButtonShow = true;
                }
            });
        },
        getDataForPlan(item) {
            let _this = this;
            _this.loading = true;
            _this.planView = false;
            _this.indicatorName = "";
            _this.searchType = "Family";
            let query = {};
            query['j_gro_id'] = item.j_gro_id;
            query['j_indicator_id'] = item.j_indicator_id;
            axios.post(_this.routes.one, query).then((res) => {
                if (res.data) {
                    _this.originalData = res.data;
                    _this.searchedData = res.data;
                    _this.indicatorName = item.name;
                    _this.searchType = item.type;
                    _this.planView = true;
                    _this.dataPush();
                    _this._checkSelectedButtonShow();
                } else {
                    toastr.error(res.data.message, "Warning");
                }
                _this.loading = false;
            }).catch((error) => {
                if (error.response) {
                    toastr.error(error.response.data.message, "Error");
                    if (error.response && error.response.data.errors) {
                        _this.errors = err.response.data.errors;
                    }
                } else {
                    toastr.error(error.message, "Error");
                }
                _this.loading = false;
            });
        },

    },
    mounted() {
        let _this = this;
        $(".ip_datepicker").datepicker({
            todayHighlight: true,
            format: "yyyy-mm-dd",
            startDate: "-200y",
            autoclose: true,
        }).on("changeDate", (event) => {
            let value = event.currentTarget.value;
            switch (event.currentTarget.name) {
                case "ip_date":
                    _this.date = value;
                    break;
            }
        });
    },
}

</script>


<style scoped>
.green-color {
    color: green;
}

.red-color {
    color: red;
}
</style>
