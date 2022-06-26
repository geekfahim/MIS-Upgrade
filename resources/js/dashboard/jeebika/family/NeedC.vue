<template>
    <div class="position-relative">
        <div class="card-header">
            <i class="fa fa-list"></i>Needs
            <div v-if="family.need_assessment" class="card-header-actions p-0 m-0">
                <button class="btn btn-brand btn-sm btn-github" type="button" @click="addNewNeed()">
                    <i class="fa fa-plus"></i>
                    <span>Add New Need</span>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div v-if="createView" class="create-need">
                <div v-for="(program, programName) in family.programs" id="accordion" :key="programName"
                     class="accordion" role="tablist">
                    <div class="card mb-0">
                        <div class="card-header" role="tab">
                            <h5 class="mb-0">
                                <a :href="'#'+programName" aria-expanded="false" class="collapsed"
                                   data-toggle="collapse"><i class="fa fa-plus"></i> {{ programName }}
                                </a>
                            </h5>
                        </div>
                        <div :id="programName" aria-labelledby="programName" class="collapse" data-parent="#accordion"
                             role="tabpanel">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div v-for="(items, key) in program" :key="key" class="familytable">
                                            <table v-if="key === 'Family'"
                                                   class="table table-responsive-sm table-bordered">
                                                <caption>{{ key }}</caption>
                                                <thead>
                                                <th>S/L</th>
                                                <th>Family Name</th>
                                                <th v-for="(indicator, indicatorKey) in items" :key="indicatorKey">
                                                    {{ indicator.name }}
                                                </th>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>{{ sl }}</td>
                                                    <td>{{ family.name }}</td>
                                                    <td v-for="(indicatorX, indicatorKeyX) in items"
                                                        :key="indicatorKeyX">
                                                        <label
                                                            class="c-switch c-switch-label c-switch-3d c-switch-primary">
                                                            <input :value="'id' + indicatorX.id + family.id"
                                                                   class="c-switch-input toggle-class"
                                                                   type="checkbox"
                                                                   @click="indicatorClick(key, $event, indicatorX.id, family.id)"/>
                                                            <span class="c-switch-slider c-switch-danger"
                                                                  data-checked="✓" data-unchecked="✕"></span>
                                                        </label>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <table v-else class="table table-responsive-sm table-bordered">
                                                <caption>{{ key }}</caption>
                                                <thead>
                                                <th>S/L</th>
                                                <th>Member's Name</th>
                                                <th v-for="(indicator, indicatorKey) in items" :key="indicatorKey">
                                                    {{ indicator.name }}
                                                </th>
                                                </thead>
                                                <tbody>
                                                <tr v-for="(member, memberKey) in family.members" :key="memberKey">
                                                    <td>{{ sl + memberKey }}</td>
                                                    <td>{{ member.mustahiq ? member.mustahiq.name : '' }}</td>
                                                    <td v-for="(indicatorY,indicatorKeyY) in items"
                                                        :key="indicatorKeyY">
                                                        <label
                                                            class="c-switch c-switch-label c-switch-3d c-switch-primary">
                                                            <input :value="'id' + indicatorY.id + member.id"
                                                                   class="c-switch-input toggle-class"
                                                                   type="checkbox"
                                                                   @click="indicatorClick(key, $event, indicatorY.id, member.id)"/>
                                                            <span class="c-switch-slider c-switch-danger"
                                                                  data-checked="✓" data-unchecked="✕"></span>
                                                        </label>
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
                </div>
                <button class="btn btn-sm btn-primary pull-right rounded-0 my-4" type="submit" @click="onSubmit">
                    <i class="fa fa-dot-circle-o"></i>
                    Submit
                </button>
            </div>
            <div v-else class="listView">
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
                <table class="table table-responsive-sm table-sm table-striped table-hover">
                    <thead>
                    <tr>
                        <th style="width:20px">#</th>
                        <th style="width: 250px">Family Name</th>
                        <th class="sort" style=" width: 250px" @click="onClickSortItems('member_id')">Member Name</th>
                        <th class="sort" @click="onClickSortItems('j_indicator_id')">Indicator Name</th>
                        <th class="sort" @click="onClickSortItems('is_need')">Need</th>
                        <th style="text-align: center; width: 110px;">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(item, index) in outputRes.data" :key="item.id">
                        <td>{{ sl + index }}</td>
                        <td class="text-capitalize">{{ item.family ? item.family.name : '' }}</td>
                        <td class="text-capitalize">{{ item.member ? item.member.name : '' }}</td>
                        <td class="text-capitalize">{{ item.j_indicator ? item.j_indicator.name : '' }}</td>
                        <td>
                            <span v-if="1===item.is_need" class="badge badge-success">Yes! Need</span>
                            <span v-else class="badge badge-danger">No! Not Need</span>
                        </td>
                        <td>
                            <button class="btn btn-xs btn-danger rounded-0" @click="onClickDelete(item.id)">
                                <i class="fa fa-remove"></i> Not Need
                            </button>
                        </td>
                    </tr>
                    <tr v-if="outputRes.data.length === 0">
                        <td class="text-center" colspan="6">No Data Found
                        </td>
                    </tr>
                    </tbody>
                </table>
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
        </div>
        <!-- Modal -->
        <div id="viewModal" aria-hidden="true" aria-labelledby="viewModalTitle" class="modal fade" role="dialog"
             tabindex="-1">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content rounded-0">
                    <div class="modal-header">
                        <h6 id="exampleModalCenterTitle" class="modal-title">Add New Need</h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="czm-xs">Need Indicator<span class="text-danger">*</span></label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-arrow-circle-down"></i>
                                        </span>
                                </div>
                                <select v-model="formData.indicator_id" v-validate="'required'"
                                        :class="[(vvErrors.has('indicator_id') ? 'is-invalid' : '')]"
                                        class="form-control form-control-sm rounded-0"
                                        data-vv-as="indicator"
                                        data-vv-name="indicator_id"
                                        @change="checkIndicatorType()">
                                    <option value="">Select One</option>
                                    <option v-for="item in indicators" :key="item.id" :value="item.id">
                                        {{ item.name + " (" + item.type + ")" }}
                                    </option>
                                </select>
                                <div v-show="vvErrors.has('indicator_id')" class="invalid-feedback">
                                    {{ vvErrors.first('indicator_id') }}
                                </div>
                            </div>
                        </div>
                        <div v-if="memberType" class="form-group">
                            <label class="czm-xs">Member<span class="text-danger">*</span></label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-arrow-circle-down"></i>
                                        </span>
                                </div>
                                <select v-model="formData.member_id" v-validate="''"
                                        :class="[(vvErrors.has('member_id') ? 'is-invalid' : '')]"
                                        class="form-control form-control-sm rounded-0" data-vv-as="member"
                                        data-vv-name="member_id">
                                    <option value="">Select One</option>
                                    <option v-for="item in familyMembers" :key="item.id" :value="item.id">
                                        {{ item.name }}
                                    </option>
                                </select>
                                <div v-show="vvErrors.has('member_id')" class="invalid-feedback">
                                    {{ vvErrors.first('member_id') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-sm btn-success pull-right rounded-0" type="button"
                                @click="onSubmitSingle">
                            <i class="fa fa-dot-circle-o"></i> Yes! Submit Need
                        </button>
                        <button class="btn btn-sm btn-danger rounded-0" data-dismiss="modal" type="button">
                            <i class="fa fa-remove"></i> Close
                        </button>
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
    name: "NeedC.Vue",
    components: {Pagination},
    props: {
        family: {
            type: Object,
            required: true
        },
    },
    data() {
        return {
            loading: false,
            createView: true,
            memberType: false,
            search: {
                page: 1,
                sort: "member_id",
                type: "asc",
                query: "",
                item: "",
            },
            formData: {
                indicator_id: '',
                member_id: ''
            },
            sl: 1,
            timeout: null,
            errors: {},
            arr: [],
            outputRes: {
                data: [],
            },
            indicators: [],
            familyMembers: [],
            routes: window.appHelper.routes,
        };
    },
    methods: {
        onClickDelete(id) {
            Swal.fire({
                title: "Are you sure?",
                html: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#2778c4",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
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
                }
            });
        },
        onSubmitSingle() {
            let _this = this;
            _this.$validator.validateAll().then((result) => {
                if (result) {
                    axios.post(_this.routes.single, _this.formData).then((res) => {
                        if (res.data.success) {
                            $('#viewModal').modal('hide');
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
                }
            });
        },
        checkIndicatorType() {
            let _this = this;
            _this.formData.member_id = '';
            _this.memberType = _this.indicators.find(item => item.id === _this.formData.indicator_id).type === 'Member';
        },
        indicatorClick(type, e, indicatorId, variableId) {
            let _this = this;
            const check = e.target.checked;
            const id = e.target.value;
            if (check) {
                let tempArray = [];
                tempArray["id"] = id;
                tempArray["type"] = type;
                tempArray["variable_id"] = variableId;
                tempArray["j_indicator_id"] = indicatorId;
                _this.arr.push(tempArray);
            } else if (_this.arr.length > 0) {
                _this.arr.forEach((item) => {
                    if (item.id == id) {
                        const index = _this.arr.indexOf(item);
                        _this.arr.splice(index, 1);
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
            let sort = key == "sort" ? value : !!parsed.sort ? parsed.sort : "member_id";
            let type = key == "type" ? value : !!parsed.type ? parsed.type : "asc";
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
            if (_this.arr.length > 0) {
                _this.loading = true;
                let mainObject = {};
                for (let xkey in _this.arr) {
                    let obj = {};
                    for (let ykey in _this.arr[xkey]) {
                        obj[ykey] = _this.arr[xkey][ykey];
                    }
                    mainObject[xkey] = obj;
                }
                let convert = JSON.stringify(mainObject);
                axios.post(_this.routes.one, {data: convert}).then((res) => {
                    if (res.data.success) {
                        toastr.success(res.data.success, "Success");
                        this.family.need_assessment = 1;
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
            } else {
                toastr.error("Please select at least one need.", "Error");
            }
        },
        addNewNeed() {
            let _this = this;
            this.$validator.reset();
            _this.memberType = false;
            _this.formData.indicator_id = '';
            _this.formData.member_id = '';
            $("#viewModal").modal({show: true, backdrop: "static"});
        },
        getAll() {
            let _this = this;
            if (1 === this.family.need_assessment) {
                _this.createView = false;
            }
            _this.loading = true;
            axios.post(_this.routes.list, _this.search).then((res) => {
                if (res.data) {
                    _this.outputRes = res.data.lists;
                    _this.indicators = res.data.indicators;
                    _this.familyMembers = res.data.familyMembers;
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
    },
    created() {
        let parsed = queryString.parse(location.search);
        this.search.page = !!parsed.page ? parsed.page : 1;
        this.search.sort = !!parsed.sort ? parsed.sort : "member_id";
        this.search.type = !!parsed.type ? parsed.type : "asc";
        this.search.query = !!parsed.query ? parsed.query : "";
        this.search.item = !!parsed.item ? parsed.item : 25;
        this.getAll();
    },
};
</script>

<style scoped>
</style>
