<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h5>Safety</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group p-0 m-0">
                            <label class="czm-xs">Female Member Abuse <span class="text-danger">*</span></label>
                            <div class="form-check form-check-inline">
                                <input id="female_abuse_true" v-model="female_abuse" class="form-check-input"
                                       name="female_abuse" type="radio" value="true" @change="checkSafety">
                                <label class="form-check-label" for="female_abuse_true">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input id="female_abuse_false" v-model="female_abuse" class="form-check-input"
                                       name="female_abuse" type="radio" value="false" @change="checkSafety">
                                <label class="form-check-label" for="female_abuse_false">No</label>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 my-4">
                            <div v-if="$parent.formData.familySafeties.length > 0" class="form-group">
                                <div class="table-responsive">
                                    <table class="table table-sm table-stripe">
                                        <thead class="bg-gray-100">
                                        <tr>
                                            <th>Victim Name</th>
                                            <th>Relation with Abuser</th>
                                            <th>Abuse Type</th>
                                            <th>Place</th>
                                            <th>Abuser Name</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(item,index) in $parent.formData.familySafeties" :key="index">
                                            <td>{{ item.safety_victim_name }}</td>
                                            <td>{{ item.safety_relation_with_abuser }}</td>
                                            <td>{{ item.safety_type_of_abuse }}</td>
                                            <td>{{ item.safety_place_of_abuse }}</td>
                                            <td>{{ item.safety_abuser_name }}</td>
                                            <td>
                                                <button class="btn btn-xs btn-danger rounded-0"
                                                        @click="requestRemoveSafety(item.safety_victim_name,index)">
                                                    <i class="fa fa-remove"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <small class="text-danger">
                                        * {{ maxCount - $parent.formData.familySafeties.length }} female victim member
                                        remaining!
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div v-show="safetyVictim">
                            <form v-if="$parent.formData.familySafeties.length < maxCount"
                                  data-vv-scope='s_v_v' @submit.prevent="onSafetySubmit('s_v_v')">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="form-group p-0 m-0">
                                            <label class="czm-xs">Name of Victim<span
                                                class="text-danger">*</span></label>
                                            <input v-model="safetyData.safety_victim_name"
                                                   v-validate="'required|alpha_spaces|max:150'"
                                                   :class="[(vvErrors.has('s_v_v.safety_victim_name') ? 'is-invalid' : '')]"
                                                   class="form-control form-control-sm rounded-0"
                                                   data-vv-as="Name of Victim"
                                                   data-vv-name="safety_victim_name"
                                                   type="text">
                                            <div v-show="vvErrors.has('s_v_v.safety_victim_name')"
                                                 class="invalid-feedback">
                                                {{ vvErrors.first("s_v_v.safety_victim_name") }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="form-group p-0 m-0">
                                            <label class="czm-xs">Relation with Abuser<span class="text-danger">*</span></label>
                                            <select v-model.number="safetyData.safety_relation_with_abuser"
                                                    v-validate="'required'"
                                                    :class="[this.vvErrors.has('s_v_v.safety_relation_with_abuser') ? 'is-invalid' : '']"
                                                    class="form-control form-control-sm rounded-0"
                                                    data-vv-as="Relation with Abuser"
                                                    data-vv-name="safety_relation_with_abuser">
                                                <option value="">Select One</option>
                                                <option v-for="(item,index) in $parent.initData.abuserRelationTypes"
                                                        :key="index" :value="item"> {{ item }}
                                                </option>
                                            </select>
                                            <div v-show="vvErrors.has('s_v_v.safety_relation_with_abuser')"
                                                 class="invalid-feedback">
                                                {{ vvErrors.first("s_v_v.safety_relation_with_abuser") }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="form-group p-0 m-0">
                                            <label class="czm-xs">Type of Abuse<span
                                                class="text-danger">*</span></label>
                                            <select v-model.number="safetyData.safety_type_of_abuse"
                                                    v-validate="'required'"
                                                    :class="[this.vvErrors.has('s_v_v.safety_type_of_abuse') ? 'is-invalid' : '']"
                                                    class="form-control form-control-sm rounded-0"
                                                    data-vv-as="Type of Abuse"
                                                    data-vv-name="safety_type_of_abuse">
                                                <option value="">Select One</option>
                                                <option v-for="(item,index) in $parent.initData.abuseTypes" :key="index"
                                                        :value="item">
                                                    {{ item }}
                                                </option>
                                            </select>
                                            <div v-show="vvErrors.has('s_v_v.safety_type_of_abuse')"
                                                 class="invalid-feedback">
                                                {{ vvErrors.first("s_v_v.safety_type_of_abuse") }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="form-group p-0 m-0">
                                            <label class="czm-xs">Place of Abuse<span
                                                class="text-danger">*</span></label>
                                            <input v-model="safetyData.safety_place_of_abuse"
                                                   v-validate="'required|min:2|max:150'"
                                                   :class="[(vvErrors.has('s_v_v.safety_place_of_abuse') ? 'is-invalid' : '')]"
                                                   class="form-control form-control-sm rounded-0"
                                                   data-vv-as="Place of Abuse"
                                                   data-vv-name="safety_place_of_abuse"
                                                   type="text">
                                            <div v-show="vvErrors.has('s_v_v.safety_place_of_abuse')"
                                                 class="invalid-feedback">
                                                {{ vvErrors.first("s_v_v.safety_place_of_abuse") }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="form-group p-0 m-0">
                                            <label class="czm-xs">Abuser Name<span class="text-danger">*</span></label>
                                            <input v-model="safetyData.safety_abuser_name"
                                                   v-validate="'required|alpha_spaces|max:150'"
                                                   :class="[(vvErrors.has('s_v_v.safety_abuser_name') ? 'is-invalid' : '')]"
                                                   class="form-control form-control-sm rounded-0"
                                                   data-vv-as="Name of Abuser"
                                                   data-vv-name="safety_abuser_name"
                                                   type="text">
                                            <div v-show="vvErrors.has('s_v_v.safety_abuser_name')"
                                                 class="invalid-feedback">
                                                {{ vvErrors.first("s_v_v.safety_abuser_name") }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-3">
                                    <button class="btn btn-brand btn-sm btn-czm-green pull-left"
                                            style="margin-bottom: 4px"
                                            type="submit">
                                        <i class="fa fa-plus"></i>
                                        <span>Add Victim Member</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5>Help From Neighbour</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group p-0 m-0">
                            <label class="czm-xs">Help from Neighbour <span class="text-danger">*</span></label>
                            <div class="form-check form-check-inline">
                                <input id="neighbour_help_true" v-model="neighbour_help" class="form-check-input"
                                       name="neighbour_help" type="radio" value="true"
                                       @change="checkNeighbourHelp">
                                <label class="form-check-label" for="neighbour_help_true">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input id="neighbour_help_false" v-model="neighbour_help" class="form-check-input"
                                       name="neighbour_help" type="radio" value="false"
                                       @change="checkNeighbourHelp">
                                <label class="form-check-label" for="neighbour_help_false">No</label>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 my-4">
                            <div v-if="$parent.formData.familyNeighborHelps.length > 0" class="form-group">
                                <div class="table-responsive">
                                    <table class="table table-sm table-stripe">
                                        <thead class="bg-gray-100">
                                        <tr>
                                            <th>Help Type</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(item,index) in $parent.formData.familyNeighborHelps" :key="index">
                                            <td> {{ item.neighbour_help_type }}</td>
                                            <td>
                                                <button class="btn btn-xs btn-danger rounded-0"
                                                        @click="requestRemoveNeighbour(item.neighbour_help_type,index)">
                                                    <i class="fa fa-remove"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <small class="text-danger">
                                        * {{ maxCount - $parent.formData.familyNeighborHelps.length }} neighbour
                                        remaining!
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div v-show="neighbourFlag">
                            <form v-if="$parent.formData.familyNeighborHelps.length < maxCount"
                                  data-vv-scope='n_v' @submit.prevent="onNeighborSubmit('n_v')">
                                <div class="form-group p-0 m-0">
                                    <label class="czm-xs">Type of Help from Neighbour<span class="text-danger">*</span></label>
                                    <select v-model.number="neighbourData.neighbour_help_type"
                                            v-validate="'required'"
                                            :class="[this.vvErrors.has('n_v.neighbour_help_type') ? 'is-invalid' : '']"
                                            class="form-control form-control-sm rounded-0"
                                            data-vv-as="Type of Help from neighbour"
                                            data-vv-name="neighbour_help_type">
                                        <option value="">Select One</option>
                                        <option v-for="(item,index) in $parent.initData.neighborHelpTypes"
                                                :key="index" :value="item">
                                            {{ item }}
                                        </option>
                                    </select>
                                    <div v-show="vvErrors.has('n_v.neighbour_help_type')"
                                         class="invalid-feedback">
                                        {{ vvErrors.first("n_v.neighbour_help_type") }}
                                    </div>
                                </div>
                                <div class="form-group mt-3">
                                    <button class="btn btn-brand btn-sm btn-czm-green pull-left"
                                            style="margin-bottom: 4px"
                                            type="submit">
                                        <i class="fa fa-plus"></i>
                                        <span>Add Help from Neighbour </span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5>Help From Rich</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group p-0 m-0">
                            <label class="czm-xs">Help from Rich <span class="text-danger">*</span></label>
                            <div class="form-check form-check-inline">
                                <input id="rich_help_true" v-model="rich_help" class="form-check-input"
                                       name="rich_help" type="radio" value="true" @change="checkRichHelp">
                                <label class="form-check-label" for="rich_help_true">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input id="rich_help_false" v-model="rich_help" class="form-check-input"
                                       name="rich_help"
                                       type="radio" value="false" @change="checkRichHelp">
                                <label class="form-check-label" for="rich_help_false">No</label>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 my-4">
                            <div v-if="$parent.formData.familyRichHelps.length > 0" class="form-group">
                                <div class="table-responsive">
                                    <table class="table table-sm table-stripe">
                                        <thead class="bg-gray-100">
                                        <tr>
                                            <th>Help Type</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(item,index) in $parent.formData.familyRichHelps" :key="index">
                                            <td> {{ item.rich_help_type }}</td>
                                            <td>
                                                <button class="btn btn-xs btn-danger rounded-0"
                                                        @click="requestRemoveRich(item.rich_help_type,index)">
                                                    <i class="fa fa-remove"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <small class="text-danger">
                                        * {{ maxCount - $parent.formData.familyRichHelps.length }} rich remaining!
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div v-show="richFlag">
                            <form v-if="$parent.formData.familyRichHelps.length < maxCount"
                                  data-vv-scope='r_v' @submit.prevent="onRichSubmit('r_v')">
                                <div class="form-group p-0 m-0">
                                    <label class="czm-xs">Type of Help from Rich<span
                                        class="text-danger">*</span></label>
                                    <select v-model.number="richData.rich_help_type" v-validate="'required'"
                                            :class="[this.vvErrors.has('r_v.rich_help_type') ? 'is-invalid' : '']"
                                            class="form-control form-control-sm rounded-0"
                                            data-vv-as="Type of Help from rich"
                                            data-vv-name="rich_help_type">
                                        <option value="">Select One</option>
                                        <option v-for="(item,index) in $parent.initData.richHelpTypes" :key="index"
                                                :value="item">
                                            {{ item }}
                                        </option>
                                    </select>
                                    <div v-show="vvErrors.has('r_v.rich_help_type')"
                                         class="invalid-feedback">
                                        {{ vvErrors.first("r_v.rich_help_type") }}
                                    </div>
                                </div>
                                <div class="form-group mt-3">
                                    <button class="btn btn-brand btn-sm btn-czm-green pull-left"
                                            style="margin-bottom: 4px"
                                            type="submit">
                                        <i class="fa fa-plus"></i>
                                        <span>Add Help from Rich</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5>Conflict Resolver</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group p-0 m-0">
                            <label class="czm-xs">Conflict Resolver<span class="text-danger">*</span></label>
                            <div class="form-check form-check-inline">
                                <input id="is_conflict_resolver_true" v-model="conflict_resolve"
                                       class="form-check-input" name="is_conflict_resolver" type="radio"
                                       value="true" @change="checkConflictResolve">
                                <label class="form-check-label" for="is_conflict_resolver_true">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input id="is_conflict_resolver_false" v-model="conflict_resolve"
                                       class="form-check-input"
                                       name="is_conflict_resolver" type="radio"
                                       value="false" @change="checkConflictResolve">
                                <label class="form-check-label" for="is_conflict_resolver_false">No</label>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 my-4">
                            <div v-if="$parent.formData.familyConflictResolves.length > 0" class="form-group">
                                <div class="table-responsive">
                                    <table class="table table-sm table-stripe">
                                        <thead class="bg-gray-100">
                                        <tr>
                                            <th>Conflict Resolver</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(item,index) in $parent.formData.familyConflictResolves"
                                            :key="index">
                                            <td> {{ item.conflict_resolve_type }}</td>
                                            <td>
                                                <button
                                                    class="btn btn-xs btn-danger rounded-0"
                                                    @click="requestRemoveConflictResolver(item.conflict_resolve_type,index)">
                                                    <i class="fa fa-remove"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <small class="text-danger">
                                        * {{ maxCount - $parent.formData.familyConflictResolves.length }} Conflict
                                        Resolver remaining!
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div v-show="conflictResolveFlag">
                            <form v-if="$parent.formData.familyConflictResolves.length < maxCount"
                                  data-vv-scope='c_r_v' @submit.prevent="onConflictResolverSubmit('c_r_v')">
                                <div class="form-group p-0 m-0">
                                    <label class="czm-xs">Conflict Resolver<span class="text-danger">*</span></label>
                                    <select v-model.number="conflictResolverData.conflict_resolve_type"
                                            v-validate="'required'"
                                            :class="[this.vvErrors.has('c_r_v.conflict_resolve_type') ? 'is-invalid' : '']"
                                            class="form-control form-control-sm rounded-0"
                                            data-vv-as="conflict resolve type"
                                            data-vv-name="conflict_resolve_type">
                                        <option value="">Select One</option>
                                        <option v-for="(item,index) in $parent.initData.conflictResolveTypes"
                                                :key="index" :value="item">
                                            {{ item }}
                                        </option>
                                    </select>
                                    <div v-show="vvErrors.has('c_r_v.conflict_resolve_type')"
                                         class="invalid-feedback">
                                        {{ vvErrors.first("c_r_v.conflict_resolve_type") }}
                                    </div>
                                </div>
                                <div class="form-group mt-3">
                                    <button class="btn btn-brand btn-sm btn-czm-green pull-left"
                                            style="margin-bottom: 4px"
                                            type="submit">
                                        <i class="fa fa-plus"></i>
                                        <span>Add Conflict Resolver</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "SafetyCreateC",
    data() {
        return {
            errors: {},
            maxCount: 10,
            //victim
            safetyVictim: false,
            female_abuse: false,
            safetyData: {
                safety_victim_name: "",
                safety_abuser_name: "",
                safety_relation_with_abuser: "",
                safety_type_of_abuse: "",
                safety_place_of_abuse: "",
            },
            //neighbour
            neighbourFlag: false,
            neighbour_help: false,
            neighbourData: {
                neighbour_help_type: "",
            },
            //neighbour
            richFlag: false,
            rich_help: false,
            richData: {
                rich_help_type: "",
            },
            //neighbour
            conflictResolveFlag: false,
            conflict_resolve: false,
            conflictResolverData: {
                conflict_resolve_type: "",
            },
        };
    },
    methods: {
        //victim
        checkSafety() {
            let _this = this;
            _this.$parent.formData.familySafeties = [];
            _this.safetyVictim = _this.female_abuse === "true";
        },
        onSafetySubmit(scope) {
            let _this = this;
            _this.$validator.validateAll(scope).then((result) => {
                if (result) {
                    _this.addSafety();
                } else {
                    _this.errors = _this.vvErrors.collect();
                }
            });
        },
        addSafety() {
            let _this = this;
            _this.$parent.formData.familySafeties.push(_this.safetyData);
            _this.safetyData = {};
            _this.safetyData.safety_victim_name = ""
            _this.safetyData.safety_abuser_name = ""
            _this.safetyData.safety_relation_with_abuser = ""
            _this.safetyData.safety_type_of_abuse = ""
            _this.safetyData.safety_place_of_abuse = ""
            _this.$nextTick(() => {
                _this.$validator.reset();
                _this.errors = {};
            });
        },
        requestRemoveSafety(safetyVictimName, index) {
            let _this = this;
            Swal.fire({
                title: "Are you sure?",
                html: '<p style="color:#3085d6">"' + safetyVictimName + '"</p>' + "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, Remove it!",
            }).then((result) => {
                if (result.value) {
                    _this.removeSafety(index);
                }
            });
        },
        removeSafety(index) {
            let _this = this;
            _this.$parent.formData.familySafeties.splice(index, 1);
            _this.$nextTick(() => {
                _this.$validator.reset();
                _this.errors = {};
            });
        },
        //neighbour help
        checkNeighbourHelp() {
            let _this = this;
            _this.$parent.formData.familyNeighborHelps = [];
            _this.neighbourFlag = _this.neighbour_help === "true";
        },
        onNeighborSubmit(scope) {
            let _this = this;
            _this.$validator.validateAll(scope).then((result) => {
                if (result) {
                    _this.addNeighbor();
                } else {
                    _this.errors = _this.vvErrors.collect();
                }
            });
        },
        addNeighbor() {
            let _this = this;
            _this.$parent.formData.familyNeighborHelps.push(_this.neighbourData);
            _this.neighbourData = {};
            _this.neighbourData.neighbour_help_type = "";
            _this.$nextTick(() => {
                _this.$validator.reset();
                _this.errors = {};
            });
        },
        requestRemoveNeighbour(neighbourHelpType, index) {
            let _this = this;
            Swal.fire({
                title: "Are you sure?",
                html: '<p style="color:#3085d6">"' + neighbourHelpType + '"</p>' + "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, Remove it!",
            }).then((result) => {
                if (result.value) {
                    _this.removeNeighbour(index);
                }
            });
        },
        removeNeighbour(index) {
            let _this = this;
            _this.$parent.formData.familyNeighborHelps.splice(index, 1);
            _this.$nextTick(() => {
                _this.$validator.reset();
                _this.errors = {};
            });
        },
        //rich help
        checkRichHelp() {
            let _this = this;
            _this.$parent.formData.familyRichHelps = [];
            _this.richFlag = _this.rich_help === "true";
        },
        onRichSubmit(scope) {
            let _this = this;
            _this.$validator.validateAll(scope).then((result) => {
                if (result) {
                    _this.addRich();
                } else {
                    _this.errors = _this.vvErrors.collect();
                }
            });
        },
        addRich() {
            let _this = this;
            _this.$parent.formData.familyRichHelps.push(_this.richData);
            _this.richData = {};
            _this.richData.rich_help_type = "";
            _this.$nextTick(() => {
                _this.$validator.reset();
                _this.errors = {};
            });
        },
        requestRemoveRich(richHelpType, index) {
            let _this = this;
            Swal.fire({
                title: "Are you sure?",
                html: '<p style="color:#3085d6">"' + richHelpType + '"</p>' + "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, Remove it!",
            }).then((result) => {
                if (result.value) {
                    _this.removeRich(index);
                }
            });
        },
        removeRich(index) {
            let _this = this;
            _this.$parent.formData.familyRichHelps.splice(index, 1);
            _this.$nextTick(() => {
                _this.$validator.reset();
                _this.errors = {};
            });
        },
        //conflict resolve
        checkConflictResolve() {
            let _this = this;
            _this.$parent.formData.familyConflictResolves = [];
            _this.conflictResolveFlag = _this.conflict_resolve === "true";
        },
        onConflictResolverSubmit(scope) {
            let _this = this;
            _this.$validator.validateAll(scope).then((result) => {
                if (result) {
                    _this.addConflictResolver();
                } else {
                    _this.errors = _this.vvErrors.collect();
                }
            });
        },
        addConflictResolver() {
            let _this = this;
            _this.$parent.formData.familyConflictResolves.push(_this.conflictResolverData);
            _this.conflictResolverData = {};
            _this.conflictResolverData.conflict_resolve_type = "";
            _this.$nextTick(() => {
                _this.$validator.reset();
                _this.errors = {};
            });
        },
        requestRemoveConflictResolver(conflictResolveType, index) {
            let _this = this;
            Swal.fire({
                title: "Are you sure?",
                html: '<p style="color:#3085d6">"' + conflictResolveType + '"</p>' + "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, Remove it!",
            }).then((result) => {
                if (result.value) {
                    _this.removeConflictResolver(index);
                }
            });
        },
        removeConflictResolver(index) {
            let _this = this;
            _this.$parent.formData.familyConflictResolves.splice(index, 1);
            _this.$nextTick(() => {
                _this.$validator.reset();
            });
        },
    },
};
</script>
<style scoped>
</style>
