<template>
    <ul class="pagination pagination-sm" style="cursor: pointer">
        <li class="page-item">
            <a :disabled="((records.current_page === 1) ? true : false)" @click.prevent="onFirstPageClicked"
               class="page-link" title="First">
                <i class="fa fa-angle-double-left"></i>
            </a>
        </li>

        <li class="page-item">
            <a :data-page="records.current_page" :disabled="((records.current_page === 1) ? true : false)"
               @click.prevent="onPreviousPageClicked" class="page-link" title="Previous">
                <i class="fa fa-angle-left"></i>
            </a>
        </li>

        <li v-for="(value,index) in pageRange" :key="index" :class="((records.current_page == value) ? 'active' : '')"
            class="page-item">
            <a @click.prevent="onClicked(value)" class="page-link">{{ value }}</a>
        </li>

        <li class="page-item">
            <a :disabled="((records.current_page === records.last_page) ? true : false)"
               @click.prevent="onNextPageClicked" class="page-link" title="Next">
                <i class="fa fa-angle-right"></i>
            </a>
        </li>

        <li class="page-item">
            <a :disabled="((records.current_page === records.last_page) ? true : false)"
               @click.prevent="onLastPageClicked" class="page-link" title="Last">
                <i class="fa fa-angle-double-right"></i>
            </a>
        </li>
    </ul>
</template>

<script>
export default {
    name: "Pagination",
    props: {
        records: {
            type: Object,
            required: true,
            default: {
                current_page: 0,
            },
        },
    },

    computed: {
        pageRange() {
            let {records} = this;
            if (records.last_page < 5) {
                return this.range(1, records.last_page + 1);
            }
            if (records.last_page - 2 < records.current_page) {
                return this.range(records.last_page - 4, records.last_page + 1);
            }
            if (records.current_page > 3) {
                return this.range(records.current_page - 2, records.current_page + 3);
            }
            return this.range(1, 6);
        },
    },

    methods: {
        range(start, count) {
            let a = [];
            for (let i = start; i < count; i++) {
                a.push(i);
            }
            return a;
        },
        onClicked(value) {
            if (this.records.current_page != value) {
                this.$emit("onclicked", value);
            }
        },
        onNextPageClicked() {
            if (this.records.current_page < this.records.last_page) {
                this.$emit("onclicked", this.records.current_page + 1);
            }
        },
        onLastPageClicked() {
            if (this.records.current_page < this.records.last_page) {
                this.$emit("onclicked", this.records.last_page);
            }
        },
        onFirstPageClicked() {
            if (this.records.current_page > 1) {
                this.$emit("onclicked", 1);
            }
        },
        onPreviousPageClicked() {
            if (this.records.current_page > 1) {
                this.$emit("onclicked", this.records.current_page - 1);
            }
        },
    },
};
</script>
