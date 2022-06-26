<template>
    <div>
        <!-- Safety -->
        <div class="table-responsive">
            <table class="table table-responsive-sm table-sm table-striped table-hover">
                <caption style="color: #4dbd74;font-size: 1.09375rem">Safeties
                    <button class="btn btn-brand btn-success btn-sm pull-right" @click="addNewSafety">
                        <i class="fa fa-plus"></i>
                        <span>Add New Safety</span>
                    </button>
                </caption>
                <thead>
                <tr>
                    <th>Victim Name</th>
                    <th>Relation with Abuser</th>
                    <th>Abuse Type</th>
                    <th>Abuse Place</th>
                    <th>Abuser Name</th>
                    <th style="width: 145px; text-align:center">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(item,index) in safeties" :key=index>
                    <td>{{ item.safety_victim_name }}</td>
                    <td>{{ item.safety_relation_with_abuser }}</td>
                    <td>{{ item.safety_type_of_abuse }}</td>
                    <td>{{ item.safety_place_of_abuse }}</td>
                    <td>{{ item.safety_abuser_name }}</td>
                    <td>
                        <button class="btn btn-xs btn-info rounded-0" @click="editSafety(item)">
                            <i class="fa fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-xs btn-danger rounded-0" @click="deleteSafety(item)">
                            <i class="fa fa-remove"></i> Delete
                        </button>
                    </td>
                </tr>
                <tr v-if="safeties.length === 0">
                    <td class="text-center" colspan="6">No Data Found</td>
                </tr>
                </tbody>
            </table>
        </div>
        <!-- Safety Create/Edit Modal -->
        <div id="safetyCreateEditModal" aria-hidden="true" aria-labelledby="Safety Modal" class="modal fade"
             role="dialog" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content rounded-0">
                    <div class="modal-body">
                        <form class="form-horizontal" data-vv-scope="safetyScope"
                              v-on:submit.prevent="submitSafety('safetyScope')">
                            <div class="form-group row justify-content-center">
                                <h6 class="text-left col-sm-12">
                                    <strong v-if="createView">Add New Safety</strong>
                                    <strong v-else>Update Safety</strong>
                                </h6>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Victim Name<span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="fa fa-file-text-o"></i>
                                        </span>
                                    </div>
                                    <input v-model="safetyFormData.safety_victim_name"
                                           v-validate="'required|name_with_number|max:50'"
                                           :class="[(vvErrors.has('safetyScope.safety_victim_name') ? 'is-invalid' : '')]"
                                           class="form-control form-control-sm rounded-0"
                                           data-vv-as="victim name" data-vv-name="safety_victim_name"

                                           type="text">
                                    <div v-show="vvErrors.has('safetyScope.safety_victim_name')"
                                         class="invalid-feedback">
                                        {{ vvErrors.first('safetyScope.safety_victim_name') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Relation with Abuser<span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="fa fa-arrow-circle-down"></i>
                                        </span>
                                    </div>
                                    <select v-model.number="safetyFormData.safety_relation_with_abuser"
                                            v-validate="'required'"
                                            :class="[(vvErrors.has('safetyScope.safety_relation_with_abuser') ? 'is-invalid' : '')]"
                                            class="form-control form-control-sm rounded-0"
                                            data-vv-as="relation with abuser"
                                            data-vv-name="safety_relation_with_abuser" data-vv-validate-on="change">
                                        <option value="">Select One</option>
                                        <option v-for="item in ABUSER_RELATION_TYPES" :key="item"
                                                :value="item">
                                            {{ item }}
                                        </option>
                                    </select>
                                    <div v-show="vvErrors.has('safetyScope.safety_relation_with_abuser')"
                                         class="invalid-feedback">
                                        {{ vvErrors.first('safetyScope.safety_relation_with_abuser') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Abuse Type<span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="fa fa-arrow-circle-down"></i>
                                        </span>
                                    </div>
                                    <select v-model.number="safetyFormData.safety_type_of_abuse" v-validate="'required'"
                                            :class="[(vvErrors.has('safetyScope.safety_type_of_abuse') ? 'is-invalid' : '')]"
                                            class="form-control form-control-sm rounded-0" data-vv-as="abuse type"
                                            data-vv-name="safety_type_of_abuse" data-vv-validate-on="change">
                                        <option value="">Select One</option>
                                        <option v-for="item in ABUSE_TYPES" :key="item" :value="item">
                                            {{ item }}
                                        </option>
                                    </select>
                                    <div v-show="vvErrors.has('safetyScope.safety_type_of_abuse')"
                                         class="invalid-feedback">
                                        {{ vvErrors.first('safetyScope.safety_type_of_abuse') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Abuse Place<span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="fa fa-file-text-o"></i>
                                        </span>
                                    </div>
                                    <input v-model="safetyFormData.safety_place_of_abuse"
                                           v-validate="'required|name_with_number|max:50'"
                                           :class="[(vvErrors.has('safetyScope.safety_place_of_abuse') ? 'is-invalid' : '')]"
                                           class="form-control form-control-sm rounded-0"
                                           data-vv-as="place of abuse" data-vv-name="safety_place_of_abuse"

                                           type="text">
                                    <div v-show="vvErrors.has('safetyScope.safety_place_of_abuse')"
                                         class="invalid-feedback">
                                        {{ vvErrors.first('safetyScope.safety_place_of_abuse') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Abuser Name<span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="fa fa-file-text-o"></i>
                                        </span>
                                    </div>
                                    <input v-model="safetyFormData.safety_abuser_name"
                                           v-validate="'required|name_with_number|max:50'"
                                           :class="[(vvErrors.has('safetyScope.safety_abuser_name') ? 'is-invalid' : '')]"
                                           class="form-control form-control-sm rounded-0"
                                           data-vv-as="abuser name" data-vv-name="safety_abuser_name"

                                           type="text">
                                    <div v-show="vvErrors.has('safetyScope.safety_abuser_name')"
                                         class="invalid-feedback">
                                        {{ vvErrors.first('safetyScope.safety_abuser_name') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button aria-label="Close" class="btn btn-sm btn-danger pull-left rounded-0"
                                        data-dismiss="modal" type="button">
                                    <span aria-hidden="true">Close</span>
                                </button>
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
        </div>
        <!-- Neighbour -->
        <div class="table-responsive">
            <table class="table table-responsive-sm table-sm table-striped table-hover">
                <caption style="color: #63c2de;font-size: 1.09375rem">Help From Neighbour
                    <button class="btn btn-brand btn-info btn-sm pull-right" @click="addNewNeighbour">
                        <i class="fa fa-plus"></i>
                        <span>Add New Neighbour Help</span>
                    </button>
                </caption>
                <thead>
                <tr>
                    <th>Neighbour Help Type</th>
                    <th style="width: 145px; text-align:center">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(item,index) in neighbourHelps" :key=index>
                    <td>{{ item.neighbour_help_type }}</td>
                    <td>
                        <button class="btn btn-xs btn-info rounded-0" @click="editNeighbour(item)">
                            <i class="fa fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-xs btn-danger rounded-0" @click="deleteNeighbour(item)">
                            <i class="fa fa-remove"></i> Delete
                        </button>
                    </td>
                </tr>
                <tr v-if="neighbourHelps.length === 0">
                    <td class="text-center" colspan="2">No Data Found</td>
                </tr>
                </tbody>
            </table>
        </div>
        <!-- Neighbour Create/Edit Modal -->
        <div id="neighbourCreateEditModal" aria-hidden="true" aria-labelledby="Neighbour Modal" class="modal fade"
             role="dialog" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content rounded-0">
                    <div class="modal-body">
                        <form class="form-horizontal" data-vv-scope="neighbourScope"
                              v-on:submit.prevent="submitNeighbour('neighbourScope')">
                            <div class="form-group row justify-content-center">
                                <h6 class="text-left col-sm-12">
                                    <strong v-if="createView">Add New Neighbour</strong>
                                    <strong v-else>Update Neighbour</strong>
                                </h6>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Neighbour Help Type<span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="fa fa-arrow-circle-down"></i>
                                        </span>
                                    </div>
                                    <select v-model.number="neighbourFormData.neighbour_help_type"
                                            v-validate="'required'"
                                            :class="[(vvErrors.has('neighbourScope.neighbour_help_type') ? 'is-invalid' : '')]"
                                            class="form-control form-control-sm rounded-0"
                                            data-vv-as="neighbour help type"
                                            data-vv-name="neighbour_help_type">
                                        <option value="">Select One</option>
                                        <option v-for="item in NEIGHBOUR_HELP_TYPES" :key="item"
                                                :value="item">
                                            {{ item }}
                                        </option>
                                    </select>
                                    <div v-show="vvErrors.has('neighbourScope.neighbour_help_type')"
                                         class="invalid-feedback">
                                        {{ vvErrors.first('neighbourScope.neighbour_help_type') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button aria-label="Close" class="btn btn-sm btn-danger pull-left rounded-0"
                                        data-dismiss="modal" type="button">
                                    <span aria-hidden="true">Close</span>
                                </button>
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
        </div>
        <!-- Rich -->
        <div class="table-responsive">
            <table class="table table-responsive-sm table-sm table-striped table-hover">
                <caption style="color: #321fdb;font-size: 1.09375rem">Help From Rich
                    <button class="btn btn-brand btn-primary btn-sm pull-right" @click="addNewRich">
                        <i class="fa fa-plus"></i>
                        <span>Add New Rich Help</span>
                    </button>
                </caption>
                <thead>
                <tr>
                    <th>Rich Help Type</th>
                    <th style="width: 145px; text-align:center">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(item,index) in richHelps" :key=index>
                    <td>{{ item.rich_help_type }}</td>
                    <td>
                        <button class="btn btn-xs btn-info rounded-0" @click="editRich(item)">
                            <i class="fa fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-xs btn-danger rounded-0" @click="deleteRich(item)">
                            <i class="fa fa-remove"></i> Delete
                        </button>
                    </td>
                </tr>
                <tr v-if="richHelps.length === 0">
                    <td class="text-center" colspan="2">No Data Found</td>
                </tr>
                </tbody>
            </table>
        </div>
        <!-- Rich Create/Edit Modal -->
        <div id="richCreateEditModal" aria-hidden="true" aria-labelledby="Rich Modal" class="modal fade"
             role="dialog" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content rounded-0">
                    <div class="modal-body">
                        <form class="form-horizontal" data-vv-scope="richScope"
                              v-on:submit.prevent="submitRich('richScope')">
                            <div class="form-group row justify-content-center">
                                <h6 class="text-left col-sm-12">
                                    <strong v-if="createView">Add New Rich</strong>
                                    <strong v-else>Update Rich</strong>
                                </h6>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Rich Help Type<span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="fa fa-arrow-circle-down"></i>
                                        </span>
                                    </div>
                                    <select v-model.number="richFormData.rich_help_type"
                                            v-validate="'required'"
                                            :class="[(vvErrors.has('richScope.rich_help_type') ? 'is-invalid' : '')]"
                                            class="form-control form-control-sm rounded-0"
                                            data-vv-as="rich help type"
                                            data-vv-name="rich_help_type">
                                        <option value="">Select One</option>
                                        <option v-for="item in RICH_HELP_TYPES" :key="item"
                                                :value="item"> {{ item }}
                                        </option>
                                    </select>
                                    <div v-show="vvErrors.has('richScope.rich_help_type')"
                                         class="invalid-feedback">
                                        {{ vvErrors.first('richScope.rich_help_type') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button aria-label="Close" class="btn btn-sm btn-danger pull-left rounded-0"
                                        data-dismiss="modal" type="button">
                                    <span aria-hidden="true">Close</span>
                                </button>
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
        </div>
        <!-- Conflict -->
        <div class="table-responsive">
            <table class="table table-responsive-sm table-sm table-striped table-hover">
                <caption style="color: #ffc107;font-size: 1.09375rem">Conflict Resolves
                    <button class="btn btn-brand btn-warning btn-sm pull-right" @click="addNewConflict">
                        <i class="fa fa-plus"></i>
                        <span>Add New Conflict Resolve</span>
                    </button>
                </caption>
                <thead>
                <tr>
                    <th>Conflict Resolve Type</th>
                    <th style="width: 145px; text-align:center">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(item,index) in conflictResolves" :key=index>
                    <td>{{ item.conflict_resolve_type }}</td>
                    <td>
                        <button class="btn btn-xs btn-info rounded-0" @click="editConflict(item)">
                            <i class="fa fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-xs btn-danger rounded-0" @click="deleteConflict(item)">
                            <i class="fa fa-remove"></i> Delete
                        </button>
                    </td>
                </tr>
                <tr v-if="conflictResolves.length === 0">
                    <td class="text-center" colspan="2">No Data Found</td>
                </tr>
                </tbody>
            </table>
        </div>
        <!-- Conflict Create/Edit Modal -->
        <div id="conflictCreateEditModal" aria-hidden="true" aria-labelledby="Conflict Modal" class="modal fade"
             role="dialog" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content rounded-0">
                    <div class="modal-body">
                        <form class="form-horizontal" data-vv-scope="conflictScope"
                              v-on:submit.prevent="submitConflict('conflictScope')">
                            <div class="form-group row justify-content-center">
                                <h6 class="text-left col-sm-12">
                                    <strong v-if="createView">Add New Conflict</strong>
                                    <strong v-else>Update Conflict</strong>
                                </h6>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Conflict Resolve Type<span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="fa fa-arrow-circle-down"></i>
                                        </span>
                                    </div>
                                    <select v-model.number="conflictFormData.conflict_resolve_type"
                                            v-validate="'required'"
                                            :class="[(vvErrors.has('conflictScope.conflict_resolve_type') ? 'is-invalid' : '')]"
                                            class="form-control form-control-sm rounded-0"
                                            data-vv-as="conflict resolve type"
                                            data-vv-name="conflict_resolve_type">
                                        <option value="">Select One</option>
                                        <option v-for="item in RESOLVE_TYPES" :key="item"
                                                :value="item"> {{ item }}
                                        </option>
                                    </select>
                                    <div v-show="vvErrors.has('conflictScope.conflict_resolve_type')"
                                         class="invalid-feedback">
                                        {{ vvErrors.first('conflictScope.conflict_resolve_type') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button aria-label="Close" class="btn btn-sm btn-danger pull-left rounded-0"
                                        data-dismiss="modal" type="button">
                                    <span aria-hidden="true">Close</span>
                                </button>
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
        </div>
    </div>
</template>

<script>
export default {
    name: "SafetyEditC",
    data() {
        return {
            //common
            createView: true,
            //Safety
            ABUSER_RELATION_TYPES: [],
            ABUSE_TYPES: [],
            safeties: [],
            safetyFormData: {
                id: '',
                safety_victim_name: '',
                safety_relation_with_abuser: '',
                safety_type_of_abuse: '',
                safety_place_of_abuse: '',
                safety_abuser_name: '',
            },
            //Neighbour
            neighbourHelps: [],
            NEIGHBOUR_HELP_TYPES: [],
            neighbourFormData: {
                id: '',
                neighbour_help_type: '',
            },
            //Rich
            richHelps: [],
            RICH_HELP_TYPES: [],
            richFormData: {
                id: '',
                rich_help_type: '',
            },
            //Conflict
            conflictResolves: [],
            RESOLVE_TYPES: [],
            conflictFormData: {
                id: '',
                conflict_resolve_type: '',
            },
        }
    },
    methods: {
        /* Safety */
        addNewSafety() {
            this.createView = true;
            this.safetyFormData = {};
            this.safetyFormData.safety_victim_name = "";
            this.safetyFormData.safety_relation_with_abuser = "";
            this.safetyFormData.safety_type_of_abuse = "";
            this.safetyFormData.safety_place_of_abuse = "";
            this.safetyFormData.safety_abuser_name = "";
            this.$validator.reset();
            $("#safetyCreateEditModal").modal({show: true, backdrop: "static"});
        },
        editSafety(item) {
            this.createView = false;
            this.safetyFormData = {};
            this.safetyFormData.id = item.id;
            this.safetyFormData.safety_victim_name = item.safety_victim_name;
            this.safetyFormData.safety_relation_with_abuser = item.safety_relation_with_abuser;
            this.safetyFormData.safety_type_of_abuse = item.safety_type_of_abuse;
            this.safetyFormData.safety_place_of_abuse = item.safety_place_of_abuse;
            this.safetyFormData.safety_abuser_name = item.safety_abuser_name;
            this.$validator.reset();
            $("#safetyCreateEditModal").modal({show: true, backdrop: "static"});
        },
        deleteSafety(item) {
            let _this = this;
            Swal.fire({
                title: "Are you sure to delete?",
                html: `<p style="color:#3085d6">${item.safety_victim_name}</p>You won't be able to revert this!`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#2778c4",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    _this.loading = true;
                    _this.errors = {};
                    axios.delete(this.$parent.routes.safety + "/" + item.id).then((res) => {
                        if (res.data.success) {
                            Swal.fire("Deleted!", res.data.success, "success");
                            _this.getAllSafeties();
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
        submitSafety(scope) {
            let _this = this;
            _this.$validator.validateAll(scope).then((result) => {
                if (result && _this.createView) {
                    _this._addSafety();
                } else if (result && !_this.createView) {
                    _this._updateSafety();
                }
            });
        },
        _addSafety() {
            let _this = this;
            _this.loading = true;
            axios.post(this.$parent.routes.safety, _this.safetyFormData).then((res) => {
                if (res.data.success) {
                    toastr.success(res.data.success, "Success");
                    _this.getAllSafeties();
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
        _updateSafety() {
            let _this = this;
            _this.loading = true;
            axios.put(this.$parent.routes.safety + "/" + _this.safetyFormData.id, _this.safetyFormData).then((res) => {
                if (res.data.success) {
                    toastr.success(res.data.success, "Success");
                    _this.getAllSafeties();
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
        getAllSafeties() {
            let _this = this;
            _this.formView = false;
            _this.loading = true;
            _this.createView = true;
            axios.get(this.$parent.routes.safety).then((res) => {
                if (res.data) {
                    _this.safeties = res.data.lists;
                    _this.ABUSER_RELATION_TYPES = res.data.ABUSER_RELATION_TYPES;
                    _this.ABUSE_TYPES = res.data.ABUSE_TYPES;
                    $('#safetyCreateEditModal').modal('hide');
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
        /* Neighbour */
        editNeighbour(item) {
            this.createView = false;
            this.neighbourFormData = {};
            this.neighbourFormData.id = item.id;
            this.neighbourFormData.neighbour_help_type = item.neighbour_help_type;
            this.$validator.reset();
            $("#neighbourCreateEditModal").modal({show: true, backdrop: "static"});
        },
        addNewNeighbour() {
            this.createView = true;
            this.neighbourFormData = {};
            this.neighbourFormData.neighbour_help_type = "";
            this.$validator.reset();
            $("#neighbourCreateEditModal").modal({show: true, backdrop: "static"});
        },
        deleteNeighbour(item) {
            let _this = this;
            Swal.fire({
                title: "Are you sure to delete?",
                html: `<p style="color:#3085d6">${item.neighbour_help_type}</p>You won't be able to revert this!`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#2778c4",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    _this.loading = true;
                    _this.errors = {};
                    axios.delete(this.$parent.routes.neighbour + "/" + item.id).then((res) => {
                        if (res.data.success) {
                            Swal.fire("Deleted!", res.data.success, "success");
                            _this.getAllNeighbourHelps();
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
        submitNeighbour(scope) {
            let _this = this;
            _this.$validator.validateAll(scope).then((result) => {
                if (result && _this.createView) {
                    _this._addNeighbour();
                } else if (result && !_this.createView) {
                    _this._updateNeighbour();
                }
            });
        },
        _addNeighbour() {
            let _this = this;
            _this.loading = true;
            axios.post(this.$parent.routes.neighbour, _this.neighbourFormData).then((res) => {
                if (res.data.success) {
                    toastr.success(res.data.success, "Success");
                    _this.getAllNeighbourHelps();
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
        _updateNeighbour() {
            let _this = this;
            _this.loading = true;
            axios.put(this.$parent.routes.neighbour + "/" + _this.neighbourFormData.id, _this.neighbourFormData).then((res) => {
                if (res.data.success) {
                    toastr.success(res.data.success, "Success");
                    _this.getAllNeighbourHelps();
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
        getAllNeighbourHelps() {
            let _this = this;
            _this.formView = false;
            // this.$parent.loading = true;
            _this.createView = true;
            _this.neighbourFormData = {};
            axios.get(this.$parent.routes.neighbour).then((res) => {
                if (res.data) {
                    _this.neighbourHelps = res.data.lists;
                    _this.NEIGHBOUR_HELP_TYPES = res.data.NEIGHBOUR_HELP_TYPES;
                    $('#neighbourCreateEditModal').modal('hide');
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
        /* Rich */
        editRich(item) {
            this.createView = false;
            this.richFormData = {};
            this.richFormData.id = item.id;
            this.richFormData.rich_help_type = item.rich_help_type;
            this.$validator.reset();
            $("#richCreateEditModal").modal({show: true, backdrop: "static"});
        },
        addNewRich() {
            this.createView = true;
            this.richFormData = {};
            this.richFormData.rich_help_type = "";
            this.$validator.reset();
            $("#richCreateEditModal").modal({show: true, backdrop: "static"});
        },
        deleteRich(item) {
            let _this = this;
            Swal.fire({
                title: "Are you sure to delete?",
                html: `<p style="color:#3085d6">${item.rich_help_type}</p>You won't be able to revert this!`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#2778c4",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    _this.loading = true;
                    _this.errors = {};
                    axios.delete(this.$parent.routes.rich + "/" + item.id).then((res) => {
                        if (res.data.success) {
                            Swal.fire("Deleted!", res.data.success, "success");
                            _this.getAllRichHelps();
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
        submitRich(scope) {
            let _this = this;
            _this.$validator.validateAll(scope).then((result) => {
                if (result && _this.createView) {
                    _this._addRich();
                } else if (result && !_this.createView) {
                    _this._updateRich();
                }
            });
        },
        _addRich() {
            let _this = this;
            _this.loading = true;
            axios.post(this.$parent.routes.rich, _this.richFormData).then((res) => {
                if (res.data.success) {
                    toastr.success(res.data.success, "Success");
                    _this.getAllRichHelps();
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
        _updateRich() {
            let _this = this;
            _this.loading = true;
            axios.put(this.$parent.routes.rich + "/" + _this.richFormData.id, _this.richFormData).then((res) => {
                if (res.data.success) {
                    toastr.success(res.data.success, "Success");
                    _this.getAllRichHelps();
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
        getAllRichHelps() {
            let _this = this;
            _this.formView = false;
            // this.$parent.loading = true;
            _this.createView = true;
            _this.richFormData = {};
            axios.get(this.$parent.routes.rich).then((res) => {
                if (res.data) {
                    _this.richHelps = res.data.lists;
                    _this.RICH_HELP_TYPES = res.data.RICH_HELP_TYPES;
                    $('#richCreateEditModal').modal('hide');
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
        /* Conflict */
        editConflict(item) {
            this.createView = false;
            this.conflictFormData = {};
            this.conflictFormData.id = item.id;
            this.conflictFormData.conflict_resolve_type = item.conflict_resolve_type;
            this.$validator.reset();
            $("#conflictCreateEditModal").modal({show: true, backdrop: "static"});
        },
        addNewConflict() {
            this.createView = true;
            this.conflictFormData = {};
            this.conflictFormData.conflict_resolve_type = "";
            this.$validator.reset();
            $("#conflictCreateEditModal").modal({show: true, backdrop: "static"});
        },
        deleteConflict(item) {
            let _this = this;
            Swal.fire({
                title: "Are you sure to delete?",
                html: `<p style="color:#3085d6">${item.conflict_resolve_type}</p>You won't be able to revert this!`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#2778c4",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    _this.loading = true;
                    _this.errors = {};
                    axios.delete(this.$parent.routes.conflict + "/" + item.id).then((res) => {
                        if (res.data.success) {
                            Swal.fire("Deleted!", res.data.success, "success");
                            _this.getAllConflictHelps();
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
        submitConflict(scope) {
            let _this = this;
            _this.$validator.validateAll(scope).then((result) => {
                if (result && _this.createView) {
                    _this._addConflict();
                } else if (result && !_this.createView) {
                    _this._updateConflict();
                }
            });
        },
        _addConflict() {
            let _this = this;
            _this.loading = true;
            axios.post(this.$parent.routes.conflict, _this.conflictFormData).then((res) => {
                if (res.data.success) {
                    toastr.success(res.data.success, "Success");
                    _this.getAllConflictHelps();
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
        _updateConflict() {
            let _this = this;
            _this.loading = true;
            axios.put(this.$parent.routes.conflict + "/" + _this.conflictFormData.id, _this.conflictFormData).then((res) => {
                if (res.data.success) {
                    toastr.success(res.data.success, "Success");
                    _this.getAllConflictHelps();
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
        getAllConflictHelps() {
            let _this = this;
            _this.formView = false;
            // this.$parent.loading = true;
            _this.createView = true;
            _this.conflictFormData = {};
            axios.get(this.$parent.routes.conflict).then((res) => {
                if (res.data) {
                    _this.conflictResolves = res.data.lists;
                    _this.RESOLVE_TYPES = res.data.RESOLVE_TYPES;
                    $('#conflictCreateEditModal').modal('hide');
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
        this.getAllSafeties();
        this.getAllNeighbourHelps();
        this.getAllRichHelps();
        this.getAllConflictHelps();
    }
}
</script>

<style scoped>

</style>
