<template>
    <div class="container">
        <div class="card-body">
            <div v-if="$parent.formData.familyOtherNgos.length > 0" class="table-responsive">
                <table class="table table-sm table-stripe">
                    <thead class="bg-gray-100">
                    <tr>
                        <th>Name</th>
                        <th>Help Type</th>
                        <th>Remarks</th>
                        <th style="width: 70px; text-align: center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(item,index) in $parent.formData.familyOtherNgos" :key="index">
                        <td class="text-capitalize">{{ item.ngo_name }}</td>
                        <td class="text-capitalize">{{ item.ngo_help_type }}</td>
                        <td class="text-capitalize">{{ item.ngo_remarks }}</td>
                        <td>
                            <button class="btn btn-xs btn-danger rounded-0"
                                    @click="requestRemoveNgo(item.ngo_name, index)">
                                <i class="fa fa-remove"></i>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <small class="text-danger">
                    * {{ maxCount - $parent.formData.familyOtherNgos.length }} ngo remaining!
                </small>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <form @submit.prevent="onSubmit()">
                        <div v-if="$parent.formData.familyOtherNgos.length < maxCount" class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group p-0 m-0">
                                    <label class="mb-0 pl-1">NGO/Organization Name<span
                                        class="text-danger">*</span></label>
                                    <input v-model="localData.ngo_name"
                                           v-validate="'required|name|min:2|max:150'"
                                           :class="[(vvErrors.has('ngo_name') ? 'is-invalid' : '')]"
                                           class="form-control form-control-sm rounded-0"
                                           data-vv-as="Ngo name"
                                           data-vv-name="ngo_name" type="text">
                                    <div v-show="vvErrors.has('ngo_name')" class="invalid-feedback">
                                        {{ vvErrors.first("ngo_name") }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group p-0 m-0">
                                    <label class="mb-0 pl-1">Help/Engagement Type<span
                                        class="text-danger">*</span></label>
                                    <select v-model.number="localData.ngo_help_type" v-validate="'required'"
                                            :class="[this.vvErrors.has('ngo_help_type') ? 'is-invalid' : '']"
                                            class="form-control form-control-sm rounded-0"
                                            data-vv-as="Help Type"
                                            data-vv-name="ngo_help_type">
                                        <option value="">Select One</option>
                                        <option v-for="(item,index) in $parent.initData.ngoHelpTypes" :key="index"
                                                :value="item">
                                            {{ item }}
                                        </option>
                                    </select>
                                    <div v-show="vvErrors.has('ngo_help_type')" class="invalid-feedback">
                                        {{ vvErrors.first("ngo_help_type") }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group p-0 m-0">
                                    <label class="mb-0 pl-1">Remarks</label>
                                    <textarea v-model="localData.ngo_remarks" v-validate="'min:2|max:998'"
                                              :class="[(vvErrors.has('ngo_remarks') ? 'is-invalid' : '')]"
                                              class="form-control form-control-sm rounded-0"
                                              data-vv-as="ngo remarks"
                                              data-vv-name="ngo_remarks"
                                              type="text"></textarea>
                                    <div v-show="vvErrors.has('ngo_remarks')" class="invalid-feedback">
                                        {{ vvErrors.first("ngo_remarks") }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 form-group mt-3">
                                <button class="btn btn-brand btn-sm btn-czm-green pull-left" style="margin-bottom: 4px"
                                        type="submit">
                                    <i class="fa fa-plus"></i>
                                    <span>Add Engagement</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "NgoCreateC",
    data() {
        return {
            localData: {
                ngo_name: "",
                ngo_help_type: "",
                ngo_remarks: "",
            },
            maxCount: 10,
        };
    },
    methods: {
        onSubmit() {
            let _this = this;
            _this.$validator.validateAll().then((result) => {
                if (result) {
                    _this.addNgo();
                } else {
                    _this.errors = _this.vvErrors.collect();
                }
            });
        },
        addNgo() {
            let _this = this;
            _this.$parent.formData.familyOtherNgos.push(_this.localData);
            _this.localData = {};
            _this.localData.ngo_name = "";
            _this.localData.ngo_help_type = "";
            _this.localData.ngo_remarks = "";
            _this.$nextTick(() => {
                _this.$validator.reset();
                _this.errors = {};
            });
        },
        requestRemoveNgo(ngoName, index) {
            let _this = this;
            Swal.fire({
                title: "Are you sure?",
                html: '<p style="color:#3085d6">"' + ngoName + '"</p>' + "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, Remove it!",
            }).then((result) => {
                if (result.value) {
                    _this.removeNgo(index);
                }
            });
        },
        removeNgo(index) {
            let _this = this;
            _this.$parent.formData.familyOtherNgos.splice(index, 1);
        },
    },
    filters: {
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
