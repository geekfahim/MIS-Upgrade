<template>
    <div>
        <!-- Disaster -->
        <div class="table-responsive">
            <table class="table table-responsive-sm table-sm table-striped table-hover">
                <caption style="color: #4dbd74;font-size: 1.09375rem">Disasters
                    <button class="btn btn-brand btn-success btn-sm pull-right" @click="addNewDisaster">
                        <i class="fa fa-plus"></i>
                        <span>Add New Disaster</span>
                    </button>
                </caption>
                <thead>
                <tr>
                    <th>Disaster</th>
                    <th>Level</th>
                    <th>Recovery</th>
                    <th style="width: 145px; text-align:center">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(item,index) in disasters" :key=index>
                    <td>{{ item.disaster ? item.disaster.name : '' }}</td>
                    <td>{{ item.disaster_level }}</td>
                    <td>{{ item.recover ? item.recover.name : '' }}</td>
                    <td>
                        <button class="btn btn-xs btn-info rounded-0" @click="editDisaster(item)">
                            <i class="fa fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-xs btn-danger rounded-0" @click="deleteDisaster(item)">
                            <i class="fa fa-remove"></i> Delete
                        </button>
                    </td>
                </tr>
                <tr v-if="disasters.length === 0">
                    <td class="text-center" colspan="4">No Data Found</td>
                </tr>
                </tbody>
            </table>
        </div>
        <!-- Disaster Create/Edit Modal -->
        <div id="disasterCreateEditModal" aria-hidden="true" aria-labelledby="Disaster Modal" class="modal fade"
             role="dialog"
             tabindex="-1">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content rounded-0">
                    <div class="modal-body">
                        <form class="form-horizontal" v-on:submit.prevent="submitDisaster()">
                            <div class="form-group row justify-content-center">
                                <h6 class="text-left col-sm-12">
                                    <strong v-if="createView">Add New Disaster</strong>
                                    <strong v-else>Update Disaster</strong>
                                </h6>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Disaster<span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="fa fa-arrow-circle-down"></i>
                                        </span>
                                    </div>
                                    <select v-model.number="disasterFormData.disaster_id" v-validate="'required'"
                                            :class="[(vvErrors.has('disaster_id') ? 'is-invalid' : '')]"
                                            class="form-control form-control-sm rounded-0"
                                            data-vv-as="disaster"
                                            data-vv-name="disaster_id">
                                        <option value="">Select One</option>
                                        <option v-for="(item,index) in sourceDisasters" :key="index" :value="item.id">
                                            {{ item.name }}
                                        </option>
                                    </select>
                                    <div v-show="vvErrors.has('disaster_id')" class="invalid-feedback">
                                        {{ vvErrors.first('disaster_id') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Level<span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="fa fa-arrow-circle-down"></i>
                                        </span>
                                    </div>
                                    <select v-model.number="disasterFormData.disaster_level" v-validate="'required'"
                                            :class="[(vvErrors.has('disaster_level') ? 'is-invalid' : '')]"
                                            class="form-control form-control-sm rounded-0"
                                            data-vv-as="level"
                                            data-vv-name="disaster_level">
                                        <option value="">Select One</option>
                                        <option v-for="item in LEVELS" :key="item" :value="item">
                                            {{ item }}
                                        </option>
                                    </select>
                                    <div v-show="vvErrors.has('disaster_level')" class="invalid-feedback">
                                        {{ vvErrors.first('disaster_level') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Recovery<span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="fa fa-arrow-circle-down"></i>
                                        </span>
                                    </div>
                                    <select v-model.number="disasterFormData.recover_id" v-validate="'required'"
                                            :class="[(vvErrors.has('recover_id') ? 'is-invalid' : '')]"
                                            class="form-control form-control-sm rounded-0"
                                            data-vv-as="recover"
                                            data-vv-name="recover_id">
                                        <option value="">Select One</option>
                                        <option v-for="(item,index) in sourceRecoveries" :key="index" :value="item.id">
                                            {{ item.name }}
                                        </option>
                                    </select>
                                    <div v-show="vvErrors.has('recover_id')" class="invalid-feedback">
                                        {{ vvErrors.first('recover_id') }}
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
    name: "DisasterEditC",
    data() {
        return {
            createView: true,
            LEVELS: [],
            disasters: [],
            disasterFormData: {
                id: '',
                disaster_id: '',
                disaster_level: '',
                recover_id: '',
            },
            sourceDisasters: [],
            sourceRecoveries: [],
        }
    },
    methods: {
        editDisaster(item) {
            this.createView = false;
            this.disasterFormData = {};
            this.disasterFormData.id = item.id;
            this.disasterFormData.disaster_id = item.disaster_id;
            this.disasterFormData.disaster_level = item.disaster_level;
            this.disasterFormData.recover_id = item.recover_id;
            this.$validator.reset();
            $("#disasterCreateEditModal").modal({show: true, backdrop: "static"});
        },
        deleteDisaster(item) {
            let _this = this;
            Swal.fire({
                title: "Are you sure to delete?",
                html: `You won't be able to revert this!`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#2778c4",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    _this.loading = true;
                    _this.errors = {};
                    axios.delete(this.$parent.routes.disaster + "/" + item.id).then((res) => {
                        if (res.data.success) {
                            Swal.fire("Deleted!", res.data.success, "success");
                            _this.getAllDisasters();
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
        submitDisaster(scope) {
            let _this = this;
            _this.$validator.validateAll(scope).then((result) => {
                if (result && _this.createView) {
                    _this._addDisaster();
                } else if (result && !_this.createView) {
                    _this._updateDisaster();
                }
            });
        },
        _addDisaster() {
            let _this = this;
            _this.loading = true;
            axios.post(this.$parent.routes.disaster, _this.disasterFormData).then((res) => {
                if (res.data.success) {
                    toastr.success(res.data.success, "Success");
                    _this.getAllDisasters();
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
        _updateDisaster() {
            let _this = this;
            _this.loading = true;
            axios.put(this.$parent.routes.disaster + "/" + _this.disasterFormData.id, _this.disasterFormData).then((res) => {
                if (res.data.success) {
                    toastr.success(res.data.success, "Success");
                    _this.getAllDisasters();
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
        addNewDisaster() {
            this.createView = true;
            this.disasterFormData = {};
            this.disasterFormData.disaster_id = "";
            this.disasterFormData.disaster_level = "";
            this.disasterFormData.recover_id = "";
            this.$validator.reset();
            $("#disasterCreateEditModal").modal({show: true, backdrop: "static"});
        },
        getAllDisasters() {
            let _this = this;
            _this.formView = false;
            // this.$parent.loading = true;
            _this.createView = true;
            _this.disasterFormData = {};
            axios.get(this.$parent.routes.disaster).then((res) => {
                if (res.data) {
                    _this.disasters = res.data.lists;
                    _this.LEVELS = res.data.LEVELS;
                    _this.sourceDisasters = res.data.sourceDisasters;
                    _this.sourceRecoveries = res.data.sourceRecoveries;
                    $('#disasterCreateEditModal').modal('hide');
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
        this.getAllDisasters();
    }
}
</script>

<style scoped>

</style>
