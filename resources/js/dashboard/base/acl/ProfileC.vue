<template>
    <div class="position-relative">
        <div class="card-header">
            <i class="fa fa-list"></i>
            Change Information
        </div>
        <div class="card-body">
            <div class="col-md-8 col-sm-12 justify-content-center">
                <div class=" row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group p-0 m-0">
                            <label class="czm-xs"> Email</label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fa fa-user-o"></i>
                  </span>
                                </div>
                                <input v-model="formData.email"
                                       :class="[(errors.hasOwnProperty('email') ? 'is-invalid' : '')]"
                                       autocomplete="off" class="form-control form-control-sm rounded-0" placeholder="Email"
                                       type="email">
                                <div v-if="errors.hasOwnProperty('email')" class="invalid-feedback">
                                    {{ errors.email[0] }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group p-0 m-0">
                            <label class="czm-xs"> Mobile</label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fa fa-inbox"></i>
                  </span>
                                </div>
                                <input v-model="formData.mobile"
                                       :class="[(errors.hasOwnProperty('mobile') ? 'is-invalid' : '')]"
                                       class="form-control form-control-sm rounded-0" placeholder="mobile"
                                       type="mobile">
                                <div v-if="errors.hasOwnProperty('mobile')" class="invalid-feedback">
                                    {{ errors.mobile[0] }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group p-0 m-0">
                            <label class="czm-xs"> New Password</label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fa fa-key"></i>
                  </span>
                                </div>
                                <input v-model="formData.new_password"
                                       :class="[(errors.hasOwnProperty('new_password') ? 'is-invalid' : '')]"
                                       class="form-control form-control-sm rounded-0" name="new_password"
                                       placeholder="New password" type="password">
                                <div v-if="errors.hasOwnProperty('new_password')" class="invalid-feedback">
                                    {{ errors.new_password[0] }}
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group p-0 m-0">
                            <label class="czm-xs"> Confirm Password</label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fa fa-key"></i>
                  </span>
                                </div>
                                <input v-model="formData.new_password_confirmation"
                                       :class="[(errors.hasOwnProperty('new_password_confirmation') ? 'is-invalid' : '')]"
                                       class="form-control form-control-sm rounded-0" name="new_password_confirmation"
                                       placeholder="New confirm password" type="password">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="form-group pt-5">
                <label class="czm-xs text-danger">Enter Current Password</label>
                <input v-model="formData.current_password"
                       :class="[(errors.hasOwnProperty('current_password') ? 'is-invalid' : '')]"
                       class="form-control form-control-sm rounded-0" placeholder="Current password" type="password">
                <div v-if="errors.hasOwnProperty('current_password')" class="invalid-feedback">
                    {{ errors.current_password[0] }}
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <button class="btn btn-sm btn-primary pull-right rounded-0 m-2" type="button" @click="onClickUpdate()">
                <i class="fa fa-dot-circle-o"></i>
                &nbsp; Update Now
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: "ProfileC.Vue",
    props: ["user_profile"],
    data() {
        return {
            errors: {},
            formData: {
                name: "",
                new_password: "",
                new_password_confirmation: "",
                present_address: "",
                email: "",
                current_password: "",
            },
            routes: window.appHelper.routes,
        };
    },
    methods: {
        getAll() {
            let _this = this;
            _this.loading = true;
            _this.errors = {};
            _this.formData.name = _this.user_profile.name;
            _this.formData.email = _this.user_profile.email;
            _this.formData.mobile = _this.user_profile.mobile;

        },

        // onClickEdit(id) {
        //   let _this = this;
        //   _this.loading = true;
        //   _this.errors = {};
        //   axios
        //     .patch(_this.routes.one + "/" + id)
        //     .then((res) => {
        //       if (res.data) {
        //           console.log(res.data)
        //         _this.formData = res.data;
        //       } else {
        //         toastr.error(res.data.message, "Warning");
        //       }
        //       _this.loading = false;
        //     })
        //     .catch((error) => {
        //       if (error.response) {
        //         toastr.error(error.response.data.message, "Error");
        //         if (error.response && error.response.data.errors) {
        //           _this.$setErrorsFromLaravel(
        //             error.response.data
        //           );
        //         }
        //       } else {
        //         toastr.error(error.message, "Error");
        //       }
        //       _this.loading = false;
        //     });
        // },
        onClickUpdate() {
            let _this = this;
            _this.errors = {};
            axios
                .post(_this.routes.one, _this.formData)
                .then((res) => {
                    if (res.data.success) {
                        _this.formData = {};
                        toastr.success(res.data.success, "Success");
                        window.setTimeout(function () {
                            location.reload();
                        }, 500);
                    } else {
                        toastr.error(res.data.message, "Warning");
                    }
                })
                .catch((err) => {
                    toastr.error(err.response.data.message, "Error");
                    if (err.response && err.response.data.errors) {
                        _this.errors = err.response.data.errors;
                    }
                });
        },
    },
    created() {
        let _this = this;
        //   this.onClickEdit()
        this.getAll();
    },
};
</script>

<style scoped>
</style>
