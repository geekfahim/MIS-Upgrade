<template>
    <div class="position-relative">
        <div class="card-header">
            <i class="fa fa-list"></i> User Roles
            <div class="card-header-actions p-0 m-0">
                <button v-if="!formView" class="btn btn-brand btn-sm btn-github" type="button" @click="addNew()">
                    <i class="fa fa-plus"></i>
                    <span>Add User</span>
                </button>
                <button v-else class="btn btn-brand btn-sm btn-github" type="button" @click="getAll()">
                    <i class="fa fa-list"></i>
                    <span>View All</span>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div v-show="formView">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Role Name<span class="text-danger">*</span></label>
                            <input v-model="formData.name"
                                   :class="[(errors.hasOwnProperty('name') ? 'is-invalid' : '')]"
                                   class="form-control form-control-sm rounded-0"
                                   type="text">
                            <div v-if="errors.hasOwnProperty('name')" class="invalid-feedback">
                                {{ errors.name[0] }}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group mt-1">
                            <div class="form-check form-check-inline mr-3 pt-4 pl-5">
                                <input id="select-all" class="form-check-input" type="checkbox"
                                       @click="selectAllClicked">
                                <label class="form-check-label ml-1" for="select-all">Select All</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group my-0 py-0">
                            <div v-for="(main_group, main_group_key) in outputRes.permissions"
                                 class="row border-bottom">
                                <div class="col-sm-2 col-md-2">
                                    <div class="form-check form-check-inline">
                                        <input :id="'main-grp-'+main_group_key" :data-main-group="main_group_key"
                                               class="form-check-input cls-all" type="checkbox"
                                               @click="mainGroupClicked">
                                        <label :for="'main-grp-'+main_group_key"
                                               class="form-check-label ml-1 text-capitalize"><strong>{{
                                                main_group_key
                                            }}</strong>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-10 col-md-10">
                                    <div v-for="(group, group_key) in main_group" class="form-group row">
                                        <div class="col-md-12 col-form-label">
                                            <div class="form-check form-check-inline">
                                                <input :id="'grp-'+main_group_key+'-'+group_key"
                                                       :class="'form-check-input cls-all main-grp-'+main_group_key"
                                                       :data-group="group_key"
                                                       :data-main-group="main_group_key"
                                                       type="checkbox"
                                                       @click="groupClicked">
                                                <label :for="'grp-'+main_group_key+'-'+group_key"
                                                       class="form-check-label ml-1">
                                                    <strong class="text-capitalize">{{ group_key }}</strong>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-10 offset-md-2">
                                            <div v-for="(sub_group, sub_group_key) in group" class="row">
                                                <div class="col-md-12">
                                                    <input
                                                        :id="'sub-grp-'+main_group_key+'-'+group_key+'-'+sub_group_key"
                                                        :class="'form-check-input cls-all grp-'+main_group_key+'-'+group_key"
                                                        :data-group="group_key"
                                                        :data-main-group="main_group_key"
                                                        :data-sub-group="sub_group_key"
                                                        type="checkbox"
                                                        @click="subGroupClicked">
                                                    <label
                                                        :for="'sub-grp-'+main_group_key+'-'+group_key+'-'+sub_group_key"
                                                        class="form-check-label ml-1">
                                                        <strong class="text-capitalize">{{
                                                                sub_group_key.split('_').join(' ')
                                                            }}</strong>
                                                    </label>
                                                </div>
                                                <div class="col-md-12">
                                                    <div v-for="(item, item_key) in sub_group"
                                                         class="form-check form-check-inline">
                                                        <input
                                                            :id="'item-'+main_group_key+'-'+group_key+'-'+sub_group_key+'-'+item_key"
                                                            :class="'form-check-input item-ids cls-all sub-grp-'+main_group_key+'-'+group_key+'-'+sub_group_key"
                                                            :data-group="group_key"
                                                            :data-item-id="item_key"
                                                            :data-main-group="main_group_key"
                                                            :data-sub-group="sub_group_key"
                                                            type="checkbox"
                                                            @click="itemClicked">
                                                        <label
                                                            :for="'item-'+main_group_key+'-'+group_key+'-'+sub_group_key+'-'+item_key"
                                                            class="form-check-label ml-1">{{ item }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="pt-3 text-right">
                            <button v-if="createView" class="btn btn-sm btn-primary pull-right rounded-0" type="button"
                                    @click="onSubmit">
                                <i class="fa fa-dot-circle-o"></i>
                                Submit
                            </button>
                            <button v-else class="btn btn-sm btn-primary pull-right rounded-0"
                                    type="button"
                                    @click="onUpdateRole(formData.id)">
                                <i class="fa fa-dot-circle-o"></i>
                                Update
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="!formView">
                <table class="table table-responsive-sm table-sm table-striped">
                    <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th style="width: 250px">Role Name</th>
                        <th>Created</th>
                        <th style="width: 140px;text-align: center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(item, index) in outputRes.roles" v-if="outputRes.roles.length > 0">
                        <td>{{ ++index }}</td>
                        <td>{{ item.name }}</td>
                        <td>{{ item.created_at | dateFormat }}</td>
                        <td>
                            <button class="btn btn-xs btn-info rounded-0" @click="onClickEdit(item.id)">
                                <i class="fa fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-xs btn-danger rounded-0" @click="onClickDelete(item)">
                                <i class="fa fa-remove"></i> Delete
                            </button>
                        </td>
                    </tr>
                    <tr v-if="outputRes.roles.length == 0">
                        <td class="text-center" colspan="4">No Data Found</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div v-if="loading" class="czm-loader">Loading&#8230;</div>
    </div>
</template>
<script>
export default {
    name: "UserRoleC",
    data() {
        return {
            formView: false,
            createView: true,
            loading: false,
            allSelected: false,
            outputRes: {
                roles: [],
                permissions: {
                    "ids": [],
                    "data": [],
                },
            },
            formData: {
                id: "",
                name: "",
                permissions: [],
            },
            errors: {},
            routes: window.appHelper.routes
        }
    },
    methods: {
        idPushOrSplice() {
            let _this = this;
            _this.formData.permissions = [];
            $(".item-ids").each(function (index, el) {
                if (el.checked === true) {
                    _this.formData.permissions.push(el.getAttribute('data-item-id'));
                }
            });
        },
        selectAllCheckedOrNot() {
            let all = true;
            $(".cls-all").each(function (index, el) {
                if (el.checked !== true) {
                    all = false;
                }
            });
            document.getElementById("select-all").checked = all;
        },
        mainGroupClicked(event) {
            let status = false;
            let main_group = event.target.getAttribute('data-main-group');
            if (event.target.checked) {
                status = event.target.checked;
            } else {
                document.getElementById('select-all').checked = status;
            }
            $('*[data-main-group="' + main_group + '"]').each(function (index, el) {
                el.checked = status;
            });
            this.selectAllCheckedOrNot();
            this.idPushOrSplice();
        },
        mainGroupCheckedOrNot(main_group) {
            let status = true;
            $(".main-grp-" + main_group).each(function (index, el) {
                if (el.checked !== true) {
                    status = false;
                }
            });
            document.getElementById("main-grp-" + main_group).checked = status;
        },
        groupClicked(event) {
            let status = false;
            let main_group = event.target.getAttribute('data-main-group');
            let group = event.target.getAttribute('data-group');
            if (event.target.checked) {
                status = true;
            } else {
                document.getElementById('select-all').checked = status;
                document.getElementById("main-grp-" + main_group).checked = status;
            }

            $('[data-main-group="' + main_group + '"][data-group="' + group + '"]').each(function (index, el) {
                el.checked = status;
            });

            if (event.target.checked) {
                this.mainGroupCheckedOrNot(main_group);
                this.selectAllCheckedOrNot();
            }
            this.idPushOrSplice();
        },
        groupCheckedOrNot(main_group, group) {
            let status = true;
            $(".grp-" + main_group + '-' + group).each(function (index, el) {
                if (el.checked !== true) {
                    status = false;
                }
            });
            document.getElementById("grp-" + main_group + "-" + group).checked = status;
        },
        subGroupClicked(event) {
            let status = false;
            let main_group = event.target.getAttribute('data-main-group');
            let group = event.target.getAttribute('data-group');
            let sub_group = event.target.getAttribute('data-sub-group');
            if (event.target.checked) {
                status = true;
            } else {
                document.getElementById('select-all').checked = status;
                document.getElementById("main-grp-" + main_group).checked = status;
                document.getElementById("grp-" + main_group + '-' + group).checked = status;
            }

            $('[data-main-group="' + main_group + '"][data-group="' + group + '"][data-sub-group="' + sub_group + '"]').each(function (index, el) {
                el.checked = status;
            });

            if (event.target.checked) {
                this.groupCheckedOrNot(main_group, group);
                this.mainGroupCheckedOrNot(main_group);
                this.selectAllCheckedOrNot();
            }
            this.idPushOrSplice();
        },
        subGroupCheckedOrNot(main_group, group, sub_group) {
            let status = true;
            $(".sub-grp-" + main_group + "-" + group + "-" + sub_group).each(function (index, el) {
                if (el.checked !== true) {
                    status = false;
                }
            });
            document.getElementById("sub-grp-" + main_group + "-" + group + "-" + sub_group).checked = status;
        },
        itemClicked(event) {
            let main_group = event.target.getAttribute('data-main-group');
            let group = event.target.getAttribute('data-group');
            let sub_group = event.target.getAttribute('data-sub-group');
            let item_id = event.target.getAttribute('data-item-id');

            if (!event.target.checked) {
                document.getElementById('select-all').checked = false;
                document.getElementById("main-grp-" + main_group).checked = false;
                document.getElementById("grp-" + main_group + '-' + group).checked = false;
                document.getElementById("sub-grp-" + main_group + "-" + group + "-" + sub_group).checked = false;
            } else {
                this.subGroupCheckedOrNot(main_group, group, sub_group);
                this.groupCheckedOrNot(main_group, group);
                this.mainGroupCheckedOrNot(main_group);
                this.selectAllCheckedOrNot();
            }
            this.idPushOrSplice();
        },
        selectAllClicked(event) {
            let status = false;
            if (event.target.checked) {
                status = true;
            }
            $('input:checkbox').each(function (index, el) {
                el.checked = status;
            });
            this.idPushOrSplice();
        },
        viewAll() {
            this.formView = false;
            this.createView = true;
            this.getAll();
        },
        addNew() {
            this.formData.name = "";
            this.formData.permissions = [];
            this.formView = true;
            this.allSelected = false;
        },
        onSubmit() {
            let _this = this;
            _this.loading = true;
            _this.errors = {};
            axios.post(_this.routes.one, _this.formData).then((res) => {
                if (res.data.success) {
                    _this.getAll();
                    toastr.success(res.data.success, "Success");
                } else {
                    toastr.error(res.data.message, "Warning");
                }
                _this.loading = false;
            }).catch((err) => {
                toastr.error(err.response.data.message, "Error");
                if (err.response && err.response.data.errors) {
                    _this.errors = err.response.data.errors;
                    if (_this.errors.hasOwnProperty("permissions")) {
                        toastr.error(_this.errors.permissions[0], "Error");
                    }
                }
                _this.loading = false;
            });
        },
        getAll() {
            let _this = this;
            _this.formView = false;
            _this.createView = true;
            _this.loading = true;
            _this.errors = {};
            axios.post(_this.routes.list).then((res) => {
                if (res.data.roles)
                    _this.outputRes = res.data;
                else {
                    toastr.error(res.data.message, "Warning");
                }
                _this.loading = false;
            }).catch((err) => {
                toastr.error(err.response.data.message, "Error");
                if (err.response && err.response.data.errors) {
                    _this.errors = err.response.data.errors;
                }
                _this.loading = false;
            });
        },
        onClickDelete(item) {
            let _this = this;
            Swal.fire({
                title: 'Are you sure?',
                html: '<p style="color:#3085d6">"' + item.name + '"</p>' + "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    _this.onDeleteRequest(item.id);
                }
            })
        },
        onDeleteRequest(id) {
            let _this = this;
            _this.loading = true;
            _this.errors = {};
            axios.delete(_this.routes.one + "/" + id).then((res) => {
                if (res.data.success) {
                    Swal.fire('Deleted!', res.data.success, 'success')
                    _this.getAll();
                } else {
                    toastr.error(res.data.message, "Warning");
                }
                _this.loading = false;
            }).catch((err) => {
                toastr.error(err.response.data.message, "Error");
                if (err.response && err.response.data.errors) {
                    _this.errors = err.response.data.errors;
                }
                _this.loading = false;
            });
        },
        onClickEdit(id) {
            let _this = this;
            _this.formView = false;
            _this.loading = true;
            _this.errors = {};
            axios.patch(_this.routes.one + "/" + id).then((res) => {
                if (res.data.role) {
                    _this.formData.id = res.data.role.id;
                    _this.formData.name = res.data.role.name;
                    _this.formData.permissions = res.data.role.permissions;
                    _this.outputRes.permissions = res.data.permissions;
                    _this.formView = true;
                    _this.createView = false;
                    setTimeout(function () {
                        $(".item-ids").each(function (index, el) {
                            let pid = parseInt(el.getAttribute('data-item-id'));
                            if (_this.formData.permissions.includes(pid)) {
                                el.checked = true
                            }
                        });
                        Object.keys(_this.outputRes.permissions).forEach(function (main_group) {
                            Object.keys(_this.outputRes.permissions[main_group]).forEach(function (group) {
                                Object.keys(_this.outputRes.permissions[main_group][group]).forEach(function (sub_group) {
                                    _this.subGroupCheckedOrNot(main_group, group, sub_group);
                                });
                                _this.groupCheckedOrNot(main_group, group);
                            });
                        });
                        _this.selectAllCheckedOrNot();
                    }, 300);
                } else {
                    toastr.error(res.data.message, "Warning");
                }
                _this.loading = false;
            }).catch((err) => {
                toastr.error(err.response.data.message, "Error");
                if (err.response && err.response.data.errors) {
                    _this.errors = err.response.data.errors;
                }
                _this.loading = false;
            });
        },
        onUpdateRole(id) {
            let _this = this;
            _this.loading = true;
            _this.errors = {};
            axios.put(_this.routes.one + "/" + id, _this.formData).then((res) => {
                if (res.data.success) {
                    _this.getAll();
                    toastr.success(res.data.success, "Success");
                } else {
                    toastr.error(res.data.message, "Warning");
                }
                _this.loading = false;
            }).catch((err) => {
                toastr.error(err.response.data.message, "Error");
                if (err.response && err.response.data.errors) {
                    _this.errors = err.response.data.errors;
                    if (_this.errors.hasOwnProperty("permissions")) {
                        toastr.warning(_this.errors.permissions[0], "Warning!");
                    }
                }
                _this.loading = false;
            });
        }
    },
    created() {
        this.getAll();
    },
    filters: {
        dateFormat(value) {
            if (!value) return '';
            return moment(value).format("MMM DD, YYYY");
        }
    }
}
</script>

<style scoped>

</style>
