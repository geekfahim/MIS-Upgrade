<template>
    <div>
        <!-- NGO -->
        <div class="table-responsive">
            <table class="table table-responsive-sm table-sm table-striped table-hover">
                <caption style="color: #4dbd74;font-size: 1.09375rem">Ngos
                    <button class="btn btn-brand btn-success btn-sm pull-right" @click="addNewNgo">
                        <i class="fa fa-plus"></i>
                        <span>Add New Ngo</span>
                    </button>
                </caption>
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Help Type</th>
                    <th>Remarks</th>
                    <th style="width: 145px; text-align:center">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(item,index) in ngos" :key=index>
                    <td>{{ item.ngo_name }}</td>
                    <td>{{ item.ngo_help_type }}</td>
                    <td>{{ item.ngo_remarks }}</td>
                    <td>
                        <button class="btn btn-xs btn-info rounded-0" @click="editNgo(item)">
                            <i class="fa fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-xs btn-danger rounded-0" @click="deleteNgo(item)">
                            <i class="fa fa-remove"></i> Delete
                        </button>
                    </td>
                </tr>
                <tr v-if="ngos.length === 0">
                    <td class="text-center" colspan="4">No Data Found</td>
                </tr>
                </tbody>
            </table>
        </div>
        <!-- NGO Create/Edit Modal -->
        <div id="ngoCreateEditModal" aria-hidden="true" aria-labelledby="Ngo Modal" class="modal fade" role="dialog"
             tabindex="-1">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content rounded-0">
                    <div class="modal-body">
                        <form class="form-horizontal" v-on:submit.prevent="submitNgo()">
                            <div class="form-group row justify-content-center">
                                <h6 class="text-left col-sm-12">
                                    <strong v-if="createView">Add New Ngo</strong>
                                    <strong v-else>Update Ngo</strong>
                                </h6>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Name</label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="fa fa-file-text-o"></i>
                                        </span>
                                    </div>
                                    <input v-model="ngoFormData.ngo_name"
                                           v-validate="'required|name_with_number|max:50'"
                                           :class="[(vvErrors.has('ngo_name') ? 'is-invalid' : '')]"
                                           class="form-control form-control-sm rounded-0"
                                           data-vv-as="name" data-vv-name="ngo_name"
                                           type="text">
                                    <div v-show="vvErrors.has('ngo_name')" class="invalid-feedback">
                                        {{ vvErrors.first('ngo_name') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Help Type<span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="fa fa-arrow-circle-down"></i>
                                        </span>
                                    </div>
                                    <select v-model.number="ngoFormData.ngo_help_type" v-validate="'required'"
                                            :class="[(vvErrors.has('ngo_help_type') ? 'is-invalid' : '')]"
                                            class="form-control form-control-sm rounded-0"
                                            data-vv-as="help type"
                                            data-vv-name="ngo_help_type">
                                        <option value="">Select One</option>
                                        <option v-for="item in HELP_TYPES" :key="item" :value="item">
                                            {{ item }}
                                        </option>
                                    </select>
                                    <div v-show="vvErrors.has('ngo_help_type')" class="invalid-feedback">
                                        {{ vvErrors.first('ngo_help_type') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Remarks</label>
                                <textarea v-model="ngoFormData.ngo_remarks" v-validate="'name_with_number|max:900'"
                                          :class="[(vvErrors.has('ngo_remarks') ? 'is-invalid' : '')]"
                                          class="form-control form-control-sm rounded-0"
                                          cols="4"
                                          data-vv-as="remarks" data-vv-name="ngo_remarks"
                                          placeholder="type here"></textarea>
                                <div v-show="vvErrors.has('ngo_remarks')" class="invalid-feedback">
                                    {{ vvErrors.first('ngo_remarks') }}
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
    name: "NgoEditC",
    data() {
        return {
            createView: true,
            HELP_TYPES: [],
            ngos: [],
            ngoFormData: {
                id: '',
                ngo_name: '',
                ngo_help_type: '',
                ngo_remarks: '',
            }
        }
    },
    methods: {
        editNgo(item) {
            this.createView = false;
            this.ngoFormData = {};
            this.ngoFormData.id = item.id;
            this.ngoFormData.ngo_name = item.ngo_name;
            this.ngoFormData.ngo_help_type = item.ngo_help_type;
            this.ngoFormData.ngo_remarks = item.ngo_remarks;
            this.$validator.reset();
            $("#ngoCreateEditModal").modal({show: true, backdrop: "static"});
        },
        deleteNgo(item) {
            let _this = this;
            Swal.fire({
                title: "Are you sure to delete?",
                html: `<p style="color:#3085d6">${item.ngo_name}</p>You won't be able to revert this!`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#2778c4",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    _this.loading = true;
                    _this.errors = {};
                    axios.delete(this.$parent.routes.ngo + "/" + item.id).then((res) => {
                        if (res.data.success) {
                            Swal.fire("Deleted!", res.data.success, "success");
                            _this.getAllNgos();
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
        submitNgo(scope) {
            let _this = this;
            _this.$validator.validateAll(scope).then((result) => {
                if (result && _this.createView) {
                    _this._addNgo();
                } else if (result && !_this.createView) {
                    _this._updateNgo();
                }
            });
        },
        _addNgo() {
            let _this = this;
            _this.loading = true;
            axios.post(this.$parent.routes.ngo, _this.ngoFormData).then((res) => {
                if (res.data.success) {
                    toastr.success(res.data.success, "Success");
                    _this.getAllNgos();
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
        _updateNgo() {
            let _this = this;
            _this.loading = true;
            axios.put(this.$parent.routes.ngo + "/" + _this.ngoFormData.id, _this.ngoFormData).then((res) => {
                if (res.data.success) {
                    toastr.success(res.data.success, "Success");
                    _this.getAllNgos();
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
        addNewNgo() {
            this.createView = true;
            this.ngoFormData = {};
            this.ngoFormData.ngo_name = "";
            this.ngoFormData.ngo_help_type = "";
            this.ngoFormData.ngo_remarks = "";
            this.$validator.reset();
            $("#ngoCreateEditModal").modal({show: true, backdrop: "static"});
        },
        getAllNgos() {
            let _this = this;
            _this.formView = false;
            // this.$parent.loading = true;
            _this.createView = true;
            _this.ngoFormData = {};
            axios.get(this.$parent.routes.ngo).then((res) => {
                if (res.data) {
                    _this.ngos = res.data.lists;
                    _this.HELP_TYPES = res.data.HELP_TYPES;
                    $('#ngoCreateEditModal').modal('hide');
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
        this.getAllNgos();
    }
}
</script>

<style scoped>

</style>
