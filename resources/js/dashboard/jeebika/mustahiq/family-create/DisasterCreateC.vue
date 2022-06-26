<template>
    <div class="container">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="form-group p-0 m-0">
                        <label class="czm-xs">Effect In Disaster<span class="text-danger">*</span></label>
                        <div class="form-check form-check-inline">
                            <input id="disaster_true" v-model="disaster_effect" class="form-check-input"
                                   name="disaster" type="radio" value="true" @change="checkDisaster">
                            <label class="form-check-label" for="disaster_true">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input id="disaster_false" v-model="disaster_effect" class="form-check-input"
                                   name="disaster" type="radio" value="false" @change="checkDisaster">
                            <label class="form-check-label" for="disaster_false">No</label>
                        </div>
                    </div>
                    <div v-if="$parent.formData.familyDisasters.length > 0" class="table-responsive">
                        <table class="table table-sm table-stripe">
                            <thead class="bg-gray-100">
                            <tr>
                                <th>Type Of Disaster</th>
                                <th>Level Of Disaster</th>
                                <th>How to Recover</th>
                                <th style="width: 70px; text-align: center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(item,index) in $parent.formData.familyDisasters" :key="index">
                                <td>{{ getDisasterName(item.disaster_id) }}</td>
                                <td> {{ item.disaster_level }}</td>
                                <td>{{ getRecoverName(item.disaster_recover_id) }}</td>
                                <td>
                                    <button class="btn btn-xs btn-danger rounded-0"
                                            @click="requestRemoveDisaster(item.disaster_id,index)">
                                        <i class="fa fa-remove"></i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <small class="text-danger">
                            * {{ maxCount - $parent.formData.familyDisasters.length }} disaster remaining!
                        </small>
                    </div>
                    <div v-show="disasterFlag">
                        <form @submit.prevent="onSubmit()">
                            <div v-if="$parent.formData.familyDisasters.length < maxCount" class="row">
                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group p-0 m-0">
                                        <label class="czm-xs">Disaster Type<span class="text-danger">*</span></label>
                                        <select v-model="localData.disaster_id"
                                                v-validate="'required'"
                                                :class="[this.vvErrors.has('disaster_id') ? 'is-invalid' : '']"
                                                class="form-control form-control-sm rounded-0"
                                                data-vv-as="Type of disaster"
                                                data-vv-name="disaster_id">
                                            <option value="">Select One</option>
                                            <option v-for="item in $parent.initData.disasters" :key="item.id"
                                                    :value="item.id">
                                                {{ item.name }}
                                            </option>
                                        </select>
                                        <div v-show="vvErrors.has('disaster_id')" class="invalid-feedback">
                                            {{ vvErrors.first("disaster_id") }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group p-0 m-0">
                                        <label class="czm-xs">Disaster Level<span
                                            class="text-danger">*</span></label>
                                        <select v-model="localData.disaster_level"
                                                v-validate="'required'"
                                                :class="[this.vvErrors.has('disaster_level') ? 'is-invalid' : '']"
                                                class="form-control form-control-sm rounded-0"
                                                data-vv-as="level of disaster"
                                                data-vv-name="disaster_level">
                                            <option value="">Select One</option>
                                            <option v-for="(item,index) in $parent.initData.disasterLevels" :key="index"
                                                    :value="item">
                                                {{ item }}
                                            </option>
                                        </select>
                                        <div v-show="vvErrors.has('disaster_level')" class="invalid-feedback">
                                            {{ vvErrors.first("disaster_level") }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group p-0 m-0">
                                        <label class="czm-xs">How You Recover<span class="text-danger">*</span></label>
                                        <select v-model="localData.disaster_recover_id"
                                                v-validate="'required'"
                                                :class="[this.vvErrors.has('disaster_recover_id') ? 'is-invalid' : '']"
                                                class="form-control form-control-sm rounded-0"
                                                data-vv-as="How You Recover"
                                                data-vv-name="disaster_recover_id">
                                            <option value="">Select One</option>
                                            <option v-for="item in $parent.initData.recoveries" :key="item.id"
                                                    :value="item.id">
                                                {{ item.name }}
                                            </option>
                                        </select>
                                        <div v-show="vvErrors.has('disaster_recover_id')" class="invalid-feedback">
                                            {{ vvErrors.first("disaster_recover_id") }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-4 col-md-4 d-inline-block mt-3">
                                    <button class="btn btn-brand btn-sm btn-czm-green pull-left"
                                            style="margin-bottom: 4px"
                                            type="submit">
                                        <i class="fa fa-plus"></i>
                                        <span>Add Disaster</span>
                                    </button>
                                </div>
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
    name: "DisasterCreateC",
    data() {
        return {
            errors: {},
            maxCount: 10,
            disasterFlag: false,
            disaster_effect: 'false',
            localData: {
                disaster_id: "",
                disaster_level: "",
                disaster_recover_id: "",
            },
        };
    },
    methods: {
        onSubmit() {
            let _this = this;
            _this.$validator.validateAll().then((result) => {
                if (result) {
                    _this.addDisaster();
                } else {
                    _this.errors = _this.vvErrors.collect();
                }
            });
        },
        getDisasterName(id) {
            let _this = this;
            let name = "";
            _this.$parent.initData.disasters.forEach((item) => {
                if (item.id == id) {
                    name = item.name;
                }
            });
            return name;
        },
        getRecoverName(id) {
            let _this = this;
            let name = "";
            _this.$parent.initData.recoveries.forEach((item) => {
                if (item.id == id) {
                    name = item.name;
                }
            });
            return name;
        },
        addDisaster() {
            let _this = this;
            _this.$parent.formData.familyDisasters.push(_this.localData);
            _this.localData = {};
            _this.localData.disaster_id = "";
            _this.localData.disaster_level = "";
            _this.localData.disaster_recover_id = "";
            _this.$nextTick(() => {
                _this.$validator.reset();
                _this.errors = {};
            });
        },
        checkDisaster() {
            let _this = this;
            _this.$parent.formData.familyDisasters = [];
            _this.disasterFlag = _this.disaster_effect === "true";
        },
        requestRemoveDisaster(disasterId, index) {
            let _this = this;
            Swal.fire({
                title: "Are you sure?",
                html: '<p style="color:#3085d6">"' + _this.getDisasterName(disasterId) + '"</p>' + "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, Remove it!",
            }).then((result) => {
                if (result.value) {
                    _this.removeDisaster(index);
                }
            });
        },
        removeDisaster(index) {
            let _this = this;
            _this.$parent.formData.familyDisasters.splice(index, 1);
            _this.$nextTick(() => {
                _this.$validator.reset();
            });
        },
    },
};
</script>
<style scoped>
</style>
